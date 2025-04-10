<div class="ml-auto flex  justify-end w-full max-w-md">
    <form class="w-1/2 py-2" action="{{ route('tasks.index') }}" method="GET">
        <div class="flex">
            <div class="relative w-full">
                <input type="search"
                       name="search"
                       class="block w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-s-md   border border-gray-300   focus:border-transparent focus:outline-none "
                       placeholder="Search title..." required/>
                <button type="submit"
                        class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-md   border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2"
                              d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </div>
        </div>
    </form>


</div>

