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
            @lang('sales.index_title')
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
                {{ route('sales.create') }}
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

                    <h4 class="header-title">@lang('sales.index_title')</h4>
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
                        <div class="tab-pane show active table-responsive" id="roles-tab-all">
                            <table id="datatable-roles-all" class="table table-striped nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>@lang('sales.invoice_date')</th>
                                        <th>@lang('sales.invoice_no')</th>
                                        <th>@lang('sales.customer_name')</th>
                                        <th>@lang('sales.products')</th>
                                        <th>@lang('sales.amount')</th>
                                        <th>@lang('common.action')</th>
                                    </tr>
                                </thead>
                            </table>
                        </div> <!-- end all-->

                        @php
                        use App\Models\sales_ledger;
                        use App\Models\sales_entry;
                        use App\Models\sales_payment;
                        $onlyTrashed = sales_ledger::onlyTrashed()->leftjoin('customer_infos','customer_infos.customer_id','sales_ledgers.customer_id')
                                        ->select('sales_ledgers.*','customer_infos.customer_name_en','customer_infos.customer_phone')
                                        ->get();
                        @endphp

                        <div class="tab-pane" id="roles-tab-deleted">
                            <table id="datatable-roles-deleted" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>@lang('sales.invoice_date')</th>
                                        <th>@lang('sales.invoice_no')</th>
                                        <th>@lang('sales.customer_name')</th>
                                        <th>@lang('sales.products')</th>
                                        <th>@lang('sales.amount')</th>
                                        <th>@lang('common.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($onlyTrashed)
                                    @foreach ($onlyTrashed as $v)
                                    <tr>
                                        <td>{{$v->invoice_date}}</td>
                                        <td>{{$v->invoice_no}}</td>
                                        <td>
                                            {{$v->customer_name_en}}<br>{{$v->customer_phone}}
                                        </td>
                                        <td>
                                            @php
                                            $product = sales_entry::onlyTrashed()->where('invoice_no',$v->invoice_no)
                                            ->leftjoin('product_informations','product_informations.pdt_id','sales_entries.product_id')
                                            ->leftjoin('measurement_subunits','measurement_subunits.id','sales_entries.sub_unit_id')
                                            ->select('sales_entries.*','product_informations.pdt_name_en','measurement_subunits.sub_unit_name')
                                            ->get();

                                            $output = '';

                                            if($product)
                                            {
                                                foreach($product as $p)
                                                {
                                                    $totalcost = $p->product_sales_price - $p->product_discount_amount;

                                                    $subtotal = $p->product_quantity * $totalcost;

                                                    $output .=  '<b>'.$p->pdt_name_en.'</b> ('.$p->product_quantity.' '.$p->sub_unit_name.' X '.$totalcost.' tk) = '.$subtotal.' tk';
                                                    $output.= '<br>';
                                                }
                                            }
                                            @endphp

                                            {!! $output !!}

                                        </td>
                                        <td>
                                            @php
                                           $sales_entry = sales_entry::onlyTrashed()->where('invoice_no',$v->invoice_no)->get();
                                            $sales_payment = sales_payment::onlyTrashed()->where('invoice_no',$v->invoice_no)->sum('payment_amount');
                                            $total = 0;
                                            if($sales_entry)
                                            {
                                                foreach($sales_entry as $p)
                                                {
                                                    $totalcost = $p->product_sales_price  - $p->product_discount_amount;
                                                    $total = ($total+($p->product_quantity * $totalcost));
                                                }
                                            }

                                            $grandtotal = $total - $v->final_discount;

                                            $output2 = 'Total : '.$total.' tk<br>
                                                    Discount: '.$v->discount.' tk<br>
                                                    Grand Total: '.$grandtotal.' tk<br>
                                                    <span class="badge bg-success">Paid : '.$sales_payment.' tk</span><br>
                                                    <span class="badge bg-danger">Due : '.$grandtotal - $sales_payment.' tk</span><br>';
                                            @endphp
                                            {!! $output2 !!}
                                        </td>
                                        <td>
                                            <a href="{{url('retrive_sales_ledger')}}/{{$v->invoice_no}}" class="btn btn-warning btn-sm"><i class="fa fa-rotate-right"></i> Retrive</a>
                                            <a onclick="return Confirm()" href="{{url('deleteper_salesledger')}}/{{$v->invoice_no}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Permenantly Delete</a>
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
              ajax: "{{ route('sales.index') }}",
              columns: [
                  {data: 'invoice_date', name: 'invoice_date'},
                  {data: 'invoice_no', name: 'invoice_no'},
                  {data: 'customer_info', name: 'customer_info'},
                  {data: 'product_info', name: 'product_info'},
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




    @include('components.delete_script')
@endpush
