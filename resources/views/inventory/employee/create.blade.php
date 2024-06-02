@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('employee.add_title')<a href="{{ route('employee.index') }}" class="btn btn-success float-end rounded addbutton"><i class="fa fa-eye"></i>&nbsp;@lang('employee.index')</a></h3><br>

				<form method="post" class="btn-submit" action="{{ route('employee.store') }}" enctype="multipart/form-data">
					@csrf

					<div class="row myinput">
                        <div class="form-group mb-2 col-md-4">
							<label>@lang('employee.name'):<span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">
								<input class="form-control" type="text" name="name" id="name"  required="" placeholder="@lang('employee.name')">
							</div>
						</div>



						<div class="form-group mb-2 col-md-4">
							<label>@lang('employee.mobile'):<span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">
								<input class="form-control" type="number" name="phone" id="phone" required="" placeholder="@lang('employee.mobile')">
							</div>
						</div>



						<div class="form-group mb-2 col-md-4">
							<label>@lang('employee.email'):</label>
							<div class="input-group">
								<input class="form-control" type="text"  name="email" id="email" placeholder="@lang('employee.email')">
							</div>
						</div>



						<div class="form-group mb-2 col-md-4">
							<label>@lang('employee.nid'):</label>
							<div class="input-group">
								<input class="form-control" type="text" name="nid_no" id="nid_no"  placeholder="@lang('employee.nid').">
							</div>
						</div>


						<div class="form-group mb-2 col-md-4">
							<label>@lang('employee.joindate'):<span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">
								<input class="form-control" type="date" name="joining_date" id="datepicker"  placeholder="" required="" value="">
							</div>
						</div>





						<div class="form-group mb-2 col-md-8">
							<label>@lang('employee.address'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">
								<textarea class="form-control" rows="3" name="address" id="address" required="" placeholder="@lang('employee.address')"></textarea>
							</div>
						</div>

                        <div class="form-group mb-2 col-md-6">
                            <label>@lang('employee.upload_nid') :</label>
                            <input type="file" name="nid_image" class="form-control">
                        </div>
                        <div class="form-group mb-2 col-md-6">
                            <label>@lang('employee.image') :</label>
                            <input type="file" name="image" class="form-control">
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
