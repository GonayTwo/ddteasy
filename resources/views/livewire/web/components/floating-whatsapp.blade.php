<div>
    @if ($whatsapp)
        <div
            class="fixed right-4 bottom-4 w-14 h-14 rounded-full shadow-black shadow text-center bg-violet-900   z-50 group hover:bg-whatsapp hover:scale-105 transition-all ease-in-out">
            <a href="https://wa.me/55{{ str($whatsapp->number)->remove(['(', ')', '-', ' ']) }}" target="_blank"
                rel="noopener noreferrer" class="relative z-10 w-full h-full rounded-full m-auto flex">

                <x-fab-whatsapp
                    class="text-orange-ddteasy group-hover:text-white h-8 w-8 m-auto transition-all ease-in-out" />
            </a>
        </div>
    @endif
</div>
