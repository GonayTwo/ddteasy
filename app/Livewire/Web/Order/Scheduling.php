<?php

namespace App\Livewire\Web\Order;

use App\Enums\PeriodTypes;
use App\Enums\ServicePeriods;
use App\Enums\SortOptions;
use App\Helpers\OrderHelper;
use App\Livewire\Forms\Web\Order\SchedulingForm;
use App\Models\Partners\Calendar;
use App\Models\Partners\Company;
use App\Services\FindCep\FindCepService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Agendamento')]
class Scheduling extends Component
{
    public SchedulingForm $form;

    public ?Collection $companies;

    public ?SortOptions $sort = SortOptions::Recommendation;

    public ?array $hours;

    public ?string $address;

    public function mount()
    {
        if (!OrderHelper::schedulingIsInitialized()) {
            return redirect()->route('site.home');
        }

        $this->hours = $this->getHours();

        $address = session()->get('scheduling.address');
        $this->form->cep = $address->cep;
        $this->address = "{$address?->street}, {$address?->district}, {$address?->city} - {$address?->state}";

        $this->form->period = ServicePeriods::Morning->value;
    }

    public function render()
    {
        if ($this->form->date != null) {
            $this->loadCompanies();
        }

        return view('livewire.web.order.scheduling');
    }

    public function save()
    {
        try {
            $this->form->store();
        } catch (ValidationException $e) {
            $message = collect($e->errors())->first()[0];
            $this->js("modal('Ops!', '{$message}', 'info')");
        }
    }

    #[On('period_type-selected')]
    public function handlePropertyTypeSelect()
    {
        if ($this->form->period_type == PeriodTypes::Period->value) {
            $this->form->hour = null;
        } else {
            $this->form->period = null;
        }
    }

    #[On('cep-filled')]
    public function searchCep()
    {
        try {
            $address = FindCepService::cep()->get(str_replace('-', '', $this->form->cep));
            session()->put('scheduling.address', $address);
            $this->address = "{$address?->street}, {$address?->district}, {$address?->city} - {$address?->state}";
            $this->loadCompanies();
        } catch (\Exception $e) {
            $this->js("modal('Erro', 'Ops! Não foi possível encontrar o endereço', 'warning')");
        }
    }

    #[On('cep-cleaned')]
    public function cepCleaned()
    {
        $this->address = null;
        $this->form->service = null;
        $this->companies = collect();
    }

    #[On('sort-selected')]
    public function loadCompanies()
    {
        $plagues = session()->get('scheduling.selected_plagues');

        $services = OrderHelper::getServicesThatExterminatesTheSelectedPlagues($plagues);

        $calendars = Calendar::all();

        $property = session()->get('scheduling.order')->property;

        $date = date('N', strtotime($this->form->date));

        $companies = Company::whereHas(
            'companyServices',
            fn ($query) => $query->whereIn('service_id', $services->pluck('id'))
                ->where('property_type', $property['type'])
                ->where('property_size', $property['value'])
        );

        $companies->with('companyServices', fn ($query) => $query->whereIn('service_id', $services->pluck('id'))
            ->where('property_type', $property['type'])
            ->where('property_size', $property['value']))
            ->doesntHave(
                'orders',
                'and',
                fn ($query) => $query->select('date', DB::raw('count(*) as count'))
                    ->where('date', $this->form->date)
                    ->groupBy('date')
                    ->having('count', '>=', 3)
            ); // Pega apenas as empresas que possuem menos de 3 serviços agendados nesse dia

        $companies->whereDoesntHave('calendars', fn ($query) => $query->where(fn ($subQuery) => collect($calendars)->each(fn ($calendar) => $subQuery->orWhere(fn ($innerQuery) => $innerQuery->where('company_id', $calendar->company_id)->whereDate('start_at', '=', $this->form->date)))));

        $companies = OrderHelper::getCompaniesInRadiusArea($companies, FindCepService::geolocation()->get(session()->get('scheduling.address')->cep))->whereJsonContains('work_days', $date)->get();

        $this->companies = OrderHelper::sortCompanies($companies, $this->sort);
    }

    private function getHours()
    {
        return [
            ['value' => '10:00:00', 'label' => '10:00'],
            ['value' => '10:30:00', 'label' => '10:30'],
            ['value' => '11:00:00', 'label' => '11:00'],
            ['value' => '11:30:00', 'label' => '11:30'],
            ['value' => '12:00:00', 'label' => '12:00'],
            ['value' => '12:30:00', 'label' => '12:30'],
            ['value' => '13:00:00', 'label' => '13:00'],
            ['value' => '13:30:00', 'label' => '13:30'],
            ['value' => '14:00:00', 'label' => '14:00'],
            ['value' => '14:30:00', 'label' => '14:30'],
            ['value' => '15:00:00', 'label' => '15:00'],
            ['value' => '15:30:00', 'label' => '15:30'],
            ['value' => '16:00:00', 'label' => '16:00'],
            ['value' => '16:30:00', 'label' => '16:30'],
            ['value' => '17:00:00', 'label' => '17:00'],
            ['value' => '17:30:00', 'label' => '17:30'],
        ];
    }
}
