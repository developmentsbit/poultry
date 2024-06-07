<!DOCTYPE html>
<html>
<head>
  <title>Supplier Loan Report</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>

  <div class="invoice">

    @component('components.report_banner')

    @endcomponent

    <center>
        <b>Supplier Loan Detials</b>
        <br>
        From {{ App\Traits\Date::DbToDate('-',$from_date) }} To {{ App\Traits\Date::DbToDate('-',$today_date) }}
        <br>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Invoice No</th>
                    <th>Customer Name</th>
                    <th>Note</th>
                    <th>Payment Amount</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data))
                @foreach ($data as $v)
                <tr>
                    <td>{{ App\Traits\Date::DbToDate('-',$v->payment_date) }}</td>
                    <td>
                        @if(isset($v->invoice_no))
                        {{ $v->invoice_no }}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        {{ $v->supplier_name_en }}
                    </td>
                    <td>
                        {{$v->comment}}
                    </td>
                    <td>
                        {{ $v->payment * -1 }}
                    </td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <th style="text-align: right" colspan="4"> Total</th>
                    <th>{{$total * -1}}</th>
                </tr>
            </tbody>
        </table>
    </center>

    <div class="container-fluid row">





  </div>



</body>
</html>
