<!DOCTYPE html>
<html>
<head>
  <title>Sales Invoice</title>
    @component('components.report_header')

    @endcomponent
</head>
<body>


@php
use NumberToWords\NumberToWords;
    $total_amount = 0;
@endphp

  <div class="invoice">

    @component('components.report_banner')

    @endcomponent


    <table class="table table-bordered">
      <tr>
        <td colspan="6" style="text-align:center;font-size: 16px;text-transform: uppercase;font-weight: bold;"><b>Sales Invoice</b></td>
      </tr>
      <tr>
       <td colspan="3">
        Date : {{$data->invoice_date}}<br>
        Invoice No : {{$data->invoice_no}} <br>
        Voucher No :  <br>
        Customer Name : {{$data->customer_name_en}}<br>
        Customer Adress : {{$data->customer_phone}}

      </td>
      <td colspan="3">
        Transaction : {{$data->transaction_type}}<br>
        Prepared By : {{Auth::user()->name}}<br>
        Print  : @php echo date('d M Y'); @endphp<br>
      </tr>



      <!-- <thead> -->
       <tr>
         <th>SL</th>
         <th>Product</th>
         <th>Quantity</th>
         <th>Price</th>
         <th>Discount</th>
         <th>Sub Total</th>
       </tr>
       <!-- </thead> -->



       <tbody>



        @php
        $i = 1;
        $total = 0;
        @endphp
        @if($product)
        @foreach ($product as $p)
        @if($p->product_quantity != NULL)
        @php
        $total_amount =($total_amount+($p->product_sales_price*$p->product_quantity))-($p->product_discount_amount*$p->product_quantity);

        $measurement_unit = DB::table('product_measurements')->where('measurement_id',$p->pdt_measurement)->first();

        @endphp
        <tr>
          <td>{{$i++}}</td>
          <td>
            {{ $p->pdt_name_en }} <br>{{ $p->pdt_name_bn }}
          </td>
          <td>{{ $p->product_quantity }} {{$measurement_unit->measurement_unit}}</td>
          <td>{{ $p->product_sales_price }}</td>
          <td>{{$p->product_discount_amount}} tk</td>
          <td>{{ ($p->product_sales_price*$p->product_quantity)-($p->product_discount_amount*$p->product_quantity) }} tk</td>
        </tr>
        @endif
        @endforeach
        @endif



    </tbody>

      <tr>

        <td colspan="5" style="text-align: right;">
          Total Amount :<br>
          Discount :<br>
          Grand Total :<br>
          Paid :<br>
          Due :
        </td>




        <td>
          {{$total_amount}} tk <br>
          {{ $data->final_discount }} tk<br>
          {{ ($total_amount+$data->vat)-$data->final_discount }} tk<br>
          {{ $data->paid_amount }} tk<br>
          {{ (($total_amount+$data->vat)-$data->final_discount)-$data->paid_amount }} tk<br>

        </td>


      </tr>


    </table>

    <span class="note p-4">
        <span style="text-transform: capitalize;"><b>In Word:</b>  @php echo ' '.  NumberToWords::transformNumber('en', $total_amount); @endphp tk only</span>
    </span>




    <br>

    @component('components.report_footer')

    @endcomponent

    <br>
    <center><a href="#" class="btn btn-danger btn-sm print w-10" onclick="window.print();">Print</a></center>
    <br>

  </div>






  <style type="text/css">

    body{
      font-family: 'Lato';
    }

    .invoice{
      background: #fff;
      padding: 30px;

    }

    .invoice span{
      font-size: 15px;
    }

    thead{
      font-size: 15px;
    }

    tbody{
      font-size: 13px;
    }

    .table-bordered td, .table-bordered th{
      border: 1px solid #585858 !important;
      box-shadow: none;
      border-bottom: 1px solid #585858;
    }

    .table-bordered tr{
      border: 1px solid #585858 !important;
    }


    tbody {
      border: none !important;
    }


    @media    print
    {

      .table-bordered tr{
        border: 1px solid #585858 !important;
      }

      @page    {
        /*size: 7in 15.00in;*/
        margin: 1mm 1mm 1mm 1mm;
        padding: 10px;
      }

      .print{
        display: none;
      }

      .invoice span{
        font-size: 22px;
      }
      /*@page    { size: 10cm 20cm landscape; }*/

    }


  </style>


</body>
</html>
