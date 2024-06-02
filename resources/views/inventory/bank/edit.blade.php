@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('add_bank.add_title')<a href="{{ route('add_bank.index') }}" class="btn btn-success float-end rounded addbutton"><i class="fa fa-eye"></i>&nbsp;@lang('add_bank.index')</a></h3><br>

				<form method="post" class="btn-submit" action="{{ route('add_bank.update',$data->id) }}">
					@csrf

                    @method('PUT')

					<div class="row myinput">
                        <div class="form-group mb-2 col-md-12">
                            <label>@lang('add_bank.name'):<span class="text-danger" style="font-size: 15px;">*</span></label>
                            <div class="input-group">
                                <input class="form-control" type="text" name="bank_name" id="bank_name" placeholder="@lang('add_bank.name')" required="" value="{{$data->bank_name}}">
                            </div>
                        </div>



                        <div class="form-group mb-2 col-md-12">
                            <label>@lang('add_bank.anumber'):<span class="text-danger" style="font-size: 15px;">*</span></label>
                            <div class="input-group">
                                <input class="form-control" type="number" name="account_number" id="account_number" placeholder="@lang('add_bank.anumber')" required="" value="{{$data->account_number}}">
                            </div>
                        </div>

                        <div class="form-group mb-2 col-md-6">
                            <label>@lang('add_bank.atype'):<span class="text-danger" style="font-size: 15px;">*</span></label>
                            <div class="input-group">
                                <select class="form-select" name="account_type" id="account_type">
                                    <option @if($data->account_type == 'Saving') selected @endif>Saving</option>
                                    <option @if($data->account_type == 'CC Loan') selected @endif>CC Loan</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group mb-2 col-md-6">
                            <label>@lang('add_bank.number'):</label>
                            <div class="input-group">
                                <input class="form-control" type="text" name="contact" id="contact" placeholder="@lang('add_bank.number')" value="{{$data->contact}}">
                            </div>
                        </div>


                        <div class="form-group mb-2 col-md-6 @if($data->account_type == 'CC Loan') @else d-none @endif" id="limitField">
                            <label>@lang('add_bank.limit') :</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="limit" id="limit" value="{{ $data->limit }}">
                            </div>
                        </div>


                        <div class="form-group mb-2 col-md-6 @if($data->account_type == 'CC Loan') @else d-none @endif" id="expiryField">
                            <label>@lang('add_bank.expiry') :</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="expiry" id="expiry" value="{{ $data->expiry }}">
                            </div>
                        </div>




                        <div class="form-group mb-2 col-md-12">
                            <label>@lang('add_bank.btype'):</label>
                            <div class="input-group">
                                <input class="form-control" type="text" name="bankingType" id="bankingType" placeholder="@lang('add_bank.btype')" value="{{$data->bankingType}}">
                            </div>
                        </div>


                        <div class="form-group mb-2 col-md-12">
                            <label>@lang('add_bank.details'):</label>
                            <div class="input-group">
                                <textarea rows="3" name="details" id="details" class="form-control" placeholder="@lang('add_bank.details')">{!! $data->details !!}</textarea>
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
    function showHideForms()
    {
        let acc_type = $('#account_type').val();

        if(acc_type == 'CC Loan')
        {
            $('#limitField').removeClass('d-none');
            $('#expiryField').removeClass('d-none');
        }
        else
        {
            $('#limitField').addClass('d-none');
            $('#expiryField').addClass('d-none');
        }
    }
</script>




@endsection
