@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('income_expense_title.add_title')<a href="{{ route('income_expense_title.index') }}" class="btn btn-success float-end rounded addbutton"><i class="fa fa-eye"></i>&nbsp;@lang('income_expense_title.index')</a></h3><br>

				<form method="post" class="btn-submit" action="{{ route('income_expense_title.update',$data->id) }}">
					@csrf

                    @method('PUT')

					<div class="row myinput">




						<div class="form-group col-md-6 mb-2">
							<label>@lang('income_expense_title.income_expense_title_en'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input class="form-control" type="text" name="title_en" id="title_en"  required="" placeholder="@lang('item.name_en')" value="{{$data->title_en}}">
							</div>
						</div>
						<div class="form-group col-md-6 mb-2">
							<label>@lang('income_expense_title.income_expense_title_bn'):</label>
							<div class="input-group">

								<input class="form-control" type="text" name="title_bn" id="title_bn" placeholder="@lang('item.name_bn')" value="{{$data->title_bn}}">
							</div>
						</div>

						<div class="form-group col-md-6 mb-2">
							<label>@lang('income_expense_title.type'):</label>
							<div class="input-group">
								<select class="form-control" name="type" id="type" required>
									<option @if($data->type == 1) selected @endif value="1">Income</option>
									<option @if($data->type == 2) selected @endif value="2">Expense</option>
								</select>
							</div>
						</div>

						<div class="form-group col-md-6 mb-2">
							<label>@lang('common.status'):</label>
							<div class="input-group">
								<select class="form-control" name="status" id="" required>
									<option @if($data->status == 1) selected @endif value="1">Active</option>
									<option @if($data->status == 0) selected @endif value="0">Inactive</option>
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
