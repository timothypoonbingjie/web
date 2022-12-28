<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>

    <meta charset="utf-8">
    <title>Send Email</title>



</head>



<body>
<title>Contact us</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link href="css/style.css" rel="stylesheet" />

    <?php
    include 'topnav.php'
    ?>
    <div class="container-fluid image" style="background-image:url('image/bright2.png')">
    <form class="d-flex flex-column mb-3 justify-content-center" action="contact_us.php" method="post">
        Email <input type="email" name="email" value="" class='form-control' placeholder="Please enter your email"> <br>
        Title <input type="text" name="subject" value="" class='form-control' placeholder="Please enter your Title"> <br>
        Message <input type="text" name="message" value="" class='form-control' placeholder="Please enter your message"> <br>
        <div class="d-flex justify-content-center mb-4"><button type="submit" class="btn btn-success" name="send">Send</button></div>
    </form>

        

        <?php

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        require 'phpmailer/src/Exception.php';
        require 'phpmailer/src/PHPMailer.php';
        require 'phpmailer/src/SMTP.php';



        if (isset($_POST["send"])) {
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'wzsohai@gmail.com';
            $mail->Password = 'tidvjhvtjfmbkzma';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = '465';

            $mail->setFrom('wzsohai@gmail.com');

            $mail->addAddress('wzsohai@gmail.com');

            $mail->isHTML(true);

            $mail->Subject = $_POST["subject"];
            $mail->Body = $_POST["message"] . " " . $_POST['email'];

            $mail->send();

            echo
            "
    
            <script>
    alert('Send Sucessfully');
    document.location.herf = 'contact_us.php'
    </script>
    ";
        }
        ?>
</div>
</body>