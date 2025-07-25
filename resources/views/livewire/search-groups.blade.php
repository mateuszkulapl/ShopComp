<div class="mx-auto">
    <form class="flex items-center w-full justify-center flex-wrap my-1 gap-y-2" action="{{ route('group.searchPost') }}"
          method="post">
        @csrf
        <label class="mr-4 text-md sm:text-lg" for="search">{{ __('search.search') }}</label>
        <div class="relative">
            <div class="flex w-96 sm:w-96 text-sm sm:text-md">
                <input
                    class="flex-auto py-1 px-2 shadow-sm bg-slate-700 hover:bg-slate-600 duration-100 hover:duration-300 border-none rounded-md outline-none ring-1 ring-slate-600 rounded-r-none mr-0 @if ($groups) rounded-b-none @endif "
                    id="search" name="search" type="text" value="" wire:model.live="search"
                    placeholder="Podaj nazwę produktu" required autocomplete="off">
                <button
                    class="flex-initial py-1 px-4 shadow-sm bg-slate-700 hover:bg-slate-600 duration-100 active:bg-slate-400 hover:duration-300 border-none rounded-md outline-none ring-1 ring-slate-600 rounded-l-none ml-0 @if ($groups) rounded-b-none @endif "
                    type="submit">{{ __('search.search_button') }}
                </button>
            </div>
            @if ($groups != null)
                <div
                    class="absolute z-30 block w-full text-sm sm:text-md ring-1 ring-slate-600 shadow-lg shadow-slate-900 bg-slate-600  rounded-b-md border-none"
                    id="searchResults" wire:loading.class.delay="loading">
                    @if ($groups->isNotEmpty())
                        <ul class="space-y-1">
                            @foreach ($groups as $group)
                                <li>
                                    <a class="pr-2  w-full flex items-center hover:bg-slate-500 active:bg-slate-400 duration-100 hover:duration-300"
                                       href="{{ $group->app_url }}">
                                        <div class="basis-2/12">
                                            @if ($group->oldestProduct->oldestImage)
                                                <div class="bg-white flex items-center">
                                                    <img class="max-w-full max-h-full w-auto mx-auto "
                                                         src="{{ $group->oldestProduct->oldestImage->getUrl(75) }}"
                                                         alt="{{ $group->oldestProduct->title }}">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="basis-10/12 pl-2 highlighted_search py-1">
                                            @if (Config::boolean('scout.enabled'))
                                                {!! $group->highlighted_title !!}
                                            @else
                                                {{ $group->oldestProduct->title }}
                                            @endif
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        @if ($groups->hasMorePages())
                            <a class="px-2 border-t py-2 border-slate-500 text-center bg-slate-700 hover:bg-slate-500 active:bg-slate-400 duration-100 hover:duration-300 w-full block rounded-b-md "
                               href="{{ route('group.search', ['searchTerm' => $searchTerm]) }}#produkty">
                                {{ __('search.see_all_matching',['searchTerm' =>$searchTerm]) }}
                            </a>
                        @endif
                    @else
                        <p class="px-2 border-t py-1">{{ __('search.products_not_found') }}</p>
                    @endif
                </div>
            @endif
        </div>

    </form>
</div>
