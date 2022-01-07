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
                <a target="_blank">
                    <img
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
            <td align="center" class="esd-block-text es-p20b">
                <h5 class="card-title" style="font-weight:bold">Compra #{{ $payment['id'] }} completada con
                    éxito.</h5>
                <p>
                    <strong>{{ $user['name'] }}</strong>, gracias por su compra.
                    Recibirá un correo con los detalles de la misma.
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
                    ${{ $payment['price'] }} (MXN)
                </p>
                <p>
                    <strong>Total: </strong> ${{ $payment['total'] }} (MXN)
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
                    Los productos que apartaste se descontarán hasta que
                    el pago quede procesado, por favor
                    continúa el proceso de compra. En caso de que no se
                    efectue el pago éstos regresarán a la
                    tienda y Ud. perderá los ítems en esta órden.
                    <br/>
                    <br/>
                    Adocionalmente, los productos serán visibles en el
                    panel una vez se confirme. Si ocurre un problema
                    durante la transacción, no dude en contactarse con
                    el equipo de INAGAVE.
                    <br/><br/>
                    Le recordamos <strong>no cerrar las ventanas
                        emergentes</strong> hasta que su pago quede
                    liberado y la pantalla de
                    confirmación sea mostrada.
                </p>
                <p>Contacto: <strong>payments@inagave.com</strong></p>
                <p>Órden:&nbsp;<strong>#{{ $payment['id'] }}</strong>
                </p>
                <p>Fecha de
                    Creación:&nbsp;<strong>{{ $payment['created_at']}}</strong>
                </p>
                <p>Método de Pago:&nbsp;<strong>{{ $payment['type']}}</strong></p>
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
