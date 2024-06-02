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
            @lang('internal_loan_provide.index')
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
                {{ route('internal_loan_provide.create') }}
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

                    <h4 class="header-title">@lang('internal_loan_provide.index')</h4>
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
                    <div class="tab-content">
                        <div class="tab-pane show active" id="roles-tab-all">
                            <table id="datatable-roles-all" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>@lang('internal_loan_provide.sl')</th>
                                        <th>@lang('internal_loan_provide.date')</th>
                                        <th>@lang('internal_loan_provide.name')</th>
                                        <th>@lang('internal_loan_provide.amount')</th>
                                        <th>@lang('common.action')</th>
                                    </tr>
                                </thead>
                            </table>
                        </div> <!-- end all-->

                        @php
                        use App\Models\internal_loan_provide;
                        $onlyTrashed = internal_loan_provide::leftjoin('internal_loan_registers','internal_loan_registers.id','internal_loan_provides.register_id')
                        ->onlyTrashed()
                        ->select('internal_loan_provides.*','internal_loan_registers.name')
                        ->get();
                        @endphp

                        <div class="tab-pane" id="roles-tab-deleted">
                            <table id="datatable-roles-deleted" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>@lang('internal_loan_provide.sl')</th>
                                        <th>@lang('internal_loan_provide.date')</th>
                                        <th>@lang('internal_loan_provide.name')</th>
                                        <th>@lang('internal_loan_provide.amount')</th>
                                        <th>@lang('common.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($onlyTrashed)
                                    @foreach ($onlyTrashed as $v)
                                    <tr>
                                        <td>{{$v->id}}</td>
                                        <td>
                                            {{$v->date}}
                                        </td>
                                        <td>
                                            {{$v->name}}
                                        </td>
                                        <td>{{$v->amount}}</td>
                                        <td>
                                            <a href="{{url('retrive_intloan_provide')}}/{{$v->id}}" class="btn btn-warning btn-sm"><i class="fa fa-rotate-right"></i> Retrive</a>
                                            <a onclick="return Confirm()" href="{{url('delete_intloan_provide')}}/{{$v->id}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Permenantly Delete</a>
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

    <script type="text/javascript">
        $(function () {
          var table = $('#datatable-roles-all').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route('internal_loan_provide.index') }}",
              columns: [
                  {data: 'sl', name: 'sl'},
                  {data: 'date', name: 'date'},
                  {data: 'name', name: 'name'},
                  {data: 'amount', name: 'amount'},
                  {data: 'action', name: 'action', orderable: false, searchable: false},
              ]
          });
        });
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

      <script>
        function changetTitleStatus(id)
        {
            // alert(id);
            $.ajax({
                headers : {
                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                },

                url : '{{ url('changetTitleStatus') }}',

                type : 'POST',

                data : {id},

                success : function(data)
                {
                    // alert(data);
                    toastr.success('Status Updated', 'Success');
                }
            });
        }
      </script>


    @include('components.delete_script')
@endpush
