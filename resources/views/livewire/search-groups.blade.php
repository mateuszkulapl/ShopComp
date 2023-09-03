<div class="mx-auto">
    <form class="flex items-center w-full justify-center flex-wrap my-1" action="{{ route('group.searchPost') }}" method="post">
        @csrf
        <label class="mr-4 text-md sm:text-lg" for="search">Wyszukaj</label>
        <div class="relative">

            <input class="inline-block w-48 sm:w-96 text-sm sm:text-md py-1 px-2 shadow-sm bg-slate-700 hover:bg-slate-600 duration-100 hover:duration-300 border-none rounded-md outline-none ring-1 ring-slate-600 rounded-r-none mr-0 @if ($groups) rounded-b-none @endif " id="search" name="search" type="text" value="" wire:model="search" placeholder="Podaj nazwę produktu" required autocomplete="off"><button class="inline-block py-1 px-4 text-sm sm:text-md shadow-sm bg-slate-700 hover:bg-slate-600 active:bg-slate-400 duration-100 hover:duration-300 border-none rounded-md outline-none ring-1 ring-slate-600 rounded-l-none ml-0 @if ($groups) rounded-b-none @endif " type="submit">Szukaj!
            </button>
            @if ($groups != null)
                <div class="absolute z-30 block w-full text-sm sm:text-md ring-1 ring-slate-600 shadow-lg shadow-slate-900 bg-slate-600  rounded-b-md border-none" id="searchResults" wire:loading.class.delay="loading">
                    @if ($groups->isNotEmpty())
                        <ul class="space-y-1">
                            @foreach ($groups as $group)
                                <li>
                                    <a class="pr-2  w-full flex items-center hover:bg-slate-500 active:bg-slate-400 duration-100 hover:duration-300 " href="{{ $group->app_url }}">
                                        <div class="basis-2/12">
                                            @if ($group->oldestProduct->oldestImage)
                                                <div class="bg-white flex items-center rounded-t-md">
                                                    <img class="max-w-full max-h-full w-auto mx-auto " src="{{ $group->oldestProduct->oldestImage->getUrl(75) }}" alt="{{ $group->oldestProduct->title }}">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="basis-10/12 pl-2">
                                            {{ $group->oldestProduct->title }}
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        @if ($groups->hasMorePages())
                            <a class="px-2 border-t py-2 border-slate-500 text-center bg-slate-700 hover:bg-slate-500 active:bg-slate-400 duration-100 hover:duration-300 w-full block rounded-b-md " href="{{ route('group.search', ['searchTerm' => $searchTerm]) }}#produkty">
                                Zobacz wszystke pasujące do "{{ $searchTerm }}"
                            </a>
                        @endif
                    @else
                        <p class="px-2 border-t py-1">Nie znaleziono produktów</p>
                    @endif
                </div>
            @endif
        </div>

    </form>
</div>
