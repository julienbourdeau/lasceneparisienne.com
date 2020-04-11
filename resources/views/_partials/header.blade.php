<div class="container lg:my-6">

    <nav class="flex items-center justify-between flex-wrap p-4 md:px-0 lg:px-0">
        <div class="flex items-center flex-shrink-0 mr-6">
            <a href="{{ route('home') }}" class="font-thin text-xl tracking-tighter">La Scene Parisienne</a>
        </div>

        <div class="block lg:hidden">
            <button class="flex items-center px-3 py-2 border border-black rounded hover:text-red-800 hover:border-red-800" onclick="toggleMenu();">
                <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
            </button>
        </div>
        <div id="nav" class="w-full flex-grow lg:flex lg:items-center lg:w-auto">
            <div id="nav-links" class="hidden lg:block lg:flex-grow">
                <a href="{{ route('events') }}" class="block mt-4 lg:inline-block lg:mt-0 font-medium hover:text-red-800 mr-5">
                    Prochains Concerts
                </a>
                <a href="{{ route('venues') }}" class="block mt-4 lg:inline-block lg:mt-0 font-medium hover:text-red-800 mr-5">
                    Salles
                </a>
                <a href="{{ route('archives') }}" class="block mt-4 lg:inline-block lg:mt-0 text-sm hover:text-red-800 mr-5">
                    Archives
                </a>
                <a href="mailto:contact@lasceneparisienne.com" class="block mt-4 lg:inline-block lg:mt-0 text-sm hover:text-red-800 mr-5">
                    Contact
                </a>
            </div>
            <div id="search" class="mt-4 md:mt-6 lg:m-0 lg:relative">
                <search-container></search-container>
            </div>
        </div>
    </nav>

</div>

