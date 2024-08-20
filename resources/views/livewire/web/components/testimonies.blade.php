<div class="container mx-auto">
    @if ($testimonies->count() > 0)
    <h1 class="text-orange-ddteasy text-3xl md:text-5xl font-bold text-center py-12 md:py-20">{{ $title }}</h1>

    <div x-data="{swiper: null}" x-init="
    swiper = new Swiper($refs.depoiments, {
        slidesPerView: 1,
        spaceBetween: 25,
        pagination: {
            el: $refs.pagination,
            clickable: true,
            bulletClass: 'inline-block w-12 md:w-16 h-2 opacity-100 bg-gray-300 mx-1',
            bulletActiveClass: '!bg-orange-ddteasy'
        },
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        breakpoints: {
            768: {
              slidesPerView: 1,
            },
            1000: {
              slidesPerView: 2,
            },
            1200: {
              slidesPerView: 3,
            },
        },
    })
    ">
        <div x-ref="depoiments" class="swiper pb-20">
            <div class="swiper-wrapper pb-20">
                @foreach ($testimonies as $testimony)
                <div
                    class="swiper-slide h-[450px] flex flex-col justify-between px-8 relative after:absolute after:right-0 after:w-px after:h-2/4 after:bg-slate-300 after:top-2/4 after:-translate-y-2/4">
                    <div class="relative rounded-full max-w-fit bg-gray-200 p-3 mx-auto mb-12">
                        <img src="{{ asset('storage/'. $testimony->image) }}" class="block mx-auto rounded-full h-48"
                            alt="{{ $testimony->name }}">
                    </div>

                    <h3 class="text-violet-900 leading-relaxed font-semibold my-10 text-xl md:text-2xl">
                        {{ $testimony->testimony }}
                    </h3>

                    <p class="text-slate-600 leading-relaxed">{{ $testimony->name }}</p>
                </div>
                @endforeach
            </div>

            <div x-ref="pagination" class="swiper-pagination py-6"></div>
        </div>
    </div>
    @endif
</div>