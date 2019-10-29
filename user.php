<?php
    session_start();
    require 'db.php';
    $query = $pdo->prepare("SELECT * FROM friends WHERE username_1 = :username_1 OR username_2 = :username_2");
    $query->execute([
        "username_1" => $_SESSION['user'],
        "username_2" => $_SESSION['user']
    ]);
    $data = $query->fetchall();

    if($_SESSION['user'])
    {
        $user_check[] = $_SESSION['user'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bootstrap.css" media="screen">
    <link rel="stylesheet" href="../_assets/css/custom.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
        integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <link rel="stylesheet" href="app.css">
    <title>User - Friends</title>
</head>

<body>
   
    <div class="container">
        <div class="row">
            <div class="offset-lg-2 col-lg-8">
               <h1>Bienvenu <?= $_SESSION['user'] ?></h1>

               <h2>Liste d'amis:</h2>
               <?php
                for($i=0; $i<sizeof($data); $i++)
                {
                    if($data[$i]['username_1'] == $_SESSION['user'])
                    {
                        echo $data[$i]['username_2'] . "<a href='#' class='btn btn-primary'>Supprimez un ami</a></br>";
                        $user_check[] = $data[$i]['username_2'];

                        if($data[$i]['is_pending'] == true)
                        echo "(en attente d'être accepté)";
                    }else{
                        if($data[$i]['is_pending'] == false){
                        echo $data[$i]['username_1'] . "<a href='#' class='btn btn-primary'>Supprimez un ami</a></br>";
                        $user_check[] = $data[$i]['username_1'];
                    }
                    }
                    echo '</br>';
                }
               ?>

               <h2>Demande d'amis:</h2>
               <?php
                for($i=0; $i<sizeof($data); $i++)
                {
                    if($data[$i]['is_pending'] == true && $data[$i]['username_2'] == $_SESSION['user'])
                    {
                        echo $data[$i]['username_1']. "<a href='#' class='btn btn-primary'>Accepté</a></br>";
                        $user_check[] = $data[$i]['username_1'];
                    }
                }

                ?>


               <h2>Autres utilisateurs:</h2>
               <?php
                $query = $pdo->query("SELECT * FROM users");
                $data = $query->fetchall();
                for($i=0; $i<sizeof($data); $i++)
                {
                    if(!in_array($data[$i]['username'], $user_check))
                    {
                        echo $data[$i]['username']. "<a href='#' class='btn btn-primary'>Invitez un ami</a> </br>";
                    }
                }
                ?>
             
            </div>
        </div>
    </div>
</body>

</html>