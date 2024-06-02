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


			<h3>Purchase  <a href="{{ route('purchase.index') }}" class="btn btn-success float-end rounded addbutton"><i class="fa fa-eye"></i>&nbsp;All Purchase</a></h3>



			<!--<div class="col-md-12 p-0">-->
				<!--	<div class="form-group mb-2 p-0 col-md-12">-->
					<!--		<label><b>Product Barcode:</b> </label>-->
					<!--		<div class="input-group" style="height: 45px;">-->
						<!--			<input type="text" name="barcode" id="barcode" class="form-control" placeholder="Product Barcode" onchange="productbarcodepurchaseadd()">-->
						<!--			<button type="button" class="border text-success" style="cursor: pointer;" onclick="productbarcodepurchaseadd()" title="Add Product"><i class="fa fa-refresh"></i></button>-->
						<!--		</div>-->
						<!--	</div>-->



						<form method="post" class="" id="purchaseForm">
                            @csrf
							<div class="col-md-12 p-0 row">

								<div class="form-group mb-2 col-md-6">
									<label>Supplier Name: <span class="text-danger" style="font-size: 15px;">*</span></label>
									<div class="input-group">
										<select class="form-control js-example-basic-single" name="supplier_id" id=
										"supplier_id" required="" onchange="return getSupplierCompany();" >
										<option value="">Select Supplier</option>
                                        @if($supplier)
                                        @foreach ($supplier as $v)
                                        <option value="{{$v->supplier_id}}">{{$v->supplier_id}} - {{$v->supplier_name_en}} - ( {{$v->supplier_phone}} )</option>
                                        @endforeach
                                        @endif
									</select>

								</div>
							</div>



{{--
					<div class="form-group mb-2 col-md-2">
						<label>Previous Due:</label>
						<div class="input-group">

							<input type="text" name="due" name="due" class="form-control" value="0.00" readonly="">

						</div>
					</div>
					--}}

					{{-- <div class="form-group mb-2 col-md-3 d-none">
						<label>Voucher No: <span class="text-danger" style="font-size: 15px;">*</span></label>
						<div class="input-group">
							<input type="text"  name="voucher_no" id="voucher_no" class="form-control" value="" placeholder="Voucher Number">

						</div>
					</div> --}}


					<div class="form-group mb-2 col-md-3">
						<label>Invoice Date: <span class="text-danger" style="font-size: 15px;">*</span></label>
						<div class="input-group">
							<input type="text" id="datepicker" name="invoice_date" id="datepicker" placeholder="Invoice Date" class="form-control" required="" value="{{ date('m/d/Y') }}" autocomplete="off">

						</div>
					</div>


                    <div class="form-group mb-2 col-md-3">
						<label>Company Information:</label>
						<div class="input-group suppliercompany">



						</div>
					</div>



					<div class="col-md-10">
						<div class="row">
							<div class="col-md-4">
{{--
								<div class="form-group mb-2">
									<label>Item Name:</label>
									<div class="input-group">

										<select class="form-control" name="item_id" id=
										"item_id" onchange="getproduct()">
										<option value="">Select Item</option>
										@php
										$item = DB::table('pdt_item')->where('item_status',1)->get();
										@endphp
										@foreach($item as $i)
										<option value="{{ $i->item_id  }}">{{ $i->item_name_en }} {{ $i->item_name_bn }} </option>
										@endforeach
									</select>

								</div>
							</div> --}}

						</div>

						<div class="col-md-12">

							<div class="row">
								<div class="form-group mb-2 col-md-12">
									<label>Product Name:</label>
									<div class="input-group">

										<select class="form-control js-example-basic-single" name="pdt_id" id=
										"pdt_id"  onchange="return purchaseproductcart()">
										<option value="">Select Product</option>
                                        @if($product)
                                        @foreach ($product as $v)
                                        <option value="{{$v->pdt_id}}">{{$v->pdt_id}} - {{$v->pdt_name_en}} - {{$v->pdt_name_bn}}</option>
                                        @endforeach
                                        @endif
									</select>
								</div>
							</div>





						</div>


						<div class="col-md-12">

							<div class="row">
								<div class="form-group mb-2 col-md-12">
									<label>Product Barcode:</label>
									<input type="text" class="form-control" name="product_barcode" id="product_barcode" onkeyup="purchaseproductcart2()">
							</div>





						</div>
                        </div>


					</div>
				</div>


				<div class="col-md-12 p-0 mt-2">
					<table class="table table-bordered table-responsive purchase">
						<thead class="bg-info text-light">
							<tr>
								<th>Name</th>
								<th>Qty</th>
								<th>P. Price</th>
								<th>Discount </th>
								<th>Cost</th>
								<th>S. Price</th>
								<th>Total</th>
								<th>Action</th>

							</tr>
						</thead>

						<tbody id="showdata">

						</tbody>
					</table>
				</div>




			</div>




			<div class="col-md-2">
				<div class="ibox-head myhead2 p-0">
					<div class="ibox-title2 bg-info text-light p-1"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Account</div>
				</div>

				<div class="col-md-12 bg-light p-3">
					<div class="form-group mb-2">
						<label>Total Amount:</label>
						<div class="input-group">

							<input type="text" id="totalamount" name="totalamount" class="form-control"  readonly="">

						</div>
					</div>

					<div class="form-group mb-2">
						<label>Discount:</label>
						<div class="input-group">

							<input type="text" id="discount" name="discount" class="form-control" placeholder="Discount" onkeyup="calculatediscount();" value="0">

						</div>
					</div>


					<div class="form-group mb-2">
						<label>Grand Total:</label>
						<div class="input-group">

							<input type="text" id="grandtotal" name="grandtotal" class="form-control"  readonly="">

						</div>
					</div>


					<div class="form-group mb-2">
						<label>Paid:</label>
						<div class="input-group">

							<input type="text" id="paid" name="paid" class="form-control" placeholder="Paid" onkeyup="calculatedue()" required="" value="0">

						</div>
					</div>


					<div class="form-group mb-2">
						<label>Due:</label>
						<div class="input-group">

							<input type="text" id="due" name="due" class="form-control"  readonly="">

						</div>
					</div>

					<div class="form-group mb-2">
						<label>Payment By:</label>
						<div class="input-group">
							<select class="form-control" name="transaction_type" id="transaction_type">
								<option value="Cash">Cash</option>
								<option value="Bank">Bank</option>
								<option value="Mobile Banking">Mobile Banking</option>

							</select>

						</div>
					</div>

				</div>

			</div>






		</div>




	</form>
    <div class="col-12 border p-4 mt-4">
        <center>
            <input type="submit" name="" value="Submit Now" class="btn btn-success" style="width: 150px; font-weight: bold; border-radius: 30px;" onclick="return getsubmit()">

        {{-- 	<input type="submit" name="draftpurchase" value="Draft Purchase" class="btn btn-dark" style="width: 150px; font-weight: bold; border-radius: 30px;"> --}}
        </center>


    </div>

</div>
</div>

</div>
</div>

<!-------End Table--------->



<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});





	function getproduct(){
		let item_id = $("#item_id").val();
		$.ajax({
			url: "{{ url('getproductajax') }}/"+item_id,
			type: 'get',
			data:{},
			success: function (data)
			{
				$("#pdt_id").html(data);
			},
			error:function(errors){
				alert("Select Item")
			}
		});

	}

	function getSupplierCompany(){
		let supplier_id = $("#supplier_id").val();
		$.ajax({
			url: "{{ url('getSupplierCompany') }}/"+supplier_id,
			type: 'get',
			data:{},
			success: function (data)
			{
                // alert(data);
				$(".suppliercompany").html(data);
			},
		});

	}




	showpurchaseproductcart();


	function purchaseproductcart(){
		let pdt_id = $("#pdt_id").val();

        // alert(pdt_id);

		$.ajax({
			url: "{{ url('purchaseproductcart') }}/"+pdt_id,
			type: 'GET',
			success: function (data)
			{


				showpurchaseproductcart();

				$("#pdt_id").val('');



			},
			error:function(errors){
				alert("Select Products");
			}
		});

	}


	function purchaseproductcart2(){
		let pdt_id = $("#product_barcode").val();

        // alert(pdt_id);

		$.ajax({
			url: "{{ url('purchaseproductcart2') }}/"+pdt_id,
			type: 'GET',
			success: function (data)
			{


				showpurchaseproductcart();

				$("#product_barcode").val('');


			},
			error:function(errors){
				alert("Select Products");
			}
		});

	}





	function showpurchaseproductcart(){
		$.ajax({
			url: "{{ url('showpurchaseproductcart') }}",
			type: 'get',
			data:{},
			success: function (data)
			{
				$("#showdata").html(data);

				let totalpurchaseamount = $("#totalpurchaseamount").val();
				$("#totalamount").val(totalpurchaseamount);
				$("#grandtotal").val(totalpurchaseamount);


			},
			error:function(errors){
				alert("errors")
			}
		});

	}






	function qtyupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let purchase_quantity = $("#purchase_quantity"+id).val();

		$.ajax({
			url: "{{ url('qtyupdate') }}/"+id,
			type: 'POST',
			data:{purchase_quantity:purchase_quantity},
			success: function (data)
			{

				showpurchaseproductcart();
			},
			error:function(errors){
				alert("errors")
			}
		});

	}




	function salepriceupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let sale_price_per_unit = $("#sale_price_per_unit"+id).val();

        let product_id = $('#product_id'+id).val();

		$.ajax({
			url: "{{ url('salepriceupdate') }}/"+id,
			type: 'POST',
			data:{sale_price_per_unit:sale_price_per_unit,product_id:product_id},
			success: function (data)
			{
				showpurchaseproductcart();
			},
			error:function(errors){
				alert("errors")
			}
		});

	}





	function purchasepriceupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let purchase_price = $("#purchase_price"+id).val();

        let product_id = $('#product_id'+id).val();

		$.ajax({
			url: "{{ url('purchasepriceupdate') }}/"+id,
			type: 'POST',
			data:{purchase_price:purchase_price,product_id:product_id},
			success: function (data)
			{
				showpurchaseproductcart();
			},
			error:function(errors){
				alert("errors")
			}
		});

	}






	function purchasepricedicount(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let discount_amount = $("#discount_amount"+id).val();

		$.ajax({
			url: "{{ url('purchasepricedicount') }}/"+id,
			type: 'POST',
			data:{discount_amount:discount_amount},
			success: function (data)
			{
				showpurchaseproductcart();
			},
			error:function(errors){
				alert("errors")
			}
		});

	}



	function purchasecostfunction(id){



		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let purchasecost = $("#purchasecost"+id).val();

		$.ajax({
			url: "{{ url('purchasecost') }}/"+id,
			type: 'POST',
			data:{purchasecost:purchasecost},
			success: function (data)
			{
				showpurchaseproductcart();
			},
			error:function(errors){
				alert("errors")
			}
		});

	}


    function submeasurmentupdate(id)
    {
        $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let sub_unit_id = $("#purchase_sub_measurement"+id).val();

        $.ajax({
			url: "{{ url('submeasurmentupdate') }}/"+id,
			type: 'POST',
			data:{sub_unit_id:sub_unit_id},
			success: function (data)
			{
				showpurchaseproductcart();
			},
		});
    }


    function purcahseoriginalmeasurement(id)
    {
        $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		// let sub_unit_id = $("#purchase_sub_measurement"+id).val();
		let purchase_quantity = $("#purchase_quantity"+id).val();

        $.ajax({
			url: "{{ url('purcahseoriginalmeasurement') }}/"+id,
			type: 'POST',
			data:{purchase_quantity:purchase_quantity},
			success: function (data)
			{
                // alert(data);
				showpurchaseproductcart();
			},
		});
    }










	function calculatediscount(){
		let total     = $("#totalamount").val();
		let discount  = $("#discount").val();



		if (discount != "" && discount>0) {
			let totaldiscount         = (parseFloat(total)-parseFloat(discount));
			$("#grandtotal").val(totaldiscount);

		}

		calculatedue();
		$("#due").val(0);
	}

	function calculatedue(){
		let grandtotal = $("#grandtotal").val();
		let paid       = $("#paid").val()

		let due = (parseFloat(grandtotal)-parseFloat(paid));
		$("#due").val(due.toFixed(2));

		calculatediscount();

	}






	function productbarcodepurchaseadd(){

		var barcode = $("#barcode").val();

		$.ajax({
			url: "{{ url('purchaseproductcart2') }}/"+barcode,
			type: 'GET',
			success: function (data)
			{
				showpurchaseproductcart();

				$("#barcode").val('');



			},
		});


	}




    function getsubmit()
    {
        let data = $('#purchaseForm').serialize();

        // alert(data);
        $.ajax({
			url:'{{ url('purchaseledger') }}',
			method:'POST',
			data:data,

			success:function(response){

                if(response == 'sub_unit_error')
                {
                    alert('Please Select Every Sub Unit From Your Purchase Product');

                }
                else
                {
                    window.open('{{URL::to('/invoicepurchase')}}'+'/'+response, "_blank");
    				location.reload();
                }


			},

			error:function(error){
				console.log(error)
			}
		});
    }







</script>

























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

	</script>


	@endpush




@endsection
