@extends('layouts.master')
@section('content')



<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('softwaresetting.edit_title')</h3><br>

				@if(isset($data))

				<form method="post" class="btn-submit row" action="{{ route('company.update' , $data->id) }}" enctype="multipart/form-data">
					@csrf
					@method('PUT')
					<div class="mb-2 col-md-12">
						<label>@lang('softwaresetting.name'):</label>
						<div class="input-group">

							<input class="form-control" type="text" name="company_name_en" id="company_name_en" placeholder="Company Name" value="{{ $data->company_name_en }}" required="">
						</div>
					</div>


					<div class="mb-2 col-md-6">
						<label>@lang('softwaresetting.mobile'):</label>
						<div class="input-group">

							<input class="form-control" type="number" name="company_mobile" id="company_mobile" placeholder="Company Mobile" value="{{ $data->company_mobile }}" required="">
						</div>
					</div>



					<div class="mb-2 col-md-6">
						<label>@lang('softwaresetting.email'):</label>
						<div class="input-group">

							<input class="form-control" type="text" placeholder="Email" name="company_email" id="company_email" value="{{ $data->company_email }}">
						</div>
					</div>



					<div class="mb-2 col-md-12">
						<label>@lang('softwaresetting.address'):</label>
						<div class="input-group">

							<textarea class="form-control" rows="3" name="company_address_en" id="company_address_en" required="">{{ $data->company_address_en }}</textarea>
						</div>
					</div>





					<div class="mb-2 col-md-6">
						<label>@lang('softwaresetting.logo'):</label>
						<div class="input-group">

							<input class="form-control" type="file" placeholder="Logo" name="logo" id="logo">
						</div><br>

						@if(isset($data->logo))
						<img src="{{asset('inventory/logo')}}/{{$data->logo}}" class="img-fluid" style="max-height: 100px;">
						@endif
					</div>


					<div class="mb-2 col-md-6">
						<label>@lang('softwaresetting.banner'):</label>
						<div class="input-group">

							<input class="form-control" type="file" placeholder="Banner" name="banner" id="banner">
						</div>
						@if(isset($data->banner))
						<img src="{{asset('inventory/banner')}}/{{$data->banner}}" class="img-fluid" style="max-height: 100px;">
						@endif
					</div>



					<div class="mb-2 col-md-6">
						<label>@lang('softwaresetting.vat'):</label>
						<div class="input-group">

							<input class="form-control" type="text" name="vat" id="vat" value="{{ $data->vat }}" >
						</div>
					</div>


					<div class="mb-2 col-md-6">
						<label>@lang('softwaresetting.opening_balance'):</label>
						<div class="input-group">

							<input class="form-control" type="text" name="openingbalance" id="openingbalance" value="{{ $data->openingbalance }}">
						</div>
					</div>

					<div class="modal-footer border-0 ml-auto">
						<button type="button" class="btn btn-secondary border-0" onclick="window.location.href=''" data-dismiss="modal">@lang('softwaresetting.close_button')</button>
						<button type="submit" class="btn btn-success button border-0">@lang('softwaresetting.update_button')</button>
					</div>
				</form>

				@else


				<form method="post" class="btn-submit row" action="{{ route('company.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="mb-2 col-md-12">
						<label>@lang('softwaresetting.name'):</label>
						<div class="input-group">

							<input class="form-control" type="text" name="company_name_en" id="company_name_en" placeholder="Company Name"  required="">
						</div>
					</div>


					<div class="mb-2 col-md-6">
						<label>@lang('softwaresetting.mobile'):</label>
						<div class="input-group">

							<input class="form-control" type="number" name="company_mobile" id="company_mobile" placeholder="Company Mobile" required="">
						</div>
					</div>



					<div class="mb-2 col-md-6">
						<label>@lang('softwaresetting.email'):</label>
						<div class="input-group">

							<input class="form-control" type="text" placeholder="Email" name="company_email" id="company_email">
						</div>
					</div>



					<div class="mb-2 col-md-12">
						<label>@lang('softwaresetting.address'):</label>
						<div class="input-group">

							<textarea class="form-control" rows="3" name="company_address_en" id="company_address_en" required=""></textarea>
						</div>
					</div>





					<div class="mb-2 col-md-6">
						<label>@lang('softwaresetting.logo'):</label>
						<div class="input-group">

							<input class="form-control" type="file" placeholder="Logo" name="logo" id="logo">
						</div><br>

					</div>


					<div class="mb-2 col-md-6">
						<label>@lang('softwaresetting.banner'):</label>
						<div class="input-group">

							<input class="form-control" type="file" placeholder="Banner" name="banner" id="banner">
						</div>
					</div>



					<div class="mb-2 col-md-6">
						<label>@lang('softwaresetting.vat'):</label>
						<div class="input-group">

							<input class="form-control" type="text" name="vat" id="vat">
						</div>
					</div>


					<div class="mb-2 col-md-6">
						<label>@lang('softwaresetting.opening_balance'):</label>
						<div class="input-group">

							<input class="form-control" type="text" name="openingbalance" id="openingbalance" >
						</div>
					</div>


					<div class="modal-footer border-0 ml-auto">
						<button type="button" class="btn btn-secondary border-0" onclick="window.location.href=''" data-dismiss="modal">@lang('softwaresetting.close_button')</button>
						<button type="submit" class="btn btn-success button border-0">@lang('softwaresetting.update_button')</button>
					</div>
				</form>

				@endif




			</div> <!-- end card body-->
		</div> <!-- end card -->
	</div><!-- end col-->
</div>







@endsection
