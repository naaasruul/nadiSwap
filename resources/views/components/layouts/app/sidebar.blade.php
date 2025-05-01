<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen w-full bg-white dark:bg-gray-900">
    <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar"
        type="button"
        class="inline-flex print:hidden items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
            </path>
        </svg>
    </button>
    <aside id="default-sidebar"
        class="fixed print:hidden top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
            <a href="https://flowbite.com/" class="flex items-center ps-2.5 mb-5">
                {{-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-6 me-3 sm:h-7" alt="Flowbite Logo" /> --}}
                <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">Preloved Goods</span>
            </a>
            <ul class="space-y-2 font-medium">
                {{-- ADMIN NAVIGATIONS --}}
                @hasrole('admin')
                <x-sidebar-item route="admin.dashboard" icon="fa-solid fa-grip-vertical" label="Dashboard" />
                <x-dropdown-item label="Manage Users" icon="fa-solid fa-users" :items="[
                    ['label' => 'Seller', 'route' => route('admin.manage-seller')],
                    ['label' => 'Buyer', 'route' => route('admin.manage-buyer')],
                ]" />
                <x-sidebar-item route="admin.transactions.index" icon="fa-solid fa-money-bill-transfer" label="Transactions List" />
                <x-sidebar-item route="admin.orders.index" icon="fa-solid fa-cube" label="List Orders" />
                <x-sidebar-item route="admin.ratings.index" icon="fa-solid fa-star" label="Rating & Review" />
                @endhasrole
                {{-- SELLER NAVIGATIONS --}}
                @hasrole('seller')
                <x-sidebar-item route="seller.dashboard" icon="fa-solid fa-grip-vertical" label="Dashboard" />
                <x-sidebar-item route="seller.products.index" icon="fa-solid fa-shirt" label="My Products" />
                <x-sidebar-item route="seller.categories.index" icon="fa-solid fa-list" label="Categories" />
                <x-sidebar-item route="seller.shippings.index" icon="fa-solid fa-location-dot" label="Shipping Location & Fee" />
                <x-sidebar-item route="seller.orders.index" icon="fa-solid fa-boxes-stacked" label="Orders" />
                <x-sidebar-item route="seller.reviews.index" icon="fa-solid fa-star" label="Rating & Review" />
                <x-sidebar-item route="seller.reports.index" icon="fa-solid fa-square-poll-vertical" label="Report" />
                @endhasrole
            </ul>

            <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
                {{-- Settings --}}
                <x-sidebar-item route="settings.profile" icon="fa-solid fa-gear" label="Settings"
                    :isActive="request()->routeIs('seller.dashboard')" />

                {{-- Sign Out --}}
                <form method="POST" action="{{ route('logout') }}" class=''>
                    {{-- <x-sidebar-item type="submit" route="logout" icon="fa-solid fa-right-from-bracket"
                        label="Log Out" /> --}}
                    @csrf
                    <x-sidebar-item type="submit" route="logout" icon="fa-solid fa-right-from-bracket"
                        label="Log Out" />
                </form>
            </ul>
        </div>
    </aside>
    {{ $slot }}

    {{-- <flux:sidebar sticky stashable
        class="border-r border-zinc-200 bg-zinc-50 dark:border-gray-700 dark:bg-gray-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid">
                <flux:navlist.item icon="home" :href="route('admin.dashboard')"
                    :current="request()->routeIs('admin.dashboard')" wire:navigate>{{ __('Admin Dashboard') }}
                </flux:navlist.item>
                @hasrole('seller')
                <flux:navlist.item icon="home" :href="route('seller.dashboard')"
                    :current="request()->routeIs('seller.dashboard')" wire:navigate>{{ __('Seller Dashboard') }}
                </flux:navlist.item>
                <flux:navlist.item icon="home" :href="route('seller.products.index')"
                    :current="request()->routeIs('seller.products.index')" wire:navigate>{{ __('My Products') }}
                </flux:navlist.item>
                @endhasrole
                @hasrole('customer')
                <flux:navlist.item icon="home" :href="route('customer.dashboard')"
                    :current="request()->routeIs('customer.dashboard')" wire:navigate>{{ __('Customer Dashboard') }}
                </flux:navlist.item>
                @endhasrole --}}
                {{-- <flux:navlist.item icon="home" :href="route('dashboard')"
                    :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                --}}
                {{--
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer /> --}}

        <!-- Desktop User Menu -->
        {{-- <flux:dropdown position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon-trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-left text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown> --}}
        {{--
    </flux:sidebar> --}}


</body>

</html>