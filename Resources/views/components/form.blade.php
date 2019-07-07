<form method="POST" action="{{ route('admin.menu.item.save', ['item' => $item->id ?? null]) }}">
    {{ csrf_field() }}
    <input name="action" id="action" type="hidden">
    <input name="menu_id" id="menuId" type="hidden" value="{{ $menu->id ?? '' }}">

    <div class="form-group">
        <label for="itemName">Заголовок:</label>
        <input required
               class="form-control"
               id="itemName"
               name="name"
               value="{{ old('name',$item->name ?? '') }}">
    </div>

    <div class="form-group">
        <label for="actionType">Тип ссылки:</label>

        <select class="form-control" id="actionType" required>
            <option></option>
            <?php
            $action = ($item)
                ? array_get(array_keys($item->action), 0)
                : null;

            $isPage = ('route' === $action && 'page.open' === array_get($item->action, 'route'))
                ? true
                : false;
            ?>

            <option value="link" {{ $action == 'link' ? 'selected': '' }}>
                Прямая ссылка
            </option>
            <option value="anhor" {{ $action == 'anhor' ? 'selected': '' }}>
                Якорь
            </option>
            <option value="page" {{ $isPage  ? 'selected': '' }}>
                Страница
            </option>
        </select>

        <small id="actionTypeHelp" class="form-text text-muted"></small>
    </div>

    {{--start--}}
    <div class="form-group">
        <label for="iActionLink">link:</label>
        <input class="form-control"
               type="url"
               id="iActionLink"
               value=""
               placeholder="https://google.com">
    </div>

    <div class="form-group">
        <label for="iActionAnhor">Anhor:</label>
        <input class="form-control"
               id="iActionAnhor"
               type="text"
               value="{{ array_get($item->action ?? '', 'anhor') }}"
               placeholder="#title">
    </div>

    <div class="form-group">
        <label for="iActionPage">Page:</label>
        <select required class="form-control" id="iActionPage">
            <option></option>
            @foreach($pages as $page)
                <?php
                $selected = ($item && 'page.open' === array_get($item->action, 'route')
                    && array_get($item->action, 'params.page') === $page->slug)
                    ? 'selected'
                    : '';
                ?>
                <option value="route::page.open|page={{ $page->slug }}" {{$selected}}>{{ $page->name }}</option>
            @endforeach
        </select>


    </div>

    {{--end--}}


    <button id="itemCreate" class="btn btn-primary">Изменить</button>
</form>

@push('script')
    <script>
        // тип ссылки
        toggleFormGroup('#actionType', {
            link: {
                off: '#iActionPage, #iActionAnhor',
                on: '#iActionLink',
                require: true,
            },

            anhor: {
                off: '#iActionLink, #iActionPage',
                on: '#iActionAnhor',
                require: true,
            },

            page: {
                off: '#iActionAnhor, #iActionLink',
                on: '#iActionPage',
                require: true,
            }
        }, function (element, name) {

            var action = $('#action'),
                help = $('#actionTypeHelp');

            function setData(data){
                action.val(data);
                help.html(data);
            }


            // link
            if (name == 'link') {
                var eLink = $('#iActionLink');

                setData('link::' + $(eLink).val());

                eLink.keyup(function (e) {
                    setData('link::' + $(eLink).val());
                });
            }

            // anhor
            if (name == 'anhor') {
                var eAnhor = $('#iActionAnhor');

                setData('anhor::' + $(eAnhor).val());

                eAnhor.keyup(function (e) {
                    setData('anhor::' + $(eAnhor).val());
                });
            }

            if (name == 'page') {
                var ePage = $('#iActionPage');

                setData($(ePage).val());

                ePage.bind('change', function (e) {
                    setData($(ePage).val());
                });
            }

        });


    </script>
@endpush