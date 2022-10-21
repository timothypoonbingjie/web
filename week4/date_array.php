<!DOCTYPE html>
<html>

<head>

    <title>EX 1</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

</head>

<body>
 
<div class="text-center mb-5">
    <h1>What Is Your Date Of Birth?</h1>
</div>
<div class="d-flex justify-content-evenly">
    
<div class="col-3">
<select class="form-select bg-info" aria-label="Default select example">
  <option selected>Day</option>
  <?php
    $curdate = date("d");
    for ($date=1; $date<=31; $date++) {
        $state = "";
        if ($curdate == $date) {
            $state="selected";
        }
        echo "<option class= value=$date $state>$date</option>";
    } 
       ?>
</select>
</div>

<div class="col-3">
<select class="form-select bg-warning" aria-label="Default select example">
  <option selected>Month</option>
  <?php
   $month = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
   $curmonth = date("n");
      
    for ($num = 1; $num <= 12; $num++) {
        $mon = $num-1;
        if($num == $curmonth){
        echo "<option value=\"$num\" selected>$month[$mon]</option>";
      } 
      else{
        
        echo "<option value=\"$num\">$month[$mon]</option>";
      }
    }
       ?>
</select>
</div>

<div class="col-3">
<select class="form-select bg-danger" aria-label="Default select example">
  <option selected>Year</option>
  <?php
    $curyear = date("Y");
    for ($year=1900; $year<=$curyear; $year++) {
        $state = "";
        if ($curyear == $year) {
            $state="selected";
        }
        echo "<option class= value=$year $state>$year</option>";
    } 
       ?>
</select>
</div>

</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>