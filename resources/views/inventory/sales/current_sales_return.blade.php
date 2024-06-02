@php

$total = 0;
@endphp

@if($products)
@foreach ($products as $v)

@php

$subtotal = ($v->product_sales_price - $v->product_discount_amount) * $v->product_quantity;

$total = $total + $subtotal;


$qty = $v->product_quantity;

@endphp
<tr id="tr{{$v->id}}">
    <td>{{$i++}}</td>
    <td>
    {{$v->product_id}} -    {{$v->pdt_name_en}}
    </td>
    <td>
        <input type="text" class="form-control" name="returnquantity{{$v->id}}" value="{{$v->product_quantity}}" id="returnquantity{{$v->id}}" onchange="return qtyUpdate({{$v->id}})">
    </td>
    <td>{{$v->measurement_unit}}</td>
    <td>{{$v->product_sales_price}}</td>
    <td>{{$v->product_discount_amount}}</td>
    @php
        $subtotal = ($v->product_sales_price - $v->product_discount_amount) * $v->product_quantity;
    @endphp
    <td>{{$subtotal}}</td>
    <td>
        <button class="btn btn-sm btn-danger delete" data-id="{{$v->id}}">X</button>
    </td>
</tr>
@endforeach
@endif




<input type="hidden" id="total" value="{{$total}}">


<script>

    $(".delete").click(function(){
        let id = $(this).data('id');

        // alert(id);

        if(confirm("Are You Sure?"))
        {
            $.ajax(
                {
                    headers : {
                        'X-CSRF-TOKEN' : '{{csrf_token()}}'
                    },
                    url: "{{ url('delete_current_sales_return') }}/"+id,
                    type: 'get',
                    success: function()
                    {
                        $('#tr'+id).hide();

                        loadCurrentSalesReturn();
                    },
                    errors:function(){
                        Command:toastr["danger"]("Data Delete Unsuccessfully")


                    }
                });
        }



    });




// End Delete Data

</script>
