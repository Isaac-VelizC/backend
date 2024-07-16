@extends('layouts.app')
@section('content')
<style>
    @media print {
        body * {
            visibility: hidden;
        }

        .contenido-imprimir,
        .contenido-imprimir * {
            visibility: visible;
        }

        .contenido-imprimir {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
    }
</style>
<div class="iq-navbar-header" style="height: 80px;"></div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-sm-12">
            <div class="">
                <div class="card-body contenido-imprimir">
                    <table class="base contenido-imprimir" align="center" cellspacing="0" cellpadding="0" border="0"
                        width="100%">
                        <tbody>
                            <tr>
                                <td align="center" bgcolor="#283663"
                                    style="font-family:Zent, 'Helvetica Neue', Helvetica, Arial, sans-serif;padding-bottom:55px;background-color: transparent;"
                                    valign="top">
                                    <table style="width:560px; margin-top: 50px; border-radius: 5px; overflow: hidden;"
                                        class="main" align="center" cellspacing="0" cellpadding="0" border="0"
                                        width="100%">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="white" valign="top">
                                                    <table align="center" cellspacing="0" cellpadding="0" border="0"
                                                        width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top">
                                                                    <table align="center" cellspacing="0"
                                                                        cellpadding="0" border="0" width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td align="center"
                                                                                    style="padding-top:60px;padding-bottom:50px;border-bottom:1px solid #EBEBEB;"
                                                                                    valign="top">
                                                                                    <span
                                                                                        style="font-family:Zent, 'Helvetica Neue', Helvetica, Arial, sans-serif;font-size:200%;font-weight:bold;">
                                                                                        INSTITUTO TÉCNICO IGLA
                                                                                    </span>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table align="center" cellspacing="0" cellpadding="0" border="0"
                                                        width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="padding-left:30px;padding-right:30px;"
                                                                    valign="top">
                                                                    <table align="center" cellspacing="0"
                                                                        cellpadding="0" border="0" width="100%"
                                                                        bgcolor="#FFFFFF">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="padding:25px 25px 15px 25px;"
                                                                                    valign="top">
                                                                                    <table align="center"
                                                                                        cellspacing="0" cellpadding="0"
                                                                                        border="0" width="100%">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td style="font-size:13px; font-weight:500; font-family:Zent, 'Helvetica Neue', Helvetica, Arial, sans-serif;padding-top:12px;padding-left:15px;"
                                                                                                    valign="top">Fecha
                                                                                                </td>
                                                                                                <td style="font-size:13px; font-weight:500; font-family:Zent, 'Helvetica Neue', Helvetica, Arial, sans-serif;padding-top:12px;padding-left:15px;white-space:nowrap;"
                                                                                                    align="right"
                                                                                                    valign="top">{{
                                                                                                    $pago->fecha }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td style="font-size:13px; font-weight:500; font-family:Zent, 'Helvetica Neue', Helvetica, Arial, sans-serif;padding-top:12px;padding-left:15px;"
                                                                                                    valign="top">Señores
                                                                                                </td>
                                                                                                <td style="font-size:13px; font-weight:500; font-family:Zent, 'Helvetica Neue', Helvetica, Arial, sans-serif;padding-top:12px;padding-left:15px;white-space:nowrap;"
                                                                                                    align="right"
                                                                                                    valign="top">
                                                                                                    {{
                                                                                                    $pago->estudiante->persona->nombre
                                                                                                    }} {{
                                                                                                    $pago->estudiante->persona->ap_paterno
                                                                                                    }} {{
                                                                                                    $pago->estudiante->persona->ap_materno
                                                                                                    }}
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td style="font-size:13px; font-weight:500; font-family:Zent, 'Helvetica Neue', Helvetica, Arial, sans-serif;padding-top:12px;padding-left:15px;"
                                                                                                    valign="top">NIT/CI
                                                                                                </td>
                                                                                                <td style="font-size:13px; font-weight:500; font-family:Zent, 'Helvetica Neue', Helvetica, Arial, sans-serif;padding-top:12px;padding-left:15px;white-space:nowrap;"
                                                                                                    align="right"
                                                                                                    valign="top">
                                                                                                    {{
                                                                                                    $pago->estudiante->persona->ci
                                                                                                    }}
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table align="center" cellspacing="0" cellpadding="0" border="0"
                                                        width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="padding-left:30px;padding-right:30px;"
                                                                    valign="top">
                                                                    <table align="center" cellspacing="0"
                                                                        cellpadding="0" border="0" width="100%"
                                                                        bgcolor="#FFFFFF">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="padding:25px 25px 15px 25px;"
                                                                                    valign="top">
                                                                                    <table align="center"
                                                                                        cellspacing="0" cellpadding="0"
                                                                                        border="0" width="100%">
                                                                                        <tbody>
                                                                                            @foreach ($datos as $item)
                                                                                            <tr>
                                                                                                <td style="font-size:13px; font-weight:500; font-family:Zent, 'Helvetica Neue', Helvetica, Arial, sans-serif;padding-top:12px;white-space:nowrap;"
                                                                                                    align="left"
                                                                                                    valign="top">{{
                                                                                                    $item->codigo }}
                                                                                                </td>
                                                                                                <td style="font-size:13px; font-weight:500; font-family:Zent, 'Helvetica Neue', Helvetica, Arial, sans-serif;padding-top:12px;padding-left:15px;"
                                                                                                    valign="top">
                                                                                                    @if($item->metodoPago)
                                                                                                    {{
                                                                                                    $item->metodoPago->nombre
                                                                                                    }}
                                                                                                    @endif
                                                                                                </td>
                                                                                                @php
                                                                                                $meses = [
                                                                                                '1' => 'Enero',
                                                                                                '2' => 'Febrero',
                                                                                                '3' => 'Marzo',
                                                                                                '4' => 'Abril',
                                                                                                '5' => 'Mayo',
                                                                                                '6' => 'Junio',
                                                                                                '7' => 'Julio',
                                                                                                '8' => 'Agosto',
                                                                                                '9' => 'Septiembre',
                                                                                                '10' => 'Octubre',
                                                                                                '11' => 'Noviembre',
                                                                                                '12' => 'Diciembre',
                                                                                                ];
                                                                                                @endphp

                                                                                                <td style="font-size:13px; font-weight:500; font-family:Zent, 'Helvetica Neue', Helvetica, Arial, sans-serif;padding-top:12px;padding-left:15px;white-space:nowrap;"
                                                                                                    align="right"
                                                                                                    valign="top">
                                                                                                    {{
                                                                                                    $meses[$item->mes]
                                                                                                    ?? '' }}
                                                                                                </td>

                                                                                                <td style="font-size:13px; font-weight:500; font-family:Zent, 'Helvetica Neue', Helvetica, Arial, sans-serif;padding-top:12px;padding-left:15px;white-space:nowrap;"
                                                                                                    align="right"
                                                                                                    valign="top">{{
                                                                                                    $item->monto }}Bs.
                                                                                                </td>
                                                                                            </tr>
                                                                                            @endforeach

                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table align="center" cellspacing="0" cellpadding="0" border="0"
                                                        width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="padding-left:50px;padding-right:50px; padding-top: 30px; padding-bottom: 30px; font-size:100%;"
                                                                    align="center" valign="top">
                                                                    <table align="center" cellspacing="0"
                                                                        cellpadding="0" border="0" width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="font-family:Zent, 'Helvetica Neue', Helvetica, Arial, sans-serif;padding-bottom:10px; font-size: 120%;  font-weight: bold;"
                                                                                    align="left" valign="top">Total
                                                                                </td>
                                                                                <td style="font-family:Zent, 'Helvetica Neue', Helvetica, Arial, sans-serif;padding-bottom:10px; font-size: 120%; font-weight: bold;"
                                                                                    align="right" valign="top">
                                                                                    {{ $pago->monto }}Bs.
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    <a type="button" class="btn btn-sm btn-danger" href="{{ route('admin.lista.pagos') }}">Cancelar</a>
                    <button type="button" class="btn btn-sm btn-primary" onclick="imprimir()">Imprimir</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    function imprimir() {
        var contenido = document.querySelector('.contenido-imprimir').innerHTML;
        var ventana = window.open('', 'PRINT', 'height=600,width=800');
        ventana.document.write('<html><head><title>Imprimir</title>');
        ventana.document.write('</head><body >');
        ventana.document.write(contenido);
        ventana.document.write('</body></html>');
        ventana.document.close();
        ventana.focus();
        ventana.print();
        ventana.close();
        return true;
    }
</script>