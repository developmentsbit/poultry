<!DOCTYPE html>
<html>
<head>
  <title>Salary Payment Report</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>

  <div class="invoice">

    @component('components.report_banner')

    @endcomponent

    <center>
        <b>Salary Payment Detials</b>
        <br>
        From {{ App\Traits\Date::DbToDate('-',$from_date) }} To {{ App\Traits\Date::DbToDate('-',$today_date) }}
        <br>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Invoice No</th>
                    <th>Employee Name</th>
                    <th>Note</th>
                    <th>Payment Amount</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data))
                @foreach ($data as $v)
                <tr>
                    <td>{{ App\Traits\Date::DbToDate('-',$v->date) }}</td>
                    <td>{{ $v->month }}</td>
                    <td>
                        {{ $v->name }}
                    </td>
                    <td>
                        {{$v->note}}
                    </td>
                    <td>
                        {{ $v->salary_withdraw }}
                    </td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <th style="text-align: right" colspan="4"> Total</th>
                    <th>{{$total}}</th>
                </tr>
            </tbody>
        </table>
    </center>

    <div class="container-fluid row">





  </div>



</body>
</html>
