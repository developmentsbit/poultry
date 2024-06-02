@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('cash_close_report.cash_close_report')</h3><br>

				<form method="get" class="btn-submit" action="{{ url('show_cash_close_report') }}" enctype="multipart/form-data" target="_blank">

					<div class="row myinput">

						<input type="hidden" name="branch_id" id="branch_id" value="{{ Auth()->user()->branch }}">


						<div class="form-group col-md-4 mb-2">
							<label>@lang('cash_close_report.date'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input class="form-control" type="date" name="date" id="date"  required="" value="">
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








@endsection
