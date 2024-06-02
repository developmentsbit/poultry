@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('salary_withdraw.add_title')<a href="{{ route('salary_withdraw.index') }}" class="btn btn-success float-end rounded addbutton"><i class="fa fa-eye"></i>&nbsp;@lang('salary_withdraw.index')</a></h3><br>

				<form method="post" class="btn-submit" action="{{ route('salary_withdraw.store') }}">
					@csrf

					<div class="row myinput">


                        <div class="form-group col-md-6 mb-2">
							<label>@lang('salary_withdraw.employee'):</label>
							<div class="input-group">
								<select class="form-control" name="employee_id" id="employee_id" required onchange="return getEmpBalance()">
                                    <option>Select One</option>
                                    @if($emp)
                                    @foreach ($emp as $v)
                                        <option value="{{$v->id}}">{{$v->name}}</option>
                                    @endforeach
                                    @endif
								</select>
							</div>
						</div>


						<div class="form-group col-md-6 mb-2">
							<label>@lang('salary_withdraw.date'):</label>
							<div class="input-group">

								<input class="form-control" type="date" name="date" id="date" placeholder="@lang('salary_withdraw.date')" required>
							</div>
						</div>


						<div class="form-group col-md-6 mb-2">
							<label>@lang('salary_withdraw.balance'):</label>
							<div class="input-group">

								<input class="form-control" type="text" name="balance" id="balance" placeholder="@lang('salary_withdraw.balance')" readonly>
							</div>
						</div>


						<div class="form-group col-md-6 mb-2">
							<label>@lang('salary_withdraw.salary_withdraw'):</label>
							<div class="input-group">

								<input class="form-control" type="text" name="salary_withdraw" id="salary_withdraw" placeholder="@lang('salary_withdraw.salary_withdraw')" required onkeyup="return checkGreater()">
							</div>
						</div>


						<div class="form-group col-md-6 mb-2">
							<label>@lang('salary_withdraw.transaction_type'):</label>
							<div class="input-group">

								<input class="form-control" type="text" name="transaction_type" id="transaction_type" placeholder="@lang('salary_withdraw.transaction_type')">
							</div>
						</div>

						<div class="form-group col-md-12 mb-2">
							<label>@lang('salary_withdraw.note'):</label>
							<div class="input-group">

								<textarea name="note" class="form-control" placeholder="note"></textarea>
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


<script>
    function getEmpBalance()
    {
        let emp_id = $('#employee_id').val();

        if(emp_id != '')
        {
            $.ajax({
                headers : {
                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                },

                url : '{{ url('getEmpBalance') }}',

                type : 'POST',

                data : {emp_id},

                success : function(data)
                {
                    $('#balance').val(data);
                }
            });
        }
    };

    function checkGreater(){


        let salary_withdraw = $('#salary_withdraw').val();

        let balance = $('#balance').val();

        if(parseInt(salary_withdraw) > parseInt(balance))
        {
            $('#salary_withdraw').val(0);
        }

    };
</script>







@endsection
