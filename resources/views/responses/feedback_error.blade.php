<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>


<style>
    p {
        font-size: .8em;
        text-align: center;
    }
</style>
<div class="container mt-3"></div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 offset-4">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-center">
                        <strong>ERROR</strong>
                    </h2>
                    <p>
                        {{ $error['ERROR'] }}
                    </p>
                    <img class="img-fluid"
                         src="https://inagave.com/wp-content/uploads/2021/09/INAGAVE-VECTORE.png"
                         alt="Logo"
                         title="Logo"/>
                    <button onclick="window.location.href = '/'" type="button" class="btn btn-danger mt-2"
                            style="width: 100%;">
                        REGRESAR A TIENDA
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
