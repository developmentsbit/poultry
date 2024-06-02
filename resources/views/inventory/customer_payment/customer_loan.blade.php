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


		<h3>Customer Loan  <a href="{{ route('customer_payment.index') }}" class="btn btn-success float-end rounded addbutton"><i class="fa fa-eye"></i>&nbsp;All Customer Payment</a></h3>

        <form method="post" class="" action="{{url('customer_loan_store')}}">
            @csrf
            <div class="col-md-12 p-0 row">

                <div class="form-group mb-2 col-md-6">

                    <label>Customer Name: <span class="text-danger" style="font-size: 15px;">*</span></label>
                    <div class="input-group">
                        <select class="form-control js-example-basic-single" name="customer_id" id=
                        "customer_id" required="" onchange="getcustomerInfo();getCustomerDue();" >
                        <option value="">Select Customer</option>
                        @if($customer)
                        @foreach ($customer as $v)
                        <option value="{{$v->customer_id}}">{{$v->customer_id}} - {{$v->customer_name_en}} - ( {{$v->customer_phone}} )</option>
                        @endforeach
                        @endif
                        </select>
                    </div>

                    <div class="supplier_informations">

                    </div>

                </div>

                <div class="form-group mb-2 col-md-6">
                    <div class="form-group mb-2">
                        <label>Total Dues</label><br>
                        <input type="text" class="form-control" placeholder="Total Dues" id="total_dues" name="total_dues" readonly>
                    </div>
                    <div class="form-group mb-2">
                        <label>Loan Amount</label><br>
                        <input type="text" class="form-control" placeholder="Payment" id="payment" name="payment">
                    </div>
                    <div class="form-group mb-2">
                        <label>Comment</label><br>
                        <input type="text" class="form-control" name="comment">
                    </div>
                    <div class="form-group mb-2">
                        <input type="submit" class="btn btn-sm btn-success" value="Submit">
                    </div>
                </div>



		</div>




	</form>

</div>
</div>

</div>
</div>

<!-------End Table--------->



<script type="text/javascript">


	function getcustomerInfo(){
		let customer_id = $("#customer_id").val();
		$.ajax({
			url: "{{ url('getcustomerInfo') }}/"+customer_id,
			type: 'get',
			data:{},
			success: function (data)
			{
                // alert(data);
				$(".supplier_informations").html(data);
			},
		});

    }


    function getCustomerDue()
    {
        let customer_id = $('#customer_id').val();

        $.ajax({
            url : "{{ url('getCustomerDue') }}/"+customer_id,

            type : 'GET',

            data : {},

            success : function(data)
            {
                $('#total_dues').val(data);
                $('#new_due').val(0);
                $('#payment').val(0);
            }
        })
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
