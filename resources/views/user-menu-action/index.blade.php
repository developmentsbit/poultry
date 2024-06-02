@extends('layouts.master')

@section('title') @lang('user_menu_action/attribute.index_title') @endsection

@section('custom-header-scripts')
    <link href="{{ asset('vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
    {{--<link href="{{ asset('vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>--}}
@endsection

@section('content')

    <div class="container-fluid">

        @component('components.breadcrumb')
            @slot('title') @lang('menu.menu') @endslot
            @slot('breadcrumb1') @lang('common.dashboard') @endslot
            @slot('breadcrumb1_link') {{ route('dashboard') }} @endslot
            @slot('action_button1') @lang('common.add_new') @endslot
            @slot('action_button1_link') {!! route('menu.create') !!} @endslot
            @slot('action_button1_class') btn-primary @endslot
        @endcomponent

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <table id="datatable" class="table table-bordered table-hover dt-responsive nowrap w-100">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Parent Menu</th>
                                    <th>Name</th>
                                    <th>Route Name</th>
                                    {{--<th>Type</th>
                                    <th>Slug</th>
                                    <th width="110px">Route</th>--}}
                                    <th width="110px">Status</th>
                                    <th width="150px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($user_menu_actions as $user_menu_action)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ @$user_menu_action->menu->name ?? '' }}</td>
                                    <td>{{ $user_menu_action->name }}</td>
                                    <td>{{ $user_menu_action->route_name }}</td>
                                    <td>
                                        <span class="badge rounded-pill @if($user_menu_action->status == 1) bg-primary @else bg-warning @endif">
                                            @if($user_menu_action->status == 1) {{ 'Active' }} @else {{ 'Inactive' }} @endif
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="{!! route('user_menu_action.index', $user_menu_action->id) !!}">
                                                @include('components.show_svg',['has_access' => true])
                                            </a>&nbsp;&nbsp;
                                            <a href="{!! route('menu.edit', $user_menu_action->id) !!}">
                                                @include('components.edit_svg',['has_access' => true])
                                            </a>&nbsp;&nbsp;
                                            <form action="{{ route('menu.destroy',$user_menu_action->id) }}" method="Post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="border: unset; background: unset;" class="show_confirm" data-toggle="tooltip" title="Delete">
                                                    @include('components.delete_svg',['has_access' => true])
                                                </button>
                                            </form>
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
    </div>
@endsection

@section('script')
    {{--yajra datatable--}}

    <script type="text/javascript">
        let datatable_columns = [
            {data: 'parent_menu',name: 'parent_menu',},
            {data: 'name',name: 'name',},
            {data: 'route_name',name: 'route_name',},
            {data: 'type_name',name: 'type_name',},
            {data: 'slug',name: 'slug',},
            {data: 'order_by',name: 'order_by',},
            {data: 'status',name: 'status',},
            {
                data: 'action',
                name: 'action',
                orderable: false,
            },
        ]
        let datatable_columns_defs = [
            { className: 'text-center', targets: [0,3,4,5] },
        ]
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 25,
            serverMethod: 'get',
            lengthMenu: [10, 25, 50,100],
            order: [ 5, "asc" ],
            language: {
                'loadingRecords': '&nbsp;',
                'processing': 'Loading ...'
            },
            ajax: {
                url: '{{ route('user_menu_action.index',$menu->id) }}',
                type: 'get',
                dataType: 'JSON',
                cache: false,
            },
            columns: datatable_columns,
            columnDefs: datatable_columns_defs,
        });

        $('#deleted_list_datatable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 25,
            serverMethod: 'get',
            lengthMenu: [10, 25, 50,100],
            order: [ 0, "asc" ],
            language: {
                'loadingRecords': '&nbsp;',
                'processing': 'Loading ...'
            },
            ajax: {
                url: '{{ route('user_menu_action.index',$menu->id) }}',
                type: 'get',
                dataType: 'JSON',
                cache: false,
            },
            columns: datatable_columns,
            search: {
                "regex": true
            },
            columnDefs: datatable_columns_defs,
        });

        function statusChange(id){
            statusUpdate(id, '{{route('user_menu_action.status')}}')
        }
    </script>

    {{--@include('components.delete_script')--}}
@endsection
