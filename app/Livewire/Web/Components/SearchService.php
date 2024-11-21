<?php

namespace App\Livewire\Web\Components;

use App\Enums\PropertyTypes;
use App\Livewire\Forms\Web\Components\SearchServiceForm;
use App\Models\Services\Plague;
use App\Services\FindCep\FindCepService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Partners\Company;
use App\Helpers\OrderHelper;
use Illuminate\Support\Facades\Log;
use App\Models\PotentialCustomer;

class SearchService extends Component
{
    public SearchServiceForm $form;

    public ?Collection $plagues;

    public ?string $address;

    public bool $noSellersModal = false; // Controle de exibição do modal
    public bool $noSellersModal2 = false; // Controle de exibição do modal
    public ?string $modalCep = null; // CEP exibido no modal
    public $contact = [
        'name' => '',
        'email' => '',
        'phone' => '',
    ];

    public function saveContact()
    {
        try {
            $this->validate([
                'contact.name' => 'required|string|max:255',
                'contact.email' => 'required|email|max:255|unique:potential_customers,email',
                'contact.phone' => 'required|string|max:15',
            ]);

            PotentialCustomer::create($this->contact);

            $this->reset('contact'); // Reseta o formulário do modal
            $this->address = null; // Reseta o endereço

            $this->noSellersModal = false;
            $this->noSellersModal2 = true;
            session()->flash('success', 'Cadastro realizado com sucesso! Entraremos em contato em breve.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura erro de validação e exibe no campo correspondente
            $this->addError('contact.email', 'O e-mail informado já está cadastrado.');
        } catch (\Exception $e) {
            // Captura qualquer outro erro
            $this->addError('general', 'Ocorreu um erro ao salvar suas informações. Tente novamente.');
        }
    }


    public function mount()
    {
        $this->plagues = Plague::all();
    }

    public function save()
    {
        $this->form->validate();
    
        try {
            // Buscar o endereço com base no CEP
            $address = FindCepService::cep()->get(str_replace('-', '', $this->form->cep));
    
            if (!$address) {
                throw new \Exception('Endereço não encontrado');
            }
    
            // Obter as coordenadas do endereço
            $coordinates = FindCepService::geolocation()->get(str_replace('-', '', $this->form->cep));
    
            // Consultar empresas no raio de 25 km
            $sellers = OrderHelper::getCompaniesInRadiusArea(Company::query(), $coordinates, 25)
                ->whereJsonContains('work_days', date('N')) // Filtrar por dia da semana
                ->get();
    
            // Log para depuração
            Log::info('Empresas encontradas:', $sellers->toArray());
    
            // Verifique se há empresas disponíveis
            if ($sellers->isEmpty()) {
                $this->noSellersModal = true;
                $this->modalCep = $this->form->cep;
                Log::info('Nenhuma empresa encontrada para o CEP: ' . $this->form->cep);
                return; // Interrompe o fluxo caso nenhuma empresa seja encontrada
            }
    
            // Garantir que o modal não será exibido
            $this->noSellersModal = false;
    
            // Salvar dados na sessão
            session()->put('scheduling.address', $address);
            session()->put('scheduling.sellers', $sellers);
    
            // Redirecionar para a página de agendamento
            Log::info('Redirecionando para a página de agendamento.');
            return redirect('/agendamento');
        } catch (\Exception $e) {
            // Log de erro
            Log::error('Erro ao buscar endereço ou empresas:', [
                'cep' => $this->form->cep,
                'mensagem' => $e->getMessage(),
            ]);
    
            // Garantir que o modal seja exibido em caso de erro
            $this->noSellersModal = true;
            $this->modalCep = null;
        }
    }

    #[On('property_type-selected')]
    public function handlePropertyTypeSelect()
    {
        if ($this->form->property_type == PropertyTypes::Apartament->value) {
            $this->form->range = null;
        } else {
            $this->form->rooms = null;
        }
    }

    #[On('cep-filled')]
    public function searchCep()
    {
        try {
            $address = FindCepService::cep()->get(str_replace('-', '', $this->form->cep));
            $this->address = "{$address?->street}, {$address?->district}, {$address?->city} - {$address?->state}";
        } catch (\Exception) {
            $this->js("modal('Erro', 'Ops! Não foi possível encontrar o endereço', 'warning')");
        }
    }

    #[On('cep-cleaned')]
    public function cleanAddress()
    {
        $this->address = null;
    }
}
