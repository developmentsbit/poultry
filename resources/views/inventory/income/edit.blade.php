@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('add_income.add_title')<a href="{{ route('add_income.index') }}" class="btn btn-success float-end rounded addbutton"><i class="fa fa-eye"></i>&nbsp;@lang('add_income.index')</a></h3><br>

				<form method="post" class="btn-submit" action="{{ route('add_income.update',$data->id) }}">
					@csrf
                    @method('PUT')
					<div class="row myinput">
                        <div class="form-group col-md-6 mb-2">
							<label>@lang('add_income.date'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input class="form-control" type="date" name="date" id="date"  required="" value="{{$data->date}}">
							</div>
						</div>

                        <div class="form-group col-md-6 mb-2">
							<label>@lang('add_income.select_title'):</label>
							<div class="input-group">
								<select class="form-control" name="income_id" id="income_id" required>
                                    @if($income)
                                    @foreach ($income as $i)
									<option @if($i->id == $data->income_id) selected @endif value="{{$i->id}}">{{$i->title_en}}</option>
                                    @endforeach
                                    @endif
								</select>
							</div>
						</div>

						<div class="form-group col-md-6 mb-2">
							<label>@lang('add_income.amount'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input class="form-control" type="text" name="amount" id="amount"  required="" placeholder="@lang('add_income.amount')" value="{{$data->amount}}">
							</div>
						</div>

                        <div>
                            <label>@lang('add_income.note'):</label>
                            <textarea name="note" class="form-control">{!! $data->note !!}</textarea>
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
