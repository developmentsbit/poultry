@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('customer.add_title')</h3><br>

				<form method="post" class="btn-submit" action="{{ route('customer.update',$data->customer_id) }}" enctype="multipart/form-data">
					@csrf

                    @method('PUT')

					<div class="row myinput">

						<input type="hidden" name="customer_branch_id" id="customer_branch_id" value="{{ Auth()->user()->branch }}">


						<div class="form-group col-md-6 mb-2">
							<label>@lang('customer.name'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input class="form-control" type="text" name="customer_name_en" id="customer_name_en"  required="" placeholder="@lang('customer.name')" value="{{$data->customer_name_en}}">
							</div>
						</div>




						<div class="form-group col-md-6 mb-2">
							<label>@lang('customer.mobile'):</label>
							<div class="input-group">

								<input class="form-control" type="number" name="customer_phone" id="customer_phone" required  placeholder="@lang('customer.mobile')" value="{{$data->customer_phone}}">
							</div>
						</div>

						<div class="form-group col-md-4 mb-2">
							<label>@lang('customer.email'):</label>
							<div class="input-group">

								<input class="form-control" type="text"  name="customer_email" id="customer_email" placeholder="@lang('customer.email')" value="{{$data->customer_email}}">
							</div>
						</div>

						<div class="form-group col-md-4 mb-2">
							<label>@lang('customer.type'):</label>
							<div class="input-group">
								<select class="form-control" name="type" id="type">
									<option @if($data->type == 1) selected @endif value="1">General Customer</option>
									<option @if($data->type == 2) selected @endif value="2">Retails Customer</option>
									<option @if($data->type == 3) selected @endif value="3">3rd Party Customer</option>
								</select>
							</div>
						</div>



						<div class="form-group col-md-4 mb-2">
							<label>@lang('customer.prev_due'):</label>
							<div class="input-group">

								<input class="form-control" type="number" name="previous_due" id="previous_due"  placeholder="@lang('customer.prev_due')" value="{{$previous_due}}">
							</div>
						</div>




						<div class="form-group col-md-12 mb-2">
							<label>@lang('customer.address'):</label>
							<div class="input-group">

								<textarea class="form-control" rows="5" name="customer_address" id="customer_address"  placeholder="@lang('customer.address')">{!! $data->customer_address !!}</textarea>
							</div>
						</div>

                        <div class="form-group col-md-6 mb-2">
							<label>@lang('customer.nid'):</label>
							<div class="input-group">

								<input type="file" class="form-control" name="nid">
							</div>
                            <img src="{{asset('inventory/customer_nid')}}/{{$data->nid}}" style="height: 80px;">
						</div>
						<div class="form-group col-md-6 mb-2">
							<label>@lang('customer.image'):</label>
							<div class="input-group">

								<input type="file" class="form-control" name="image">
							</div>
                            <img src="{{asset('inventory/customer_image')}}/{{$data->image}}" style="height: 80px;">
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
