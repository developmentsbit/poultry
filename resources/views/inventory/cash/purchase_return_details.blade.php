<!DOCTYPE html>
<html>
<head>
  <title>Purchase Return Detials</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>

  <div class="invoice">

    @component('components.report_banner')

    @endcomponent

    <center>
        <b>Purchase Return Detials</b>
        <br>
        From {{ App\Traits\Date::DbToDate('-',$from_date) }} To {{ App\Traits\Date::DbToDate('-',$today_date) }}
        <br>
        @php
            $total = 0;
            $grandtotal = 0;
        @endphp
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Return Invoice NO</th>
                    <th>Details</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data))
                @foreach ($data as $v)
                <tr>
                    <td>
                        {{ App\Traits\Date::DbToDate('-',$v->payment_date) }}
                    </td>
                    <td>
                        {{ $v->invoice_no }}
                    </td>
                    <td>
                        @php
                            $return_entries = App\Models\purchase_entry::leftjoin('product_informations','product_informations.pdt_id','purchase_entries.product_id')
                            ->leftjoin('product_measurements','product_measurements.measurement_id','product_informations.pdt_measurement')
                            ->where('purchase_entries.invoice_no',$v->invoice_no)
                            ->where('purchase_entries.status',$v->id)
                            ->where('purchase_entries.return_quantity','>',0)
                            ->get();
                        @endphp
                        @foreach ($return_entries as $r)
                        <span>{{ $r->pdt_name_en }} -  {{ $r->return_quantity }} {{ $r->measurement_unit }} *{{ $r->purchase_price }}</span>

                        @php
                            $total = 0;
                            $total = $total + ($r->return_quantity * $r->purchase_price);
                        @endphp

                        @endforeach
                    </td>
                    <td>
                        @php
                            $grandtotal = $grandtotal + $total;
                        @endphp
                        {{ $total }}
                    </td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <th colspan="3" style="text-align: right;">Total</th>
                    <th>{{ $grandtotal }}</th>
                </tr>
            </tbody>
        </table>
    </center>

    <div class="container-fluid row">





  </div>



</body>
</html>
