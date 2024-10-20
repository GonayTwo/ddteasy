<?php

namespace App\Livewire\Web\Customers\Cards;

use App\Livewire\Forms\Web\Customers\Cards\CreateCard;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Adicionar Cartão')]
class Create extends Component
{
    public CreateCard $form;

    public function mount()
    {
        $this->form->number = '';
        $this->form->holder_name = '';
        $this->form->exp_month = (int) date('m');
        $this->form->exp_year = (int) date('Y');
        $this->form->cvv = null;
    }

    public function save()
    {
        try {
            // Capturando a resposta da API ao chamar o método store()
            $response = $this->form->store();

            // Verifica se a resposta é válida e se o cartão foi criado
            if ($response && !is_null($response->id) && !is_null($response->last_four_digits)) {
                // Se o cartão foi criado corretamente, exibe o modal de sucesso
                $this->js("modal('Sucesso!', 'Cartão cadastrado com sucesso! Você será redirecionado em instantes', 'success')");

                return session()->get('scheduling') ? redirect()->route('site.scheduling.checkout') : redirect()->route('site.profile.cards.index');
            } else {
                // Se a resposta for nula ou incompleta, exibe o modal de erro
                $this->js("modal('Erro!', 'O cartão inserido não é válido. Por favor, tente novamente.', 'error')");
            }
        } catch (\Exception $e) {
            // Captura qualquer erro inesperado e exibe o modal de erro
            $this->js("modal('Erro!', 'Ocorreu um erro ao adicionar o cartão. Tente novamente mais tarde.', 'error')");
        }
    }
}
