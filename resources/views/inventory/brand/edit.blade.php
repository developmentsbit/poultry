@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('brand.add_title')</h3><br>

				<form method="post" class="btn-submit" action="{{ route('brand.update',$data->brand_id) }}">
					@csrf
                    @method('PUT')

					<div class="row myinput">



						<div class="form-group col-md-6 mb-2">
							<label>@lang('brand.name_en'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input class="form-control" type="text" name="brand_name_en" id="brand_name_en"  required="" placeholder="@lang('brand.name_en')" value="{{$data->brand_name_en}}">
							</div>
						</div>
						<div class="form-group col-md-6 mb-2">
							<label>@lang('brand.name_bn'):</label>
							<div class="input-group">

								<input class="form-control" type="text" name="brand_name_bn" id="brand_name_bn" placeholder="@lang('brand.name_bn')" value="{{$data->brand_name_bn}}">
							</div>
						</div>

						<div class="form-group col-md-6 mb-2">
							<label>@lang('brand.status'):</label>
							<div class="input-group">
								<select class="form-control" name="brand_status" id="brand_status">
									<option @if($data->brand_status == 1) selected @endif value="1">Active</option>
									<option @if($data->brand_status == 0) selected @endif value="0">Inactive</option>
								</select>
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
