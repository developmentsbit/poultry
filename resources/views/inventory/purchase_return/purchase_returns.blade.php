@extends('layouts.master')
@section('content')

@push('header_styles')
<!-- third party css -->
<link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/vendor/buttons.bootstrap5.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/vendor/select.bootstrap5.css') }}" rel="stylesheet" type="text/css">
<!-- third party css end -->

<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.6.4.slim.min.js"></script>
<style>
    .form-control {
    padding: 4px 9px;
    font-size: 14px;
    border-radius: 0px !important;
}


</style>
@endpush




<div class="container-fluid mt-2">
	<div class="card">
		<div class="card-body p-2">


			<h3>Purchase Return  <a href="{{ route('purchase_return.index') }}" class="btn btn-success float-end rounded addbutton"><i class="fa fa-eye"></i>&nbsp;All Purchase Return</a></h3>
            <hr>
				<form method="post" class="" id="" action="{{url('submitPurchaseReturnForm')}}/{{$data['purchase_ledger']->invoice_no}}">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <b>Invoice No :</b> <span>{{$data['purchase_ledger']->invoice_no}}</span><br>
                        <b>Purchase Date : </b> <span>{{$data['purchase_ledger']->invoice_date}}</span><br>
                        <b>Supplier Name : </b> <span>{{$data['supplier']->supplier_name_en}}, {{$data['supplier']->supplier_phone}}</span>
                        <input type="hidden" name="supplier_id" value="{{$data['supplier']->supplier_id}}">
                    </div>
                    <div class="col-12 mt-3">
                        <table class="table table-borderd">
                            <tr class="table-success">
                                <th>Product Name</th>
                                <th style="width: 15%">Return Quantity</th>
                                <th style="width: 17%">Price (p/u)</th>
                                <th style="width : 20%;">Total</th>
                            </tr>
                            <tr>
                                <td>
                                    {{$data['purchase_entries']->pdt_name_en}}
                                    <input type="hidden" name="product_id" value="{{$data['purchase_entries']->product_id}}">
                                </td>
                                <td>
                                    @php
                                    $return_qty = App\Models\purchase_entry::where('product_id',$data['purchase_entries']->product_id)->where('invoice_no',$data['purchase_entries']->invoice_no)->where('product_quantity','=',NULL)->sum('return_quantity');
                                    $total_qty = $data['purchase_entries']->product_quantity - $return_qty;
                                    @endphp
                                    <input type="text" class="form-control form-control-sm" value="{{$total_qty}}" name="return_quantity" id="return_quantity" onkeyup="calculateReturnAmount()">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" value="{{($data['purchase_entries']->purchase_price + $data['purchase_entries']->per_unit_cost) - $data['purchase_entries']->discount_amount}}" name="price_per_unit" id="price_per_unit" onkeyup="calculateReturnAmount()">
                                </td>
                                @php
                                $total = ($data['purchase_entries']->purchase_price + $data['purchase_entries']->per_unit_cost) - $data['purchase_entries']->discount_amount ;

                                @endphp
                                <td>
                                    <input readonly type="text" class="form-control form-control-sm" value="{{$total * $data['purchase_entries']->product_quantity}}" name="total" id="total">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;">Supplier Present Due</td>
                                @php
                                $previous_due = App\Models\supplier_payment::where('supplier_id',$data['supplier']->supplier_id)->where('comment','PD')->sum('previous_due');
                                $total_purchase = App\Models\purchase_ledger::where('suplier_id',$data['supplier']->supplier_id)->sum('total');
                                $total_pd = App\Models\purchase_ledger::where('suplier_id',$data['supplier']->supplier_id)->sum('discount');
                                $total_paid_amount = App\Models\supplier_payment::where('supplier_id',$data['supplier']->supplier_id)->sum('payment');
                                $total_return_amount = App\Models\supplier_payment::where('supplier_id',$data['supplier']->supplier_id)->sum('return_amount');
                                $result = ( ($total_purchase - $total_pd) - $total_paid_amount - $total_return_amount) + $previous_due;
                                @endphp


                                <td class="">
                                    <input readonly type="text" class="form-control form-control-sm" value="{{$result}}" id="supplier_present_due" name="supplier_present_due">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;">Grand Total (Minus)</td>
                                <td>
                                    <input readonly type="text" class="form-control form-control-sm" value="{{$total * $data['purchase_entries']->product_quantity}}" id="grandtotal" name="grandtotal">
                                </td>
                            </tr>

                            {{-- <tr>
                                <td colspan="3" style="text-align: right">Return Pay :</td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" name="returnpaid" id="returnpaid">
                                </td>
                            </tr> --}}
                            <tr>
                                <td colspan="3" style="text-align: right;">Supplier New Balance</td>
                                <td>
                                    <input readonly type="text" class="form-control form-control-sm" value="{{$result - ($total * $data['purchase_entries']->product_quantity)}}" id="supplier_new_balance" name="supplier_new_balance">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12" style="text-align: center">
                        <input type="submit" name="submit" id="" class="btn btn-sm btn-success" value="Submit Purchase Return">
                    </div>
                </div>
            </form>
			</div>
		</div>
</div>
</div>

</div>
</div>

<!-------End Table--------->


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

	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>



	<script>
		$('#datepicker').datepicker({
			uiLibrary: 'bootstrap4'
		});

        function calculateReturnAmount()
        {
            let return_qty = $('#return_quantity').val();
            let price_per_unit = $('#price_per_unit').val();

            let result;

            result = return_qty * price_per_unit;

            $('#total').val(result);
            $('#grandtotal').val(result);

            let supplier_present_due = $('#supplier_present_due').val();

            let present_supplier_balance;

            present_supplier_balance = supplier_present_due - result;

            $('#supplier_new_balance').val(present_supplier_balance);
        }

	</script>

	@endpush




@endsection
