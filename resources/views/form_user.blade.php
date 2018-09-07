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
    <<body>
        <section style="padding-top: 11%;">
            
        </section>
        <div class="row">
            <div class="col-md-12" style="text-align: center">
                <div class="row">
                    <div class="col-md-4">
                        
                    </div>
                    <div class="col-md-4">

                        <div class="row">
                            <div class="col-md-6">
                                <i class="fa fa-tags" style="font-size:48px;color:black"></i>
                                <h4>Persona natural</h4>        
                            </div>
                            <div class="col-md-6">
                                <i class="fa fa-building" style="font-size:48px;color:black"></i>
                                
                                <h4>Persona juridica</h4>        
                            </div>
                            </br></br>
                            <div class="col-md-6">
                                
                                <p style="cursor: pointer;"> <i class="fa fa-check-circle-o" style="font-size:28px;color:#f6f689"></i> Soy usuario registrado</p>        
                            </div>
                            <div class="col-md-6">
                                <p style="cursor: pointer;" > <i class="fa fa-user-plus" style="font-size:28px;color:#7e7e7c"></i> Quiero registrarme</p>
                            </div>
                            
                        </div>
                        
                    </div>
                    <div class="col-md-4">
                        
                    </div>
                    
                </div>
            
            </div>    
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

        <script type="text/javascript">
            $('#newUser').on('click', function() {

                window.location ="/form_user";
            });
        </script>
    </body>
</html>
