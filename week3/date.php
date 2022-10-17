<!DOCTYPE html>
<html>

<head>

    <title>Homework 1</title>

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
    for ($num = 1; $num <= 31; $num++) {
        echo "<option value=\"$num\">$num</option>";
      } 
       ?>
</select>
</div>

<div class="col-3">
<select class="form-select bg-warning" aria-label="Default select example">
  <option selected>Month</option>
  <?php
    for ($num = 1; $num <= 12; $num++) {
        echo "<option value=\"$num\">$num</option>";
      } 
       ?>
</select>
</div>

<div class="col-3">
<select class="form-select bg-danger" aria-label="Default select example">
  <option selected>Year</option>
  <?php
    for ($num = 2022; $num >= 1900; $num--) {
        echo "<option value=\"$num\">$num</option>";
      } 
       ?>
</select>
</div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>