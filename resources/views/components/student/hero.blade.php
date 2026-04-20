@props([
    'eyebrow' => null,
    'title' => '',
    'description' => null,
])

<section class="student-hero relative overflow-hidden rounded-[2rem] px-6 py-8 md:px-8 md:py-10">
    <div class="student-hero__mesh"></div>
    <div class="relative z-10 grid gap-8 xl:grid-cols-[minmax(0,1fr)_320px] xl:items-end">
        <div class="space-y-5">
            @if ($eyebrow)
                <p class="student-eyebrow">{{ $eyebrow }}</p>
            @endif

            <div class="max-w-3xl space-y-4">
                <h1 class="font-headline text-4xl font-extrabold tracking-[-0.04em] text-white md:text-5xl xl:text-6xl">{!! $title !!}</h1>
                @if ($description)
                    <p class="max-w-2xl text-sm leading-7 text-white/72 md:text-base">{{ $description }}</p>
                @endif
            </div>

            @if (trim((string) $slot) !== '')
                <div class="flex flex-wrap gap-3 text-sm text-white/88">
                    {{ $slot }}
                </div>
            @endif
        </div>

        @isset($aside)
            <div class="relative z-10">
                {{ $aside }}
            </div>
        @endisset
    </div>
</section>
