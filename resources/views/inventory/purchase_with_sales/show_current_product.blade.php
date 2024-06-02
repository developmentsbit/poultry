@php
$i = 1;
$totalsalesamount = 0;

$totalpurchaseamount = 0;
@endphp

@if(isset($data))
@foreach($data as $d)

@php
$purchasesubtotal    = ($d->product_sales_price * $d->product_quantity)-($d->product_discount_amount*$d->product_quantity);

$totalsalesamount = $totalsalesamount + $purchasesubtotal;

$totalsubtotalpurchase = $d->product_purchase_price * $d->product_quantity;

$totalpurchaseamount = $totalpurchaseamount + $totalsubtotalpurchase;


$subunit = DB::table('measurement_subunits')->where('measurement_unit_id',$d->pdt_measurement)->get();
// $stock = DB::table('stocks')->where('product_id',$d->pdt_id)->first();

// $avialable_qty = $stock->quantity - $stock->sales_qty;
@endphp


<tr id="tr{{ $d->id }}">
    <td>{{ $i++ }}</td>
    <td width="250">{{ $d->pdt_name_en }} {{ $d->pdt_name_bn }}
        &nbsp;&nbsp;
        <a href="" data-toggle="tooltip" data-placement="right" title="P.Price : {{ $d->product_purchase_price }}"><i class="fa fa-eye text-dark"></i></a><br>
        <input type="hidden" name="salesproduct_id" id="salesproduct_id{{$d->id}}" value="{{$d->pdt_id}}">
    </td>


    <td>
        <div class="input-group">
            <input type="text" name="product_quantity" id="product_quantity{{ $d->id }}" class="form-control" value="{{ $d->product_quantity }}" onchange="purchasesalesqtyupdate('{{ $d->id }}');purchasesalesoriginalmeasurement({{$d->id}})" autocomplete="off">
        </div>

    </td>


    <td>
        <select class="form-control" name="sale_sub_measurement" id="sale_sub_measurement{{$d->id}}" onchange="purchasesalessubunitupdate({{$d->id}});purchasesalesoriginalmeasurement({{$d->id}})">
            <option>Select One</option>
            @if($subunit)
            @foreach ($subunit as $v)
            <option @if($d->sub_unit_id == $v->id) selected @endif value="{{$v->id}}">{{$v->sub_unit_name}}</option>
            @endforeach
            @endif
        </select>
    </td>




    <td>
        <div class="input-group">
            <input type="text" name="purchase_price_per_unit" id="purchase_price_per_unit{{ $d->id }}" class="form-control" value="{{ $d->product_purchase_price }}" onchange="purchasesalespurchasepriceupdate('{{ $d->id }}');purchasesalesoriginalmeasurement('{{$d->id}}')">

        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="text" name="sale_price_per_unit" id="sale_price_per_unit{{ $d->id }}" class="form-control" value="{{ $d->product_sales_price }}" onchange="purchasesalespriceupdate('{{ $d->id }}');purchasesalesoriginalmeasurement('{{$d->id}}')">

        </div>
    </td>




    <td>
        <div class="input-group">
            <input type="text" name="product_discount_amount" id="product_discount_amount{{ $d->id }}" class="form-control"  value="{{ $d->product_discount_amount }}" onchange="purchasesalespricediscount('{{ $d->id }}')" autocomplete="off">


        </div>
    </td>


    <td>
        <input type="text" name="note" class="form-control" value="{{$d->note}}" onchange="return purchasesalesnoteupdate('{{$d->id}}')" id="note{{$d->id}}">
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
    <input type="hidden" name="totalpurchase" id="totalpurchase" value="{{ $totalpurchaseamount }}">
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
                    url: "{{ url('deletepurchase_sales_product') }}/"+id,
                    type: 'get',
                    success: function()
                    {
                        $('#tr'+id).hide();

                        showcurrentpurchasesales_product();
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
    function purchasesalesnoteupdate(id)
    {
        // alert(id);
        let note = $('#note'+id).val();

        $.ajax({
            headers : {
                'X-CSRF-TOKEN' : '{{ csrf_token() }}'
            },

            url : '{{ url('purchasesalesnoteupdate') }}/'+id,

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
