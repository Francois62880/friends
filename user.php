<?php
    require_once 'fonctions/auth.php';
    forcer_utilisateur_connecte();
    require_once 'db.php';
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
    require_once 'elements/header.php';
?>

    <div class="container">
        <div class="row">
            <div class="offset-lg-2 col-lg-8">
                <h1>Bienvenu <?= $_SESSION['user'] ?></h1>
                <?php if(est_connecte()): ?>
                <a href="/logout.php" class="btn btn-success">Se déconnecter</a>
                <?php endif ?>
                <h2>Liste d'amis:</h2>
                <?php
                for($i=0; $i<sizeof($data); $i++)
                {
                    if($data[$i]['username_1'] == $_SESSION['user'])
                    {
                        echo "<tr scope='row'>";
                        echo "<td>" . $data[$i]['username_2'] . "</td>" . "<td><a href='action.php?action=delete&id=".$data[$i]['id']."' class='btn btn-primary'>Supprimez un ami</a></td>";
                        $user_check[] = $data[$i]['username_2'];
                        echo "</tr>";

                        if($data[$i]['is_pending'] == true)
                        echo "<h4>en attente d'être accepté</h4>";
                    }else{
                        echo '<table class="table">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th scope="col">Pseudo</th>';
                        echo '<th scope="col">Action</th>';
                        echo '</tr>';
                        echo '</thead>';
                        if($data[$i]['is_pending'] == false){
                            echo "<tr scope='row'>";
                            echo "<td>" . $data[$i]['username_1'] . "</td>" . "<td><a href='action.php?action=delete&id=".$data[$i]['id']."' class='btn btn-primary'>Supprimez un ami</a></td>";
                        $user_check[] = $data[$i]['username_1'];
                        echo "</tr>";
                    }
                    }
                }
               ?>
                </table>

                <h2>Demande d'amis:</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Pseudo</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <?php
                for($i=0; $i<sizeof($data); $i++)
                {
                    if($data[$i]['is_pending'] == true && $data[$i]['username_2'] == $_SESSION['user'])
                    {
                        echo "<tr scope='row'>";
                        echo "<td>" . $data[$i]['username_1']. "</td>" . "<td><a href='action.php?action=accept&id=".$data[$i]['id'] . "' class='btn btn-primary'>Accepté</a>" . " " . "<a href='action.php?action=delete&id=".$data[$i]['id']."' class='btn btn-primary'>Refusez</a></td>";
                        $user_check[] = $data[$i]['username_1'];
                        echo "</tr>";
                    }
                }

                ?>
                </table>


                <h2>Autres utilisateurs:</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Pseudo</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <?php
                $query = $pdo->query("SELECT * FROM users");
                $data = $query->fetchall();
               
                for($i=0; $i<sizeof($data); $i++)
                {
                    if(!in_array($data[$i]['username'], $user_check))
                    {
                        echo "<tr scope='row'>";
                        echo "<td>" . $data[$i]['username'] . "</td>" . "<td><a href='action.php?action=add&username=".$data[$i]['username'] . "' class='btn btn-primary'>Invitez un ami</a></td>";
                        echo "</tr>";
                    }
                }
               
                ?>
                </table>
            </div>
        </div>
    </div>

<?php
require_once 'elements/footer.php';
?>