@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('internal_loanregister.add_title')<a href="{{ route('internal_loanregister.index') }}" class="btn btn-success float-end rounded addbutton"><i class="fa fa-eye"></i>&nbsp;@lang('internal_loanregister.index')</a></h3><br>

				<form method="post" class="btn-submit" action="{{ route('internal_loanregister.store') }}" enctype="multipart/form-data">
					@csrf

					<div class="row myinput">
                        <div class="form-group mb-2 col-md-4">
							<label>@lang('internal_loanregister.name'):<span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">
								<input class="form-control" type="text" name="name" id="name"  required="" placeholder="@lang('internal_loanregister.name')">
							</div>
						</div>



						<div class="form-group mb-2 col-md-4">
							<label>@lang('internal_loanregister.phone'):<span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">
								<input class="form-control" type="number" name="phone" id="phone" required="" placeholder="@lang('internal_loanregister.phone')">
							</div>
						</div>



						<div class="form-group mb-2 col-md-8">
							<label>@lang('internal_loanregister.address'): </label>
							<div class="input-group">
								<textarea class="form-control" rows="3" name="address" id="address" placeholder="@lang('internal_loanregister.address')"></textarea>
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
