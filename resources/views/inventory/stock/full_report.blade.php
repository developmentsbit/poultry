<!DOCTYPE html>
<html>
<head>
  <title>Full Stock Report</title>
</head>
<body>

  <div class="invoice">

    @component('components.report_banner')

    @endcomponent

    <table>
        <thead>
            <tr>
                <th>SL</th>
                <th>Product Name</th>
                <th>Purchase Quantity</th>
                <th>Purchase Return Quantity</th>
                <th>Sales Quantity</th>
                <th>Sales Return Quantity</th>
                <th>Available Quantity</th>
            </tr>
        </thead>
        <tbody>
            @php
            $i = 1;
            @endphp
            @if($data)
            @foreach ($data as $v)
            <tr>
                <td>{{$i++}}</td>
                <td>{{$v->product_id}} - {{$v->pdt_name_en}}</td>
                <td>{{$v->quantity}} {{$v->measurement_unit}}</td>
                <td>
                    @if($v->purchase_return_qty > 0)
                    {{$v->purchase_return_qty}} {{$v->measurement_unit}}
                    @else
                    -
                    @endif
                </td>
                <td>
                    @if($v->sales_qty > 0)
                    {{$v->sales_qty}} {{$v->measurement_unit}}
                    @else
                    -
                    @endif
                </td>
                <td>
                    @if($v->sales_return_qty > 0)
                    {{$v->sales_return_qty}} {{$v->measurement_unit}}
                    @else
                    -
                    @endif
                </td>
                @php
                $available_qty = ( $v->quantity - $v->purchase_return_qty) - ($v->sales_qty - $v->sales_return_qty)
                @endphp
                <td>{{$available_qty}} {{$v->measurement_unit}}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>


    <br>

    <br>
    <center><a href="#" class="btn btn-danger btn-sm print w-10" onclick="window.print();">Print</a></center>
    <br>

  </div>









</body>
</html>
