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
            @lang('salary_setup.index')
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
                {{ route('salary_setup.create') }}
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

                    <h4 class="header-title">@lang('salary_setup.index')</h4>
                    <form method="post" action="{{route('salary_payment.store')}}" class="row">
                        @csrf
                        @if($data)
                        @foreach ($data as $v)
                        {{-- <input type="checkbox" value="{{$v->employee_id}}" name="employee_id[]" id="checkinput" class="d-none"> --}}
                        @endforeach
                        @endif
                        <div class="col-md-4 mb-2">
                            <select class="form-control" name="month" required>
                                <option value="">Select Month</option>
									<option value="01">January</option>
									<option value="02">February</option>
									<option value="03">March</option>
									<option value="04">April</option>
									<option value="05">May</option>
									<option value="06">June</option>
									<option value="07">July</option>
									<option value="08">August </option>
									<option value="09">September </option>
									<option value="10">October </option>
									<option value="11">November </option>
									<option value="12">December </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="year" value="@php echo date('Y') @endphp">
                        </div>
                        <div class="col-md-4">
                            <input type="submit" class="btn btn-sm btn-success" value="Submit Salary">
                        </div>
                    <br>
                    <hr>
                    <table id="datatable-roles-deleted" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectall" onclick="return checkAll()"> <label for="selectall">Select All</label></th>
                                <th>@lang('salary_setup.sl')</th>
                                <th>@lang('salary_setup.employees')</th>
                                <th>@lang('salary_setup.employee_salary')</th>
                                <th>@lang('common.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($data)
                            @php
                            $i = 1;
                            @endphp
                            @foreach ($data as $v)
                                <tr>
                                    <td>
                                        <input type="checkbox" value="{{$v->employee_id}}" name="employee_id[]" id="checkinput">
                                    </td>
                                </form>
                                    <td>{{$i++}}</td>
                                    <td>{{$v->name}}</td>
                                    <td>{{$v->employee_salary}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a target="" class="dropdown-item" href="{{route('salary_setup.edit',$v->id)}}"><i class="fa fa-edit"></i> Edit</a>
                                                <form action="{{route('salary_setup.destroy',$v->id)}}" method="post">
                                                @csrf
                                                @method("DELETE")
                                                <button onclick="return Confirm()" type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table> <!-- end tab-content-->

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
              ajax: "{{ route('supplier.index') }}",
              columns: [
                  {data: 'supplier_id', name: 'supplier_id'},
                  {data: 'supplier_details', name: 'supplier_details'},
                  {data: 'company_details', name: 'company_details'},
                  {data: 'acounts', name: 'acounts'},
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

        function checkAll()
        {
            if($('#selectall').is(':checked'))
            {
                $('input#checkinput').prop('checked',true);
            }
            else
            {
                $('input#checkinput').prop('checked',false);
            }
        }
      </script>




    @include('components.delete_script')
@endpush
