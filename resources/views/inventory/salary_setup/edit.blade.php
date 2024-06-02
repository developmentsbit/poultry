@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('salary_setup.add_title')<a href="{{ route('salary_setup.index') }}" class="btn btn-success float-end rounded addbutton"><i class="fa fa-eye"></i>&nbsp;@lang('salary_setup.index')</a></h3><br>

				<form method="post" class="btn-submit" action="{{ route('salary_setup.update',$data->id) }}">
					@csrf

                    @method('PUT')

					<div class="row myinput">


                        <div class="form-group col-md-6 mb-2">
							<label>@lang('salary_setup.employee'):</label>
							<div class="input-group">
								<select class="form-control" name="employee_id" id="" required>
                                    <option>Select One</option>
                                    @if($emp)
                                    @foreach ($emp as $v)
                                        <option @if($data->employee_id == $v->id) selected @endif value="{{$v->id}}">{{$v->name}}</option>
                                    @endforeach
                                    @endif
								</select>
							</div>
						</div>


						<div class="form-group col-md-6 mb-2">
							<label>@lang('salary_setup.employee_salary'):</label>
							<div class="input-group">

								<input class="form-control" type="text" name="employee_salary" id="employee_salary" placeholder="@lang('salary_setup.employee_salary')" required value="{{$data->employee_salary}}">
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
