@php
$i = 1;
$totalpurchaseamount = 0;
@endphp

@if(isset($data))
@foreach($data as $d)

@php
$purchasesubtotal    = ($d->purchase_price * $d->purchase_quantity + $d->per_unit_cost * $d->purchase_quantity)-($d->discount_amount*$d->purchase_quantity);
$totalpurchaseamount = $totalpurchaseamount + $purchasesubtotal;

$subunit = DB::table('measurement_subunits')->where('measurement_unit_id',$d->pdt_measurement)->get();

@endphp


<tr id="tr{{ $d->id }}">
    <td width="150">
        {{ $d->pdt_name_en }}
        <input type="hidden" name="product_id" id="product_id{{$d->id}}" value="{{$d->pdt_id}}">
    </td>

    <td>
        <div class="input-group">
            <input type="text" name="purchase_quantity" id="purchase_quantity{{ $d->id }}" class="form-control" value="{{ $d->purchase_quantity }}" onchange="qtyupdate('{{ $d->id }}');purcahseoriginalmeasurement({{$d->id}})">

            <button type="button" class="border text-success" style="cursor: pointer;" onclick="qtyupdate('{{ $d->id }}');purcahseoriginalmeasurement({{$d->id}})" title="Update Quentity"><i class="fa fa-refresh"></i></button>
        </div>

    </td>



    <td>
        <div class="input-group">
            <input type="text" name="purchase_price" id="purchase_price{{ $d->id }}" class="form-control"  value="{{ $d->purchase_price }}" onchange="purchasepriceupdate('{{ $d->id }}')">
            <button type="button" class="border text-success" style="cursor: pointer;" onclick="purchasepriceupdate('{{ $d->id }}')" title="Update Price"><i class="fa fa-refresh"></i></button>

        </div>
    </td>

    <td>
        <div class="input-group">
            <input type="text" name="discount_amount" id="discount_amount{{ $d->id }}" class="form-control"  value="{{ $d->discount_amount }}" onchange="purchasepricedicount('{{ $d->id }}')">
            <button type="button" class="border text-success" style="cursor: pointer;" onclick="purchasepricedicount('{{ $d->id }}')" title="Update Price"><i class="fa fa-refresh"></i></button>

        </div>
    </td>



    <td>
        <div class="input-group">
            <input type="text" name="purchasecost" id="purchasecost{{ $d->id }}" class="form-control"  value="{{ $d->per_unit_cost }}" onchange="purchasecostfunction('{{ $d->id }}')">
            <button type="button" class="border text-success" style="cursor: pointer;" onclick="purchasecostfunction('{{ $d->id }}')" title="Update Price"><i class="fa fa-refresh"></i></button>

        </div>
    </td>




    <td>
        <div class="input-group">
            <input type="text" name="sale_price_per_unit" id="sale_price_per_unit{{ $d->id }}" class="form-control" value="{{ $d->sale_price_per_unit }}" onchange="salepriceupdate('{{ $d->id }}')"><button type="button" class="border text-success" style="cursor: pointer;"  onclick="salepriceupdate('{{ $d->id }}')" title="Update Price"><i class="fa fa-refresh"></i></button>
        </div>
    </td>





    <td>
        <div class="input-group">
            <input type="text" class="form-control" readonly="" value="{{ ($d->purchase_price*$d->purchase_quantity + $d->per_unit_cost*$d->purchase_quantity)-($d->discount_amount*$d->purchase_quantity) }}">

        </div>
    </td>




    <td>
        <a  class="delete btn btn-danger  border-0 text-light" data-id="{{ $d->id }}"><i class="fa fa-times" aria-hidden="true"></i></a>
    </td>
</tr>


@endforeach
@endif



<tr>
    <input type="hidden" name="totalpurchaseamount" id="totalpurchaseamount" value="{{ $totalpurchaseamount }}">
    <th colspan="7" class="text-end">Total</th>
    <th colspan="2">{{ $totalpurchaseamount }}/-</th>
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
                    url: "{{ url('deletepurchasecartproduct') }}/"+id,
                    type: 'get',
                    success: function()
                    {
                        $('#tr'+id).hide();

                        Command:toastr["error"]("Product Delete Done")
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "3000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }

                        showpurchaseproductcart();
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
