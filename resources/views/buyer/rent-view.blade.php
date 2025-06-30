<x-layouts.customer-layout>
    <section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-10 mx-auto max-w-screen-xl px-4 2xl:px-0">
        <x-dashboard-header>MPPFind4U 🏠</x-dashboard-header>
        <div class="products-grid grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($products as $product)
                @include('components.rent.rent-card', ['product' => $product])
            @endforeach
        </div>

    </section>
</x-layouts.customer-layout>
