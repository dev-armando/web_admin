<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>search...</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://kit.fontawesome.com/cbec68f37d.js"></script>
<script src="https://stackpath.bootstrapcdn.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
        $('.search-box input[type="text"]').on("keyup input", function(){
            /* Obtener valor de entrada en el cambio */
            var inputVal = $(this).val();
            var resultDropdown = $(this).siblings(".result");
            if(inputVal.length){
                $.get("backend-search.php", {term: inputVal}).done(function(data){
                    // Mostrar los datos devueltos en el explorador
                    resultDropdown.html(data);
                });
            } else{
                resultDropdown.empty();
            }
        });
        // Establecer valor de entrada de búsqueda en el clic del elemento de resultado
        $(document).on("click", ".result p", function(){
            $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
            $(this).parent(".result").empty();
        });
    });
</script>
</head>
<body>
<div class="container mt-5">
<div class="search-box">
<input type="text" class="form-control" autocomplete="off" placeholder="Buscar individuo, nombre, apellido, genero..." />
<div class="result"></div>
</div>
</div>
</body>
</html>
