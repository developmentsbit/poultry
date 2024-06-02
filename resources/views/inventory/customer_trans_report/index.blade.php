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

<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('customer_trans_report.customer_trans_report')</h3><br>

				<form method="get" class="btn-submit" action="{{ url('show_customer_trans_report') }}" enctype="multipart/form-data" target="_blank">

					<div class="row myinput">

						<input type="hidden" name="branch_id" id="branch_id" value="{{ Auth()->user()->branch }}">


						<div class="form-group col-md-4 mb-2">
							<label>@lang('customer_trans_report.from_date'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input class="form-control date" type="date" name="from_date" id="from_date"  required="" value="{{ date('Y-m-d') }}">
							</div>
						</div>
						<div class="form-group col-md-4 mb-2">
							<label>@lang('customer_trans_report.to_date'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input class="form-control" type="date" name="to_date" id="to_date"  required="" value="{{ date('Y-m-d') }}">
							</div>
						</div>

                        <div class="form-group col-md-4 mb-2">
							<label>@lang('customer_trans_report.customer'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">
								<select class="form-control js-example-basic-single" name="customer_id" id="customer_id" required>
									@if($customer)
                                    @foreach ($customer as $b)
                                    <option value="{{$b->customer_id}}">{{$b->customer_name_en}} - {{$b->customer_phone}}</option>
                                    @endforeach
                                    @endif
								</select>
							</div>
						</div>

						<div class="modal-footer border-0 col-12">
							<button type="submit" class="btn btn-success button border-0">@lang('customer.add_button')</button>
						</div>





					</div>
				</form>



			</div> <!-- end card body-->
		</div> <!-- end card -->
	</div><!-- end col-->
</div>





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
