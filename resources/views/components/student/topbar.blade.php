@props([
    'centerClass' => '',
    'rightClass' => '',
])

<header class="fixed top-0 right-0 z-40 w-full md:w-[calc(100%-15.5rem)]">
    <div class="flex min-h-16 items-center gap-3 border-b border-[#e7e0f6] bg-[rgba(255,255,255,0.76)] px-4 py-3 shadow-[0_8px_22px_rgba(32,20,75,0.04)] backdrop-blur-2xl md:px-6">
        <div class="min-w-0 flex-1">
            {{ $slot }}
        </div>

        @isset($center)
            <div @class(['hidden min-w-0 flex-1 xl:block', $centerClass])>
                {{ $center }}
            </div>
        @endisset

        @isset($right)
            <div @class(['ml-auto flex shrink-0 items-center gap-2 sm:gap-3', $rightClass])>
                {{ $right }}
            </div>
        @endisset
    </div>
</header>
