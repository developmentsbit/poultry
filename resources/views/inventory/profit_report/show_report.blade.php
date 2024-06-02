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
    $totalSalesItem = 0;
    $netProfit = 0;
@endphp
<body>
    <div class="page">
        <div class="page-header">
            <div class="banner">
                <img src="{{ asset('inventory/banner') }}/{{ $website_info->banner }}" id="banner">
            </div>
            <div class="page-title" style="text-align: center;">
                <h3>{{$data['report_type']}} Profit Report</h3>

                <b>{{ $data['search_date'] }}</b>
                <hr>
            </div>
        </div>
        <div class="page-body">
            <table>
                <thead>
                    <tr>
                        <th>Details</th>
                        <th>Tk</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($data['profit_data']))
                    @foreach ($data['profit_data'] as $pd)
                    <tr>
                        <td>
                            {{ $pd->item_name_en }}
                        </td>
                        <td>
                            {{ $pd->profit }}
                            @php
                            $netProfit += $pd->profit;
                            @endphp
                        </td>
                    </tr>
                    @endforeach
                    @endif
                    <tr>
                        <th style="text-align: left;">Total Item Sales</th>
                        <th style="text-align: left;">{{ $netProfit }}</th>
                    </tr>
                    <tr>
                        <td>
                           (-) Sales Discount
                        </td>
                        <td>
                            {{ $data['sales_discount'] }}
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Sub Total Sales Profit </th>
                        <th style="text-align: left;">{{ $netProfit - $data['sales_discount'] }}</th>
                    </tr>
                    <tr>
                        <td>
                            (+) Total Incomes
                        </td>
                        <td>
                            {{ $data['total_incomes']}}
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">
                            Total Net Profit
                        </th>
                        <th style="text-align: left">
                            {{ ($netProfit - $data['sales_discount']) + $data['total_incomes'] }}
                        </th>
                    </tr>
                    <tr>
                        <td>
                            (-) Total Expense
                        </td>
                        <td>
                            {{ $data['total_expense']}}
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: left">
                            Grand Profit
                        </th>
                        <th style="text-align: left">
                            {{ (($netProfit - $data['sales_discount']) + $data['total_incomes']) - $data['total_expense'] }}
                        </th>
                    </tr>
                    <tr>
                        <td>
                            (-) Total Salary Pay
                        </td>
                        <td>
                            {{ $data['salary_pay']}}
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">
                            Total Profit
                        </th>
                        <th style="text-align: left">
                            {{ ((($netProfit - $data['sales_discount']) + $data['total_incomes']) - $data['total_expense']) - $data['salary_pay'] }}
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
