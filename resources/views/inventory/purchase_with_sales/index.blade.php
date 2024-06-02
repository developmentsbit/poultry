@extends('layouts.master')
@section('content')

@push('header_styles')
<!-- third party css -->
<link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/vendor/buttons.bootstrap5.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/vendor/select.bootstrap5.css') }}" rel="stylesheet" type="text/css">
<!-- third party css end -->
<script src="https://code.jquery.com/jquery-3.6.4.slim.min.js"></script>
@endpush



	<div class="container-fluid mt-2">
		<div class="card">
			<div class="card-body">


				<h3>Purchase with Sales<a href="{{ route('sales.index') }}" class="btn btn-success float-end rounded addbutton"><i class="fa fa-eye"></i>&nbsp;All Sales</a></h3><br>
                <form method="post" class="btn-submit" id="" action="{{url('submitpurchasesales')}}">
                    @csrf

                    <div class="col-md-12 p-0 row">

                        <div class="form-group mb-2 col-md-4">
                            <label>Customer Name: <span class="text-danger" style="font-size: 15px;">*</span></label>
                            <div class="input-group">

                                <select class="form-control js-example-basic-single2" name="customer_id" id=
                                "customer_id" required="" onchange="">
                                <option value="">Select Customer</option>
                                @foreach($first_customer as $i)
                                <option value="{{ $i->customer_id  }}">{{ $i->customer_id }} - {{ $i->customer_name_en }} - {{$i->customer_phone}}</option>
                                @endforeach
                            </select>

                            </div>
                        </div>
                        <div class="form-group mb-2 col-md-4">
                            <label>3rd Party Customer Name: <span class="text-danger" style="font-size: 15px;">*</span></label>
                            <div class="input-group">

                                <select class="form-control js-example-basic-single3" name="third_party" id=
                                "third_party" required="" onchange="">
                                <option value="">Select Customer</option>
                                @foreach($third_party as $i)
                                <option value="{{ $i->customer_id  }}">{{ $i->customer_id }} - {{ $i->customer_name_en }} - {{$i->customer_phone}}</option>
                                @endforeach
                            </select>

                            </div>
                        </div>

                        <div class="form-group mb-2 col-md-3">
                            <label>Invoice Date:<span class="text-danger" style="font-size: 15px;">*</span></label>
                            <div class="input-group">
                                <input value="@php echo date('m/d/Y'); @endphp" type="text" name="invoice_date" id="datepicker" placeholder="Invoice Date" class="form-control" required="" autocomplete="off">

                            </div>
                        </div>
						<div class="col-md-12">
							<div class="row">
								<div class="form-group mb-2 col-md-12">
									<label>Product Name: </label>
									<div class="input-group">

										<select class="form-control js-example-basic-single" name="pdt_id" id=
										"pdt_id"  onchange="return purchasesalesproduct()">
										<option value="">Select Product</option>
                                        @if($product)
                                        @foreach ($product as $v)
                                        <option value="{{$v->pdt_id}}">{{$v->pdt_id}} - {{$v->pdt_name_en}}</option>

                                        @endforeach
                                        @endif
									</select>

								</div>
							</div>
						</div>
					</div>
				</div>
            </div>

				<div class="col-md-12 p-0 mt-2">
					<table class="table table-bordered table-responsive purchase">
						<thead class="bg-info text-light">
							<tr>
								<th>SL</th>
								<th>Name</th>
								<th style="width:10%;">Qty</th>
								<th style="width:10%">Sub Unit</th>
								<th>P. Price (Unit)</th>
								<th>S. Price (Unit)</th>
								<th>Discount (Unit)</th>
								<th>Note</th>
								<th>Sub Total</th>
								<th>Action</th>

							</tr>
						</thead>

						<tbody id="showdata">

						</tbody>
					</table>
				</div>









			<div class="col-md-2">
				<div class="ibox-head myhead2 p-0">
					<div class="ibox-title2 bg-info text-light p-2"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Account</div>
				</div>

				<div class="col-md-12 bg-light p-3">
					<div class="form-group">
						<label>Total Sales Amount:</label>
						<div class="input-group">

							<input type="text" id="totalamountsales" name="totalamountsales" class="form-control"  readonly="">

						</div>
					</div>




					<div class="form-group">
						<label>Discount:</label>
						<div class="input-group">

							<input type="text" id="sales_discount" name="sales_discount" class="form-control" placeholder="Discount" onkeyup="" value="0" autocomplete="off">

						</div>
					</div>



					<div class="form-group">
						<label>Total Purchase Amount:</label>
						<div class="input-group">

							<input type="text" id="totalpurchaseamount" name="totalpurchaseamount" class="form-control"  readonly="">

						</div>
					</div>


                    <div class="form-group">
						<label>Discount:</label>
						<div class="input-group">

							<input type="text" id="purchase_discount" name="purchase_discount" class="form-control" placeholder="Discount" onkeyup="" value="0" autocomplete="off">

						</div>
					</div>


					{{-- @php
					$vat = DB::table("company_info")->first();
					@endphp

					<div class="form-group">
						<label>Vat ({{ $vat->vat  }} %):</label>
						<div class="input-group">

							<input type="hidden" id="vathidden" name="vathidden" class="form-control"  value="{{ $vat->vat  }}">
							<input type="text" id="vat" name="vat" class="form-control"  readonly="" >

						</div>
					</div> --}}

					<div class="form-group">
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


		<div class="col-12 border p-4 mt-4">
        </div>


        <center>

            <input type="submit" name="submitbutton" id="invoicebutton"  value="Submit Now" class="btn btn-success" style="width: 150px; font-weight: bold; border-radius: 30px;" onclick="return getSubmit()">&nbsp;


        </center>
	</form>

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




	function getsalesproduct(){
		let item_id = $("#item_id").val();
		$.ajax({
			url: "{{ url('getsalesproductajax') }}/"+item_id,
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

	function getcustomerphone(){
		let customer_id = $("#customer_id").val();
		$.ajax({
			url: "{{ url('getcustomerphone') }}/"+customer_id,
			type: 'get',
			success: function (response)
			{
				$("#customer_phone").val(response);
			},
			error:function(errors){
				alert("Select Customer")
			}
		});

	}




	showcurrentpurchasesales_product();


	function purchasesalesproduct(){
		let pdt_id = $("#pdt_id").val();

		$.ajax({
			url: "{{ url('purchasesalesproduct') }}/"+pdt_id,
			type: 'GET',
			success: function (data)
			{
                // alert(data);
				showcurrentpurchasesales_product();

				$("#pdt_id").val('');

			},
		});

	}





	function showcurrentpurchasesales_product(){
		$.ajax({
			url: "{{ url('showcurrentpurchasesales_product') }}",
			type: 'get',
			data:{},
			success: function (data)
			{
				$("#showdata").html(data);

				let totalsalesamount = parseFloat($("#totalsalesamount").val());
				let totalamountpurchase = parseFloat($("#totalpurchase").val());
				let vathidden = parseFloat($("#vathidden").val());
				// let vattotal = vathidden*totalsalesamount/100;
				$("#totalamountsales").val(totalsalesamount.toFixed(2));
				$("#totalpurchaseamount").val((totalamountpurchase).toFixed(2));
				$("#vat").val(vattotal.toFixed(2));


			},
			error:function(errors){
				alert("errors")
			}
		});

	}






	function purchasesalespriceupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let sale_price_per_unit = $("#sale_price_per_unit"+id).val();
		let product_id = $("#salesproduct_id"+id).val();


		$.ajax({
			url: "{{ url('purchasesalespriceupdate') }}/"+id,
			type: 'GET',
			data:{sale_price_per_unit:sale_price_per_unit,product_id:product_id},
			success: function (data)
			{

				showcurrentpurchasesales_product();
			},
			error:function(errors){
				alert("errors")
			}
		});

	}
	function purchasesalespurchasepriceupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let purchase_price_per_unit = $("#purchase_price_per_unit"+id).val();
		let product_id = $("#salesproduct_id"+id).val();


		$.ajax({
			url: "{{ url('purchasesalespurchasepriceupdate') }}/"+id,
			type: 'GET',
			data:{purchase_price_per_unit:purchase_price_per_unit,product_id:product_id},
			success: function (data)
			{

				showcurrentpurchasesales_product();
			},
			error:function(errors){
				alert("errors")
			}
		});

	}






	function purchasesalesqtyupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let product_quantity = $("#product_quantity"+id).val();


		$.ajax({
			url: "{{ url('purchasesalesqtyupdate') }}/"+id,
			type: 'POST',
			data:{product_quantity:product_quantity},
			success: function (data)
			{
                // alert(data);
				showcurrentpurchasesales_product();
			},
		});

	}


	function purchasesalessubunitupdate(id){
        $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let sub_unit_id = $("#sale_sub_measurement"+id).val();

        $.ajax({
			url: "{{ url('purchasesalessubunitupdate') }}/"+id,
			type: 'POST',
			data:{sub_unit_id:sub_unit_id},
			success: function (data)
			{
				showcurrentpurchasesales_product();
			},
		});
    }

    function purchasesalesoriginalmeasurement(id)
    {
        // alert(id);
        $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let sub_unit_id = $("#sale_sub_measurement"+id).val();
		let product_quantity = $("#product_quantity"+id).val();

        $.ajax({
			url: "{{ url('purchasesalesoriginalmeasurement') }}/"+id,
			type: 'POST',
			data:{sub_unit_id:sub_unit_id,product_quantity:product_quantity},
			success: function (data)
			{
                // alert(data);
				showcurrentpurchasesales_product();
			},
		});
    }

	function qtyupdatesales(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let product_quantity = $("#product_quantity"+id).val();


		$.ajax({
			url: "{{ url('qtyupdatesales') }}/"+id,
			type: 'POST',
			data:{product_quantity:product_quantity},
			success: function (data)
			{

				showcurrentpurchasesales_product();
			},
			error:function(errors){
				alert("errors")
			}
		});

	}




	function purchasesalespricediscount(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let product_discount_amount = $("#product_discount_amount"+id).val();

		$.ajax({
			url: "{{ url('purchasesalespricediscount') }}/"+id,
			type: 'POST',
			data:{product_discount_amount:product_discount_amount},
			success: function (data)
			{
				showcurrentpurchasesales_product();
			},
			error:function(errors){
				alert("errors")
			}
		});

	}










	function calculatediscount(){
		let total     = $("#totalamount").val();
		let discount  = $("#discount").val();

        // alert(discount);





			let totaldiscount = (parseFloat(total)-parseFloat(discount));
			$("#grandtotal").val(totaldiscount);

			// let vathidden = parseFloat($("#vathidden").val());
			// let vattotal = vathidden*totaldiscount/100;
			// $("#grandtotal").val((totaldiscount+vattotal).toFixed(2));
			// $("#vat").val(vattotal.toFixed(2));

        if(discount == "")
        {
            $("#discount").val(0);
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



	function productbarcodeadd(){

		var barcode = $("#barcode").val();

		$.ajax({
			url: "{{ url('salesproductcart2') }}/"+barcode,
			type: 'GET',
			success: function (data)
			{
				showcurrentpurchasesales_product();
				$("#barcode").val('');

			},
		});


	}




    function getSubmit()
    {
		var data = $('#purchasesalesform').serialize();



		$.ajax({
			url:'{{ url('purchasesalessubmit') }}',
			method:'POST',
			data:data,

			success:function(response){

                alert(response);

                // window.open('{{URL::to('/sales_invoice')}}'+'/'+response, "_blank");
                // location.reload();
                // alert('Suceess');


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
