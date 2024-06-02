<!DOCTYPE html>
<html>
<head>
  <title>{{$customer->customer_name_en}} Balance Sheet</title>
</head>
<style>
    #header_image{
        width : 100% !important;
        height : 140px !important;
    }
    td{
        padding : 5px !important;
    }
</style>
<body>

  <div class="invoice">

    @component('components.report_banner')

    @endcomponent


    <table class="table table-bordered" style="font-size : 12px;">




      <!-- <thead> -->
        <tr>
            <td colspan="20">
                <center>
                    <b>BALNCE SHEET</b><br>
                    <span>Of</span><br>
                    <b>{{$customer->customer_name_en}}</b><br>
                    <span>{{$customer->customer_phone}}</span><br>
                    <span>{{$customer->customer_address}}</span><br>
                </center>
            </td>
        </tr>
        <tr>
            <th>Date</th>
            <th>Invoice No</th>
            <th>Invoice Details</th>
            <th>Total (Grand Total - Discount)</th>
            <th>Paid</th>
            <th>Loan</th>
            <th>Return Amount</th>
            <th>Due</th>
        </tr>
        <tr>
            <td style="text-align: right;" colspan="7">Previous Due</td>
            <td>{{$previous_due}}</td>
        </tr>
        @if($sales_payment)
        @foreach ($sales_payment as $v)

        <tr>
            <td>{{GetDate::getDate($v->entry_date,'-') ?? '-'}}</td>
            <td>
                @if($v->note != 'purchasewithsales')
                {{$v->invoice_no ?? '-'}}
                @endif
            </td>
            <td style="padding : 0px !important;">
                @if($v->invoice_no)

                    @if($v->return_amount != NULL)
                        <b>Sales Retuns</b>
                        @php
                        $sales_return = App\Models\sales_entry::leftjoin('product_informations','product_informations.pdt_id','sales_entries.product_id')
                        ->leftjoin('product_measurements','product_measurements.measurement_id','product_informations.pdt_measurement')
                        ->where('sales_entries.invoice_no',$v->invoice_no)
                        ->where('sales_entries.return_quantity','!=',NULL)
                        ->where('sales_entries.status',$v->id)
                        ->select('sales_entries.*','product_informations.pdt_name_en','product_measurements.measurement_unit')
                        ->get();
                        @endphp

                        @foreach ($sales_return as $pd)
                        <table>
                        <tr>
                        <td style="width: 70%;">
                        <b>{{$pd->pdt_name_en}} </b>
                        </td>
                        <td>
                            {{$pd->return_quantity}} {{$pd->measurement_unit}} * {{$pd->product_sales_price}}
                        </td>
                        </tr>
                        </table>
                        @endforeach

                    @else

                        @php
                        $sales_entries = App\Models\sales_entry::leftjoin('product_informations','product_informations.pdt_id','sales_entries.product_id')
                        ->leftjoin('product_measurements','product_measurements.measurement_id','product_informations.pdt_measurement')
                        ->select('product_informations.pdt_name_en','product_measurements.measurement_unit','sales_entries.*')
                        ->where('sales_entries.invoice_no',$v->invoice_no)
                        ->get();
                        @endphp

                        <table>
                            @foreach ($sales_entries as $se)
                            @if($se->product_quantity != NULL)
                            <tr>
                                <td style="width: 70%;">{{$se->pdt_name_en}}</td>
                                <td>{{$se->product_quantity}} {{$se->measurement_unit}} X {{$se->product_sales_price - $se->product_discount_amount}} tk</td>
                            </tr>
                            @endif
                            @endforeach
                        </table>

                    @endif

                @elseif($v->note == 'purchasewithsales')
                <b>Purchase With Sales</b>
                @else
                <b>Sales Payment @if($v->discount != NULL) (Discount : {{ $v->discount }}) @endif</b>
                @endif
            </td>
            <td>
                @if($v->invoice_no && $v->return_amount == NULL && $v->note != 'purchasewithsales')
                @php
                $sales_ledger = App\Models\sales_ledger::where('invoice_no',$v->invoice_no)->first();
                $total = $sales_ledger->total - $sales_ledger->final_discount;
                @endphp
                {{$total}} @if($sales_ledger->final_discount > 0)({{$sales_ledger->total}} tk - {{$sales_ledger->final_discount}} tk)@endif
                @else
                -
                @endif
            </td>
            <td>
                @if($v->invoice_no && $v->return_amount == NULL && $v->note != 'purchasewithsales')

                {{$sales_ledger->paid_amount}}

                @else

                @if($v->payment_amount > 0 || $v->note == 'purchasewithsales')
                {{$v->payment_amount + $v->discount}}
                @endif

                @endif
            </td>
            <td>
                @if($v->payment_amount < 0)
                {{$v->payment_amount *-1}}
                @endif
            </td>
            <td>
                @if($v->return_amount != NULL)
                {{$v->return_amount}}
                @else
                -
                @endif
            </td>
            <td>
                @if($v->invoice_no && $v->note != 'purchasewithsales')

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

                @endif
            </td>
        </tr>
        @endforeach
        @endif
        <tr>
            <td colspan="7" style="text-align: right">Total Due</td>
            <td>
                <b>{{$total_due}}/-</b>
            </td>
        </tr>
    </table>







    <br>

    <br>
    <center><a href="#" class="btn btn-danger btn-sm print w-10" onclick="window.print();">Print</a></center>
    <br>

  </div>



</body>
</html>
