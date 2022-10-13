<!DOCTYPE html>
<html>
    <head>
        <title> EX 1 </title>
    </head>
<body>
<style>
.green {
    	color: green;
}
     
.blue {
    	color: blue;
}
     
.red {
     	color: red;
}

.italic {
		font-style: italic;
}
     
     
</style>
<?php
$num1 = (rand(100,200));
$num2 = (rand(100,200));
$sum = $num1 + $num2;
$mult = $num1 * $num2;

echo "<p class=\"green italic\">$num1</p>";

echo "<p class=\"blue italic\">$num2</p>";

echo "<p class=\"red\"><strong>$sum</strong></p>";

echo "<p class=\"italic\"><strong>$mult</strong></p>";

?>

</body>
</html>