<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<div class="container-fluid mt-3 p-0">
	<center><h5 class="text-uppercase border p-3 bg-success text-light">Product Barcodes</h5></center><br>
	<div class="col-md-12">

		<div class="row ">
            @if($data)
            @foreach ($data as $v)

            @php
            $generatorHTML = new Picqer\Barcode\BarcodeGeneratorHTML();
            $barcode = $generatorHTML->getBarcode($v->barcode, $generatorHTML::TYPE_CODE_128);
            @endphp

            <div class="col-lg-3 col-md-6 col-12 mt-2 p-3 " style="border: 1px solid lightgray;">
                {!! $barcode !!}
                <b>{{$v->pdt_name_en}}</b>
            </div>

            @endforeach
            @endif

		</div>


	</div>
</div>
