@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('bank_transaction.add_title')<a href="{{ route('bank_transaction.index') }}" class="btn btn-success float-end rounded addbutton"><i class="fa fa-eye"></i>&nbsp;@lang('bank_transaction.index')</a></h3><br>

				<form method="post" class="btn-submit" action="{{ route('bank_transaction.update',$data->id) }}">
					@csrf
                    @method('PUT')
                    <div class="row">


					<div class="form-group mb-2 col-md-8">
                        <label>@lang('bank_transaction.anumber'):<span class="text-danger" style="font-size: 15px;">*</span></label>
                        <div class="input-group">

                            <select class="form-control" name="account_id" id="account_id" required="" onchange="gettotalamount();">
                                <option value="">@lang('bank_transaction.anumber')</option>
                                @if($bank)
                                @foreach ($bank as $v)
                                 <option @if($v->id == $data->account_id) selected @endif value="{{$v->id}}">{{$v->bank_name}} - {{$v->account_number}}</option>
                                @endforeach
                                @endif

                            </select>
                        </div>
                    </div>



                    <div class="form-group mb-2 col-md-4">
                        <label>@lang('bank_transaction.total'):</label>
                        <div class="input-group">

                            <input class="form-control" type="text" name="totalbalance" id="totalbalance"  readonly="" value="{{$result}}">
                        </div>
                    </div>


                    <div class="form-group mb-2 col-md-4">
                        <label>@lang('bank_transaction.date'): <span class="text-danger" style="font-size: 15px;">*</span></label>
                        <div class="input-group">

                            <input class="form-control" type="date" name="date" id="datepicker" value="{{$data->date}}" required="">
                        </div>
                    </div>



                    <div class="form-group mb-2 col-md-4">
                        <label>@lang('bank_transaction.ttype'):</label>
                        <div class="input-group">

                            <select class="form-control" name="transaction_type" id="transaction_type">
                                <option @if($data->transaction_type == 1) selected @endif value="1">Deposit</option>
                                <option @if($data->transaction_type == 2) selected @endif value="2">Withdraw</option>
                                <option @if($data->transaction_type == 3) selected @endif value="3">Bank Account Cost</option>
                                <option @if($data->transaction_type == 4) selected @endif value="4">Bank Account Interest</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group mb-2 col-md-4">
                        <label>@lang('bank_transaction.amount'): <span class="text-danger" style="font-size: 15px;">*</span></label>
                        <div class="input-group">

                            <input class="form-control" type="text" name="amount" id="amount" required="" value="{{$data->amount}}">
                        </div>
                    </div>




                    <div class="form-group mb-2 col-md-8">
                        <label>@lang('bank_transaction.others'):</label>
                        <div class="input-group">

                            <textarea rows="3" class="form-control" placeholder="@lang('bank_transaction.others')" name="voucher_cheque_no" id="voucher_cheque_no   ">{!! $data->voucher_cheque_no !!}</textarea>
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


<script type="text/javascript">

function gettotalamount()
{
    let account_id = $('#account_id').val();
    $.ajax({
        headers : {
            'X-CSRF-TOKEN' : '{{csrf_token()}}'
        },

        url : '{{url('gettotalamount')}}',

        type : 'POST',

        data : {account_id},

        success : function(data){
            $('#totalbalance').val(data);
        }
    })
}

</script>





@endsection
