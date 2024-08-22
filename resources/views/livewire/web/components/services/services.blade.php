<div class="w-full mx-auto mt-12">
    @foreach ($services as $service)
        <div class="py-10 px-8 md:py-20 md:px-10 flex flex-wrap flex-col md:flex-row even:bg-slate-50">
            <div class="flex-auto w-full lg:w-1/2 lg:px-16">
                <h2 class="text-2xl md:text-3xl text-purple-800 font-semibold">{{ $service->name }}</h2>

                <div class="service-description">
                    {!! $service->description !!}
                </div>

                <h3 class="text-lg lg:text-2xl text-purple-800 p-6 border border-orange-ddteasy w-full">
                    Pragas Alvo:
                    <span class="pl-2 text-gray-600 text-base md:text-lg">
                        {{ $service->plagues->pluck('name')->implode(', ') }}
                    </span>
                </h3>

                @if ($service->observations)
                    <div class="observations-content">
                        {!! $service->observations !!}
                    </div>
                @endif
            </div>

            <div class="flex-auto w-full md:w-1/2 pt-4 md:pt-0 lg:px-16">
                <h2 class="text-2xl md:text-3xl text-purple-800 font-semibold">Benefícios</h2>

                <ul class="marker:text-orange-ddteasy list-disc py-4 md:py-8">
                    @foreach ($service->benefits as $benefit)
                        <li class="pb-4 last:pb-0 text-lg text-gray-600">
                            {{ $benefit }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>
