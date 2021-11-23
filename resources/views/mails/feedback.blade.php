<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>


<style>
    p {
        font-size: .8em;
    }
</style>
<div class="container mt-5"></div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
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
                        {{ $payment['price'] }}
                    </p>
                    <p>
                        <strong>Total: </strong> {{ $payment['total'] }}
                    </p>
                    <p>

                </div>
            </div>
        </div>
        <div class="col-md-4">
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
        </div>
    </div>
</div>
