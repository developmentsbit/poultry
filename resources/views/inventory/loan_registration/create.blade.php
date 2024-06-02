@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('loan_registration.add_title')<a href="{{ route('loan_registration.index') }}" class="btn btn-success float-end rounded addbutton"><i class="fa fa-eye"></i>&nbsp;@lang('loan_registration.index')</a></h3><br>

				<form method="post" class="btn-submit" action="{{ route('loan_registration.store') }}" enctype="multipart/form-data">
					@csrf

					<div class="row myinput">
                        <div class="form-group mb-2 col-md-4">
							<label>@lang('loan_registration.name'):<span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">
								<input class="form-control" type="text" name="name" id="name"  required="" placeholder="@lang('loan_registration.name')">
							</div>
						</div>



						<div class="form-group mb-2 col-md-4">
							<label>@lang('loan_registration.phone'):<span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">
								<input class="form-control" type="number" name="phone" id="phone" required="" placeholder="@lang('loan_registration.phone')">
							</div>
						</div>



						<div class="form-group mb-2 col-md-8">
							<label>@lang('loan_registration.address'): </label>
							<div class="input-group">
								<textarea class="form-control" rows="3" name="address" id="address" placeholder="@lang('loan_registration.address')"></textarea>
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
