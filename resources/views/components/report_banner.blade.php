<style type="text/css">

#header_image{
    height: 200px;
    width: 100%;
}

    body{
      font-family: 'Lato';
    }

    table {
        width: 100%;
    }

    table, tr, th, td{
        border: 1px solid black;
        border-collapse: collapse;
        padding: 7px;
    }

    tbody {
      border: none !important;
    }



  </style>
@php
$data = DB::table('company_infos')->where('id',1)->first();
@endphp
<center><img src="{{asset('inventory/banner')}}/{{$data->banner}}" id="header_image" class="img-fluid"></center>
