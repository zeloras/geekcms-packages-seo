@extends('admin.layouts.main')

@section('title',  Translate::get('menu::admin.page_title') )

@section('content')

    <script>
        var menuIndexUrl = '{{ route('admin.menu') }}';
        var menuId = '{{ $menu->id ?? 0 }}';
    </script>

    <div class="row">
        <div class="col-6">
            <form class="form-inline" style="margin-bottom: 10px;">
                <label class="mr-sm-2" for="menu">
                    Выбор навигации:
                </label>

                <select class="form-control mb-2 mr-sm-2 mb-sm-0" id="menu">
                    <option></option>

                    @foreach($elements as $element)
                        @php($selected = ($menu && $element->id == $menu->id) ? 'selected' : '')

                        <option value="{{ $element->id }}" {{$selected}}>
                            {{ $element->name }} ({{ $element->lang }})
                        </option>
                    @endforeach
                </select>
            </form>

            <form class="form-inline"
                  style="margin-bottom: 10px;"
                  method="POST"
                  action="{{ route('admin.menu.create') }}">
                {{ csrf_field() }}

                <label class="mr-sm-2" for="menu">
                    Создать навигацию:
                </label>

                <input type="text" name="name" max="50" class="form-control mb-2 mr-sm-2 mb-sm-0">

                <select class="form-control mb-2 mr-sm-2 mb-sm-0" id="lang" name="lang">
                    @foreach($locales as $locale => $lang)
                        <option value="{{ $locale }}">
                            {{ array_get($lang, 'name', $locale) }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-primary">Создать</button>
            </form>

            @if($menu)
                @component('menu::components.tree.index')
                    @slot('menu', $menu)
                @endcomponent
            @endif

        </div>

        <div class="col-6">
            @if($menu)
                @include('menu::components.form')
            @endif
        </div>


    </div>
@endsection

@push('js')
    <script src="{{ asset('themes/admin/vendor/menu/jquery.nestable.js') }}"></script>
    <script src="{{ asset('themes/admin/vendor/menu/menu.js') }}"></script>
@endpush

@push('css')
    <link href="{{ asset('themes/admin/vendor/menu/menu.css') }}" rel="stylesheet" type="text/css">
    <style>
        .dd-actions {
            position: absolute;
            height: 100%;
            right: 0;
            top: 0;
            z-index: 9;
        }
    </style>
@endpush
