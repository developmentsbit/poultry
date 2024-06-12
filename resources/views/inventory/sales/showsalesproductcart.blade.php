@php
$i = 1;
$totalsalesamount = 0;
@endphp

@if(isset($data))
@foreach($data as $d)

@php
$purchasesubtotal    = ($d->product_sales_price * $d->product_quantity)-($d->product_discount_amount*$d->product_quantity);
$totalsalesamount = $totalsalesamount + $purchasesubtotal;


$subunit = DB::table('measurement_subunits')->where('measurement_unit_id',$d->pdt_measurement)->get();
$stock = DB::table('stocks')->where('product_id',$d->pdt_id)->where('branch_id',Auth::user()->branch)->first();

$avialable_qty = ($stock->quantity + $stock->purchase_return_qty) - ($stock->sales_qty - $stock->sales_return_qty);
@endphp


<tr id="tr{{ $d->id }}">
    <td>{{ $i++ }}</td>
    <td width="250">{{ $d->pdt_name_en }} {{ $d->pdt_name_bn }}
        &nbsp;&nbsp;
        <a href="" data-toggle="tooltip" data-placement="right" title="P.Price : {{ $d->product_purchase_price }}"><i class="fa fa-eye text-dark"></i></a><br>
        <span class="badge bg-success">Available Qty : {{$avialable_qty}}</span>
        <input type="hidden" name="salesproduct_id" id="salesproduct_id{{$d->id}}" value="{{$d->pdt_id}}">
    </td>


    <td>
        <div class="input-group">
            <input type="text" name="product_quantity" id="product_quantity{{ $d->id }}" class="form-control" value="{{ $d->product_quantity }}" onchange="qtyupdatesales('{{ $d->id }}')" autocomplete="off">
        </div>

    </td>




    <td>
        <div class="input-group">
            <input type="text" name="sale_price_per_unit" id="sale_price_per_unit{{ $d->id }}" class="form-control" value="{{ $d->product_sales_price }}" onchange="salepriceupdatesingle('{{ $d->id }}');salesOriginalMeasurement('{{$d->id}}')">
            <button type="button" class="border text-success" style="cursor: pointer;" onclick="salepriceupdatesingle('{{ $d->id }}')" title="Update Quentity"><i class="fa fa-refresh"></i></button>
        </div>
    </td>




    <td>
        <div class="input-group">
            <input type="text" name="product_discount_amount" id="product_discount_amount{{ $d->id }}" class="form-control"  value="{{ $d->product_discount_amount }}" onchange="salesproductdiscount('{{ $d->id }}')" autocomplete="off">
            <button type="button" class="border text-success" style="cursor: pointer;" onclick="salesproductdiscount('{{ $d->id }}')" title="Update Price"><i class="fa fa-refresh"></i></button>

        </div>
    </td>


    <td>
        <input type="text" name="note" class="form-control" value="{{$d->note}}" onchange="return noteUpdate('{{$d->id}}')" id="note{{$d->id}}">
    </td>






    <td>
        <div class="input-group">
            <input type="text" class="form-control" readonly="" value="{{ ($d->product_sales_price*$d->product_quantity)-($d->product_discount_amount*$d->product_quantity) }}" autocomplete="off">

        </div>
    </td>




    <td>
        <a  class="delete btn btn-danger  border-0 text-light" data-id="{{ $d->id }}"><i class="fa fa-times" aria-hidden="true"></i></a>
    </td>
</tr>


@endforeach
@endif



<tr>
    <input type="hidden" name="totalsalesamount" id="totalsalesamount" value="{{ $totalsalesamount }}">
    <th colspan="5" class="text-right">Total</th>
    <th colspan="2">{{ $totalsalesamount }}/-</th>
</tr>



<script type="text/javascript">
    $(".delete").click(function(){
        let id = $(this).data('id');


        swal({
            title: "Product Remove From Carts?",
            icon: "info",
            buttons: true,
            dangerMode: true,

        })
        .then((willDelete) => {
            if (willDelete) {

                $.ajax(
                {
                    url: "{{ url('deletesalescartproduct') }}/"+id,
                    type: 'get',
                    success: function()
                    {
                        $('#tr'+id).hide();

                        showsalesproductcart();
                    },
                    errors:function(){
                        Command:toastr["danger"]("Data Delete Unsuccessfully")


                    }
                });


            } else {

            }
        });
    });




// End Delete Data
</script>


<script>
    function noteUpdate(id)
    {
        // alert(id);
        let note = $('#note'+id).val();

        $.ajax({
            headers : {
                'X-CSRF-TOKEN' : '{{ csrf_token() }}'
            },

            url : '{{ url('note_update') }}/'+id,

            type : 'POST',

            data : {note},

            success : function(data)
            {

            }
        })
    }
</script>


<script type="text/javascript">
$(function () {
$('[data-toggle="tooltip"]').tooltip()
})
</script>
