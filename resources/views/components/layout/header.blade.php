@props(['widthClasses'])
<header {{ $attributes->merge(['class' => 'bg-slate-900 mb-4 ']) }}>
    <div class="max-w-7xl w-full mx-auto px-2 py-2 flex justify-between">
        <div>
            <a href="{{route('group.index')}}" class="text-xl">{{ config('app.name') }}</a>
        </div>
        <div>
            <span onclick="document.querySelector('#headerSearch').classList.toggle('hidden');" class=" cursor-pointer">Szukaj</p>
        </div>
    </div>
    <div id="headerSearch" class="max-w-7xl w-full mx-auto px-2 py-0 hidden ">
        <form action="{{route('group.searchPost')}}" method="post" class=" flex items-center w-full justify-center">
            @csrf
            <label for="search" class=" text-lg mr-4">Wyszukaj</label>
            <input type="text" name="search" id="search" class="
                inline-block w-96 p-1 my-1
                text-md
                shadow-sm
                bg-slate-700 focus:bg-slate-600 hover:bg-slate-600
                border-none
                rounded-md
                outline-none
                ring-1 ring-slate-600 focus:ring-slate-400
                rounded-r-none
                mr-0
                "
                placeholder="Podaj nazwę produktu" required
                value="">
                
            <div id="buttons" class="flex items-center justify-center align-middle space-x-4">
                <button type="submit" class="
                    inline-block  p-1 my-1
                    text-md
                    shadow-sm
                    bg-slate-700 focus:bg-slate-500 hover:bg-slate-600
                    border-none
                    rounded-md
                    outline-none
                    ring-1 ring-slate-600 focus:ring-slate-400
                    rounded-l-none
                    ml-0
                    ">Szukaj!</button>
            </div>
        </form>
    </div>
</header>
