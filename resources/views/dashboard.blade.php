@extends('layouts.master')

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('components.error_messages')

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <form class="d-flex">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-light" id="dash-daterange">
                                <span class="input-group-text bg-primary border-primary text-white">
                                    <i class="mdi mdi-calendar-range font-13"></i>
                                </span>
                            </div>
                            <a href="javascript: void(0);" class="btn btn-primary ms-2">
                                <i class="mdi mdi-autorenew"></i>
                            </a>
                            <a href="javascript: void(0);" class="btn btn-primary ms-1">
                                <i class="mdi mdi-filter-variant"></i>
                            </a>
                        </form>
                    </div>
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12 col-lg-12">

                <div class="row">
                    <div class="col-lg-3">
                        <div class="card widget-flat">
                            <div class="card-body">
                                <div class="float-end">
                                    <i class="fa fa-users"></i>
                                </div>
                                <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Total Customers</h5>
                                <h3 class="mt-3 mb-3">{{$total_customer}}</h3>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-lg-3">
                        <div class="card widget-flat">
                            <div class="card-body">
                                <div class="float-end">
                                    <i class="fa fa-users"></i>
                                </div>
                                <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Total Suppliers</h5>
                                <h3 class="mt-3 mb-3">{{$total_suppliers}}</h3>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-lg-3">
                        <div class="card widget-flat">
                            <div class="card-body">
                                <div class="float-end">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Total Purchase</h5>
                                <h3 class="mt-3 mb-3">{{$total_purchase}}</h3>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->


                    <div class="col-lg-3">
                        <div class="card widget-flat">
                            <div class="card-body">
                                <div class="float-end">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Total Sales</h5>
                                <h3 class="mt-3 mb-3">{{$total_sales}}</h3>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->


                    <div class="col-lg-3">
                        <div class="card widget-flat">
                            <div class="card-body">
                                <div class="float-end">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Total Product</h5>
                                <h3 class="mt-3 mb-3">{{$total_product}}</h3>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->


                    <div class="col-lg-3">
                        <div class="card widget-flat">
                            <div class="card-body">
                                <div class="float-end">
                                    <i class="fa fa-money-bill"></i>
                                </div>
                                <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Total Income</h5>
                                <h3 class="mt-3 mb-3">{{$total_income}}</h3>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                    <div class="col-lg-3">
                        <div class="card widget-flat">
                            <div class="card-body">
                                <div class="float-end">
                                    <i class="fa fa-money-bill"></i>
                                </div>
                                <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Total Expense</h5>
                                <h3 class="mt-3 mb-3">{{$total_expense}}</h3>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->



                </div> <!-- end row -->

            </div> <!-- end col -->


        </div>
        <!-- end row -->


        <!-- end row -->



        <!-- end row -->

    </div>
    <!-- container -->
@endsection

@push('footer_scripts')
    <!-- third party js -->
    <script src="{{ asset('assets/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- third party js ends -->

    <!-- demo app -->
    <script src="{{ asset('assets/js/pages/demo.dashboard.js') }}"></script>
    <!-- end demo js-->
@endpush
