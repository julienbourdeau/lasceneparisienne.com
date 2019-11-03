<div class="container lg:my-6">

    <nav class="flex items-center justify-between flex-wrap p-4 md:px-0 lg:px-0">
        <div class="flex items-center flex-shrink-0 mr-6">
            <a href="{{ route('home') }}" class="font-semibold text-xl tracking-tight">La Scene Parisienne</a>
        </div>

        <div class="block lg:hidden">
            <button class="flex items-center px-3 py-2 border border-black rounded hover:text-red-800 hover:border-red-800">
                <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
            </button>
        </div>
        <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
            <div class="text-sm lg:flex-grow">
                <a href="{{ route('events') }}" class="block mt-4 lg:inline-block lg:mt-0 hover:text-red-800 mr-4">
                    Concerts
                </a>
                <a href="{{ route('venues') }}" class="block mt-4 lg:inline-block lg:mt-0 hover:text-red-800 mr-4">
                    Salles
                </a>
            </div>
            <div>
                <a href="#" class="inline-block text-sm px-4 py-2 leading-none border border-black rounded hover:border-red-800 hover:text-red-800 mt-4 lg:mt-0">Contact</a>
            </div>
        </div>
    </nav>

</div>

