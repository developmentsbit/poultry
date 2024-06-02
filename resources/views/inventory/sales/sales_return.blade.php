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
                        <form method="post" class="btn-submit" id="" action="{{url('sales_return_submit')}}">
                            @csrf

                            <div class="col-md-12 p-0 row">
                                <div class="form-group mb-2 col-md-4">
                                    <label>Invoice No : </label><br>
                                    {{$data->invoice_no}}
                                </div>

                                <div class="form-group mb-2 col-md-4">
                                    <label>Customer Name:</label><br>
                                    <b>{{$data->customer_name_en}}</b> ({{$data->customer_phone}})
                                </div>
                                <div class="form-group mb-2 col-md-4">
                                    <label>Invoice Date:<br></label>
                                    {{$data->invoice_date}}
                                    <input type="hidden" name="invoice_no" id="invoice_no" value="{{$data->invoice_no}}">
                                </div>

                            </div>
                    </div>

                </div>

                <div class="row">
				<div class="col-md-10 p-0 mt-2">
					<table class="table table-bordered table-responsive purchase">
						<thead class="bg-info text-light">
							<tr>
								<th>SL</th>
								<th>Name</th>
								<th style="width:10%;">Qty</th>
								<th style="width:10%">Sub Unit</th>
								<th>S. Price (Unit)</th>
								<th>Discount (Unit)</th>
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

                    </div>

                </div>
            </div>
        </div>
		</div>


		<div class="col-12 border p-4 mt-4">
        </div>


        <center>

            <input type="submit" name="submitbutton" id="invoicebutton"  value="Submit Now" class="btn btn-success" style="width: 150px; font-weight: bold; border-radius: 30px;">&nbsp;


        </center>
	</form>

</div>
</div>

</div>
</div>

<!-------End Table--------->




<script>




    function loadCurrentSalesReturn()
    {
    // alert();
    var invoice_no = $('#invoice_no').val();
    // alert(invoice_no);
    $.ajax({
        headers : {
            'X-CSRF-TOKEN' : '{{csrf_token()}}'
        },

        url : '{{url('load_current_salesreturn')}}',

        type : 'POST',

        data : {invoice_no},

        success : function(data)
        {
            // alert(total);
            $('#showdata').html(data);

            var total = parseFloat($('#total').val());



            var finaldiscount = parseFloat($('#discount').val());

            var grandtotal = total - finaldiscount;


            $('#totalamount').val(total.toFixed(2));
            $('#grandtotal').val(grandtotal);

            var grandtotal = $('#grandtotal').val();

            var paidamount = $('#paid').val();

            var result = grandtotal - paidamount;

            $('#due').val(result);

        }
    });
}


$(document).ready(function(){

    loadCurrentSalesReturn();
})





function calculatediscount()
{
    var total = parseFloat($('#totalamount').val());
    var finaldiscount = parseFloat($('#discount').val());

    var grandtotal = total - finaldiscount;
    $('#grandtotal').val(grandtotal);
}

function calculatedue(){
    var grandtotal = $('#grandtotal').val();

    var paidamount = $('#paid').val();

    var result = grandtotal - paidamount;

    $('#due').val(result);
}


function qtyUpdate(id)
{
    var qty = $("#returnquantity"+id).val();

    $.ajax({
        headers : {
            'X-CSRF-TOKEN' : '{{ csrf_token() }}'
        },

        url : '{{url('current_sales_returnqty_update')}}/'+id,

        type : 'POST',

        data : {qty},

        success : function(data)
        {
            loadCurrentSalesReturn();
        }
    })
}



</script>





	@endsection
