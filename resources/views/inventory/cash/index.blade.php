@extends('layouts.master')
@section('content')


<style>
    .text-right{
        float:right;
    }
    .list-item-sl{

        padding: 10px 10px;
    }
    #detailsbox{
        border: 1px solid lightgray;
    }
</style>


<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('cash.add_title')</h3><br>

				<form method="post" class="btn-submit" action="{{ route('cash_close.store') }}">
					@csrf

					<div class="row myinput">
                        <div class="col-lg-6 col-12" id="">
                            <div class="w-100 bg-success p-2 text-white">
                                @lang('cash.incomes')
                            </div>
                            <div id="detailsbox">
                                <div class="list-item-sl">
                                    <span>Previous Cash </span> <span class="text-right" style="">{{ $previous_cash }}/-</span>
                                </div>
                                <div class="list-item-sl">
                                    <span>Customer Payment </span> <span class="text-right" style="">{{ $customer_payment }}/-</span>
                                    <input type="hidden" name="sales" value="{{ $customer_payment }}">
                                </div>
                                <div class="list-item-sl">
                                    <span>Purchase Return </span> <span class="text-right" style="">{{ $purchase_return }}/-</span>
                                    <input type="hidden" name="purchase_return" value="{{ $purchase_return }}">
                                </div>
                                <div class="list-item-sl">
                                    <span>Bank Withdraw </span> <span class="text-right" style="">{{ $bank_withdraw }}/-</span>
                                    <input type="hidden" name="bank_withdraw" value="{{ $bank_withdraw }}">
                                </div>
                                <div class="list-item-sl">
                                    <span>Bank Interset </span> <span class="text-right" style="">{{ $bank_interest }}/-</span>
                                    <input type="hidden" name="bank_interest" value="{{ $bank_interest }}">
                                </div>
                                <div class="list-item-sl">
                                    <span>Others Income </span> <span class="text-right" style="">{{ $income }}/-</span>
                                    <input type="hidden" name="others" value="{{ $income }}">
                                </div>
                                <div class="list-item-sl">
                                    <span>Loan Recived </span> <span class="text-right" style="">{{ $loan_recived }}/-</span>
                                    <input type="hidden" name="loan_recived" value="{{ $loan_recived }}">
                                </div>
                                <div class="list-item-sl">
                                    <span>Internal Loan Recived </span> <span class="text-right" style="">/-</span>
                                    <input type="hidden" name="intloan_recived" value="">
                                </div>
                                <div class="list-item-sl">
                                    <b>Total Income </b> <b class="text-right" style="">/-</b>
                                    <input type="hidden" name="total_income" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12" id="">
                            <div class="w-100 bg-danger p-2 text-white">
                                @lang('cash.expense')
                            </div>
                            <div id="detailsbox">
                                <div class="list-item-sl">
                                    <span>Supplier Payment </span> <span class="text-right" style="">{{ $supplier_payment }}/-</span>
                                    <input type="hidden" name="purchase" value="{{ $supplier_payment }}">
                                </div>
                                <div class="list-item-sl">
                                    <span>Sales Return </span> <span class="text-right" style="">/-</span>
                                    <input type="hidden" name="sales_return" value="">
                                </div>
                                <div class="list-item-sl">
                                    <span>Others Expense </span> <span class="text-right" style="">/-</span>

                                    <input type="hidden" value="" name="others_expense">
                                </div>
                                <div class="list-item-sl">
                                    <span>Bank Deposit </span> <span class="text-right" style=""> /-</span>

                                    <input type="hidden" value="" name="bank_deposit">
                                </div>

                                <div class="list-item-sl">
                                    <span>Bank Account Cost </span> <span class="text-right" style="">/-</span>

                                    <input type="hidden" name="bank_cost" value="">
                                </div>
                                <div class="list-item-sl">
                                    <span>Loan Provide </span> <span class="text-right" style="">/-</span>
                                    <input type="hidden" value="" name="loan_provide">
                                </div>
                                <div class="list-item-sl">
                                    <span>Internal Loan Provide </span> <span class="text-right" style="">/-</span>
                                    <input type="hidden" value="" name="intloan_provide">
                                </div>
                                <div class="list-item-sl">
                                    <span>Salary Payment </span> <span class="text-right" style="">/-</span>
                                    <input type="hidden" value="" name="salary_payment">
                                </div>
                                <div class="list-item-sl">
                                    <b>Total Expense </b> <b class="text-right" style="">/-</b>
                                    <input type="hidden" name="total_exense" value="">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 w-100 bg-success p-2 text-white text-center mt-2">
                            Cash Calculation
                        </div>

                        <div class="col-12 mt-2">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <th>Collection</th>
                                    <th>Expense</th>
                                    <th>Current Cash</th>
                                </tr>
                                <tr>
                                    <td> /-</td>
                                    <td> /-</td>

                                    <td>
                                        /-
                                    </td>
                                </tr>

                            </table>
                            <div class="row">
                                <div class="col-6 p-3" id="detailsbox">
                                    <b>Bank Balance</b><br>


                                    <input type="hidden" name="bankbalance" value="">
                                </div>
                                <div class="col-6 p-3" id="detailsbox">
                                    <b>Cash In Hand</b><br>


                                    <input type="hidden" name="cash" value="">
                                </div>
                            </div>
                        </div>


                        <div class="col-12 w-100 bg-success p-2 text-white text-center mt-2">
                            Current Cash
                        </div>

                        <div class="col-12 mt-2">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <th>Date</th>
                                    <th>Cash Amount</th>
                                    <th>Comment</th>
                                </tr>
                                <tr>
                                    <td>{{date('Y-m-d')}}</td>
                                    <td>/-</td>

                                    <td>
                                        <input type="text" class="" name="comment">
                                    </td>
                                </tr>

                            </table>
                        </div>

                        <div class="col-12">


                            <span class="text-danger">N:B - Your Toady Cash is Closed</span>

                            <input type="submit" class="btn btn-success" value="Submit Cash Close">
                        </div>

					</div>
				</form>



			</div> <!-- end card body-->
		</div> <!-- end card -->
	</div><!-- end col-->
</div>








@endsection
