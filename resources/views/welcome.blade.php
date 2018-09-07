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
        <div style="text-align: center;">
            <h4 style="color: black;font-weight: bold;">Indique el tipo de cuenta con la que desea realizar el pago.</h4>
            <select>
                <option value="0">PSE</option>
            </select>
            
            <h4 style="color: black;font-weight: bold;">Seleccione de la lista la entidad financiera con la que desea realizar el pago.</h4>
            <br>
            <select id="selectBank">
                
                @php $selected=null @endphp
                
                @foreach ($result->getBankListResult->item as $key => $r)
                    @if ($r->bankCode == 0)
                        <option value="{{ $r->bankCode }}" selected>{{ $r->bankName }} </option>
                    @else
                        <option value="{{ $r->bankCode }}" >{{ $r->bankName }} </option>
                    @endif
                @endforeach            

            </select>
            
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <script type="text/javascript">
        $('#selectBank').on('change', function() {
            
            $.ajax({
            
                url: '/transaction/'+this.value,
                type: 'GET',
                cache: false,
                datatype:'JSON',
                success: function (data) {
                   
                    window.location =data.createTransactionResult.bankURL;    
                },
                error : function(xhr,errmsg,err) {
                    console.log(xhr.status + ": " + xhr.responseText); 
                }    
            });
            //window.location ="/transaction/"+this.value;
        });
    </script>
    </body>
</html>
