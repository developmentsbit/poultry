@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('measurement_subunit.add_title')</h3><br>

				<form method="post" class="btn-submit" action="{{ route('measurement_subunit.store') }}">
					@csrf

					<div class="row myinput">


						<div class="form-group col-md-6 mb-2">
							<label>@lang('measurement.name'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<select class="form-control" name="measurement_unit_id" id="measurement_unit_id" required>
                                    <option value="">-- Select One --</option>
                                    @if($measurment)
                                    @foreach ($measurment as $v)
                                    <option value="{{$v->measurement_id}}">{{$v->measurement_unit}}</option>
                                    @endforeach
                                    @endif
                                </select>
							</div>
						</div>

						<div class="form-group col-md-6 mb-2">
							<label>@lang('measurement_subunit.name'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input required="Give Measurement" class="form-control" type="text" name="sub_unit_name" id="sub_unit_name" placeholder="@lang('measurement_subunit.name')">
							</div>
						</div>

						<div class="form-group col-md-6 mb-2">
							<label>@lang('measurement_subunit.data'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input required="Give Measurement" class="form-control" type="text" name="sub_unit_data" id="sub_unit_data" placeholder="@lang('measurement_subunit.data')">
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
