<!DOCTYPE html>
<html>
<head>
  <title> {{$data['supplier']->supplier_name_en ?? ''}} Balance Sheet</title>
</head>
<body>

  <div class="invoice" style="width : 1140px;margin:auto">

    @component('components.report_banner')

    @endcomponent

    @php
    $total_due = '';
    @endphp
    <table class="" style="font-size: 13px;">
      <!-- <thead> -->
        <tr style="background: rgb(211, 211, 211);">
            <td colspan="20">
                <center>
                    <b>BALANCE SHEET</b>
                    <span>Of</span><br>
                    <b style="font-size: 15px;">{{$data['supplier']->supplier_name_en}}</b>
                </center>
            </td>
        </tr>
       <tr>
         <th style="width : 3%;">SL</th>
         <th style="width: 11%;">Date</th>
         <th style="wdith : 8%;">Invoice No</th>
         <th style="width: 30%;">Invoice Details</th>
         <th>Total</th>
         <th>Discount</th>
         <th>Paid</th>
         <th>Loan</th>
         <th>Return Amount</th>
         <th style="width: 10%;">Due Amount</th>
       </tr>
       <!-- </thead> -->
       <tbody>
        <tr>
            <td colspan="9" style="text-align: right">
                <b>Previous Due : </b>
            </td>
            <td style="text-align: right">
                {{$data['previous_due']}}
            </td>
        </tr>
        @if($data['supplier_payment'])
        @foreach ($data['supplier_payment'] as $sp)
        @if($sp->comment != 'PD')
        <tr>
            <td>{{$data['sl']++}}</td>
            <td>{{GetDate::getDate($sp->payment_date,'-') ?? '-'}}</td>
            <td>{{$sp->invoice_no ?? '-'}}</td>
            <td style="font-size: 11px;padding:0px;">
                {{-- invoice details --}}
                @if($sp->invoice_no)

                @if($sp->return_amount != NULL)

                <b>Purchase Return</b>

                @php
                $purchase_return = App\Models\purchase_entry::leftjoin('product_informations','product_informations.pdt_id','purchase_entries.product_id')
                ->leftjoin('product_measurements','product_measurements.measurement_id','product_informations.pdt_measurement')
                ->where('purchase_entries.invoice_no',$sp->invoice_no)
                ->where('purchase_entries.return_quantity','!=',NULL)
                ->where('purchase_entries.status',$sp->id)
                ->select('purchase_entries.*','product_informations.pdt_name_en','product_measurements.measurement_unit')
                ->get();
                @endphp

                @foreach ($purchase_return as $pd)
                <table>
                <tr>
                <td style="width: 70%;">
                <b>{{$pd->pdt_name_en}} </b>
                </td>
                <td>
                    {{$pd->return_quantity}} {{$pd->measurement_unit}} * {{($pd->purchase_price + $pd->per_unit_cost) - $pd->discount_amount}}
                </td>
                </tr>
                </table>
                @endforeach

                @else

                @php
                $purchase_details = App\Models\purchase_entry::leftjoin('product_informations','product_informations.pdt_id','purchase_entries.product_id')
                ->leftjoin('product_measurements','product_measurements.measurement_id','product_informations.pdt_measurement')
                ->where('purchase_entries.invoice_no',$sp->invoice_no)
                ->where('purchase_entries.product_quantity','!=',NULL)
                ->select('purchase_entries.*','product_informations.pdt_name_en','product_measurements.measurement_unit')
                ->get();
                @endphp

                @foreach ($purchase_details as $pd)
                <table>
                <tr>
                <td style="width: 70%;">
                <b>{{$pd->pdt_name_en}} </b>
                </td>
                <td>
                    {{$pd->product_quantity}} {{$pd->measurement_unit}} * {{($pd->purchase_price + $pd->per_unit_cost) - $pd->discount_amount}}
                </td>
                </tr>
                </table>
                @endforeach

                @endif

                @elseif($sp->payment > 0 && $sp->invoice_no == NULL)
                Supplier Payment @if($sp->comment) ({{$sp->comment}}) @endif
                @elseif($sp->payment < 0 && $sp->invoice_no == NULL)
                Supplier Loan @if($sp->comment) ({{$sp->comment}}) @endif
                @elseif($sp->payment == NULL && $sp->discount > 0)
                Supplier Pyament Discount
                @else


                @endif


            </td>

            <td style="text-align: right">

                @if($sp->invoice_no && $sp->comment != 'purchase_return')

                @php
                $purchase_ledger = App\Models\purchase_ledger::where('invoice_no',$sp->invoice_no)->first();
                @endphp
                {{$purchase_ledger->total}}

                @else
                -
                @endif

            </td>

            <td>
                @if($sp->invoice_no)
               {{ $purchase_ledger->discount.' ' ?: '-'}}
               @else
               {{ $sp->discount ?: '-'}}
               @endif
            </td>

            <td style="text-align: right">
                @if($sp->invoice_no && $sp->comment != 'purchase_return')
                @php
                $paid = App\Models\supplier_payment::where('invoice_no',$sp->invoice_no)->sum('payment');
                @endphp
                {{$paid}}
                @else
                @if($sp->payment > 0)
                {{$sp->payment.'' ?: '-'}}
                @endif
                @endif
            </td>
            <td style="text-align: right">
                @if($sp->payment < 0)
                {{$sp->payment * -1}}
                @endif
            </td>
            <td style="text-align: right">
                @if($sp->return_amount != NULL)
                {{$sp->return_amount}}
                @else
                -
                @endif
            </td>
            <td style="text-align: right">

            @if($sp->invoice_no && $sp->comment != 'purchase_return')

            {{($purchase_ledger->total - $purchase_ledger->discount) - $paid}}

            @elseif($sp->payment < 0)

            {{$sp->payment * -1}}

            @elseif($sp->invoice_no == NULL && $sp->payment > 0)

            ({{$sp->payment}})

            @elseif ($sp->return_amount != NULL)
            ({{$sp->return_amount}})

            @elseif($sp->discount != NULL)
                {{ $sp->payment + $sp->discount }}
            @else
            -
            @endif

            </td>

        </tr>
        @endif
        @endforeach
        @endif
        <tr>
            <td colspan="9" style="text-align:right">
                <b>Total Due</b>
            </td>
            <td style="text-align: right">
            @php
            $total_purchase = App\Models\purchase_ledger::where('suplier_id',$data['supplier']->supplier_id)->sum('total');
            $total_pd = App\Models\purchase_ledger::where('suplier_id',$data['supplier']->supplier_id)->sum('discount');
            $total_paid_amount = App\Models\supplier_payment::where('supplier_id',$data['supplier']->supplier_id)->sum('payment');
            $total_return_amount = App\Models\supplier_payment::where('supplier_id',$data['supplier']->supplier_id)->sum('return_amount');
            $total_discount = App\Models\supplier_payment::where('supplier_id',$data['supplier']->supplier_id)->sum('discount');
            @endphp


            {{ ( ($total_purchase - $total_pd) - $total_paid_amount - $total_return_amount - $total_discount) + $data['previous_due'] }}
            </td>
        </tr>
       </tbody>
    </table>







    <br>

    <br>
    <center><a href="#" class="btn btn-danger btn-sm print w-10" onclick="window.print();">Print</a></center>
    <br>

  </div>









</body>
</html>
