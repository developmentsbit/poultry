<!DOCTYPE html>
<html>
<head>
  <title>Bank Sheet</title>
</head>
<body>

  <div class="invoice">

    @component('components.report_banner')

    @endcomponent

    <table>
        <tr>
            <th colspan="12" style="text-align: left">
                <b>Bank Name : </b> {{$bank_info->bank_name}}<br>
                <b>A/C No : </b> {{$bank_info->account_number}}<br>
                <b>A/C Type : </b> {{$bank_info->account_type}}
            </th>
        </tr>
        <tr>
            <th>Serial No</th>
            <th>Date</th>
            <th>Voucher / Cheque No</th>
            <th>Deposit</th>
            <th>Withdraw</th>
            <th>Bank Account Cost</th>
            <th>Interest Deposit</th>
        </tr>
        @if($bank_transaction)
        @foreach ($bank_transaction as $v)
        <tr>
            <td>{{$i++}}</td>
            <td>{{$v->date}}</td>
            <td>
                @if($v->voucher_cheque_no)
                {{$v->voucher_cheque_no}}
                @else
                -
                @endif
            </td>
            <td>
                @if($v->transaction_type == 1)
                {{$v->amount}} /-
                @else
                -
                @endif
            </td>
            <td>
                @if($v->transaction_type == 2)
                {{$v->amount}} /-
                @else
                -
                @endif
            </td>
            <td>
                @if($v->transaction_type == 3)
                {{$v->amount}} /-
                @else
                -
                @endif
            </td>
            <td>
                @if($v->transaction_type == 4)
                {{$v->amount}} /-
                @else
                -
                @endif
            </td>
        </tr>
        @endforeach
        @endif
        <tr>
            <td colspan="3">Total</td>
            <td><b>{{$total_deposit}} /-</b></td>
            <td><b>{{$total_withdraw}} /-</b></td>
            <td><b>{{$total_accost}} /-</b></td>
            <td><b>{{$total_interest}} /-</b></td>
        </tr>
    </table>
<br>

    <b>Balance : </b> <u>{{$balance}}</u>










    <br>

    <br>
    <center><a href="#" class="btn btn-danger btn-sm print w-10" onclick="window.print();">Print</a></center>
    <br>

  </div>



</body>
</html>
