<!DOCTYPE html>
<html>
<head>
  <title>Bank Account Cost Details</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>

  <div class="invoice">

    @component('components.report_banner')

    @endcomponent

    <center>
        <b>Bank Account Cost Detials</b>
        <br>
        From {{ App\Traits\Date::DbToDate('-',$from_date) }} To {{ App\Traits\Date::DbToDate('-',$today_date) }}
        <br>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Bank Name</th>
                    <th>TRX ID</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data))
                @foreach ($data as $v)
                <tr>
                    <td>{{ App\Traits\Date::DbToDate('-',$v->date) }}</td>
                    <td>
                        {{ $v->bank_name.'-'. $v->account_type }}
                    </td>
                    <td>
                        {{ $v->voucher_cheque_no }}
                    </td>
                    <td>
                        {{ $v->amount }}
                    </td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <th colspan="3" style="text-align: right">Total</th>
                    <th>{{ $total }}</th>
                </tr>
            </tbody>
        </table>
    </center>

    <div class="container-fluid row">





  </div>



</body>
</html>
