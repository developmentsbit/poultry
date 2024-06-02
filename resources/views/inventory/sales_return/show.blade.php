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
        <td colspan="6" style="text-align:center;font-size: 16px;text-transform: uppercase;font-weight: bold;"><b>Sales Return Invoice</b></td>
      </tr>
      <tr>
       <td colspan="3">
        Date : {{GetDate::getDate($data->entry_date,'-') ?? '-'}}<br>
        Invoice No : {{$data->invoice_no}} <br>
        Customer Name : {{$data->customer_name_en}}, {{$data->customer_address}}
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
         <th>Sub Total</th>
       </tr>
       <!-- </thead> -->



       <tbody>

        <tr>
            <td>
                1
            </td>
            <td>
                {{$sales_entry->pdt_name_en}}
            </td>
            <td>
                {{$sales_entry->return_quantity}} {{$sales_entry->measurement_unit}}
            </td>
            <td>
                {{$sales_entry->product_sales_price}}
            </td>
            <td>
                {{$sales_entry->product_sales_price * $sales_entry->return_quantity}}
            </td>
        </tr>

        <tr>
            <td colspan="4" style="text-align: right;">Total</td>
            <td>{{$sales_entry->product_sales_price * $sales_entry->return_quantity}}</td>
        </tr>


      </tbody>


    </table>

    <span class="note p-4">
    <b>Present Balance : </b> <u>{{$subtotal}}</u> <br>
    </span>

    <span class="note p-4">
      <span style="text-transform: capitalize;"><b>In Word:</b>  @php echo ' '.  NumberToWords::transformNumber('en', $sales_entry->product_sales_price * $sales_entry->return_quantity); @endphp tk only</span>
    </span>




    <br>

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
