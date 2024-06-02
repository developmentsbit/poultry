@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('add_bank.add_title')<a href="{{ route('add_bank.index') }}" class="btn btn-success float-end rounded addbutton"><i class="fa fa-eye"></i>&nbsp;@lang('add_bank.index')</a></h3><br>

				<form method="post" class="btn-submit" action="{{ route('add_bank.store') }}">
					@csrf

					<div class="row myinput">
                        <div class="form-group mb-2 col-md-12">
                            <label>@lang('add_bank.name'):<span class="text-danger" style="font-size: 15px;">*</span></label>
                            <div class="input-group">										<input class="form-control" type="text" name="bank_name" id="bank_name" placeholder="@lang('add_bank.name')" required="">
                            </div>
                        </div>



                        <div class="form-group mb-2 col-md-12">
                            <label>@lang('add_bank.anumber'):<span class="text-danger" style="font-size: 15px;">*</span></label>
                            <div class="input-group">
                                <input class="form-control" type="number" name="account_number" id="account_number" placeholder="@lang('add_bank.anumber')" required="">
                            </div>
                        </div>

                        <div class="form-group mb-2 col-md-6">
                            <label>@lang('add_bank.atype'):<span class="text-danger" style="font-size: 15px;">*</span></label>
                            <div class="input-group">
                                <select class="form-select" name="account_type" id="account_type" onchange="return showHideForms()">
                                    <option value="Saving">Saving</option>
                                    <option value="CC Loan">CC Loan</option>
                                </select>
                            </div>
                        </div>



                        <div class="form-group mb-2 col-md-6">
                            <label>@lang('add_bank.number'):</label>
                            <div class="input-group">
                                <input class="form-control" type="text" name="contact" id="contact" placeholder="@lang('add_bank.number')">
                            </div>
                        </div>

                        <div class="form-group mb-2 col-md-6 d-none" id="limitField">
                            <label>@lang('add_bank.limit') :</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="limit" id="limit">
                            </div>
                        </div>


                        <div class="form-group mb-2 col-md-6 d-none" id="expiryField">
                            <label>@lang('add_bank.expiry') :</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="expiry" id="expiry">
                            </div>
                        </div>


                        <div class="form-group mb-2 col-md-12">
                            <label>@lang('add_bank.btype'):</label>
                            <div class="input-group">
                                <input class="form-control" type="text" name="bankingType" id="bankingType" placeholder="@lang('add_bank.btype')">
                            </div>
                        </div>


                        <div class="form-group mb-2 col-md-12">
                            <label>@lang('add_bank.details'):</label>
                            <div class="input-group">
                                <textarea rows="3" name="details" id="details" class="form-control" placeholder="@lang('add_bank.details')"></textarea>
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
