@extends('layouts.master')
@section('content')
@push('header_styles')
<!-- third party css -->
<link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/vendor/buttons.bootstrap5.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/vendor/select.bootstrap5.css') }}" rel="stylesheet" type="text/css">
<!-- third party css end -->

<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.6.4.slim.min.js"></script>
<style>
    .form-control {
    padding: 4px 9px;
    font-size: 14px;
    border-radius: 0px !important;
}


</style>
@endpush
<div class="container mt-2">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
                <h4>Financial Statement</h4><br>
                <form method="get" target="_blank" action="show_financial_statement">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12 mt-2">
                            <label for="category">Report Type</label>
                            <select class="form-control form-control-sm js-example-basic-single" name="report_type" id="report_type" onchange="reportStat()" required>
                                <option value="">Select One</option>
                                <option value="Monthly">Monthly</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 mt-2" id="dateBox">
                            <label for="category">Date</label>
                            <input type="text" id="datepicker" class="form-control form-control-sm" name="date" id="date" autocomplete="off" value="{{ date('d/m/Y') }}">
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 mt-2" id="monthBox">
                            <label>Select Month</label>
                            <select class="form-control form-control-sm js-example-basic-single" name="month" id="month">
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 mt-2" id="yearBox">
                            <label for="category">Year</label>
                            <input type="text" id="year" class="form-control form-control-sm" name="year" id="year" autocomplete="off" value="{{ date('Y') }}">
                        </div>
                        <div class="col-lg-12 col-md-12 col-12 mt-2">
                            <button type="submit"  class="btn btn-sm btn-success"><i class="fa fa-eye"></i> Show Report</button>
                        </div>
                    </div>
                </form>
			</div> <!-- end card body-->
		</div> <!-- end card -->
	</div><!-- end col-->
</div>
@push('footer_scripts')
	<!-- third party js -->
	<script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/dataTables.buttons.min.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/buttons.bootstrap5.min.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/buttons.html5.min.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/buttons.flash.min.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/buttons.print.min.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/dataTables.keyTable.min.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/dataTables.select.min.js') }}"></script>
	<!-- third party js ends -->

	<!-- demo app -->
	<script src="{{ asset('assets/js/pages/demo.datatable-init.js') }}"></script>
	<!-- end demo js-->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>
        $('#dateBox').hide();
        $('#monthBox').hide();
        $('#yearBox').hide();
    </script>

    <script>
        function reportStat()
        {
            let report_type = $('#report_type').val();
            if(report_type == 'Daily')
            {
                $('#dateBox').show();
                $('#monthBox').hide();
                $('#yearBox').hide();
            }
            else if(report_type == 'Monthly')
            {
                $('#dateBox').hide();
                $('#monthBox').show();
                $('#yearBox').show();
            }
            else if(report_type == 'Yearly')
            {
                $('#dateBox').hide();
                $('#monthBox').hide();
                $('#yearBox').show();
            }
            else
            {
                $('#dateBox').hide();
                $('#monthBox').hide();
                $('#yearBox').hide();
            }
        }
    </script>

	<script>
		$('#datepicker').datepicker({
            format : 'dd/mm/yyyy',
			uiLibrary: 'bootstrap4'
		});

	</script>


	@endpush
@endsection
