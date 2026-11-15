@props(['item'])

<a href="{{ route('items.show', $item) }}"
   class="block bg-white rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden border border-gray-100 group">

    <div class="relative aspect-video bg-gray-100 overflow-hidden">
        @if($item->images->isNotEmpty())
            <img src="{{ asset('storage/' . $item->images->first()->path) }}"
                 alt="{{ $item->title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition">
        @else
            <div class="flex items-center justify-center h-full text-gray-400">
                <i class="fa-solid fa-image text-4xl"></i>
            </div>
        @endif

        <span class="absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-semibold {{ $item->type === 'lost' ? 'bg-red-500' : 'bg-green-500' }} text-white">
            {{ $item->type === 'lost' ? 'مفقود' : 'موجود' }}
        </span>

        @if($item->status === 'resolved')
            <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-semibold bg-blue-500 text-white">
                تم استرجاعه
            </span>
        @endif
    </div>

    <div class="p-4">
        <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-primary-600 transition">
            {{ $item->title }}
        </h3>
        <p class="text-sm text-gray-500 line-clamp-2 mb-3">{{ $item->description }}</p>

        <div class="flex items-center justify-between text-xs text-gray-500">
            <span><i class="fa-solid fa-tag ml-1"></i> {{ $item->category->name }}</span>
            @if($item->region)
                <span><i class="fa-solid fa-location-dot ml-1"></i> {{ $item->region->name }}</span>
            @endif
        </div>

        <div class="mt-3 pt-3 border-t border-gray-100 text-xs text-gray-400">
            <i class="fa-regular fa-clock ml-1"></i>
            {{ $item->created_at->diffForHumans() }}
        </div>
    </div>
</a>