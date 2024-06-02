@extends('layouts.master')
@section('content')




<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('supplier.add_title')</h3><br>


				<form method="post" class="btn-submit" action="{{ route('supplier.update',$data->supplier_id) }}">
					@csrf

                    @method('PUT')

					<div class="row myinput">


						<input type="hidden" name="supplier_branch_id" id="supplier_branch_id" value="{{ Auth()->user()->branch }}">


						<div class="form-group mb-2 col-md-4">
							<label>@lang('supplier.name'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input class="form-control" type="text" name="supplier_name_en" id="supplier_name_en"  required="" value="{{$data->supplier_name_en}}">
							</div>
						</div>




						<div class="form-group mb-2 col-md-4">
							<label>@lang('supplier.mobile'):</label>
							<div class="input-group">

								<input class="form-control" type="number" name="supplier_phone" id="supplier_phone" value="{{$data->supplier_phone}}">
							</div>
						</div>

						<div class="form-group mb-2 col-md-4">
							<label>@lang('supplier.email'):</label>
							<div class="input-group">

								<input class="form-control" type="text"  name="supplier_email" id="supplier_email" value="{{$data->supplier_email}}">
							</div>
						</div>


						<div class="form-group mb-2 col-md-4">
							<label>@lang('supplier.address'):</label>
							<div class="input-group">

								<input type="text" class="form-control" name="supplier_address" id="supplier_address" value="{{$data->supplier_address}}">
							</div>
						</div>


						<div class="form-group mb-2 col-md-4">
							<label>@lang('supplier.prev_due'):</label>
							<div class="input-group">

								<input class="form-control" type="number" name="previous_due" id="previous_due"  placeholder="Previous Due" value="{{$previous_due}}">
							</div>
						</div>






						<div class="form-group mb-2 col-md-6">
							<label>@lang('supplier.cname'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input class="form-control" type="text"  name="supplier_company_name" id="supplier_company_name" required="" value="{{$data->supplier_company_name}}">
							</div>
						</div>


						<div class="form-group mb-2 col-md-6">
							<label>@lang('supplier.cmobile'):</label>
							<div class="input-group">

								<input class="form-control" type="text" name="supplier_company_phone" id="supplier_company_phone" value="{{$data->supplier_company_phone}}">
							</div>
						</div>



						<div class="form-group mb-2 col-md-12">
							<label>@lang('supplier.caddress'):</label>
							<div class="input-group">
								<textarea rows="5" class="form-control" name="supplier_company_address">{!! $data->supplier_company_address !!}</textarea>
							</div>
						</div>




						<div class="modal-footer border-0">
							<button type="button" class="btn btn-secondary border-0" onClick="window.location.reload();">@lang('supplier.close_button')</button>
							<button type="submit" class="btn btn-success button border-0">@lang('supplier.add_button')</button>
						</div>





					</div>
				</form>



			</div> <!-- end card body-->
		</div> <!-- end card -->
	</div><!-- end col-->
</div>





@endsection

