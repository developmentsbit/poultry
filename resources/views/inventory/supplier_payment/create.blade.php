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


		<h3>Supplier Payment  <a href="{{ route('supplier_payment.index') }}" class="btn btn-success float-end rounded addbutton"><i class="fa fa-eye"></i>&nbsp;All Supplier Payment</a></h3>

        <form method="post" class="" action="{{route('supplier_payment.store')}}">
            @csrf
            <div class="col-md-12 p-0 row">

                <div class="form-group mb-2 col-md-6">

                    <label>Supplier Name: <span class="text-danger" style="font-size: 15px;">*</span></label>
                    <div class="input-group">
                        <select class="form-control js-example-basic-single" name="supplier_id" id=
                        "supplier_id" required="" onchange="getsupplierInfo();getsupplierDue();" >
                        <option value="">Select Supplier</option>
                        @if($supplier)
                        @foreach ($supplier as $v)
                        <option value="{{$v->supplier_id}}">{{$v->supplier_id}} - {{$v->supplier_name_en}} - ( {{$v->supplier_phone}} )</option>
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
                        <label>Payment</label><br>
                        <input type="text" class="form-control" placeholder="Payment" id="payment" name="payment">
                    </div>
                    <div class="form-group mb-2">
                        <label>Discount</label><br>
                        <input type="text" class="form-control" placeholder="" id="discount" name="discount">
                    </div>
                    <div class="form-group mb-2">
                        <label>New Due</label><br>
                        <input type="text" class="form-control" placeholder="" id="new_due" name="new_due" readonly>
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


	function getsupplierInfo(){
		let supplier_id = $("#supplier_id").val();
		$.ajax({
			url: "{{ url('getsupplierInfo') }}/"+supplier_id,
			type: 'get',
			data:{},
			success: function (data)
			{
                // alert(data);
				$(".supplier_informations").html(data);
			},
		});

    }


    function getsupplierDue()
    {
        let supplier_id = $('#supplier_id').val();

        $.ajax({
            url : "{{ url('getsupplierDue') }}/"+supplier_id,

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

    $('#payment').on('keyup',function(){

        let total_due = $('#total_dues').val();
        let discount = $('#discount').val();

        let payment = $(this).val();


            let result = total_due - (parseInt(payment) + parseInt(discount));

            $('#new_due').val(result);

    });
    $('#discount').on('keyup',function(){

        let total_due = $('#total_dues').val();

        let discount = $(this).val();
        let payment = $('#payment').val();


        let result = total_due - (parseInt(payment) + parseInt(discount));

        $('#new_due').val(result);

    })

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
