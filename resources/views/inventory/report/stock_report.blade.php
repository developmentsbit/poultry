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
                <h4>@lang('stock_report.title')</h4><br>
                <form method="get" target="_blank" action="show_stock_report">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-12 mt-2">
                            <label for="category">@lang('stock_report.category')</label>
                            <select class="form-control form-control-sm js-example-basic-single" name="category_id">
                                <option value="All">All</option>
                                @if(isset($category))
                                @foreach ($category as $v)
                                <option value="{{ $v->cat_id }}">{{ $v->cat_id}} - {{ $v->cat_name_en }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12 mt-2">
                            <label for="category">@lang('stock_report.brand')</label>
                            <select class="form-control form-control-sm js-example-basic-single" name="brand_id">
                                <option value="All">All</option>
                                @if(isset($brand))
                                @foreach ($brand as $v)
                                <option value="{{ $v->brand_id}}">{{ $v->brand_id}} - {{ $v->brand_name_en }} </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12 mt-2">
                            <button type="submit"  class="btn btn-sm btn-success"><i class="fa fa-eye"></i> @lang('stock_report.show_report')</button>
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
		$('#datepicker').datepicker({
			uiLibrary: 'bootstrap4'
		});

	</script>


	@endpush
@endsection
