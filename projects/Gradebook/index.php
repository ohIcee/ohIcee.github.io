<?php

$user = 'root';
$pass = 'IEtAElB0Xe3g9Pe0';
$db = new PDO('mysql:host=localhost;dbname=NIRSA_MySQL', $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

if (isset($_POST["add-submit"])) {

    $FirstName = $_POST["add-firstname"];
    $LastName = $_POST["add-lastname"];
    $BirthYear = $_POST["add-birthyear"];
    AddUser($FirstName, $LastName, $BirthYear);

}

if (isset($_POST["chg-submit"])) {
    
    $ID = $_POST["chg-id"];
    $FirstName = $_POST["chg-firstname"];
    $LastName = $_POST["chg-lastname"];
    $BirthYear = $_POST["chg-birthyear"];
    ChangeUser($ID, $FirstName, $LastName, $BirthYear);

}

if (isset($_POST["del-submit"])) {
    
    $ID = $_POST["del-id"];
    DeleteUser($ID);

}

function AddUser($FirstName, $LastName, $BirthYear) {

    global $db;

    $sql = "INSERT INTO Users (Name, Lastname, LetnicaRojstva) VALUES (:firstname, :lastname, :birthyear)";
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':firstname', $FirstName);
    $stmt->bindValue(':lastname', $LastName);
    $stmt->bindValue(':birthyear', $BirthYear);

    if (!$stmt->execute()) { echo "Napaka :(((("; }

}

function ChangeUser($ID, $FirstName, $LastName, $BirthYear) {

    global $db;

    $sql = "UPDATE Users SET Name=:firstname, Lastname=:lastname, LetnicaRojstva=:birthyear WHERE ID=:id";
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':id', $ID);
    $stmt->bindValue(':firstname', $FirstName);
    $stmt->bindValue(':lastname', $LastName);
    $stmt->bindValue(':birthyear', $BirthYear);

    if (!$stmt->execute()) { echo "Napaka :<<<<"; }

}

function DeleteUser($ID) {

    global $db;

    $sql = "DELETE FROM Users WHERE ID=:id";
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':id', $ID);

    if (!$stmt->execute()) { echo "Napaka :[[[["; }

}

?>

<html>
    <head>
        <link rel="stylesheet" href="css/semantic.min.css">
        <link rel="stylesheet" href="css/index_design.css">
    </head>
    <body>

        <div class="ui container">

            <h1>Vaja 1</h1>

            <div class="ui stackable grid">
                <div class="six wide column">
                    <div class="ui top attached tabular menu">
                        <a class="item active" data-tab="first">Dodaj</a>
                        <a class="item" data-tab="second">Spremeni</a>
                        <a class="item" data-tab="third">Izbriši</a>
                    </div>
                    <div class="ui bottom attached tab segment active" data-tab="first">
                        
                        <form class="ui form" method="post">
                            <div class="field">
                                <label>Ime</label>
                                <input type="text" name="add-firstname" placeholder="Ime">
                            </div>
                            <div class="field">
                                <label>Priimek</label>
                                <input type="text" name="add-lastname" placeholder="Priimek">
                            </div>
                            <div class="field">
                                <label>Letnica Rojstva</label>
                                <input type="number" name="add-birthyear" placeholder="2000">
                            </div>
                            <button class="ui button" type="submit" name="add-submit">Dodaj</button>
                        </form>

                    </div>
                    <div class="ui bottom attached tab segment" data-tab="second">
                        
                        <form class="ui form" method="post">
                            <div class="field">
                                <label>ID Dijaka</label>
                                <input type="number" name="chg-id" placeholder="2000">
                            </div>
                            <div class="field">
                                <label>Ime</label>
                                <input type="text" name="chg-firstname" placeholder="Ime">
                            </div>
                            <div class="field">
                                <label>Priimek</label>
                                <input type="text" name="chg-lastname" placeholder="Priimek">
                            </div>
                            <div class="field">
                                <label>Letnica Rojstva</label>
                                <input type="number" name="chg-birthyear" placeholder="2000">
                            </div>
                            <button class="ui button" type="submit" name="chg-submit">Spremeni</button>
                        </form>

                    </div>
                    <div class="ui bottom attached tab segment" data-tab="third">
                        
                        <form class="ui form" method="post">
                            <div class="field">
                                <label>ID Dijaka</label>
                                <input type="number" name="del-id" placeholder="2000">
                            </div>
                            <button class="ui button" type="submit" name="del-submit">Izbriši</button>
                        </form>

                    </div>
                </div>
                <div class="nine wide column">
                    <table class="ui table">
                        <thead>
                            <tr>
                            <th>ID</th>
                            <th>Ime</th>
                            <th>Priimek</th>
                            <th>Letnica Rojstva</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            $sql = "SELECT * FROM Users";
                            $stmt = $db->prepare($sql);
                            $stmt->execute();
                            $rows = $stmt->fetchAll();

                            foreach($rows as $row) {
                                echo ""
                                    . "<tr>"
                                        . "<td>" . $row['ID'] . "</td>"
                                        . "<td>" . $row['Name'] . "</td>"
                                        . "<td>" . $row['Lastname'] . "</td>"
                                        . "<td>" . $row['LetnicaRojstva'] . "</td>"
                                    . "</tr>";
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="js/semantic.min.js"></script>
        <script src="js/index_script.js"></script>
    </body>
</html>