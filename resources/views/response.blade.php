<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Prueba</title>

        <!-- Fonts -->
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    </head>
    <body>
        <section style="padding-top: 12%; ">
            
        </section>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6" style="text-align: center;">
                <h2>{{$msj}}</h2>
                <br>
                <button type="button" class="btn btn-sm btn-success" onclick="index_return()">Regresar al Inicio
                </button>
            </div>
            <div class="col-md-3"></div>
        </div>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script type="text/javascript">

            function index_return() {
                 window.location="/";
            }
        </script>
    </body>
</html>
