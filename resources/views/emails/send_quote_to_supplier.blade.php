<!DOCTYPE html>
<html>
<head>
    <title>Correo de Cotización</title>
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
        color: #767171;
    }
    </style>

</head>
<body>
    @php
        $vendor = App\Models\Supplier::where('id',$supplier)->first();
        $linea = App\Models\QuoteLine::where('id',$lines[0])->first();
        $RFQ = App\Models\RequestQuote::where('id',$linea->quoteRequest->id)->pluck('RFQ')->first();
    @endphp
    <h1>Cotización YKM, {{$RFQ}}</h1>
    {{-- <p>Este es un ejemplo de correo electrónico.</p> --}}
    <p>Buen día,  {{$vendor->VNDNAM}}, me podría compartir cotización de lo enlistado a continuación, por favor:</p>
    <p>&nbsp;</p>
    <div class="container">
        <table class="table-styled">
            <thead>
                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                        <span class="mr-1">Imagen</span>
                    </th>
                    <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                        <span class="mr-1">Contenido</span>
                    </th>
                    <th  class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                        <span class="mr-1">Descripción</span>
                    </th>
                    <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                        <span class="mr-1">Cantidad</span>
                    </th>
                    <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                        <span class="mr-1">Fecha Requerido</span>
                    </th>
                    <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                        <span class="mr-1">Medida</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                @foreach($lines as $line)
                    @php
                        $item = App\Models\QuoteLine::find($line);
                    @endphp
                    <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <td class="px-4 py-2 text-xs">
                            @if ($item->imgPath)    
                                <span>Adjunto</span>
                            @else
                                <span>NA</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-xs">
                            {{ $item->name }}
                        </td>
                        <td class="px-4 py-2 text-xs">
                            {{ $item->description }}
                        </td>
                        <td class="px-4 py-2 text-xs">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-4 py-2 text-xs">
                            {{ $item->quoteRequest->dateRequiredQuote }}
                        </td>
                        <td class="px-4 py-2 text-xs">
                            {{ $item->measuremetnUnit->description }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <p>
        Favor de agregar a su cotización:
    </p>
    <p>
        Descripción, código, no, de parte:
    </p>
    <p>
        Precio unitario:
    </p>
    <p>
        Monto Total:
    </p>
    <p>
        Moneda:
    </p>
    <p>
        Tiempo / fecha de entrega (indicar días hábiles o naturales):
    </p>
    <p>
        Condiciones de pago:
    </p>
    <p>
        Condiciones de entrega:
    </p>
    <p>
        Otras condiciones:
    </p>
    <p>Atte: {{$user->name}} </p>
    <p>Favor de responder al siguiente correo.</p>
    <p>email:  {{$user->email}} </p>
    <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width=617 style='width:463.0pt;border-collapse:collapse'>
        <tr style='height:70.5pt'>
            <td width=165 valign=top style='width:123.95pt;padding:0cm 5.4pt 0cm 5.4pt; height:70.5pt'>
                <p class="MsoNormal" style="margin-bottom:0cm;line-height:normal">
                    <span style="font-family:'Calibri',sans-serif;color:black">
                        <img width="205" height="106" id="Imagen1" src="{{ asset('img/image001.png') }}" alt="YKM">
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
