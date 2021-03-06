<?php

//config inclusion session starts
include("config.php");
session_start();

/*
if($_SERVER["REQUEST_METHOD"] == "POST") {

}
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        #centerwrapper { text-align: center; margin-bottom: 10px; }
        #centerdiv { display: inline-block; }
        /* Navbar container */
        .navbar {
        overflow: hidden;
        background-color: #333;
        font-family: Arial;
        }

        h1 { 
        display: block;
        font-size: 3em;
        margin-top: 0.67em;
        margin-bottom: 0.67em;
        margin-left: 0;
        margin-right: 0;
        font-weight: bold;
        }

        /* Links inside the navbar */
        .navbar a {
        float: left;
        font-size: 16px;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        }
        /* Add a red background color to navbar links on hover */
        .navbar a:hover, .dropdown:hover .dropbtn {
        background-color: black;
        }

    </style>
</head>
<body>
    
    <div class="container">
        
        <nav class="navbar navbar-inverse bg-primary navbar-fixed-top">
        
            <div class="container-fluid">
                <div class="navbar-header">
                    <h4 class="navbar-text">User <?php echo htmlspecialchars($_SESSION['nick_name']); ?></h4>

                </div>
                <a href="userWelcome.php">Home</a>
                <a href="userLibrary.php">Library</a>
                <a href="userStore.php">Store</a>
                <a href="userCheckUpdates.php">Check Updates</a>
                <a href="userCheckMods.php">Mods</a>
                <a href="followCurators.php">Follow Curators</a>
                <a href="userRefund.php">Refund</a>
                <a href="userRefundHistory.php">Refund History</a>
                <a href="userShopHistory.php">Shop History</a>
                <?php
                    $query = "SELECT credits FROM person WHERE person_id = " .$_SESSION['person_id'];
                    $res = mysqli_query($db, $query);
                    $row = mysqli_fetch_array($res);
                    $credit = $row['credits'];
                    echo "<a href='userCredits.php'>Credit : $credit TL </a>";
                ?>
                
                <div class="navbar-right">
                    <a href="logout.php">Log Out</a>
                </div>
    </div>
            </div>
            
        </nav>

        
        <div id="centerwrapper">
            <div id="centerdiv">
                <br><br>
                <h1>Shop History</h1>


                    
                    <?php
                        $person_id = $_SESSION['person_id'];
                        // Prepare a select statement
                        $query = "SELECT shop_id, game_id FROM renew WHERE person_id = '$person_id'";


                        echo "<p><b>Bought Games : </b></p>";

                        $result = mysqli_query($db, $query);

                        if (!$result) {
                            printf("Error: %s\n", mysqli_error($db));
                            exit();
                        }

                        echo "<table class=\"table table-lg table-striped\">
                            <tr>
                            <th>Game Name</th>
                            <th>Bought Date</th>
                            <th>Bought Price</th>
                            <th>Current Price</th>
                            </tr>";

                        while($hasRow = mysqli_fetch_array($result)) {
                            $shop_id = $hasRow['shop_id'];
                            $game_id = $hasRow['game_id'];

                            // get game name from game id;
                            $queryGame = "SELECT game_name, game_price FROM game WHERE game_id = '$game_id'";
                            $result2 = mysqli_query($db, $queryGame);
                            if(!$result2) {
                                printf("Error1: %s\n", mysqli_error($db));
                                exit();
                            }
                            $gameRow =  mysqli_fetch_array($result2);
                            $game_name = $gameRow['game_name'];
                            $game_price = $gameRow['game_price'];

                            // get bought date and bought price
                            $query = "SELECT bought_date, bought_price FROM shophistory WHERE shop_id = '$shop_id'";
                            $res = mysqli_query($db, $query);
                            if(!$res) {
                                printf("Error1: %s\n", mysqli_error($db));
                                exit();
                            }

                            $shopRow =  mysqli_fetch_array($res);
                            $bought_price = $shopRow['bought_price'];
                            $bought_date = $shopRow['bought_date'];
                            

                                            
                            echo "<form action=\"\" METHOD=\"POST\">";
                            echo "<tr>";
                            echo "<td>" . $game_name . "</td>";
                            echo "<td>" . $bought_date . "</td>";
                            echo "<td>" . $bought_price . "</td>";
                            echo "<td>" . $game_price . "</td>";

                            echo "</tr>";
                            echo "</form>";
                        }

                        echo "</table>";
                        
                        ?>
          
            </div>
        </div>
    </div>


    <script type="text/javascript">
        function checkEmpty() {

        }
    </script>
</body>
</html>