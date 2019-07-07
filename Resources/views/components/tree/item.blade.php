<li class="dd-item" data-id="{{ $item->id }}">

    <div class="dd-handle">
        {{ $item->name }}
    </div>

    <div class="dd-actions">
        @component('menu::components.tree.actions')
            @slot('item', $item)
        @endcomponent
    </div>
</li>

