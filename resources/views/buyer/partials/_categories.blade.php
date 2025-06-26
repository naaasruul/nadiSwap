
<section class='antialiased dark:bg-gray-900 pt-8 mx-auto max-w-screen-xl px-4 2xl:px-0'>
    <h1 class="text-xl font-semibold sm:text-2xl ">Browse Categories</h1>
    <div  class="grid grid-cols-2 sm:grid-cols-3  md:grid-cols-5 gap-4 bg-gray-50 py-8">
    @foreach ($allCategories as $category)
        <a href='{{ route('buyer.dashboard') }}?category={{ $category->id }}' class="p-4 card hover:bg-purple-500 hover:text-white text-center hover:cursor-pointer  bg-white dark:bg-gray-800 shadow-md rounded-lg hover:shadow-lg transition-shadow duration-300">
            {{ $category->name }}
        </a>
    @endforeach
</div>
</section>