<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Asset Report</title>
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
    use App\Models\asset_invest;
    use App\Models\asset_cost;
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
                <h3>{{$data['report_type']}} Asset Report
                    @if($data['title_id'] != 'all' )
                    ({{ $data['title_name']->title_en }})
                    @endif
                </h3>

                <b>{{ $data['search_date'] }}</b>
                <hr>
            </div>
        </div>
        <div class="page-body">
            @if($data['title_id'] == 'all')
            <table>
                <thead>
                    <tr>
                        <th> Sl</th>
                        <th>Asset Title</th>
                        <th>Invest</th>
                        <th>Withdraw</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @if($data['title'])
                    @foreach ($data['title'] as $v)
                    <tr>
                        <td>
                            {{ $i++ }}
                        </td>
                        <td>
                            {{ $v->title_en }}
                        </th>
                        <td>
                            @php
                            $total_invest = 0;
                            if($data['report_type'] == 'Daily')
                            {
                                $invests = asset_invest::where('title_id',$v->id)->where('date',Date::DateToDb('/',$data['search_date']))->sum('amount');
                            }
                            elseif($data['report_type'] == 'Monthly')
                            {
                                $invests = asset_invest::where('title_id',$v->id)
                                ->whereMonth('date',$data['month'])
                                ->whereYear('date',$data['year'])
                                ->sum('amount');
                            }
                            else
                            {
                                $invests = asset_invest::where('title_id',$v->id)
                                ->whereYear('date',$data['year'])
                                ->sum('amount');
                            }
                            @endphp
                            {{ $invests }}
                        </td>
                        <td>
                            @php
                            $total_withdraw = 0;
                            if($data['report_type'] == 'Daily')
                            {
                                $withdraw = asset_cost::where('title_id',$v->id)->where('date',Date::DateToDb('/',$data['search_date']))->sum('amount');
                            }
                            elseif($data['report_type'] == 'Monthly')
                            {
                                $withdraw = asset_cost::where('title_id',$v->id)
                                ->whereMonth('date',$data['month'])
                                ->whereYear('date',$data['year'])
                                ->sum('amount');
                            }
                            else
                            {
                                $withdraw = asset_cost::where('title_id',$v->id)
                                ->whereYear('date',$data['year'])
                                ->sum('amount');
                            }
                            @endphp
                            {{ $withdraw }}
                        </td>
                        <td>
                            {{ $invests - $withdraw}}
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>

            @else

            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Invest</th>
                        <th>Withdraw</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    @if($data['invests'])
                    @foreach ($data['invests'] as $v)
                    <tr>
                        <td>{{ $v->date }}</td>
                        <td>
                            {{ $v->amount }}
                        </td>
                        <td>

                        </td>
                        <td>
                            {!! $v->comment !!}
                        </td>
                    </tr>
                    @endforeach
                    @endif
                    @if($data['withdraw'])
                    @foreach ($data['withdraw'] as $v)
                    <tr>
                        <td>{{ $v->date }}</td>
                        <td>

                        </td>
                        <td>
                            {{ $v->amount }}
                        </td>
                        <td>
                            {!! $v->comment !!}
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>

            @endif
        </div>
        <div class="page-footer" style="text-align: center;margin-top:20px;">
            <button id="print" onclick="window.print()">Print</button>
        </div>
    </div>
</body>
</html>
