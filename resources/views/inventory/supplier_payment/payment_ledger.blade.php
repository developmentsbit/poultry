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
    @php
    date_default_timezone_set('Asia/Dhaka');
    @endphp
    <table>
        <tr>
            <td colspan="3">
                {{-- <span>Payment Date : </span> <b>{{$data->payment_date}}</b><br> --}}
                <span>Supplier Name : </span> <b>{{$data->supplier_name_en}}, {{$data->supplier_phone}}</b><br>
                <span>Print Date & Time : </span> <b>{{date('d/m/Y')}} & {{date('h:i:s')}}</b><br>
            </td>
        </tr>
        <tr>
            <th>Date</th>
            <th>Details</th>
            <th>Paid Amount</th>
        </tr>
        <tr>
            <td style="width : 10%;">{{$data->payment_date}}</td>
            <td>
                {{$data->comment}}
            </td>
            <td style="width : 10%;">{{$data->payment}}</td>
        </tr>
        <tr style="border: none !important;">
            <td colspan="2" style="border: none !important;">Total</td>
            <td style="border: none !important;"><b>{{$data->payment}}</b></td>
        </tr>
        <tr style="border: none !important;">
            <td colspan="2" style="border: none !important;">Total Due</td>
            <td style="border: none !important;"><b>{{$subtotal}}</b></td>
        </tr>
    </table>


    <span class="note p-4">
      <span style="text-transform: capitalize;"><b>In Word:</b> @php echo ' '.  NumberToWords::transformNumber('en', $data->payment); @endphp   tk only</span>
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
