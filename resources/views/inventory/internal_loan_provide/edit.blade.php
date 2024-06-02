@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('internal_loan_provide.add_title')<a href="{{ route('internal_loan_provide.index') }}" class="btn btn-success float-end rounded addbutton"><i class="fa fa-eye"></i>&nbsp;@lang('internal_loan_provide.index')</a></h3><br>

				<form method="post" class="btn-submit" action="{{ route('internal_loan_provide.update',$data->id) }}">
					@csrf
                    @method('PUT')

					<div class="row myinput">
                        <div class="form-group col-md-6 mb-2">
							<label>@lang('internal_loan_provide.date'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input class="form-control" type="date" name="date" id="date"  required="" value="{{$data->date}}">
							</div>
						</div>

                        <div class="form-group col-md-6 mb-2">
							<label>@lang('internal_loan_provide.select_register'):</label>
							<div class="input-group">
								<select class="form-control" name="register_id" id="register_id" required onchange="">
                                    <option>Select One</option>
                                    @if($register)
                                    @foreach ($register as $v)
                                    <option @if($data->register_id == $v->id) selected @endif value="{{$v->id}}">{{$v->name}}</option>
                                    @endforeach
                                    @endif
								</select>
							</div>
						</div>

						<div class="form-group col-md-6 mb-2">
							<label>@lang('internal_loan_provide.amount'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input class="form-control" type="text" name="amount" id="amount"  required="" placeholder="@lang('internal_loan_provide.amount')" onkeyup="" value="{{$data->amount}}">
							</div>
						</div>

                        <div>
                            <label>@lang('internal_loan_provide.note'):</label>
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



<script>
    function getdue_loan()
    {
        let register_id = $('#register_id').val();

        $.ajax({
            headers : {
                'X-CSRF-TOKEN' : '{{ csrf_token() }}'
            },

            url : '{{url('getintloanRegisterdue_loan')}}',

            type : 'POST',

            data : {register_id},

            success : function(data)
            {
                $('#due_loan').val(data);
            }
        })
    }


</script>

<script>
    function checkAmount()
    {

        let due_loan = $('#due_loan').val();

        let amount = $('#amount').val();


        if(parseInt(amount) > parseInt(due_loan))
        {
            $('#amount').val(0);
        }
    }

</script>





@endsection
