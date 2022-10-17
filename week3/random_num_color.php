<!DOCTYPE html>
<html>

<head>
    <title> EX 2 </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>

    <?php
    $num1 = (rand(100, 200));
    $num2 = (rand(100, 200));

    if ($num1 > $num2) {
        echo "<h1 class=\"col text-center bg-primary\"><strong>$num1</strong></h1>";
        echo "<h2 class=\"col text-center bg-secondary\">$num2</h2>";
    } elseif ($num2 > $num1) {
        echo "<h2 class=\"col text-center bg-secondary\">$num1</h2>";
        echo "<h1 class=\"col text-center bg-primary\"><strong>$num1</strong></h1>";
    }
    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>