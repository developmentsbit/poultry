@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('income_expense_report.report_title')</h3><br>

				<form method="get" class="btn-submit" action="{{ url('show_income_expense_report') }}" enctype="multipart/form-data" target="_blank">

					<div class="row myinput">

						<input type="hidden" name="branch_id" id="branch_id" value="{{ Auth()->user()->branch }}">


						<div class="form-group col-md-4 mb-2">
							<label>@lang('income_expense_report.from_date'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input class="form-control" type="date" name="from_date" id="from_date"  required="" value="">
							</div>
						</div>
						<div class="form-group col-md-4 mb-2">
							<label>@lang('income_expense_report.to_date'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input class="form-control" type="date" name="to_date" id="to_date"  required="">
							</div>
						</div>

                        <div class="form-group col-md-4 mb-2">
							<label>@lang('income_expense_report.report_type'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">
								<select class="form-control" name="report_type" id="report_type" required>
                                    <option value="all">All</option>
                                    <option value="income">Income</option>
                                    <option value="expense">Expense</option>
								</select>
							</div>
						</div>

						<div class="modal-footer border-0 col-12">
							<button type="submit" class="btn btn-success button border-0">@lang('customer.add_button')</button>
						</div>





					</div>
				</form>



			</div> <!-- end card body-->
		</div> <!-- end card -->
	</div><!-- end col-->
</div>








@endsection
