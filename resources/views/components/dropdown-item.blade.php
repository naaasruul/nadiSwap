@props(['label', 'icon', 'items' => []])

<li>
    <button type="button" 
        class="flex  items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700" 
        aria-controls="dropdown-{{ Str::slug($label) }}" 
        data-collapse-toggle="dropdown-{{ Str::slug($label) }}">
        <i class="{{ $icon }} text-accent shrink-0 w-5 h-5 transition duration-75 "></i>
        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ $label }}</span>
        <svg class="w-3 h-3 text-accent" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
        </svg>
    </button>
    <ul id="dropdown-{{ Str::slug($label) }}" class="hidden py-2 space-y-2">
        @foreach ($items as $item)
            <li>
                <a href="{{ $item['route'] ?? '#' }}" 
                   class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                    {{ $item['label'] }}
                </a>
            </li>
        @endforeach
    </ul>
</li>