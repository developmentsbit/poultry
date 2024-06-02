@extends('layouts.master')
@push('header_styles')
    <!-- third party css -->
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/buttons.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/select.bootstrap5.css') }}" rel="stylesheet" type="text/css">

<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.6.4.slim.min.js"></script>
    <!-- third party css end -->
@endpush
@section('content')
<div class="container">

    @component('components.breadcrumb')
        @slot('title')
            @lang('damage_product.create_title')
        @endslot
        @slot('breadcrumb1')
            @lang('common.dashboard')
        @endslot
        @slot('breadcrumb1_link')
            {{ route('dashboard') }}
        @endslot
        @if (\App\Traits\RolePermissionTrait::checkRoleHasPermission('role', 'create'))
            @slot('action_button1')
               <i class="fa fa-eye"></i> @lang('common.view')
            @endslot
            @slot('action_button1_link')
                {{ route('damage_product.index') }}
            @endslot
        @endif
        @slot('action_button1_class')
            btn-info
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('damage_product.store') }}">
                        @csrf
                        <div class="from-group row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <label for="product_id">@lang('damage_product.product')</label><span class="text-danger">*</span>
                                <select class="form-control js-example-basic-single" name="product_id" required id="product_id" onchange="getOriginalQty()">
                                    <option value="">@lang('common.select_one')</option>
                                    @foreach ($product as $p)
                                    <option value="{{ $p->pdt_id }}">{{ $p->pdt_id }} - {{ $p->pdt_name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <b>Available Qty : </b> <span class="text-danger" id="availableQty"></span>
                                <input type="hidden" name="available_qty" id="available_qty" value="" >
                            </div>
                            <div class="col-lg-12 col-md-12 col-12 mt-2" id="dmageProductBox">
                                <label for="damage_product">@lang('damage_product.damage_product')</label>
                                <input type="number" class="form-control form-control-sm" name="damage_product" id="damage_product" required onkeyup="checkQty()">
                            </div>
                            <div class="col-12 text-right mt-2" style="text-align: right">
                                <button class="btn btn-sm btn-success"><i class="fa fa-save"></i> @lang('common.submit')</button>
                            </div>
                        </div>
                    </form>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

</div>



@endsection
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
    <script>
        function checkQty()
        {
            let avialable_qty = parseInt($('#available_qty').val());
            let damage_product = parseInt($('#damage_product').val());
            if(damage_product > avialable_qty)
            {
                $('#damage_product').val('');
            }
        }
        function getOriginalQty()
        {
            let product_id = $('#product_id').val();
            if(product_id != '')
            {
                $.ajax({
                    headers : {
                        'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                    },

                    url : '{{ url('getOriginalQty') }}',

                    type : 'post',

                    data : {product_id},

                    success : function(res)
                    {
                        if(res == 0)
                        {
                            $('#availableQty').html(res);
                            $('#available_qty').val(res);
                            $('#dmageProductBox').hide();
                        }
                        else
                        {

                            $('#dmageProductBox').show();
                            $('#availableQty').html(res);
                            $('#available_qty').val(res);
                        }
                    }
                });
            }
        }
    </script>

@include('components.delete_script')
@endpush
