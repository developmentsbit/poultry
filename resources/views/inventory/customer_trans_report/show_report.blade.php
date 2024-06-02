<!DOCTYPE html>
<html>
<head>
  <title>{{$customer->customer_name_en}} Balance Sheet</title>
</head>
<body>

  <div class="invoice">

    @component('components.report_banner')

    @endcomponent


    <table style="font-size: 13px;">
        <tr>
            <td style="text-align: center;" colspan="8">
                Customer Transaction Report<br>
                {{$from_date}} to {{$to_date}}
            </td>
        </tr>
        <tr>
            <th>Date</th>
            <th>Invoice Details</th>
            <th>Grand Total</th>
            <th>Paid</th>
            <th>Discount</th>
            <th>Loan Amount</th>
            <th>Return Amount</th>
            <th>Due</th>
        </tr>
        <tr>
            <td colspan="7">Balance The Date In {{$previous_date}}</td>
            <td>{{$balance}} /-</td>
        </tr>

        @php
            $sl = 1;
            $totalGrandTotal = 0;
            $totalPaid= 0;
            $totalDiscount= 0;
            $totalLoanAmount= 0;
            $totalReturnAmount= 0;
            $balance = 0;
        @endphp

        @if(isset($data))
        @foreach ($data as $v)
        <tr>
            <td>
                {{GetDate::getDate($v->entry_date,'-') ?? '-'}}
            </td>
            <td>
                @if($v->invoice_no)
                <a target="_blank" href="{{ url('sales_invoicea4') }}/{{ $v->invoice_no }}">
                    {{$v->invoice_no}}
                </a>

                @elseif($v->payment_amount < 0)

                Customer Loan

                @elseif($v->payment_amount <= 0 && $v->discount)

                Customer Discount

                @elseif($v->payment_amount >= 0 && $v->discount)

                Sales Payment With Discount

                @else
                @endif
                @if(isset($v->note)) ( {{ $v->note }}) @endif
            </td>
            <td>
                @if($v->invoice_no && $v->return_amount == NULL && $v->note != 'purchasewithsales')
                @php
                $sales_ledger = App\Models\sales_ledger::where('invoice_no',$v->invoice_no)->first();
                $total = $sales_ledger->total - $sales_ledger->final_discount;
                $totalGrandTotal = $totalGrandTotal + $total;
                $balance = $balance + $total;
                @endphp
                {{$total}} @if($sales_ledger->final_discount > 0)({{$sales_ledger->total}} tk - {{$sales_ledger->final_discount}} tk)@endif
                @else
                -
                @endif
            </td>
            <td>
                @if($v->invoice_no && $v->return_amount == NULL && $v->note != 'purchasewithsales')

                {{$sales_ledger->paid_amount}}

                @php
                    $totalPaid = $totalPaid + $sales_ledger->paid_amount;
                    $balance = $balance - $sales_ledger->paid_amount;
                @endphp

                @else

                @if($v->payment_amount > 0 || $v->note == 'purchasewithsales')
                {{$v->payment_amount}}
                @php
                $totalPaid = $totalPaid + $v->payment_amount;
                $balance = $balance - $v->payment_amount;
                @endphp
                @endif

                @endif
            </td>
            <td>
                {{ $v->discount }}
                @php
                    $totalDiscount = $totalDiscount + $v->discount;
                    $balance = $balance - $v->discount;
                @endphp
            </td>
            <td>
                @if($v->payment_amount < 0)
                {{$v->payment_amount *-1}}
                @php
                    $totalLoanAmount = $totalLoanAmount + ($v->payment_amount * -1);
                    $balance = $balance + ($v->payment_amount * -1);
                @endphp
                @endif
            </td>
            <td>
                @if($v->return_amount != NULL)
                {{$v->return_amount}}
                @php
                    $totalReturnAmount = $totalReturnAmount + $v->return_amount;
                    $balance = $balance - $v->return_amount;
                @endphp
                @else
                -
                @endif
            </td>
            <td>
                {{-- @if($v->invoice_no && $v->note != 'purchasewithsales')

                    @if($v->return_amount != NULL)

                    ( {{$v->return_amount}} )

                    @else

                    {{($sales_ledger->total - $sales_ledger->final_discount) - $sales_ledger->paid_amount}}

                    @endif

                @elseif($v->payment_amount > 0 || $v->payment_amount == NULL)

                ( {{($v->payment_amount + $v->discount)}} )

                @elseif($v->payment_amount < 0)

                {{$v->payment_amount * -1}}

                @elseif ($v->return_amount != NULL)

                {{$v->return_amount}}

                @endif --}}
                {{$balance}}
            </td>
        </tr>
        @endforeach
        @endif
        <tr>
            <td colspan="2">
                Total :
            </td>
            <th style="text-align:left;">
                {{ $totalGrandTotal }}
            </th>
            <th style="text-align:left;">
                {{ $totalPaid }}
            </th>
            <th style="text-align:left;">
                {{ $totalDiscount }}
            </th>
            <th style="text-align:left;">
                {{ $totalLoanAmount }}
            </th>
            <th style="text-align:left;">
                {{ $totalReturnAmount }}
            </th>
            <th style="text-align:left;">
                {{ $totalDueBetweenSearch }}
            </th>
        </tr>



    </table>

    {{-- Balance in Today (@php echo date('d M Y'); @endphp) : <u>{{$totalRowDues}}</u> --}}





    <br>

    <br>
    <center><a href="#" class="btn btn-danger btn-sm print w-10" onclick="window.print();">Print</a></center>
    <br>

  </div>



</body>
</html>
