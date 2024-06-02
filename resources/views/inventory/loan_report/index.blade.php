@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('loan_report.loan_report')</h3><br>

				<form method="get" class="btn-submit" action="{{ url('show_loan_report') }}" enctype="multipart/form-data" target="_blank">

					<div class="row myinput">

						<input type="hidden" name="branch_id" id="branch_id" value="{{ Auth()->user()->branch }}">


						<div class="form-group col-md-4 mb-2">
							<label>@lang('loan_report.from_date'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input class="form-control" type="date" name="from_date" id="from_date"  required="" value="">
							</div>
						</div>
						<div class="form-group col-md-4 mb-2">
							<label>@lang('loan_report.to_date'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<input class="form-control" type="date" name="to_date" id="to_date"  required="">
							</div>
						</div>

                        <div class="form-group col-md-4 mb-2">
							<label>@lang('loan_report.member'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">
								<select class="form-control" name="register_id" id="register_id" required>
                                    <option value="All">All</option>
                                    @if($member)
                                    @foreach ($member as $m)
                                    <option value="{{$m->id}}">{{$m->name}} - {{$m->phone}}</option>
                                    @endforeach
                                    @endif
								</select>
							</div>
						</div>

						<div class="modal-footer border-0 col-12">
							<button type="submit" class="btn btn-success button border-0">@lang('common.show_report')</button>
						</div>





					</div>
				</form>



			</div> <!-- end card body-->
		</div> <!-- end card -->
	</div><!-- end col-->
</div>








@endsection
