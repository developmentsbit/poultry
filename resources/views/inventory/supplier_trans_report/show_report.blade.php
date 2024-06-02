<!DOCTYPE html>
<html>
<head>
  <title>{{$supplier->supplier_name_en}} Balance Sheet</title>
</head>
<body>

    <style>
        table {
            font-size: 13px;
        }
    </style>

  <div class="invoice">

    @component('components.report_banner')

    @endcomponent


    <table>
        <tr>
            <td style="text-align: center;" colspan="8">
                Supplier Transaction Report<br>
                {{$from_date}} to {{$to_date}}
            </td>
        </tr>
        <tr>
            <th>Sl</th>
            <th>Date</th>
            <th>Invoice No</th>
            <th>Grand Total</th>
            <th>Discount</th>
            <th>Paid</th>
            <th>Loan Amount</th>
            <th>Return Amount</th>
            <th>Due</th>
        </tr>
        @php
        $sl = 1;
        $totalDue = 0;
        $totalPayment = 0;
        $finalTotal = 0;
        $totalGrandTotal = 0;
        $totalGrandDiscount = 0;
        $totalGrandPaid = 0;
        $totalGrandLoan = 0;
        $totalGrandReturn = 0;
        @endphp
        <tr>
            <td colspan="8">Balance The Date In {{$previous_date}}</td>
            <td>{{$finalTotal + $balance}} /-</td>
        </tr>

        @if($data)
        @foreach ($data as $v)
        @if($v->comment != 'PD')
        <tr>
            <td>{{$sl++}}</td>
            <td>{{GetDate::getDate($v->payment_date,'-') ?? '-'}}</td>
            <td>
                <a target="_blank" href="{{ url('invoicepurchase') }}/{{ $v->invoice_no }}">
                    {{$v->invoice_no}}
                </a>
            </td>
            @php
            $purchase_ledger = DB::table('purchase_ledgers')->where('deleted_at',NULL)->where('invoice_no',$v->invoice_no)->first();
            @endphp
            <td>
                @if($v->invoice_no && $v->return_amount == NULL)

                @php
                    $finalTotal = $finalTotal + $purchase_ledger->total;
                    $totalGrandTotal = $totalGrandTotal + $purchase_ledger->total;
                @endphp

                {{$purchase_ledger->total}}
                @endif
            </td>
            <td>
                @if($v->invoice_no && $v->return_amount == NULL)
                @php
                    $finalTotal = $finalTotal - $purchase_ledger->discount;
                    $totalGrandDiscount = $totalGrandDiscount + $purchase_ledger->discount;
                @endphp
                {{$purchase_ledger->discount}} /-
                @else
                @php
                    $finalTotal = $finalTotal - $v->discount;
                    $totalGrandDiscount = $totalGrandDiscount + $v->discount;
                @endphp
                {{ $v->discount }}
                @endif
            </td>
            <td>
                @if($v->invoice_no && $v->return_amount == NULL)
                @php
                    $finalTotal = $finalTotal - $purchase_ledger->paid;
                    $totalGrandPaid = $totalGrandPaid + $purchase_ledger->paid;
                @endphp
                {{$purchase_ledger->paid}} /-
                @else

                @if($v->payment > 0)
                @php
                    $finalTotal = $finalTotal - $v->payment;
                    $totalGrandPaid = $totalGrandPaid + $v->payment;
                @endphp
                {{$v->payment}}/-
                @endif

                @endif
            </td>
            <td>
                @if($v->payment < 0)
                @php
                    $finalTotal = $finalTotal - $v->payment;
                    $totalGrandLoan = $totalGrandLoan + ($v->payment * -1);
                @endphp
                {{$v->payment}}
                @endif
            </td>
            <td>
                @if($v->invoice_no && $v->return_amount != NULL)
                @php
                    $finalTotal = $finalTotal - $v->return_amount;
                    $totalGrandReturn = $totalGrandReturn + $v->return_amount;
                @endphp
                {{$v->return_amount}} /-
                @endif
            </td>
            <td>
                {{ $finalTotal }}/-
            </td>
        </tr>
        @endif
        @endforeach
        @endif

        <tr>
            <td colspan="3">Total Due : </td>
            <th style="text-align: left;">{{ $totalGrandTotal}}/-</th>
            <th style="text-align: left;">{{ $totalGrandDiscount}}/-</th>
            <th style="text-align: left;">{{ $totalGrandPaid}}/-</th>
            <th style="text-align: left;">{{ $totalGrandLoan}}/-</th>
            <th style="text-align: left;">{{ $totalGrandReturn}}/-</th>
            <th style="text-align: left;">{{$totalDueBetweenSearch}}  /-</th>
        </tr>

    </table>

    Balance in Today (@php echo date('d M Y'); @endphp) : <u>{{$finalTotal}}</u>
    <br>

    <br>
    <center><a href="#" class="btn btn-danger btn-sm print w-10" onclick="window.print();">Print</a></center>
    <br>

  </div>



</body>
</html>
