<form method="POST" action="{{ route('admin.menu.save', ['menu' => $menu->id]) }}">
    {{ csrf_field() }}

    <div class="row">
        <div class="col">
            <div class="dd">
                <ol class="dd-list">

                    @foreach($menu->items as $item)
                        @if(!$item->items->count())
                            @component('menu::components.tree.item')
                                @slot('item', $item)
                            @endcomponent
                        @else
                            @component('menu::components.tree.child')
                                @slot('item', $item)
                            @endcomponent
                        @endif

                    @endforeach
                </ol>
            </div>


            <input id="sorts" name="sorts" type="hidden">
        </div>
    </div>


    <div class="row">
        <div class="col">
            <div class="form-group text-center">
                <button id="menuSave" class="btn btn-primary">Save</button>

                <a href="{{ route('admin.menu.delete', ['menu' => $menu->id]) }}"
                   class="btn  btn-danger"
                   data-delete="Данные навигации будут удалены! Продолжить?">
                    Delete navigation
                </a>
            </div>
        </div>
    </div>
</form>