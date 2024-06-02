@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('add_expense.add_title')<a href="{{ route('add_expense.index') }}" class="btn btn-success float-end rounded addbutton"><i class="fa fa-eye"></i>&nbsp;@lang('add_expense.index')</a></h3><br>

				<form method="post" class="btn-submit" action="{{ route('add_expense.store') }}">
					@csrf

					<div class="row myinput">
                        <div class="form-group col-md-6 mb-2">
							<label>@lang('expense.date'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input class="form-control" type="date" name="date" id="date"  required="">
							</div>
						</div>

                        <div class="form-group col-md-6 mb-2">
							<label>@lang('add_expense.select_title'):</label>
							<div class="input-group">
								<select class="form-control" name="expense_id" id="expense_id" required>
                                    @if($expense)
                                    @foreach ($expense as $i)
									<option value="{{$i->id}}">{{$i->title_en}}</option>
                                    @endforeach
                                    @endif
								</select>
							</div>
						</div>

						<div class="form-group col-md-6 mb-2">
							<label>@lang('add_expense.amount'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input class="form-control" type="text" name="amount" id="amount"  required="" placeholder="@lang('add_expense.amount')">
							</div>
						</div>

                        <div>
                            <label>@lang('add_expense.note'):</label>
                            <textarea name="note" class="form-control"></textarea>
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
