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


				<h3>Sales  Information<a href="{{ route('sales.index') }}" class="btn btn-success float-end rounded addbutton"><i class="fa fa-eye"></i>&nbsp;All Sales</a></h3><br>



				<!--<div class="col-md-12 p-0">-->
					<!--	<div class="form-group mb-2 col-md-12 p-0">-->
						<!--		<label><b>Product Barcode:</b> </label>-->
						<!--		<div class="input-group" style="height: 45px;">-->
							<!--			<input type="text" name="barcode" id="barcode" class="form-control" placeholder="Product Barcode" onchange="productbarcodeadd()">-->
							<!--			<button type="button" class="border text-success" style="cursor: pointer;" onclick="productbarcodeadd()" title="Add Product"><i class="fa fa-refresh"></i></button>-->
							<!--		</div>-->
							<!--	</div>-->
							<!--</div>-->


							<form method="post" class="btn-submit" id="salesform">
								@csrf

								<div class="col-md-12 p-0 row">

									<div class="form-group mb-2 col-md-8">
										<label>Customer Name: <span class="text-danger" style="font-size: 15px;">*</span></label>
										<div class="input-group">

											<select class="form-control js-example-basic-single" name="customer_id" id=
											"customer_id" required="" onchange="">
											<option value="">Select Customer</option>
											@foreach($customer as $i)
											<option value="{{ $i->customer_id  }}">{{ $i->customer_id }} - {{ $i->customer_name_en }} - {{$i->customer_phone}}</option>
											@endforeach
										</select>

									</div>
								</div>


								<!--<div class="form-group mb-2 col-md-3">-->
									<!--	<label>Cash No:</label>-->
									<!--	<div class="input-group">-->
										<!--		<div class="input-group-addon"><i class="fa fa-envelope"></i></div>-->
										<!--		<input type="text"  name="cash_no" id="cash_no" class="form-control" value="" placeholder="Cash No">-->

										<!--	</div>-->
										<!--</div>-->


										<div class="form-group mb-2 col-md-3">
											<label>Invoice Date:<span class="text-danger" style="font-size: 15px;">*</span></label>
											<div class="input-group">
												<input value="@php echo date('m/d/Y'); @endphp" type="text" name="invoice_date" id="datepicker" placeholder="Invoice Date" class="form-control" required="" autocomplete="off">

											</div>
										</div>



										<div class="col-md-9">
											<div class="row">
												<div class="col-md-4">

						{{-- 		<div class="form-group mb-2">
									<label>Item Name:</label>
									<div class="input-group">

										<select class="form-control" name="item_id" id=
										"item_id" onchange="getsalesproduct()">
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
									<label>Product Name: </label>
									<div class="input-group">

										<select class="form-control js-example-basic-single" name="pdt_id" id=
										"pdt_id"  onchange="return salesproductcart()">
										<option value="">Select Product</option>
                                        @if($product)
                                        @foreach ($product as $v)

                                        @php
                                        $stockqty = ($v->quantity + $v->quantity) - ($v->sales_qty - $v->sales_return_qty);
                                        @endphp
                                        @if($stockqty > 0)
                                        <option value="{{$v->pdt_id}}">{{$v->pdt_id}} - {{$v->pdt_name_en}}</option>
                                        @endif
                                        @endforeach
                                        @endif
									</select>

								</div>
							</div>







						</div>

						<div class="col-md-12">


							<div class="row">
								<div class="form-group mb-2 col-md-12">
									<label>Product Barcode: </label>
									<div class="input-group">

									<input class="form-control" type="text" name="product_barcode" id="product_barcode" onkeyup="salesproductcart2()">

								</div>
							</div>







						</div>
                        </div>





					</div>
				</div>

            </div>


				<div class="col-md-10 p-0 mt-2">
					<table class="table table-bordered table-responsive purchase">
						<thead class="bg-info text-light">
							<tr>
								<th>SL</th>
								<th>Name</th>
								<th style="width:10%;">Qty</th>
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
						<label>Total Amount:</label>
						<div class="input-group">

							<input type="text" id="totalamount" name="totalamount" class="form-control"  readonly="">

						</div>
					</div>




					<div class="form-group">
						<label>Discount:</label>
						<div class="input-group">

							<input type="text" id="discount" name="discount" class="form-control" placeholder="Discount" onkeyup="calculatediscount();" value="0" autocomplete="off">

						</div>
					</div>



					<div class="form-group">
						<label>Grand Total:</label>
						<div class="input-group">

							<input type="text" id="grandtotal" name="grandtotal" class="form-control"  readonly="">

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
						<label>Paid:</label>
						<div class="input-group">

							<input type="text" id="paid" name="paid" class="form-control" placeholder="Paid" onkeyup="calculatedue()" required="" value="0" autocomplete="off" >

						</div>
					</div>


					<div class="form-group">
						<label>Due:</label>
						<div class="input-group">

							<input type="text" id="due" name="due" class="form-control"  readonly="">

						</div>
					</div>

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


	</form>
    <center>

        <input type="submit" name="submitbutton" id="invoicebutton"  value="Submit Now" class="btn btn-success" style="width: 150px; font-weight: bold; border-radius: 30px;" onclick="return getSubmit()">&nbsp;


    </center>

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




	showsalesproductcart();


	function salesproductcart(){
		let pdt_id = $("#pdt_id").val();

		$.ajax({
			url: "{{ url('salesproductcart') }}/"+pdt_id,
			type: 'GET',
			success: function (data)
			{
				showsalesproductcart();

				$("#pdt_id").val('');

			},
			error:function(errors){
				alert("Select Products");
			}
		});

	}

	function salesproductcart2(){
		let pdt_id = $("#product_barcode").val();

		$.ajax({
			url: "{{ url('salesproductcart2') }}/"+pdt_id,
			type: 'GET',
			success: function (data)
			{
                // alert(data);
				showsalesproductcart();

				$("#product_barcode").val('');

			},
		});

	}
	function salesproductcart(){
		let pdt_id = $("#pdt_id").val();

		$.ajax({
			url: "{{ url('salesproductcart') }}/"+pdt_id,
			type: 'GET',
			success: function (data)
			{
				showsalesproductcart();

				$("#pdt_id").val('');

			},
			error:function(errors){
				alert("Select Products");
			}
		});

	}





	function showsalesproductcart(){
		$.ajax({
			url: "{{ url('showsalesproductcart') }}",
			type: 'get',
			data:{},
			success: function (data)
			{
				$("#showdata").html(data);

				let totalsalesamount = parseFloat($("#totalsalesamount").val());
				let vathidden = parseFloat($("#vathidden").val());
				// let vattotal = vathidden*totalsalesamount/100;
				$("#totalamount").val(totalsalesamount.toFixed(2));
				$("#grandtotal").val((totalsalesamount).toFixed(2));
				$("#vat").val(vattotal.toFixed(2));


			},
			error:function(errors){
				alert("errors")
			}
		});

	}






	function salepriceupdatesingle(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let sale_price_per_unit = $("#sale_price_per_unit"+id).val();
		let product_id = $("#salesproduct_id"+id).val();


		$.ajax({
			url: "{{ url('salepriceupdatesingle') }}/"+id,
			type: 'GET',
			data:{sale_price_per_unit:sale_price_per_unit,product_id:product_id},
			success: function (data)
			{

				showsalesproductcart();
			},
			error:function(errors){
				alert("errors")
			}
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

				showsalesproductcart();
			},
			error:function(errors){
				alert("errors")
			}
		});

	}


	function salesubmeasurmentupdate(id){
        $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let sub_unit_id = $("#sale_sub_measurement"+id).val();

        $.ajax({
			url: "{{ url('salessubmeasurmentupdate') }}/"+id,
			type: 'POST',
			data:{sub_unit_id:sub_unit_id},
			success: function (data)
			{
				showpurchaseproductcart();
			},
		});
    }

    function salesOriginalMeasurement(id)
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
			url: "{{ url('salesOriginalMeasurement') }}/"+id,
			type: 'POST',
			data:{sub_unit_id:sub_unit_id,product_quantity:product_quantity},
			success: function (data)
			{
                // alert(data);
				showpurchaseproductcart();
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

				showsalesproductcart();
			},
			error:function(errors){
				alert("errors")
			}
		});

	}




	function salesproductdiscount(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let product_discount_amount = $("#product_discount_amount"+id).val();

		$.ajax({
			url: "{{ url('product_discount_amount') }}/"+id,
			type: 'POST',
			data:{product_discount_amount:product_discount_amount},
			success: function (data)
			{
				showsalesproductcart();
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
				showsalesproductcart();
				$("#barcode").val('');

			},
		});


	}




    function getSubmit()
    {
		var data = $('#salesform').serialize();



		$.ajax({
			url:'{{ url('salesledger') }}',
			method:'POST',
			data:data,

			success:function(response){

                window.open('{{URL::to('/sales_invoicea4')}}'+'/'+response, "_blank");
                location.reload();
                // alert('Suceess');


			},
			error:function(error){
				console.log(error)
			}
		});
    }








</script>









<!-- Supplier Modal -->
<div class="modal fade" id="exampleModalCenters" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitles" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">

		<div class="modal-content rounded">
			<div class="modal-header bg-dark text-light">
				<h5 class="modal-title" id="exampleModalCenterTitles"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Customer</h5>
				<button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body editdata myinput">

				<form method="post" action="{{ url("customerinsert2") }}">
					@csrf

					<div class="row myinput">


						<input type="hidden" name="customer_branch_id" id="customer_branch_id" value="{{ Auth()->user()->branch }}">



						<div class="form-group mb-2 col-md-6">
							<label>Customer Name(EN):</label>
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-text-width"></i></div>
								<input class="form-control" type="text" name="customer_name_en" id="customer_name_en"  required="" placeholder="Customer Name EN">
							</div>
						</div>



						<div class="form-group mb-2 col-md-6">
							<label>Customer Name(BN):</label>
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-text-width"></i></div>
								<input class="form-control" type="text" name="customer_name_bn" id="customer_name_bn"  placeholder="Customer Name BN">
							</div>
						</div>


						<div class="form-group mb-2 col-md-6">
							<label>Customer Mobile:</label>
							<div class="input-group">

								<input class="form-control" type="number" name="customer_phone" id="customer_phone"  placeholder="Customer Mobile">
							</div>
						</div>

						<div class="form-group mb-2 col-md-6">
							<label>Email:</label>
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-envelope"></i></div>
								<input class="form-control" type="text"  name="customer_email" id="customer_email" placeholder="Customer Email">
							</div>
						</div>


						<div class="form-group mb-2 col-md-12">
							<label>Address:</label>
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-location-arrow"></i></div>
								<textarea class="form-control" rows="3" name="customer_address" id="customer_address"  placeholder="Customer Address"></textarea>
							</div>
						</div>



						<div class="modal-footer border-0 col-12">
							<button type="button" class="btn btn-secondary border-0" onClick="window.location.reload();">Close</button>
							<button type="submit" class="btn btn-success button border-0">Save</button>

						</div>





					</div>
				</form>



			</div>


		</div>
	</div>
</div>
<!--End Supplier Modal -->





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
