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


			<h3>Sales Return  <a href="{{ route('sales_return.index') }}" class="btn btn-success float-end rounded addbutton"><i class="fa fa-eye"></i>&nbsp;All Sales Return</a></h3>
				<form method="post" class="" id="purchaseForm">
                     @csrf
                    <div class="row">
                        <div class="form-group mb-2 col-md-6">
                            <label>Product Name:</label>
                            <div class="input-group">
                                <select class="form-control js-example-basic-single" name="pdt_id" id=
                                "pdt_id"  onchange="return getSalesDetails()">
                                <option value="">Select Product</option>
                                @if($product)
                                @foreach ($product as $v)
                                <option value="{{$v->pdt_id}}">{{$v->pdt_id}} - {{$v->pdt_name_en}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-6">
                        <label>Customer Name: <span class="text-danger" style="font-size: 15px;">*</span></label>
                        <div class="input-group">

                            <select class="form-control js-example-basic-single" name="customer_id" id=
                            "customer_id" required="" onchange="getSalesDetails()">
                            <option value="">Select Customer</option>
                            @foreach($customer as $i)
                            <option value="{{ $i->customer_id  }}">{{ $i->customer_id }} - {{ $i->customer_name_en }} - {{$i->customer_phone}}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
                </div>

                <div class="row showdata mt-3 p-3">

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

	</script>


    <script>
        function getSalesDetails()
        {
            let pdt_id = $('#pdt_id').val();
            let customer_id = $('#customer_id').val();

            // console.log(pdt_id);
            if(pdt_id != "")
            {
                $.ajax({
                    headers : {
                        'X-CSRF-TOKEN' : '{{csrf_token()}}'
                    },
                    url : '{{url('getSalesDetails')}}',

                    type : 'POST',

                    data : {pdt_id,customer_id},

                    success : function(data)
                    {
                        $('.showdata').html(data);
                    }
                });
            }
        }
    </script>


	@endpush




@endsection
