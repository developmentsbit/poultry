<!DOCTYPE html>
<html>
<head>
  <title>Income Expense Report</title>
</head>
<body>
    <style>
        .datacolumn {
    width: 50%;
    float: left;
    /* margin-right: 13px; */
}
    </style>

  <div class="invoice">

    @component('components.report_banner')

    @endcomponent
    <center>
        @if($report_type == 'all')
        <b>Income Expense Report</b><br>
        @elseif($report_type == "income")
        <b>Income Report</b><br>
        @elseif($report_type == "expense")
        <b>Expense Report</b><br>
        @endif
        From {{$from_date}} to {{$to_date}}
    </center>
    <br>
    @if($report_type == 'all')
    <div class="datacolumn">
        <b>Incomes</b>
        <table id="">
            <tr>
                <th>Sl.</th>
                <th>Date</th>
                <th>Title</th>
                <th>Amount</th>
            </tr>
            @if($incomes)
            @foreach ($incomes as $v)
            <tr>
                <td>{{$i++}}</td>
                <td>{{$v->date}}</td>
                <td>{{$v->title_en}}</td>
                <td>{{$v->amount}} /-</td>
            </tr>
            @endforeach
            @endif
            <tr>
                <td colspan="3">Total</td>
                <td colspan=""><b>{{$total_income}} /-</b></td>
            </tr>
        </table>
    </div>
    <div class="datacolumn">
        <b style="float: right">Expenses</b>
        <table id="">
            <tr>
                <th>Date</th>
                <th>Title</th>
                <th>Amount</th>
            </tr>
            @if($expense)
            @foreach ($expense as $v)
            <tr>
                {{-- <td>{{$i++}}</td> --}}
                <td>{{$v->date}}</td>
                <td>{{$v->title_en}}</td>
                <td>{{$v->amount}} /-</td>
            </tr>
            @endforeach
            @endif
            <tr>
                <td colspan="2">Total</td>
                <td colspan=""><b>{{$total_expense}} /-</b></td>
            </tr>
        </table>
    </div>
    @endif

    @if($report_type == 'income')
    <table id="">
        <tr>
            <th>Sl.</th>
            <th>Date</th>
            <th>Title</th>
            <th>Amount</th>
        </tr>
        @if($incomes)
        @foreach ($incomes as $v)
        <tr>
            <td>{{$i++}}</td>
            <td>{{$v->date}}</td>
            <td>{{$v->title_en}}</td>
            <td>{{$v->amount}} /-</td>
        </tr>
        @endforeach
        @endif
        <tr>
            <td colspan="3">Total</td>
            <td colspan=""><b>{{$total_income}} /-</b></td>
        </tr>
    </table>
    @endif
    @if($report_type == 'expense')
    <table id="">
        <tr>
            <th>Date</th>
            <th>Title</th>
            <th>Amount</th>
        </tr>
        @if($expense)
        @foreach ($expense as $v)
        <tr>
            {{-- <td>{{$i++}}</td> --}}
            <td>{{$v->date}}</td>
            <td>{{$v->title_en}}</td>
            <td>{{$v->amount}} /-</td>
        </tr>
        @endforeach
        @endif
        <tr>
            <td colspan="2">Total</td>
            <td colspan=""><b>{{$total_expense}} /-</b></td>
        </tr>
    </table>
    @endif
<br>




  </div>

  <div class="print-btn" style="text-align:center">
    <button onclick="window.print()">Print</button>
</div>



</body>
</html>
