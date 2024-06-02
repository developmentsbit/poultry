<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales Profit Report</title>
    <style>
        .page{
            width: 1040px;
            margin: auto;
            /* border : 1px solid rgb(0, 0, 0); */
        }
        #banner{
            max-width: 100%;
        }
        table{
            width: 100%;
            font-size: 15px;
        }
        table, tr, td, th{
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td{
            padding : 4px;
        }
        #print{
            border-radius: 0px;
            padding: 7px 15px;
            background: red;
            color: white;
            border: none;
        }
        @media print
        {
            #print{
                display: none;
            }
        }
    </style>
</head>
@php
    use App\Traits\Date;
    use App\Models\sales_entry;
    use App\Models\purchase_entry;
    use App\Models\product_information;
    $i = 1;
    $total_sales = 0;
    $total_sales_return = 0;
    $total_purchase = 0;
    $total_profit = 0;
@endphp
<body>
    <div class="page">
        <div class="page-header">
            <div class="banner">
                <img src="{{ asset('inventory/banner') }}/{{ $website_info->banner }}" id="banner">
            </div>
            <div class="page-title" style="text-align: center;">
                <h3>{{$data['report_type']}} Sales Profit Report</h3>

                <b>{{ $data['search_date'] }}</b>
                <hr>
            </div>
        </div>
        <div class="page-body">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Sales Invoice No.</th>
                        <th>Sales Amount</th>
                        <th>Return Amount</th>
                        <th>Purchase Amount</th>
                        <th>Total Profit</th>
                    </tr>
                </thead>
                <tbody>
                    @if($data['data'])
                    @foreach ($data['data'] as $d)

                    @php

                    $sales_price =0;
                    $return_amount = 0;
                    $purchase_price = 0;

                    $sales_amount = sales_entry::where('invoice_no',$d->invoice_no)->get();
                    foreach ($sales_amount as  $sa)
                    {
                        if($sa->return_quantity != NULL)
                        {
                            $return_amount = $return_amount + $sa->product_sales_price;
                        }


                        if($sa->product_quantity != NULL)
                        {



                        $actual_amount = ($sa->product_sales_price - $sa->product_discount_amount) * $sa->product_quantity;
                        $sales_price = $sales_price + $actual_amount;
                        // <- purchase info ->
                        $purchase_amount = product_information::where('pdt_id',$sa->product_id)->first();

                        $sales_qty = sales_entry::where('invoice_no',$d->invoice_no)->where('product_id',$sa->product_id)->sum('product_quantity');
                        $return_qty = sales_entry::where('invoice_no',$d->invoice_no)->where('product_id',$sa->product_id)->sum('return_quantity');

                        $main_qty = ($sales_qty - $return_qty);

                        $purchase_price = $purchase_price + ( $purchase_amount->pdt_purchase_price * $main_qty );

                        }
                    }
                    @endphp
                    <tr>
                        <td>
                            {{ Date::DbtoDate('-',$d->invoice_date) }}
                        </td>
                        <td>
                            <a target="_blank" href="{{ url('sales_invoicea4') }}/{{ $d->invoice_no }}">
                                {{ $d->invoice_no }}
                            </a>
                        </td>
                        <td>
                            {{ $sales_price }}
                            @php
                            $total_sales = $total_sales + $sales_price;
                            @endphp
                        </td>
                        <td>
                            @if($return_amount == 0)
                            -
                            @else
                            {{ $return_amount }}
                            @endif
                            @php
                            $total_sales_return = $total_sales_return + $return_amount;
                            @endphp
                        </td>
                        <td>
                            {{ $purchase_price }}
                            @php
                            $total_purchase = $total_purchase + $purchase_price;
                            @endphp
                        </td>
                        <td>
                            {{ ($sales_price - $return_amount) - $purchase_price }}
                            @php
                            $total_profit = $total_profit + ($sales_price - $purchase_price);
                            @endphp
                        </td>
                    </tr>
                    @endforeach
                    @endif
                    <tr>
                        <th colspan="2" style="text-align: right;">Total</th>
                        <th style="text-align: left;">
                            {{ $total_sales }}
                        </th>
                        <th style="text-align: left;">
                            {{ $total_sales_return }}
                        </th>
                        <th style="text-align: left;">
                            {{ $total_purchase }}
                        </th>
                        <th style="text-align: left;">
                            {{ $total_profit }}
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="page-footer" style="text-align: center;margin-top:20px;">
            <button id="print" onclick="window.print()">Print</button>
        </div>
    </div>
</body>
</html>
