@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('category.add_title')</h3><br>

				<form method="post" class="btn-submit" action="{{ route('category.store') }}">
					@csrf

					<div class="row myinput">


                        <div class="form-group col-md-6 mb-2">
							<label>@lang('category.item_name'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">
								<select class="form-control" name="cat_item_id" id="cat_item_id" required="Select Item">
									<option value="">-- Select One --</option>
                                    @if($item)
                                    @foreach ($item as $v)
                                    <option value="{{$v->item_id}}">{{$v->item_name_en}} ({{$v->item_name_bn}})</option>
                                    @endforeach
                                    @endif
								</select>
							</div>
						</div>

						<div class="form-group col-md-6 mb-2">
							<label>@lang('category.name_en'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input class="form-control" type="text" name="cat_name_en" id="cat_name_en"  required="" placeholder="@lang('category.name_en')">
							</div>
						</div>
						<div class="form-group col-md-6 mb-2">
							<label>@lang('category.name_bn'):</label>
							<div class="input-group">

								<input class="form-control" type="text" name="cat_name_bn" id="cat_name_bn" placeholder="@lang('category.name_bn')">
							</div>
						</div>

						<div class="form-group col-md-6 mb-2">
							<label>@lang('item.status'):</label>
							<div class="input-group">
								<select class="form-control" name="cat_status" id="cat_status">
									<option value="1">Active</option>
									<option value="0">Inactive</option>
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
