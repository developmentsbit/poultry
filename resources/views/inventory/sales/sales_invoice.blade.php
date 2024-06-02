<!DOCTYPE html>
<html>
<head>
	<title>Sales Invoice</title>
	<style type="text/css">
		*{ margin: 0px; padding: 0px; }
		.container{

			width: 75mm;
			background: #fff;

				margin: auto;
				padding:5px;

		}
   @media    print
  {
    .print{
      display: none;
    }
}
	</style>
</head>
<body>
	<div class="container">
		<table width="100%" height="100%" cellpadding="0" cellspacing="0"  style="border: 1px #000 solid;">
			<tr>
					<td valign="top" align="center" colspan="2"> <p style="padding: 10px; font-size: 25px; font-weight: bold; background: #fff;">
						Sale Invoice
					</p>
					<p style="font-weight: bold; background: #fff;font-size:28px;">{{$website_info->company_name_en}}</p>
					<p style="font-weight: bold;">{{$website_info->company_address_en}}</p>
                    <span>{{$website_info->company_mobile}}</span>
					<br>
					</td>

			</tr>
			<tr>
				<td valign="top" style="font-weight: bold; background: #fff; padding: 5px; border-top:1px #000 solid;">Customer Name : {{$data->customer_name_en}}</td>

			</tr>

			<tr>
				<td valign="top" align="left" style="font-weight: bold; background: #fff; padding: 5px; border-top:1px #000 solid;">Phone: {{$data->customer_phone}}</td>
			</tr>

			<tr>
				<td valign="top" align="lefft" style="font-weight: bold; background: #fff; padding: 5px; border-top:1px #000 solid;">Adress: {{$data->customer_address}}</td>
			</tr>

			<tr>
				<td colspan="2" style=" border-bottom:1px #000 solid; "></td>
			</tr>


				<tr>
				<td colspan="2" style=" border-bottom:1px #000 solid;padding:5px; ">Invoice ID : <b>{{ $data->invoice_no }}</b></td>
			</tr>


			<tr>
				<td colspan="2" style=" padding:5px; text-align: center; font-size: 28px; font-weight: bold;  ">

						{!! DNS1D::getBarcodeSVG($data->invoice_no, 'C39',0.9,40,'#414141') !!}

</td>
			</tr>

			<tr>
				<td colspan="2" style="">

				<table cellspacing="0" cellpadding="0" align="center"  style="width: 100%; ">

					<tr>


						 <td style="font-size: 14px; font-weight:bold; border-left:1px #000 solid;border-top:1px #000 solid; border-bottom:1px #000 solid; ">Sl</td>



						  <td style="font-size: 14px; font-weight: bold; border-left:1px #000 solid;border-top:1px #000 solid; border-bottom:1px #000 solid; ">Product</td>

						   <td style="font-size: 14px; font-weight: bold; border-left:1px #000 solid;border-top:1px #000 solid; border-bottom:1px #000 solid; ">Qty.</td>

						   <td style="font-size: 14px; font-weight: bold; border-left:1px #000 solid;border-top:1px #000 solid; border-bottom:1px #000 solid;  ">Price</td>

						   <td style="font-size: 14px; font-weight: bold; border-left:1px #000 solid;border-top:1px #000 solid; border-bottom:1px #000 solid;  ">Total</td>



					</tr>


         @php
         $i=1;
         $total_amount = 0;
         @endphp
         @if(isset($product))
         @foreach($product as $p)

         @php
         $total_amount =($total_amount+($p->product_sales_price*$p->product_quantity))-($p->product_discount_amount*$p->product_quantity);

         $measurement_unit = DB::table('product_measurements')->where('measurement_id',$p->pdt_measurement)->first();

         @endphp

<tr>
    <td style="font-size: 13px; font-weight: bold; border-left:1px #000 dotted;  border-bottom:1px #000 dotted; text-align:center; "> {{ $i++ }}</td>
    <td style="font-size: 13px; font-weight: bold; border-left:1px #000 dotted;  border-bottom:1px #000 dotted; text-align:center;"> {{ $p->pdt_name_en }} {{ $p->pdt_name_bn }}</td>
    <td style="font-size: 13px; font-weight: bold; border-left:1px #000 dotted;  border-bottom:1px #000 dotted; text-align:center;"> {{ $p->product_quantity }} {{$measurement_unit->measurement_unit}}</td>
    <td style="font-size: 13px; font-weight: bold; border-left:1px #000 dotted;  border-bottom:1px #000 dotted;text-align:center; "> {{ $p->product_sales_price }}</td>
    <td style="font-size: 13px; font-weight: bold; border-left:1px #000 dotted;  border-bottom:1px #000 dotted; text-align:center;"> {{ ($p->product_sales_price*$p->product_quantity)-($p->product_discount_amount*$p->product_quantity) }}</td>
</tr>


    @endforeach
        @endif

				</table>


			</td>
			</tr>


			<tr>
				<td colspan="3" style=" font-size: 14px; text-align: left; padding-top: 5px;">


							<table style="float:right;border-left:1px solid black;" cellpadding="0" cellspacing="0" width="150">

							    <tr>
										<td style="border-right: 1px #000 solid; border-bottom: 1px #000 solid;font-weight: bold;text-align: center;">Total Ammount</td>
										<td style="border-left: 1px #000 solid; border-right: 1px #000 solid; border-bottom: 1px #000 solid;font-weight: bold;text-align: center;"> {{ $total_amount }}</td>
								</tr>
							    <tr>
										<td style="border-right: 1px #000 solid; border-bottom: 1px #000 solid;font-weight: bold;text-align: center;">Discount</td>
										<td style="border-left: 1px #000 solid; border-right: 1px #000 solid; border-bottom: 1px #000 solid;font-weight: bold;text-align: center;"> {{ $data->final_discount }}</td>
								</tr>
							    <tr>
										<td style="border-right: 1px #000 solid; border-bottom: 1px #000 solid;font-weight: bold;text-align: center;">Grand Total</td>
										<td style="border-left: 1px #000 solid; border-right: 1px #000 solid; border-bottom: 1px #000 solid;font-weight: bold;text-align: center;"> {{ ($total_amount+$data->vat)-$data->final_discount }}</td>
								</tr>
							    <tr>
										<td style="border-right: 1px #000 solid; border-bottom: 1px #000 solid;font-weight: bold;text-align: center;">Paid</td>
										<td style="border-left: 1px #000 solid; border-right: 1px #000 solid; border-bottom: 1px #000 solid;font-weight: bold;text-align: center;"> {{ $data->paid_amount }}</td>
								</tr>
							    <tr>
										<td style="border-right: 1px #000 solid; border-bottom: 1px #000 solid;font-weight: bold;text-align: center;">Due</td>
										<td style="border-left: 1px #000 solid; border-right: 1px #000 solid; border-bottom: 1px #000 solid;font-weight: bold;text-align: center;"> {{ (($total_amount+$data->vat)-$data->final_discount)-$data->paid_amount }}</td>
								</tr>

							       @php
                                    $total          = DB::table("sales_ledgers")->where("customer_id",$data->customer_id)->sum('total');
                                    $discount       = DB::table("sales_ledgers")->where("customer_id",$data->customer_id)->sum('final_discount');
                                    $grandtotal     = $total-$discount;
                                    $paid           = DB::table("sales_payments")->where("customer_id",$data->customer_id)->sum('payment_amount');
                                    $finaldiscount  = DB::table("sales_payments")->where("customer_id",$data->customer_id)->sum('discount');
                                    $salesreturn    = DB::table("sales_payments")->where("customer_id",$data->customer_id)->sum('return_amount');
                                    $pd             = DB::table("sales_payments")->where("customer_id",$data->customer_id)->where("note","PD")->sum('previous_due');

                                    $totaldue       = ($grandtotal-$paid)-$finaldiscount;
                                    $stotaldue      = ($totaldue+$pd)-$salesreturn;

                                        @endphp


								<tr>
										<td style="border-right: 1px #000 solid; border-bottom: 1px #000 solid;font-weight: bold;text-align: center;">Previous Due</td>
										<td style="border-left: 1px #000 solid; border-right: 1px #000 solid; border-bottom: 1px #000 solid;font-weight: bold;text-align: center;">{{ $pd  }}</td>
								</tr>
							</table>


				</td>
			</tr>




			<!-- <tr>
				<td colspan="2" style=" border-bottom:1px #000 solid; padding:5px;font-size: 14px;"><center><img src="http://anwermubaraki.com/public/qrcode.png" class="img-fluid" style="height: 100px;"></center></td>
			</tr> -->

				<tr>
				<td colspan="2" style=" border-bottom:1px #000 solid; padding:5px;font-size: 14px; font-weight: bold;  ">Print Date:{{ date("d M Y") }}, {{date("h:i:s a")}}</td>
			</tr>

			<tr>
				<td colspan="2" style=" border-bottom:1px #000 solid; padding:5px;font-size: 24px;"><center> Thank You</center></td>
			</tr>

<tr>
				<td colspan="2" style=" text-align: center;"><br><br>

.................................................................
<input type="button" name="print" value="Print" style="width: 100px; height: 35px; background: #ff0000; color: #fff" onclick="window.print()" class="print" tabindex="1"> <br>
				</td>
			</tr>

		</table>
	</div>
<script>
    window.print();
</script>
</body>
</html>
