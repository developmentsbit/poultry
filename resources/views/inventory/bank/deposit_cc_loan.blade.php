@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>Deposit CC Loan<a href="{{ route('bank_transaction.index') }}" class="btn btn-success float-end rounded addbutton"><i class="fa fa-eye"></i>&nbsp;@lang('bank_transaction.index')</a></h3><br>

				<form method="post" class="btn-submit" action="{{ url('depositCCloan') }}">
					@csrf
                    <div class="row">
					<div class="form-group mb-2 col-md-4">
                        <label>@lang('bank_transaction.anumber'):<span class="text-danger" style="font-size: 15px;">*</span></label>
                        <div class="input-group">

                            <select class="form-control" name="account_id" id="account_id" required="" onchange="getLimitBalance();">
                                <option value="">@lang('bank_transaction.anumber')</option>
                                @if($data['bank'])
                                @foreach ($data['bank'] as $v)
                                <option value="{{$v->id}}">{{$v->bank_name}} - {{$v->account_number}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-2 col-md-4">
                        <label>Total Limit Balance:</label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="limit_balance" id="limit_balance"  readonly="">
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-4">
                        <label>Total Retain Balance:</label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="retain_balance" id="retain_balance"  readonly="">
                        </div>
                    </div>

                    <div class="form-group mb-2 col-md-4">
                        <label>@lang('bank_transaction.date'): <span class="text-danger" style="font-size: 15px;">*</span></label>
                        <div class="input-group">

                            <input class="form-control" type="date" name="date" id="datepicker" value="" required="">
                        </div>
                    </div>

                    <div class="form-group mb-2 col-md-8">
                        <label>@lang('bank_transaction.amount'): <span class="text-danger" style="font-size: 15px;">*</span></label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="amount" id="amount" required="" onkeyup="BlockAmount()">
                        </div>
                    </div>

                    <div class="form-group mb-2 col-md-8">
                        <label>@lang('bank_transaction.others'):</label>
                        <div class="input-group">
                            <textarea rows="3" class="form-control" placeholder="@lang('bank_transaction.others')" name="voucher_cheque_no" id="voucher_cheque_no   "></textarea>
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
    function getLimitBalance()
    {
        let acc_number = $('#account_id').val();
        if(acc_number != '')
        {
            $.ajax({
                headers : {
                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                },
                url : '{{ url('getLimitBalance') }}',
                type : 'POST',
                data : {acc_number},
                success : function(res)
                {
                    // console.log(res);
                    $('#limit_balance').val(res[0]);
                    $('#retain_balance').val(res[1]);
                }
            });
        }
        else
        {
            $('#limit_balance').val('');
            $('#retain_balance').val('');
        }
    }
</script>
<script>
    function BlockAmount()
    {
        let amount = $('#amount').val();
        // console.log(amount);
        let retainedBalance = $('#retain_balance').val();
        let limit = $('#limit_balance').val();
        // alert(limit);
        let result = parseInt(retainedBalance) + parseInt(amount);
        // console.log(result);
        if(result > limit)
        {
            $('#amount').val('0');
            return;
        }
    }
</script>
@endsection
