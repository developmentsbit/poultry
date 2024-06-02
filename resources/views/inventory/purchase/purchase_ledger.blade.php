<!DOCTYPE html>
<html>
<head>
  <title>Invoice</title>
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
        <td colspan="6" style="text-align:center;font-size: 16px;text-transform: uppercase;font-weight: bold;"><b>Purchase Invoice</b></td>
      </tr>
      <tr>
       <td colspan="3">
        Date : {{$purchase_ledger->invoice_date}}<br>
        Invoice No : {{$purchase_ledger->invoice_no}} <br>
        Voucher No :  <br>

        @if($purchase_ledger->ledger_type == 'pws')
        @php
        $customer = DB::table('customer_infos')->where('customer_id',$purchase_ledger->suplier_id)->first();
        @endphp
        3rd Party Customer : {{$customer->customer_name_en}} ({{$customer->customer_phone}})<br>

        @else
        Supplier Info : {{$supplier->supplier_name_en}} ({{$supplier->supplier_phone}})<br>
        Supplier Company : {{$supplier->supplier_company_name}} ({{$supplier->supplier_company_phone}})
        @endif

      </td>
      <td colspan="3">
        Transaction : {{$purchase_ledger->transaction_type}}<br>
        Prepared By : {{Auth::user()->name}}<br>
        Print  : @php echo date('d M Y'); @endphp<br>
      </tr>



      <!-- <thead> -->
       <tr>
         <th>SL</th>
         <th>Product</th>
         <th>Quantity</th>
         <th>Price With Cost</th>
         <th>Discount (Per Unit)</th>
         <th>Sub Total</th>
       </tr>
       <!-- </thead> -->



       <tbody>



        @php
        $i = 1;
        @endphp
        @if($purchase_entry)
        @foreach ($purchase_entry as $v)
        @if($v->product_quantity != NULL)
        <tr>
          <td>{{$i++}}</td>
          <td>
                {{$v->pdt_name_en}}<br>
                {{$v->pdt_name_bn}}
          </td>
          <td>{{$v->product_quantity}} {{$v->sub_unit_name}}</td>
          @php
          $pricewithcost = $v->purchase_price + $v->per_unit_cost
          @endphp
          <td>{{$pricewithcost}} tk</td>
          <td>{{$v->discount_amount}} tk</td>
          @php
          $subtotal = ($pricewithcost - $v->discount_amount) * $v->product_quantity;
          $total_amount = ($total_amount+($pricewithcost - $v->discount_amount) * $v->product_quantity);
          @endphp
          <td>{{$subtotal}} tk</td>
        </tr>
        @endif
        @endforeach
        @endif



      </tbody>

    @php



    $totalpurchaseprice = DB::table('purchase_entries')->where('invoice_no',$purchase_ledger->invoice_no)->sum('purchase_price');

    $total_cost = DB::table('purchase_entries')->where('invoice_no',$purchase_ledger->invoice_no)->sum('per_unit_cost');

    $total_discount = DB::table('purchase_entries')->where('invoice_no',$purchase_ledger->invoice_no)->sum('discount_amount');


    $grandtotal = $total_amount - $purchase_ledger->discount;

    $supplier_payment = DB::table('supplier_payments')->where('invoice_no',$purchase_ledger->invoice_no)->sum('payment');

    $due = $grandtotal - $supplier_payment;


    @endphp


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
          {{$purchase_ledger->discount}} tk<br>
          {{$grandtotal}} tk<br>
          {{$supplier_payment}} tk<br>
          {{$due}} tk<br>

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
