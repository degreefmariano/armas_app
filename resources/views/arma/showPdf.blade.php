<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Arma.pdf</title>
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

</styl>
<!--ESTILO...................................................................................-->

<!--HEADER...................................................................................-->

<header>
    <table>
        <tr>
            <th style="text-align: left; font-size:11px" width="320px">POLICIA DE LA PROVINCIA DE SANTA FE</th>
            <th style="text-align: right; font-size:11px" width="320px">EMISION: {{$fecha}}</th>
        </tr>
        <tr>
            <th style="text-align: left; font-size:11px" width="320px">UNIDAD: {{$unidad}}</th>
            <th style="text-align: right; font-size:11px" width="320px">DEPENDENCIA: {{$dependencia}}</th>
        </tr>
    </table>
    <table>
        <tr>
            <th style="text-align: center; font-size:11px" width="640px">SISTEMA DE INVENTARIO DE ARMAS</th>
        </tr>
    </table>
    <hr />
</header>
<!--BODY.....................................................................................-->

<body>
    <section>
        <div id="watermark"> {{$marcaAgua}}</div>
        <p>Datos del Arma</p>
        <table>
            <tr>
                <th style="text-align: left; font-size:11px" width="320px"><u>NRO ARMA</u>: {{$arma->nro_arma}}</th>
                <th style="text-align: left; font-size:11px" width="320px"><u>TIPO</u>: {{$arma->nom_tipo_arma}}</th>
            </tr>
            <tr>
                <th style="text-align: left; font-size:11px" width="320px"><u>MARCA</u>: {{$arma->nom_marca_arma}}</th>
                <th style="text-align: left; font-size:11px" width="320px"><u>CALIBRE</u>: {{$arma->nom_cal_principal}}</th>
            </tr>
            <tr>
                <th style="text-align: left; font-size:11px" width="320px"><u>MODELO</u>: {{$arma->modelo}}</th>
                <th style="text-align: left; font-size:11px" width="320px"><u>UN.MED.CAL.</u>: {{$arma->nom_medida_cal_ppal}}</th>
            </tr>
            <tr>
                <th style="text-align: left; font-size:11px" width="320px"><u>CAÑON</u>: {{$arma->largo_canon_principal}}</th>
                <th style="text-align: left; font-size:11px" width="320px"><u>CLASIFICACION</u>: {{$arma->corta_larga}}</th>
            </tr>
            <tr>
                <th style="text-align: left; font-size:11px" width="320px"><u>USO</u>: {{$arma->uso}}</th>
                <th style="text-align: left; font-size:11px" width="320px"><u>SITUACION</u>: {{$arma->nom_situacion}}</th>
            </tr>
            <tr>
                <th style="text-align: left; font-size:11px" width="320px"><u>ESTADO</u>: {{$arma->nom_estado}}</th>
                <th style="text-align: left; font-size:11px" width="320px"><u>FECHA ALTA</u>: {{date('d-m-Y',strtotime($arma->fecha_alta))}}</th>
            </tr>
            <tr>
                <th style="text-align: left; font-size:11px" width="320px"><u>UNIDAD</u>: {{$unidadAr}}</th>
                <th style="text-align: left; font-size:11px" width="320px"><u>FUNCIONARIO</u>: {{$funcionario}}</th>
            </tr>
        </table>

        @if ($cuibs != null && $cuibs->count())
        <br>
        <p style="text-align: center">Cuib</p>
        <table style="border-collapse: collapse; width: 100%">
            <tr>
                <th style="text-align: center; border: 1px solid black; font-size:11px" width="213px">FECHA</th>
                <th style="text-align: center; border: 1px solid black; font-size:11px" width="213px">N° CAJA</th>
                <th style="text-align: center; border: 1px solid black; font-size:11px" width="213px">N° SOBRES</th>
            </tr>
            @foreach($cuibs as $cuib)
            <tr>
                <td style="border: 1px solid black">
                    {{ date("d-m-Y",strtotime($cuib->fecha_cuib)) }}
                </td>

                <td style="border: 1px solid black">
                    {{ $cuib->caja_cuib }}
                </td>

                <td style="border: 1px solid black">
                    {{ $cuib->sobre1_cuib.' - '.$cuib->sobre2_cuib }}
                </td>

            </tr>
            @endforeach
        </table>
        @endif

        @if ($deposito)
        <br>
        <table>
            <tr>
                <th style="text-align: left; font-size:11px" width="320px"><u>SUB SITUACION</u>: {{$deposito['subsituacion']}}</th>
                @if ($deposito['subsituacion'] == 'REPARACION')
                <th style="text-align: left; font-size:11px" width="320px"><u>TRABAJO REALIZADO</u>: {{$deposito['trabajo_realizado']}}</th>
                @endif
            </tr>

        </table>
        @endif

        @if ($sustraccion_extravio)
        <br>
        <table>
            <tr>
                <th style="text-align: left; font-size:11px" width="320px"><u>FECHA DEL HECHO</u>: {{$sustraccion_extravio->fecha_hecho}}</th>
                <th style="text-align: left; font-size:11px" width="320px"><u>LUGAR DEL HECHO</u>: {{$sustraccion_extravio->lugar_hecho}}</th>
            </tr>
            <tr>
                <th style="text-align: left; font-size:11px" width="320px"><u>DEPENDENCIA INTERVINIENTE</u>: {{$sustraccion_extravio->dep_interviniente}}</th>
                <th style="text-align: left; font-size:11px" width="320px"><u>FISCALIA INTERVINIENTE</u>: {{$sustraccion_extravio->fiscalia_interviniente}}</th>
            </tr>
            <tr>
                <th style="text-align: left; font-size:11px" width="320px"><u>VICTIMA/S</u>: {{$sustraccion_extravio->victimas}}</th>
            </tr>
            <tr>
                <th style="text-align: left; font-size:11px" width="320px"><u>IMPUTADO/S</u>: {{$sustraccion_extravio->imputados}}</th>
            </tr>
            <tr>
                <th style="text-align: left; font-size:11px" width="320px"><u>CARATULA</u>: {{$sustraccion_extravio->caratula}}</th>
            </tr>

            <tr>
                <th style="text-align: left; font-size:11px" width="320px"><u>CUIJ</u>: {{$sustraccion_extravio->cuij}}</th>
            </tr>
        </table>
        @endif

        @if ($secuestro)
        <br>
        <table>
            <tr>
                <th style="text-align: left; font-size:11px" width="640px"><u>LUGAR DEPOSITO</u>: {{$secuestro->lugar_deposito}}</th>
            </tr>

        </table>
        @endif

        @if ($historial_situaciones != null && $historial_situaciones->count())
        <br>

        <p style="text-align: center">Historial de Situaciones</p>

        <table style="border-collapse: collapse; width: 100%">

            <tr>
                <th style="text-align: center; border: 1px solid black; font-size:11px" width="113px">FECHA SITUACION</th>
                <th style="text-align: center; border: 1px solid black; font-size:11px" width="113px">SITUACION</th>
                <th style="text-align: center; border: 1px solid black; font-size:11px" width="130px">UD / FUNCIONARIO</th>
                <th style="text-align: center; border: 1px solid black; font-size:11px" width="330px">OBSERVACIONES</th>
            </tr>
            @foreach($historial_situaciones as $historial_situacion)
            <tr>
                {{-- FECHA SITUACION --}}
                <td style="text-align: center; border: 1px solid black">
                    {{ date("d-m-Y",strtotime($historial_situacion->fecha_movimiento)) }}
                </td>
                {{-- SITUACION --}}
                <td style="text-align: center; border: 1px solid black">
                    {{ $historial_situacion->nom_situacion }}
                </td>

                {{-- UD / FUNCIONARIO --}}
                @if ($historial_situacion['nom_situacion'] == 'DEPOSITO')
                <td style="border: 1px solid black">
                    {{ $oficina_suboficina }}
                </td>
                @elseif ($historial_situacion['nom_situacion'] == 'ALTA EN DEPOSITO')
                <td style="border: 1px solid black">
                    {{ $oficina_suboficina }}
                </td>
                @endif

                @if ($historial_situacion['nom_situacion'] == 'SERVICIO')
                <td style="border: 1px solid black">
                    {{ $historial_situacion->ud_funcionario }}
                </td>
                @endif

                @if ($historial_situacion['nom_situacion'] == 'REPARACION')
                <td style="border: 1px solid black">
                    {{ $oficina_suboficina }}
                </td>
                @endif

                @if ($historial_situacion['nom_situacion'] == 'EXTRAVIADA')
                <td style="border: 1px solid black">
                    <!-- {{ $oficina_suboficina }} -->
                </td>
                @endif

                @if ($historial_situacion['nom_situacion'] == 'SECUESTRO JUDICIAL')
                <td style="border: 1px solid black">
                    <!-- {{ $oficina_suboficina }} -->
                </td>
                @endif

                @if ($historial_situacion['nom_situacion'] == 'FUERA DE SERVICIO')
                <td style="border: 1px solid black">
                    {{ $oficina_suboficina }}
                </td>
                @endif

                @if ($historial_situacion['nom_situacion'] == 'BAJA')
                <td style="border: 1px solid black">
                    {{ $oficina_suboficina }}
                </td>
                @endif

                @if ($historial_situacion['nom_situacion'] == 'SUSTRAIDA')
                <td style="border: 1px solid black">
                    <!-- {{ $oficina_suboficina }} -->
                </td>
                @endif

                @if ($historial_situacion['nom_situacion'] == 'DEVOLUCION UD A D4')
                <td style="border: 1px solid black">
                    {{ $oficina_suboficina }}
                </td>
                @endif

                @if ($historial_situacion['nom_situacion'] == 'REINGRESO')
                <td style="border: 1px solid black">
                    {{ $oficina_suboficina }}
                </td>
                @endif

                {{-- OBSERVACIONES --}}
                <td style="border: 1px solid black">
                    {{ $historial_situacion->obs }}
                </td>
            </tr>
            @endforeach

        </table>
        @endif

        @if ($historial_estados != null && $historial_estados->count())
        <br>

        <p style="text-align: center">Historial de Estados</p>

        <table style="border-collapse: collapse; width: 100%">

            <tr>
                <th style="text-align: center; border: 1px solid black; font-size:11px" width="113px">FECHA ESTADO</th>
                <th style="text-align: center; border: 1px solid black; font-size:11px" width="113px">ESTADO</th>
                <th style="text-align: center; border: 1px solid black; font-size:11px" width="130px">UD</th>
                <th style="text-align: center; border: 1px solid black; font-size:11px" width="330px">OBSERVACIONES</th>
            </tr>
            @foreach($historial_estados as $historial_estado)
            <tr>
                {{-- FECHA ESTADO --}}
                <td style="text-align: center; border: 1px solid black">
                    {{ date("d-m-Y",strtotime($historial_estado->fecha_movimiento)) }}
                </td>
                {{-- ESTADO --}}
                <td style="text-align: center; border: 1px solid black">
                    {{ $historial_estado->nom_estado }}
                </td>

                {{-- UD --}}
                <td style="border: 1px solid black">
                    {{ $oficina_suboficina }}
                </td>

                {{-- OBSERVACIONES --}}
                <td style="border: 1px solid black">
                    {{ $historial_estado->obs }}
                </td>
            </tr>
            @endforeach
        </table>
        @endif

    </section>
</body>

</html>