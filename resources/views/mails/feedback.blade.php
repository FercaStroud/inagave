<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title></title>
    <!--[if (mso 16)]>
    <style type="text/css">
    a {
        text-decoration: none;
    }
    </style>
    <![endif]-->
    <!--[if gte mso 9]>
    <style>sup {
        font-size: 100% !important;
    }</style><![endif]-->
    <!--[if gte mso 9]>
    <xml>
    <o:OfficeDocumentSettings>
        <o:AllowPNG></o:AllowPNG>
        <o:PixelsPerInch>96</o:PixelsPerInch>
    </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
</head>

<body>
<div class="es-wrapper-color">
    <!--[if gte mso 9]>
    <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
    <v:fill type="tile" color="#fafafa"></v:fill>
    </v:background>
    <![endif]-->

    <table cellpadding="0" cellspacing="0" width="100%">
        <tbody>
        <tr>
            <td align="center" class="esd-block-image es-p10b"
                style="font-size: 0px;">
                <a target="_blank"><img
                        src="https://inagave.com/wp-content/uploads/2021/09/INAGAVE-VECTORE.png"
                        alt="Logo"
                        style="display: block; font-size: 12px;"
                        width="200" title="Logo">
                </a>
            </td>
        </tr>
        </tbody>
    </table>
    <table cellpadding="0" cellspacing="0" width="100%">
        <tbody>
        <tr>
            <td align="center" class="esd-block-text es-m-txt-c">
                <h2>Compra #{{ $payment['id'] }} completada con éxito.</h2>
            </td>
        </tr>
        <tr>
            <td align="center" class="esd-block-text es-p20b">
                <p>
                    Hola, <i>{{ $user['name'] }} {{ $user['lastname'] }} {{ $user['second_lastname'] }}</i>.
                </p>
                <p>
                    Se procesó una órden de compra a su nombre con los
                    siguientes datos: <br/>
                </p>
                <p>
                    <strong>Predio: </strong>
                    {{ $payment['estate'] }}
                </p>
                <p>
                    <strong># de Ítems: </strong>
                    {{ $payment['quantity'] }}
                </p>
                <p>
                    <strong>Precio unitario: </strong>
                    {{ $payment['price'] }}
                </p>
                <p>
                    <strong>Total: </strong> {{ $payment['total'] }}
                </p>
                <p>
                <p>
                    A continuación se listan datos importantes de compra
                    para cualquier duda y aclaración.
                </p>
                <p>
                    <strong>Referencia: </strong>
                    {{ $payment['preference_id'] }}
                </p>
                <p>
                    <strong>ID de Colección: </strong>
                    {{ $payment['collection_id'] }}
                </p>
                <p>
                    <strong>Estatus de Colección: </strong>
                    {{ $payment['collection_status'] }}
                </p>
                <p>
                    <strong>ID de Pago: </strong>
                    {{ $payment['payment_id'] }}
                </p>
                <p>
                    <strong>Estatus de compra: </strong>
                    {{ $payment['status'] }}
                </p>
                <p>
                    <strong>Tipo de Pago: </strong>
                    {{ $payment['payment_type'] }}
                </p>
                <p>
                    <strong>ID de Pedido Mercantíl: </strong>
                    {{ $payment['merchant_order_id'] }}
                </p>
                <p>
                    <strong>Modo de Procesamiento: </strong>
                    {{ $payment['processing_mode'] }}
                </p>
                <p>
                    <strong>Cuenta MercadoPago(si aplica): </strong>
                    {{ $payment['merchant_account_id'] }}
                </p>
                <p>
                    <strong>NOTA: </strong><br/>
                    Es muy probable que tengas que iniciar sesión por
                    seguridad.
                    <br/>
                    <br/>
                    Podrás ver tu compra en el historial de compras.
                    <br/><br/>
                    Su producto será listado en su panel de
                    administración.
                </p>
                <p>Contacto: <strong>payments@inagave.com</strong></p>
                <p>Órden:&nbsp;<strong>#{{ $payment['id'] }}</strong>
                </p>
                <p>Fecha de
                    Actualización:&nbsp;<strong>{{ $payment['updated_at']}}</strong>
                </p>
                <p>Método de Pago:&nbsp;<strong>MercadoPago</strong></p>
                <p>
                    Gracias por su preferencia.
                    <br/>
                    <strong>Equipo de INAGAVE</strong>
                </p>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>

</html>
