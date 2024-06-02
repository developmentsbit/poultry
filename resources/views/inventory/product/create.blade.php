@extends('layouts.master')
@section('content')





<div class="container mt-2">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<h3>@lang('product.add_title')</h3><br>

				<form method="post" class="btn-submit" action="{{ route('product.store') }}">
					@csrf

					<div class="row myinput">






							<div class="form-group mb-2 col-md-6 d-none">
								<label>@lang('product.barcode'): <span class="text-danger" style="font-size: 15px;">*</span></label>
								<div class="input-group">
									<input class="form-control" type="text" name="barcode" id="barcode" value="{{ rand(1111,9999) }}">
								</div>
							</div>



							<div class="form-group mb-2 col-md-4">
								<label>@lang('product.item_name'):<span class="text-danger" style="font-size: 15px;">*</span></label>
								<div class="input-group">
									<select class="form-control select2_demo_1" name="pdt_item_id" id=
									"pdt_item_id" required="" onchange="getcat()">
									<option value="">@lang('product.select_item')</option>
									@foreach($item as $i)
									<option value="{{ $i->item_id  }}">{{ $i->item_name_en }} ( {{ $i->item_name_bn }} )</option>
									@endforeach
								</select>
							    </div>
                            </div>




						<div class="form-group mb-2 col-md-4">
							<label>@lang('product.category_name'):</label>
							<div class="input-group">

								<select class="form-control" name="pdt_cat_id" id="pdt_cat_id">
									<option value="">@lang('product.select_category')</option>

								</select>

							</div>

						</div>





						<div class="form-group mb-2 col-md-4">
							<label>@lang('product.brand_name'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">

								<select class="form-control" name="pdt_brand_id" required="">
									<option value="">@lang('product.select_brand')</option>
									@foreach($brand as $c)
									<option value="{{ $c->brand_id  }}">{{ $c->brand_name_en }} ( {{ $c->brand_name_bn }} )</option>
									@endforeach
								</select>
								{{-- 		<div class="input-group-addon border border-left-0" data-toggle="modal" data-target="#exampleModalCenters2"><i class="fa fa-plus-circle text-primary"></i></div> --}}
							</div>
						</div>



						<div class="form-group mb-2 col-md-6">
							<label>@lang('product.name_english'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">
								<input class="form-control" type="text" name="pdt_name_en" id="pdt_name_en"required="">
							</div>
						</div>

						<div class="form-group mb-2 col-md-6">
							<label>@lang('product.name_bn'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group">
								<input class="form-control" type="text" name="pdt_name_bn" id="pdt_name_bn"required="">
							</div>
						</div>


						<div class="form-group mb-2 col-md-6">
							<label>@lang('product.measurement_name'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<select class="form-control" name="pdt_measurement" required="">
								<option value="">@lang('product.select_measurement')</option>
								@foreach($measurement as $c)
								<option value="{{ $c->measurement_id  }}">{{ $c->measurement_unit }}</option>
								@endforeach
							</select>
						</div>

                        <div class="form-group mb-2 col-md-6">
                            <label>@lang('product.status'):</label>
                            <div class="input-group">
                                <select class="form-control" name="pdt_status" id="pdt_status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>



					</div>



						<div class="row">




							<div class="form-group mb-2 col-md-6">
								<label>@lang('product.purchase_price'):</label>
								<div class="input-group">
									<input class="form-control" type="text" name="pdt_purchase_price" id="pdt_purchase_price" value="0">
								</div>
							</div>

							<div class="form-group mb-2 col-md-6">
								<label>@lang('product.sale_price'):</label>
								<div class="input-group">
									<input class="form-control" type="text" name="pdt_sale_price" id="pdt_sale_price" value="0">
								</div>
							</div>




						</div>


					<div class="modal-footer border-0 col-12">
						<button type="submit" class="btn btn-success button border-0">@lang('product.add_button')</button>
					</div>
				</form>



			</div> <!-- end card body-->
		</div> <!-- end card -->
	</div><!-- end col-->
</div>


<script type="text/javascript">

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});


	function getcat(){
		let item_id = $("#pdt_item_id").val();
		$.ajax({
			url: "{{ url('getcatajax') }}/"+item_id,
			type: 'get',
			data:{},
			success: function (data)
			{
				$("#pdt_cat_id").html(data);
			},
			error:function(errors){
				alert("Select Item")
			}
		});

	}


</script>






@endsection
