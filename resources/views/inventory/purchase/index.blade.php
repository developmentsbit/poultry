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
            @lang('purchase.index_title')
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
                {{ route('purchase.create') }}
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

                    <h4 class="header-title">@lang('purchase.index_title')</h4>
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
                                        <th>@lang('purchase.invoice_date')</th>
                                        <th>@lang('purchase.invoice_no')</th>
                                        <th>@lang('purchase.supplier_name')</th>
                                        <th>@lang('purchase.products')</th>
                                        <th>@lang('purchase.amount')</th>
                                        <th>@lang('common.action')</th>
                                    </tr>
                                </thead>
                            </table>
                        </div> <!-- end all-->

                        @php
                        use App\Models\purchase_ledger;
                        use App\Models\purchase_entry;
                        use App\Models\supplier_payment;
                        $onlyTrashed = purchase_ledger::onlyTrashed()->leftjoin('supplier_infos','supplier_infos.supplier_id','purchase_ledgers.suplier_id')
                                        ->select('purchase_ledgers.*','supplier_infos.supplier_name_en','supplier_infos.supplier_phone')
                                        ->get();
                        @endphp

                        <div class="tab-pane" id="roles-tab-deleted">
                            <table id="datatable-roles-deleted" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>@lang('purchase.invoice_date')</th>
                                        <th>@lang('purchase.invoice_no')</th>
                                        <th>@lang('purchase.supplier_name')</th>
                                        <th>@lang('purchase.products')</th>
                                        <th>@lang('purchase.amount')</th>
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
                                            {{$v->supplier_name_en}}<br>{{$v->supplier_phone}}
                                        </td>
                                        <td>
                                            @php
                                            $product = purchase_entry::where('invoice_no',$v->invoice_no)
                                            ->leftjoin('product_informations','product_informations.pdt_id','purchase_entries.product_id')
                                            ->leftjoin('measurement_subunits','measurement_subunits.id','purchase_entries.sub_unit_id')
                                            ->select('purchase_entries.*','product_informations.pdt_name_en','measurement_subunits.sub_unit_name')
                                            ->get();
                                            $output = '';

                                            if($product)
                                            {
                                                foreach($product as $p)
                                                {
                                                    $totalcost = ($p->purchase_price + $p->per_unit_cost) - $p->discount_amount;

                                                    $subtotal = $p->product_quantity * $totalcost;

                                                    $output .=  '<b>'.$p->pdt_name_en.'</b> ('.$p->product_quantity.' '.$p->sub_unit_name.' X '.$totalcost.') = '.$subtotal;
                                                    $output.= '<br>';
                                                }
                                            }
                                            @endphp

                                            {!! $output !!}

                                        </td>
                                        <td>
                                            @php
                                            $purchase_entry = purchase_entry::where('invoice_no',$v->invoice_no)->get();
                                            $supplier_payment = supplier_payment::where('invoice_no',$v->invoice_no)->sum('payment');
                                            $total = 0;
                                            if($purchase_entry)
                                            {
                                                foreach($purchase_entry as $p)
                                                {
                                                    $totalcost = ($p->purchase_price + $p->per_unit_cost) - $p->discount_amount;
                                                    $total = ($total+($p->product_quantity * $totalcost));
                                                }
                                            }

                                            $grandtotal = $total - $v->discount;

                                            $output2 = 'Total : '.$total.'<br>
                                                    Discount: '.$v->discount.'<br>
                                                    Grand Total: '.$grandtotal.'<br>
                                                    <span class="badge bg-success">Paid : '.$supplier_payment.'</span><br>
                                                    <span class="badge bg-danger">Due : '.$grandtotal - $supplier_payment.'</span><br>';
                                            @endphp
                                            {!! $output2 !!}
                                        </td>
                                        <td>
                                            <a href="{{url('retrive_purchase_ledger')}}/{{$v->invoice_no}}" class="btn btn-warning btn-sm"><i class="fa fa-rotate-right"></i> Retrive</a>
                                            <a onclick="return Confirm()" href="{{url('deleteper_purchaseledger')}}/{{$v->invoice_no}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Permenantly Delete</a>
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
              ajax: "{{ route('purchase.index') }}",
              columns: [
                  {data: 'invoice_date', name: 'invoice_date'},
                  {data: 'invoice_no', name: 'invoice_no'},
                  {data: 'supplier_info', name: 'supplier_info'},
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

      <script>
        function changeBrandStatus(id)
        {
            // alert(id);
            $.ajax({
                headers : {
                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                },

                url : '{{ url('changeBrandStatus') }}',

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
