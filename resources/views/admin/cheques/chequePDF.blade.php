<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Document</title>
    <style>
        .head {
            padding: 10px;
        }
        body {
            font-size: 20px;
        }
        table {
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 7px;
        }
    </style>
</head>
<body>
   <table style="margin-top: 10px">
   <p  style="margin-top: 40px">
       <span style="margin-left: 16%; font-size: 14px">{{ $cheque[0]->referencia }}</span>
   </p>
    <p style="margin-top: -7px">
            <span style="margin-left: 10%;">{{ $letras }}</span>
        </p>
          <p style="margin-top: -8px">
            <span style="margin-left: 19%;">{{ $cheque[0]->receptor }}</span>
        </p>
       <p>
           <span style="margin-left: 15%;">Ciudad Guatemala, {{ date('d/m/Y', strtotime($cheque[0]->fecha)) }}</span><span style="margin-left: 35%;">{{  number_format($cheque[0]->cantidad,2, '.', ',') }}</span>
       </p>
       
   </table>
</body>

</html>