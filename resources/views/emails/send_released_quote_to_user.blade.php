<!DOCTYPE html>
<html>
<head>
    <title>Ejemplo de correo electrónico</title>
    <link rel="stylesheet"
        href="https://unpkg.com/purecss@2.0.6/build/pure-min.css"
        integrity="sha384-Uu6IeWbM+gzNVXJcM9XV3SohHtmWE+3VGi496jvgX1jyvDTXfdK+rfZc8C1Aehk5"
        crossorigin="anonymous"
        origin="anonymous"
    />
    <!-- Used to optimized Website for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <style>
    .container {
        margin-top: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    h1 {
        color: rgb(39, 63, 217);
    }
    .table-styled {
    border-collapse: collapse;
    width: 100%;
    }

    .table-styled th,
    .table-styled td {
        border: 1px solid #000000;
        padding: 8px;
        text-align: left;
    }

    .table-styled th {
        background-color: #000000;
    }
    </style>

</head>
<body>
    <h1>Liberación de Cotización,</h1>
    {{-- <p>Este es un ejemplo de correo electrónico.</p> --}}
    <p>Buen día,</p>
    <p>Por favor revise la cotización, con RFQ: {{$request_quote->RFQ}}</p> 

    
    <a href="http://192.168.130.9:8071/index.php/Home/Menu/index">GESC - INICIO</a>
    
    <p>Atte: {{$user->name}} </p>
    <p>email:  {{$user->email}} </p>
    <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width=617 style='width:463.0pt;border-collapse:collapse'>
        <tr style='height:70.5pt'>
            <td width=165 valign=top style='width:123.95pt;padding:0cm 5.4pt 0cm 5.4pt; height:70.5pt'>
                <p class="MsoNormal" style="margin-bottom:0cm;line-height:normal">
                    <span style="font-family:'Calibri',sans-serif;color:black">
                        <img width="205" height="106" id="Imagen1" src="{{ asset('img/image001.png') }}" alt="Descripción de la imagen">
                    </span>
                </p>
            </td>
            <td width=452 valign=top style='width:339.05pt;padding:0cm 5.4pt 0cm 5.4pt; height:70.5pt'>
            <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>
                <span style='font-size:10.0pt;font-family:"Century Gothic",sans-serif;color:#2E75B6'>
                    Sistema de cotizaciones | Departamento de IT&nbsp;
                </span>
            </p>
            <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>
                <span style='font-size:8.0pt;font-family:"Century Gothic",sans-serif;color:#767171'>
                    Ave.  Hiroshima&nbsp;No. 1000 Int. 5, Complejo Industrial Salamanca, 36875, Salamanca, Guanajuato.&nbsp;
                </span>
                <span style='font-size:8.0pt;font-family: "Century Gothic",sans-serif;color:black'>
                    &nbsp;
                </span>
                <span style='font-family: "Century Gothic",sans-serif;color:black'>
                    &nbsp;
                </span>
            </p>
            </td>
        </tr>
    </table>
</body>
</html>
