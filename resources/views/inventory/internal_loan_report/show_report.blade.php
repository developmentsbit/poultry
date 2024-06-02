<!DOCTYPE html>
<html>
<head>
  <title>Income Expense Report</title>
  @component('components.report_header')

  @endcomponent
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
        @if($report_type == 'All')
        <b>All Internal Loan Transaction Report</b><br>
        @else
        Internal Loan Transaction Report of <b>{{$member->name}}</b>
        <br>
        @endif
        From {{$from_date}} to {{$to_date}}
    </center>
    <br>

    <div class="row container-fluid">
        @if($report_type == "All")
        <div class="col-lg-6 col-6">
            <b>Loan Reciveds</b>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Register Name</th>
                    <th>Amount</th>
                </tr>
                @if($loan_recived)
                @foreach ($loan_recived as $v)
                <tr>
                    <td>{{$v->date}}</td>
                    <td>{{$v->name}}</td>
                    <td>{{$v->amount}}/-</td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <td colspan="2">Total</td>
                    <th colspan="">{{$total_loan_recived}}/-</th>
                </tr>
            </table>
        </div>
        <div class="col-lg-6 col-6">
            <b>Loan Provide</b>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Register Name</th>
                    <th>Amount</th>
                </tr>
                @if ($loan_provide)
                @foreach ($loan_provide as $v)
                <tr>
                    <td>{{$v->date}}</td>
                    <td>{{$v->name}}</td>
                    <td>{{$v->amount}}/-</td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <td colspan="2">Total</td>
                    <th colspan="">{{$total_loan_provide}}/-</th>
                </tr>
            </table>
        </div>
        @else

        <div class="col-6">
            <b>Loan Recived</b>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
                @if($loan_recived)
                @foreach ($loan_recived as $v)
                <tr>
                    <td>{{$v->date}}</td>
                    <td>{{$v->amount}}/-</td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <td>Total</td>
                    <th>{{$total_loan_recived}}</th>
                </tr>
            </table>
        </div>
        <div class="col-6">
            <b>Loan Provide</b>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
                @if($loan_provide)
                @foreach ($loan_provide as $v)
                <tr>
                    <td>{{$v->date}}</td>
                    <td>{{$v->amount}}/-</td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <td>Total</td>
                    <th>{{$total_loan_provide}}</th>
                </tr>
            </table>
        </div>

        @endif
    </div>

<br>




  </div>

  <div class="print-btn" style="text-align:center">
    <button onclick="window.print()">Print</button>
</div>



</body>
</html>
