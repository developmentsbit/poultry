@extends('layouts.master')

@push('header_styles')
    <!-- third party css -->
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/buttons.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/select.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <!-- third party css end -->
@endpush

@section('content')
    <div class="container-fluid">

        @component('components.breadcrumb')
            @slot('title')
                @lang('menu.menu')
            @endslot
            @slot('breadcrumb1')
                @lang('common.dashboard')
            @endslot
            @slot('breadcrumb1_link')
                {{ route('dashboard') }}
            @endslot
            @slot('action_button1')
                @lang('common.add_new')
            @endslot
            @slot('action_button1_link')
                {!! route('menu.create') !!}
            @endslot
            @slot('action_button1_class')
                btn-primary
            @endslot
        @endcomponent

        <div class="row">
            <div class="col-xl-12">
                <div>
                    <table id="datatable-menus-all" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>
                                    @lang('menu.default_icon')
                                    <div class="checkbox align-self-center">
                                        {{-- <div class="custom-control custom-checkbox ">
                                            <input type="checkbox" class="custom-control-input" id="checkAll" required="">
                                            <label class="font-weight-bold" class="custom-control-label" for="checkAll"></label>
                                        </div> --}}
                                    </div>
                                </th>
                                <th>@lang('menu.parent_menu')</th>
                                <th>@lang('menu.menu_name')</th>
                                <th>@lang('menu.route_name')</th>
                                <th>@lang('menu.status')</th>
                                <th>@lang('menu.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menus as $menu)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            {{-- <div class="checkbox text-right align-self-center">
                                            <div class="custom-control custom-checkbox ">
                                                <input type="checkbox" class="custom-control-input" id="customCheckBox2" required="">
                                                <label class="font-weight-bold" class="custom-control-label" for="customCheckBox2"></label>
                                            </div>
                                        </div> --}}
                                            <img alt=""
                                                src="{{ $menu->default_image ? asset('storage/menu/' . $menu->default_image ?? '') : asset('assets/images/no_image.png') }}"
                                                height="30px" width="30px" class="{{-- rounded-circle --}}">
                                        </div>
                                    </td>
                                    <td>{{ @$menu->parent->name ?? '' }}</td>
                                    <td>{{ $menu->name }}</td>
                                    <td>{{ $menu->route_name }}</td>
                                    <td>
                                        <span
                                            class="badge rounded-pill @if ($menu->status == 1) bg-primary @else bg-warning @endif">
                                            @if ($menu->status == 1)
                                                {{ 'Active' }}
                                            @else
                                                {{ 'Inactive' }}
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="{!! route('user_menu_action.index', $menu->id) !!}">
                                                @include('components.show_svg', ['has_access' => true])
                                            </a>&nbsp;&nbsp;
                                            <a href="{!! route('menu.edit', $menu->id) !!}">
                                                @include('components.edit_svg', ['has_access' => true])
                                            </a>&nbsp;&nbsp;
                                            <a class="destroy mb-1" href="{{ route('menu.destroy', $menu->id) }}"
                                                data-id="1" data-route="{{ route('menu.destroy', $menu->id) }}"
                                                data-status="" *data-toggle="tooltip" data-placement="top" *=""
                                                title="Delete">
                                                @include('components.delete_svg', [
                                                    'has_access' => true,
                                                ])
                                            </a>
                                            {{-- <form action="#" method="Post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="border: unset; background: unset;"
                                                    class="show_confirm" data-toggle="tooltip" title="Delete">
                                                    @include('components.delete_svg', [
                                                        'has_access' => true,
                                                    ])
                                                </button>
                                            </form> --}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer_scripts')
    <!-- third party js -->
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.select.min.js') }}"></script>
    <!-- third party js ends -->

    <!-- demo app -->
    <script src="{{ asset('assets/js/pages/demo.datatable-init.js') }}"></script>
    <!-- end demo js-->

    <script>
        $('#datatable-menus-all').DataTable({});

        $('#datatable-menus-all tbody').on('click', '.show_confirm', function() {
            let form = $(this).closest("form");
            event.preventDefault();
            swal({
                    title: `Are you sure you want to delete this menu?`,
                    text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    </script>

    @include('components.delete_script')
@endpush
