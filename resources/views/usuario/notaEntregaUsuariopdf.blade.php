<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>NotaEntregaUsuario.pdf</title>
</head>
<!--ESTILO...................................................................................-->
<style>
    html {
        min-height: 100%;
        position: relative;
    }

    body {
        margin: 0;
        margin-bottom: 40px;
    }

    body {
        font-family: sans-serif;
        margin: 10mm 1mm 1mm 1mm;
        top: 5px;
    }

    body tr {
        font-size: 12px;
    }

    body th {
        font-size: 6px;
    }

    @page {
        margin: -5px 15;
        margin-bottom: 5px;
    }

    .page-counter {
        position: fixed;
    }

    .page-counter::after {
        content: counter(page);
    }

    /* #watermark {
        position: fixed;
        font-size: 72px;
        top: 35%;
        width: 100%;
        text-align: center;
        opacity: .1;
        transform: rotate(-45deg);
        transform-origin: 50% 50%;
        z-index: -1000;
    } */

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

<body>
    @include('usuario/header')
    <section>

        <!-- <div id="watermark"> DEPARTAMENTO LOGISTICA (D-4)</div> -->

        <div id="watermark"> {{$marcaAgua}}</div>

        <table width="100%;">

            <tr>
                <td width="100%;" style="font-size: 13px;"> <b style="font-size: 13px;">DESTINATARIO:</b> {{trim($nombre)}}</td>
            </tr>
            <tr>
                <td width="100%;" style="font-size: 13px;"> <b style="font-size: 13px;">DEPENDENCIA:</b> {{trim($unidad)}}</td>
            </tr>
        </table>

        <br><br><br><br><br><br><br>
        <p style="text-align: center; font-size: 15px;">
            <b>--- CONTIENE CLAVE DE ACCESO AL SISTEMA DE ARMAS ---</b>
        </p>
        <br><br><br><br><br><br><br><br>
        <hr>
        <p style="text-align: center;">
            <b>Datos para el ingreso al Sistema de Armas</b>
        </p>

        <p style="text-align: center;">
            <b>Nombre de Usuario:</b> {{strtolower($email)}}
        </p>
        <p style="text-align: center;">
            <b>Clave:</b> {{$legajo}}
        </p>
        <hr>
        <br><br><br><br><br><br><br><br><br><br><br><br>
        <hr>
        <p style="text-align: justify;">
            <b>
                <u>Notificación para el Usuario</u>:</b> <i>El nombre de usuario y clave de acceso al Sistema de
                Armas que se proporciona es de uso exclusivo del titular del presente.
                Queda totalmente prohibido su divulgación a terceros siendo responsable de su custodia.
                La aceptación del usuario y la clave otorgada responsabiliza al citado del acceso y
                confidencialidad de la información a la que accede a través del software aplicativo de
                mención. Sirva la presente nota de notificación de entrega.-</i>
        </p>
        <hr>
        <br><br>
    </section>
    @include('usuario/footer')
</body>

</html>