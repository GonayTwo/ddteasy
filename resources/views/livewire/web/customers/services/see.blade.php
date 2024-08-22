<div>
    <livewire:web.components.header title="Área do Cliente" />

    <div class="w-full flex flex-col md:flex-row">
        <div class="p-4 md:p-8 shadow-md w-full md:w-1/4">
            <livewire:web.components.profile.sidebar route="site.profile.services.see" />
        </div>
        <div class="w-full p-4 md:p-8">
            <h2 class="text-3xl md:text-4xl font-poppins font-bold">Serviço - {{ $order->pagarme['code'] }}</h2>
            <h3 class="text-md md:text-lg text-gray-500">Consulte aqui as informações sobre o serviço.</h3>

            <div class="w-full py-8">

                <div class="flex max-w-full flex-col-reverse xl:flex-row">
                    <div class="w-full xl:w-8/12 shrink-0 grow-0 basis-full xl:basis-8/12">
                        <div class="mb-2 w-full xl:pr-2">
                            <strong class="text-slate-900">Empresa: </strong> <br />
                            {{ $order->company->fantasy_name }}
                            {{ $order->company->corporate_name }}
                            {{ preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $order->company->cnpj) }}
                            <hr>
                        </div>

                        <div class="mb-2 w-full xl:pr-2">
                            <strong class="text-slate-900">Serviço: </strong> <br />
                            @foreach ($order_items as $item)
                            {{ $item->service->name }}
                            {{ $item->service->plagues->pluck('name')->implode(', ') }}
                            {{ $item->daily_price }}
                            @endforeach
                            <hr>
                        </div>

                        <div class="mb-2 w-full xl:pr-2">
                            <strong class="text-slate-900">Data: </strong> <br />
                            {{ date('d/m/Y', strtotime($order->date)) }}
                            <hr>
                        </div>

                        <div class="mb-2 w-full xl:pr-2">
                            <strong class="text-slate-900">Período: </strong> <br />
                            {{ \App\Enums\ServicePeriods::tryFrom($order->period['value'])?->getLabel() ?? str($order->period['value'])->substr(0, 5) }}
                            <hr>
                        </div>

                        <div class="mb-2 w-full xl:pr-2">
                            <strong class="text-slate-900">Endereço do prestador: </strong> <br />
                            {{ "{$order->company->address->street}, {$order->company->address->number}" . ($order->company->address->complement ?? '') . " - {$order->company->address->district} - {$order->company->address->city} - {$order->company->address->state}, {$order->company->address->cep}" }}
                            <hr>
                        </div>

                        <div class="mb-2 w-full xl:pr-2">
                            <strong class="text-slate-900">Endereço do serviço: </strong> <br />
                            {{ "{$order->address->street}, {$order->address->number}" . ($order->address->complement ?? '') . " - {$order->address->district} - {$order->address->city} - {$order->address->state}, {$order->address->cep}" }}
                            <hr>
                        </div>

                        <div class="mb-2 w-full xl:pr-2">
                            <strong class="text-slate-900">Método de pagamento: </strong> <br />
                            {{ \App\Services\Pagarme\Enums\PaymentMethods::tryFrom($order->pagarme['charges'][0]['payment_method'])->getLabel() }}
                            <hr>
                        </div>

                        <div class="mb-2 w-full xl:pr-2">
                            <strong class="text-slate-900">Situação: </strong> <br />
                            {{ \App\Services\Pagarme\Enums\OrderPaymentStatus::tryFrom($order->pagarme['status'])->getLabel() }}
                            <hr>
                        </div>
                    </div>
                    <div class="w-full mb-6 xl:mb-0 xl:w-4/12 shrink-0 grow-0 basis-full xl:basis-4/12 clear-both">
                        <img src="{{ asset($order->company->getFilamentAvatarUrl()) }}" class="max-w-[225px] xl:float-right" alt="">
                    </div>
                </div>


            </div>
        </div>
    </div>

</div>