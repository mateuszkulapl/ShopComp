<h1>Groups index</h1>
@foreach ($groups as $group)
    <div>
        <h2><a href="{{ route('group.show', $group->ean) }}">{{ $group->ean }}</a></h2>
        <ul>
            @foreach ($group->products as $product)
                <li>{{ $product }}</li>
            @endforeach
        </ul>
    </div>
@endforeach
{{ $groups->links() }}
