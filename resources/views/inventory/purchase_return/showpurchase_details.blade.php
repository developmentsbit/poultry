@if($data)
@foreach ($data as $v)
@php
$pdt_return_qty = App\Models\purchase_entry::where('product_id',$v->product_id)->where('invoice_no',$v->invoice_no)->where('product_quantity','=',NULL)->sum('return_quantity');

$final_qty = $v->product_quantity - $pdt_return_qty;
@endphp
@if($final_qty > 0)
<div class="col-lg-3 col-12" style="background: rgb(14, 168, 48);margin-right:10px;">
    <a href="{{url('purchase_returns')}}/{{$v->invoice_no}}/{{$v->product_id}}" style="padding:5px;color:white;">
        <div class="supplier_info">
            <b>{{$v->supplier_name_en}} </b> <br> {{GetDate::getDate($v->invoice_date,'-') ?? '-'}}
        </div>
        <div class="details">

            {{$v->product_quantity - $pdt_return_qty}} {{$v->measurement_unit}} * {{($v->purchase_price + $v->per_unit_cost) - $v->discount_amount}}
        </div>
    </a>
</div>
@endif
@endforeach
@endif
