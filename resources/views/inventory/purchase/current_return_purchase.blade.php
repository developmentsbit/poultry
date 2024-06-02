@if($data)
@php
$i = 1;
$total = 0;
@endphp
@foreach ($data as $v)

@php

    $subtotal = (( $v->purchase_price + $v->per_unit_cost ) - $v->discount_amount) * $v->purchase_quantity;

    $total = $total + $subtotal ;

@endphp

<tr>
    <td>{{$i++}}</td>
    <td>{{$v->pdt_id}}-{{$v->pdt_name_en}}</td>
    <td>
        <input type="text" name="return_quantity{{$v->id}}" value="{{$v->purchase_quantity}}" id="return_quantity{{$v->id}}" class="form-control" onchange="return purchaseqtyupdate({{$v->id}})">
    </td>
    <td>{{$v->sub_unit_name}}</td>
    <td>{{$v->purchase_price}}</td>
    <td>{{$v->per_unit_cost}}</td>
    <td>{{$v->discount_amount}}</td>
    <td>{{$subtotal}}</td>
    <td>
        <button class="btn btn-sm btn-danger" id="deletecurrentreturnpurchase{{$v->id}}" onclick="return deleteCurrentReturnpurchase({{$v->id}})">X</button>
    </td>
</tr>

@endforeach
@endif

<input type="hidden" value="{{$total}}" id="total">
