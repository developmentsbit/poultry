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
<div class="container">

    @component('components.breadcrumb')
        @slot('title')
            @lang('asset_dep.index_title')
        @endslot
        @slot('breadcrumb1')
            @lang('common.dashboard')
        @endslot
        @slot('breadcrumb1_link')
            {{ route('dashboard') }}
        @endslot
        @if (\App\Traits\RolePermissionTrait::checkRoleHasPermission('role', 'create'))
            @slot('action_button1')
                @lang('common.add_new')
            @endslot
            @slot('action_button1_link')
                {{ route('asset_depreciation.create') }}
            @endslot
        @endif
        @slot('action_button1_class')
            btn-dark
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="header-title">@lang('asset_category.index_title')</h4>
                    <ul class="nav nav-tabs nav-bordered mb-3">
                        <li class="nav-item">
                            <a href="#roles-tab-all" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                All
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#roles-tab-deleted" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                Deleted
                            </a>
                        </li>
                    </ul> <!-- end nav-->
                    @php
                    $i =1;
                    @endphp
                    <div class="tab-content">
                        <div class="tab-pane show active" id="roles-tab-all">
                            <table id="datatable-roles-all" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>@lang('common.sl')</th>
                                        <th>@lang('asset_dep.title')</th>
                                        <th>@lang('asset_dep.depreciation_value')</th>
                                        <th>@lang('asset_dep.details')</th>
                                        <th>@lang('common.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($data))
                                    @foreach ($data as $d)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            @if((config('app.locale')) == 'en')
                                            {{ $d->title->title_en ?: $d->title->title_bn }}
                                            @else
                                            {{ $d->title->title_bn ?: $d->title->title_en }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $d->depreciation_value }} %
                                        </td>
                                        <td>
                                            {!! $d->details !!}
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a  class="btn btn-info btn-sm border-0 edit text-light" href="{{ route("asset_depreciation.edit",$d->id) }}"><i class="fa fa-edit"></i></a>
                                                <form action="{{ route('asset_depreciation.destroy',$d->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onClick="return confirm('Are You Sure?')"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div> <!-- end all-->

                        @php
                        use App\Models\asset_depreciation;
                        $onlyTrashed = asset_depreciation::onlyTrashed()
                        ->get();
                        @endphp

                        <div class="tab-pane" id="roles-tab-deleted">
                            <table id="datatable-roles-deleted" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>@lang('common.sl')</th>
                                        <th>@lang('asset_dep.title')</th>
                                        <th>@lang('asset_dep.depreciation_value')</th>
                                        <th>@lang('asset_dep.details')</th>
                                        <th>@lang('common.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($onlyTrashed)
                                    @foreach ($onlyTrashed as $d)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            @if((config('app.locale')) == 'en')
                                            {{ $d->title->title_en ?: $d->title->title_bn }}
                                            @else
                                            {{ $d->title->title_bn ?: $d->title->title_en }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $d->depreciation_value }} %
                                        </td>
                                        <td>
                                            {!! $d->details !!}
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a onClick="return confirm('Are You Sure?')"  class="btn btn-warning btn-sm border-0 edit text-light" href="{{ route("asset_depreciation.restore",$d->id) }}"><i class="fa fa-arrow-left"></i></a>
                                                <a onClick="return confirm('Are You Sure?')"  class="btn btn-danger btn-sm border-0 edit text-light" href="{{ route("asset_depreciation.delete",$d->id) }}"><i class="fa fa-trash"></i></a>

                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div> <!-- end deleted-->
                    </div> <!-- end tab-content-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
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
        $('#datatable-roles-all').DataTable();
    </script>

    <script>
        function assetCategoryStatus(id)
        {
            $.ajax({
                headers : {
                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                },
                url : '{{ url('asset_category_status') }}/'+id,
                type : 'GET',
                success : function(res)
                {
                    toastr.success("Status Changed Successfully");
                }
            })
        }
    </script>


      <script>
        function Confirm()
        {
            if(confirm("Are You Sure ?"))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
      </script>
@include('components.delete_script')
@endpush
