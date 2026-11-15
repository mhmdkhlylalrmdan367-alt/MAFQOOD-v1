@props(['item', 'showEventDate' => false])

<a href="{{ route('items.show', $item) }}"
   class="group block overflow-hidden rounded-2xl border border-slate-200 bg-white transition duration-200 hover:-translate-y-1 hover:border-teal-200 hover:shadow-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-teal-700 focus-visible:ring-offset-2">

    <div class="relative aspect-[4/3] overflow-hidden bg-stone-100">
        @if($item->images->isNotEmpty())
            <img src="{{ asset('storage/' . $item->images->first()->path) }}"
                 alt="{{ $item->title }}"
                 loading="lazy"
                 class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]">
        @else
            <div class="flex h-full items-center justify-center text-stone-400">
                <i class="fa-regular fa-image text-4xl" aria-hidden="true"></i>
            </div>
        @endif

        <span class="absolute right-3 top-3 rounded-full px-3 py-1.5 text-xs font-bold {{ $item->type === 'lost' ? 'bg-rose-50 text-rose-700' : 'bg-emerald-50 text-emerald-700' }}">
            {{ $item->type_label }}
        </span>

        @if($item->status !== 'active')
            <span class="absolute left-3 top-3 rounded-full bg-white/95 px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-sm backdrop-blur">
                {{ $item->status_label }}
            </span>
        @endif
    </div>

    <div class="p-4 sm:p-5">
        <div class="mb-2 flex items-center gap-2 text-xs font-medium text-teal-700">
            <i class="fa-solid fa-tag" aria-hidden="true"></i>
            <span>{{ $item->category->name }}</span>
        </div>

        <h3 class="line-clamp-2 text-lg font-bold leading-7 text-slate-900 transition group-hover:text-teal-800">
            {{ $item->title }}
        </h3>
        <p class="mt-1.5 line-clamp-2 min-h-12 text-sm leading-6 text-slate-600">
            {{ $item->description }}
        </p>

        <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2 border-t border-slate-100 pt-3 text-xs text-slate-500">
            @if($item->region)
                <span class="inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-location-dot text-slate-400" aria-hidden="true"></i>
                    {{ $item->region->name }}
                </span>
            @endif
            <span class="inline-flex items-center gap-1.5">
                <i class="fa-regular fa-clock text-slate-400" aria-hidden="true"></i>
                @if($showEventDate && $item->event_date)
                    <time datetime="{{ $item->event_date->format('Y-m-d') }}">
                        {{ $item->type === 'lost' ? 'فُقد في' : 'عُثر عليه في' }} {{ $item->event_date->format('d/m/Y') }}
                    </time>
                @else
                    {{ $item->created_at->diffForHumans() }}
                @endif
            </span>
        </div>

        <div class="mt-4 flex items-center justify-between text-sm font-semibold text-teal-700">
            <span>عرض التفاصيل</span>
            <i class="fa-solid fa-arrow-left transition group-hover:-translate-x-1" aria-hidden="true"></i>
        </div>
    </div>
</a>
