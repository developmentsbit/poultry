<!DOCTYPE html>
<html>
<head>
  <title>Customer Due Report</title>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
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

    <table id="myTable">
        <thead>
            <tr>
                <th>Customer ID</th>
                <th>Customer Name</th>
                <th>Customer Phone</th>
                <th>Adress</th>
                <th id="sortable">Total Due</th>
            </tr>
        </thead>
        @if(isset($customer))
        @foreach ($customer as $c)

        @php
               $total_sales = App\Models\sales_ledger::where('customer_id',$c->customer_id)->sum('total');
                $total_discount = App\Models\sales_ledger::where('customer_id',$c->customer_id)->sum('final_discount');
                $paid_amount = App\Models\sales_ledger::where('customer_id',$c->customer_id)->sum('paid_amount');
                $previous_due = App\Models\sales_payment::where('customer_id',$c->customer_id)->sum('previous_due');
                $return_amount = App\Models\sales_payment::where('customer_id',$c->customer_id)->sum('return_amount');
                $sales_payment = App\Models\sales_payment::where('customer_id',$c->customer_id)->sum('payment_amount');
                $return_paid = App\Models\sales_payment::where('customer_id',$c->customer_id)->sum('returnpaid');
                $sales_payment_discount = App\Models\sales_payment::where('customer_id',$c->customer_id)->sum('discount');
                $grandtotal = $total_sales - $total_discount;
                $total = (($grandtotal - $sales_payment) - $sales_payment_discount)  + $previous_due;
                $subtotal = ($total - $return_amount) - $return_paid;
                $total_amount = $total_amount + $subtotal;
        @endphp
        @if($subtotal > 0)
        <tbody>
        <tr>
            <td>
                {{ $c->customer_id }}
            </td>
            <td>
                {{ $c->customer_name_en }}
            </td>
            <td>
                {{ $c->customer_phone }}
            </td>
            <td>
                {{ $c->customer_address }}
            </td>
            <td>
                {{ $subtotal }} /-
            </td>
        </tr>
        @endif
        @endforeach
        @endif
        <tfoot>

            <tr>
                <th colspan="4" style="text-align: right;">Total</th>
                <th style="">{{ $total_amount }} /-</th>
            </tr>
        </tfoot>
    </table>

    <br>
    <center>
        <button class="print-d-none" onclick="window.print();">Print</button>
    </center>
  </div>



<script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

{{-- <script>
    let table = new DataTable('#myTable',{
        paging: false,
        searching:false,
        // order: [[4, 'desc']],
    });
</script> --}}

<script>
    $( function() {
      $( "#sortable" ).sortable();
} );
</script>

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

<style>

    @media print{
        body {
          -webkit-print-color-adjust: exact;
       }
       .print-d-none{
        display: none;
       }
    }
    </style>


</body>
</html>
