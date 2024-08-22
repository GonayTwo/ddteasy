<div class="w-full font-poppins">
    <livewire:web.components.header title="Serviços e Recomendações" />

    <div class="w-full">
        <div class="flex flex-wrap items-center mb-20 max-xl:flex-col">
            <img src="{{ asset('images/img-servicos.webp') }}" class="flex-auto aspect-video md:w-2/4" alt="Foto Serviços">

            <div class="flex-auto w-2/4 max-xl:w-full pt-12 pl-10 pr-20">
                <h1 class="text-5xl max-2xl:text-4xl text-orange-ddteasy font-bold">Por que fazer dedetização</h1>

                <p class="my-4 text-lg">A dedetização é o processo que elimina as pragas de ambientes urbanos e garante o bem-estar e a saúde das pessoas que moram ou frequentam esses ambientes.</p>

                <h2 class="mt-4 text-3xl max-2xl:text-2xl text-purple-800">As Pragas</h2>

                <p class="my-4 text-lg">A convivência do homem com insetos sempre causou desconforto e aversão. São muitas as pragas urbanas que aprenderam a viver no mesmo ambiente dos humanos, se alimentando de seus restos de comida e de alimentos deixados expostos ou pouco protegidos. Além dessa desagradável competição, as chamadas pragas sinantrópicas ou pragas urbanas, também estão associadas a diversas doenças que afetam diretamente o homem.</p>
            </div>
        </div>
    </div>

    <h1 class="text-5xl max-2xl:text-4xl text-orange-ddteasy font-bold text-center">Tipos de dedetização</h1>

   
   <livewire:web.components.services.services lazy/>
</div>