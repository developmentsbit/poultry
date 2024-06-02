<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stock Report</title>
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
    $grandTotal = 0;
    $salesTotal = 0;
    $totalPurchaseStock = 0;
    $totalSalesStock = 0;
    $i = 1;
    use App\Models\product_information;
@endphp
<body>
    <div class="page">
        <div class="page-header">
            <div class="banner">
                <img src="{{ asset('inventory/banner') }}/{{ $website_info->banner }}" id="banner">
            </div>
            <div class="page-title" style="text-align: center;">
                <h3>Stock Report</h3>
            </div>
        </div>
        <div class="page-body">
            <table>
                <thead>
                <tr>
                    <th colspan="5">
                        Category : {{ $category }}
                    </th>
                    <th colspan="4">
                        Brand : {{ $brand }}
                    </th>
                </tr>
                <tr>
                    <th>Sl</th>
                    <th>Product Name</th>
                    <th>Total Purchase</th>
                    <th>Total Sales</th>
                    <th>Purchase Return</th>
                    <th>Sales Return</th>
                    <th>Damage Stock</th>
                    <th>Current Stock</th>
                    <th>Current Purchase Stock Price</th>
                    <th>Current Sales Stock Price</th>
                </tr>
                </thead>
                <tbody>
                    @if(isset($data))
                    @foreach ($data as $v)
                    @php
                    $product = product_information::where('pdt_id',$v->product_id)->first();
                    $purchase_price = $v->quantity * $product->pdt_purchase_price;
                    $totalPurchaseStock = $totalPurchaseStock + $purchase_price;
                    $sales_price = $v->sales_qty * $product->pdt_sale_price;
                    $totalSalesStock = $totalSalesStock + $sales_price;
                    @endphp
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>
                            {{ $v->product_id }} - {{ $v->pdt_name_en }}
                        </td>
                        <td>
                            {{ $v->quantity }} {{ $v->measurement_unit }}

                        </td>
                        <td>
                            @if($v->sales_qty > 0)
                            {{ $v->sales_qty }} {{ $v->measurement_unit }}
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            @if($v->purchase_return_qty > 0)
                            {{ $v->purchase_return_qty }} {{ $v->measurement_unit }}
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            @if($v->sales_return_qty > 0)
                            {{ $v->sales_return_qty }} {{ $v->measurement_unit }}
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            @if($v->damage_product > 0)
                            {{ $v->damage_product }} {{ $v->measurement_unit }}
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            @php
                            $available_qty = ($v->quantity + $v->sales_return_qty) - ($v->sales_qty + $v->purchase_return_qty) - $v->damage_product;
                            @endphp
                            {{$available_qty}} {{ $v->measurement_unit }}
                        </td>
                        <td>
                           {{ $available_qty * $v->pdt_purchase_price}} /-
                           @php
                            $grandTotal = $grandTotal + ( $available_qty * $v->pdt_purchase_price );
                           @endphp
                        </td>
                        <td>
                           {{ $available_qty * $product->pdt_sale_price}} /-
                           @php
                            $salesTotal = $salesTotal + ( $available_qty * $product->pdt_sale_price );
                           @endphp
                        </td>
                    </tr>
                    @endforeach
                    @endif
                    <tr>
                        <th colspan="2" style="text-align: right;">
                            Grand Total
                        </th>
                        <th style="text-align: left;">
                            {{$totalPurchaseStock}}
                        </th>
                        <th style="text-align: left;">
                            {{$totalSalesStock}}
                        </th>
                        <th style="text-align: left;">
                            -
                        </th>
                        <th style="text-align: left;">
                            -
                        </th>
                        <th style="text-align: left;">
                            -
                        </th>
                        <th style="text-align: left;">
                            -
                        </th>
                        <th style="text-align: left;">
                            {{ $grandTotal }}/-
                        </th>
                        <th style="text-align: left;">
                            {{ $salesTotal }}/-
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
