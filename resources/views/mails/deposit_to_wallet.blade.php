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
            <td align="center" class="esd-block-text es-m-txt-c">
                <h2>DEPÓSITO A CUENTA INAGAVE</h2>
            </td>
        </tr>
        <tr>
            <td align="center" class="esd-block-text es-p20b">
                <p>
                    Hola, <i>{{ $owner['name'] }} {{ $owner['lastname'] }} {{ $owner['second_lastname'] }}</i>.
                </p>
                <p>
                    Se depositó a tu cuenta INAGAVE, los detalles a continuación: <br/>
                </p>

                @foreach ($transactions as $transaction)
                <p>
                    <strong>Referencia: </strong>
                    {{ $transaction['id'] }}
                </p>
                <p>
                    <strong>Estado: </strong>
                    {{ $transaction['status'] }}
                </p>
                <p>
                    <strong>Cantidad: </strong>
                    ${{ $transaction['amount'] }} (MXN)
                </p>
                <p>
                    <strong>Banco: </strong>
                    {{ $transaction['bank'] }}
                </p>
                <p>
                    <strong>Cuenta: </strong>
                    {{ $transaction['account'] }}
                </p>
                <p>
                    <strong>Tipo: </strong>
                    {{ $transaction['type'] }}
                </p>
                @endforeach

                <p>
                    <strong>NOTA: </strong><br/>
                    Le recordamos <strong>no cerrar las ventanas
                        emergentes</strong> hasta que su pago quede
                    liberado y la pantalla de
                    confirmación sea mostrada.
                </p>
                <p>Contacto: <strong>payments@inagave.com</strong></p>
                </p>
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
