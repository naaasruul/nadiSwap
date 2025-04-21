@props(['route', 'icon', 'label', 'isActive' => false, 'type' => 'link'])

<li>
    @if ($type === 'submit')
        <button type="submit" 
            class="flex  items-center p-2 w-full text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ $isActive ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
            <i class="{{ $icon }} text-accent"></i>
            <span class="ms-3 text">{{ $label }}</span>
        </button>
    @else
        <a href="{{ route($route) }}" 
           class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs($route) ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
            <i class="{{ $icon }} text-accent"></i>
            <span class="ms-3 text">{{ $label }}</span>
        </a>
    @endif
</li>