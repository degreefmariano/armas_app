<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ACTA ENTREGA.pdf</title>
</head>
<!--ESTILO...................................................................................-->
<style>
    html {
        min-height: 100%;
        position: relative;
    }

    header {
        position: fixed;
        left: 0px;
        top: 20px;
        right: 0px;
        height: 40px;
        background-color: white;
        text-align: center;
    }

    body {
        margin: 0;
        margin-bottom: 40px;
    }

    body {
        font-family: sans-serif;
        margin: 22mm 1mm 25mm 1mm;
        top: 310px;
    }

    body tr {
        font-size: 12px;
    }

    body th {
        font-size: 6px;
    }

    @page {
        margin: -5px 50;
        margin-bottom: 0px;
    }

    footer {
        position: fixed;
        left: 0px;
        bottom: -40px;
        right: 0px;
        height: 40px;
        border-bottom: 2px solid #ddd;

    }

    footer .page:after {
        content: counter(page);
    }

    footer table {
        width: 100%;
    }

    footer p {
        text-align: center;
    }

    footer .izq {
        text-align: center;
    }

    #watermark {
        position: fixed;
        font-size: 40px;
        top: 45%;
        width: 100%;
        text-align: center;
        opacity: .3;
        transform: rotate(-25deg);
        transform-origin: 50% 50%;
        z-index: -1000;
    }
</style>

<!--ESTILO...................................................................................-->

<!--HEADER...................................................................................-->

<header>
    <table>
        <tr>
            <th style="text-align: left; font-size:11px" width="320px">POLICIA DE LA PROVINCIA DE SANTA FE</th>
        </tr>
        <tr>
            <th style="text-align: left; font-size:11px" width="320px">SISTEMA DE INVENTARIO DE ARMAS</th>
        </tr>
        <tr>
            <th style="text-align: left; font-size:11px" width="320px">NRO. DE ACTA: {{ $entrega->nro_nota }}</th>
        </tr>
    </table>

    <hr />
</header>
<!--BODY.....................................................................................-->

<body>
    <section>
        <div id="watermark"> {{$marcaAgua}}</div>
        <p style="text-align: center"><b><u>ACTA DE ENTREGA PERSONALIZADA</u></b></p>

        <p style="text-align: justify">En la Ciudad de <b>{{$entrega->localidadEntrega->nom_localidad}}</b>, Departamento
            <b>{{$entrega->localidadEntrega->departamento->nom_departamento}}</b>, Provincia de Santa Fe, a los {{$dia}} días
            del mes de {{$nombre_mes_actual}} del año {{$anio}}, quién suscribe <b>NI: {{$entrega->usuario->legajo}} -
                {{$entrega->usuario->personal->nombre_ps}}</b>, logístico de el/la <b>{{$entrega->udEntrega->nom_ud}}</b>, procede a labrar
            la presente a fin de dejar debidamente documentado que comparece ante esta <b>NI: {{$entrega->personal->nlegajo_ps}}
                - {{$entrega->personal->nombre_ps}}</b>, quién presta servicios en <b>{{$entrega->subUdRecibe->nom_subud}}</b>,
            de el/la <b>{{$entrega->udRecibe->nom_ud}}</b>, al cual en este acto se le hace entrega del arma que se detalla a continuación.
        </p>
        <br>
        <table style="border-collapse: collapse; width: 100%">

            <tr>
                <th style="text-align: center; border: 1px solid black; font-size:11px" width="85px">NRO ARMA</th>
                <th style="text-align: center; border: 1px solid black; font-size:11px" width="95px">TIPO</th>
                <th style="text-align: center; border: 1px solid black; font-size:11px" width="70px">MARCA</th>
                <th style="text-align: center; border: 1px solid black; font-size:11px" width="70px">MODELO</th>
                <th style="text-align: center; border: 1px solid black; font-size:11px" width="70px">CALIBRE</th>
                <th style="text-align: center; border: 1px solid black; font-size:11px" width="80px">ESTADO</th>
                <th style="text-align: center; border: 1px solid black; font-size:11px" width="70px">CARGADORES</th>
                <th style="text-align: center; border: 1px solid black; font-size:11px" width="70px">MUNICIONES</th>
            </tr>

            <tr>
                <td style="text-align: center; border: 1px solid black">
                    {{ $arma->nro_arma }}
                </td>
                <td style="text-align: center; border: 1px solid black">
                    {{ $arma->tipo->descripcion }}
                </td>
                <td style="text-align: center; border: 1px solid black">
                    {{ $arma->marca->descripcion }}
                </td>
                <td style="text-align: center; border: 1px solid black">
                    {{ $arma->modelo }}
                </td>
                <td style="text-align: center; border: 1px solid black">
                    {{ $arma->calibre->descripcion }}
                </td>
                <td style="text-align: center; border: 1px solid black">
                    {{ $arma->estadoArma->nom_estado }}
                </td>
                <td style="text-align: center; border: 1px solid black">
                    {{ $personalArma->cantidad_cargador }}
                </td>
                <td style="text-align: center; border: 1px solid black">
                    {{ $personalArma->cantidad_municion }}
                </td>
            </tr>

        </table>

        <p style="text-align: justify">Motivo de la entrega: {{$personalArma->obs}}</p>

        <p style="text-align: justify">Con lo que no siendo para mas, se da por finalizado el presente acto del que previa lectura de
            todo su contenido, recibe de total conformidad, firmando al pie y para debida constancia.-</p>

        <br>
        <br>
        <p>Firma: __________________________</p>
        <p>Aclaración: ______________________</p>
        <p>N.I: ____________________________</p>
        <p>Dependencia: ____________________</p>
        <p>Fecha: {{$dia}}/{{$mes}}/{{$anio}}</p>

    </section>
</body>

</html>