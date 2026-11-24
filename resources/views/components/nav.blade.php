 @foreach ($items as $item)
     <a href="{{ route($item['route']) }}" class="admin-nav-link {{ request()->routeIs($item['pattern']) ? 'is-active' : '' }}"
         @if (request()->routeIs($item['pattern'])) aria-current="page" @endif>
         <i class="fa-solid {{ $item['icon'] }}" aria-hidden="true"></i>
         <span><strong>{{ $item['label'] }}</strong><small>{{ $item['description'] }}</small></span>
         @if (request()->routeIs($item['pattern']))
             <span class="admin-nav-dot" aria-hidden="true"></span>
         @endif
     </a>
 @endforeach
