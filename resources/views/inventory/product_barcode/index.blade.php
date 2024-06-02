@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('product.barcode')</h3><br>


                <form method="post" action="{{route('product_barcode.store')}}">
                    @csrf

                <table id="datatable-roles-all" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th> <input type="checkbox" id="selectall" onclick="return checkAll();"> <label for="selectall">All</label></th>
                            <th>Sl</th>
                            <th>Product Barcode</th>
                            <th>Product ID</th>
                            <th>Product Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @if($product)
                        @foreach ($product as $v)
                        <tr>
                        <td>
                            <input id="checkinput" type="checkbox" name="product_id[]" value="{{$v->pdt_id}}">

                        </td>
                        <td>{{$i++}}</td>
                        <td>{{$v->barcode}}</td>
                        <td>
                            {{$v->pdt_id}}
                        </td>
                        <td>
                            {{$v->pdt_name_en}}
                        </td>
                    </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                <input type="submit" class="btn btn-success" value="Generate Barcode">
            </form>



			</div> <!-- end card body-->
		</div> <!-- end card -->
	</div><!-- end col-->
</div>


<script>
    function checkAll()
        {
            if($('#selectall').is(':checked'))
            {
                $('input#checkinput').prop('checked',true);
            }
            else
            {
                $('input#checkinput').prop('checked',false);
            }
        }
</script>






@endsection
