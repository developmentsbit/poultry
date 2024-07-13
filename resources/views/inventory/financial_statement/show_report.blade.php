<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Financial Statement Analysis</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css
    ">
    <style>
        /* .page{
            width: 1040px;
            margin: auto;
            /* border : 1px solid rgb(0, 0, 0); */
        } */
        #banner{
            max-width: 100%;
        }
        table{
            width: 100%;
            font-size: 15px;
        }
        table, tr, td, th{
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td{
            padding : 4px;
        }
        #print{
            border-radius: 0px;
            padding: 7px 15px;
            background: red;
            color: white;
            border: none;
        }
        @media print
        {
            #print{
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="page-header">
            <div class="banner">
                <img src="{{ asset('inventory/banner') }}/{{ $website_info->banner }}" id="banner">
            </div>
            <div class="page-title" style="text-align: center;">
                <h3>Financial Statement Report</h3>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-6">
                    <b>Equity Information</b>
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-6">
                    <b>Libalities Information</b>
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="page-footer" style="text-align: center;margin-top:20px;">
            <button id="print" onclick="window.print()">Print</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js
    "></script>
</body>
</html>
