@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('measurement.add_title')</h3><br>

				<form method="post" class="btn-submit" action="{{ route('measurement.store') }}">
					@csrf

					<div class="row myinput">




						<div class="form-group col-md-6 mb-2">
							<label>@lang('measurement.sl'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input class="form-control" type="text" name="measurement_sl" id="measurement_sl"  required="" placeholder="@lang('measurement.sl')">
							</div>
						</div>
						<div class="form-group col-md-6 mb-2">
							<label>@lang('measurement.name'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input required="Give Measurement" class="form-control" type="text" name="measurement_unit" id="measurement_unit" placeholder="@lang('measurement.name')">
							</div>
						</div>






						<div class="modal-footer border-0 col-12">
							<button type="submit" class="btn btn-success button border-0">@lang('item.add_button')</button>
						</div>





					</div>
				</form>



			</div> <!-- end card body-->
		</div> <!-- end card -->
	</div><!-- end col-->
</div>








@endsection
