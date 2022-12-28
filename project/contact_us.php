<!DOCTYPE html>
<html>

<head>
    <title>Contact</title>

    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link href="css/style.css" rel="stylesheet" />

</head>

<body>

    <?php
    include 'topnav.php'
    ?>
    <div class="container-fluid image" style="background-image:url('image/bright2.png')">
        <div class="d-flex justify-content-center mt-5">
            <h1>Contact Us</h1>
        </div>

        <div class="row m-5">
            <div class="col">
                Email:<br>
                timothypoon1015@e.newera.edu.my
            </div>
            <div class="col">
                Phone:<br>
                013-9331358
            </div>
            <div class="col">
                Instagram:<br>
                zhe_1026
            </div>
        </div>

        <div class="d-flex justify-content-center mt-5">
            <h1>Suggestion</h1>
        </div>

        <form>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name">
            </div>
            <div class="mb-3">
                <label for="suggestion" class="form-label">Suggestion</label>
                <textarea type="text" class="form-control" id="suggestion"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
    </div>
</body>

</html>