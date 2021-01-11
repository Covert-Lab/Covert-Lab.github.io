<!doctype html>
<html lang="en">

    <head>
        <title> Covert Paradise Leaderboards </title>
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <link rel="stylesheet" type="text/css" href="css/tables.css">
    </head>
     
    <?php
      $dbServerName = "47.232.2.30";
      $dbUsername = "cvpadmin";
      $dbPassword = "cp123";
      $dbName = "exile";

      // create connection
      $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);
    ?>

    <body>

        <img class="navlogo" src="assets\cp.png">
        <a class="navlogo text" style="font-weight: bolder;"> COVERT <span class="color">PARADISE</span></a>
        <div class="nav">
                    <a class="naventry"> HOME</a>
                    <a class="naventry"> LEADERBOARD</a>
                    <a class="naventry"> TEAM</a>
                    <a class="naventry"> SUPPORT</a>
        </div>

    <div class="columna">
        <br>
    </div>

    <div class="columnb">
        
        <h1 class="header"> LEADERBOARDS </h1>
        <p class="lower"> Current Player Rankings, Updated Constantly.</p>
        
        <table class="table table-dark">
            <thead>
            <tr>
            <center>
                <th scope="col">Placement</th>
                <th scope="col">Name</th>
                <th scope="col">Score</th>
                <th scope="col">Kills</th>
                <th scope="col">Join Date</th>
            </center>
            </tr>
            </thead>
            <tbody>
              <?php 
                $place = 1;
                if ($result = $conn->query("SELECT * FROM account WHERE NOT name='DMS_PersistentVehicle' ORDER BY score DESC")) {                          
                  while($row = $result->fetch_assoc()) {
                    $id = $row["uid"];
                    $key = 'FD3A9BC13D94276543267EE264BE4E2B';
                    $link = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . $key . '&steamids=' . $id . '&format=json');
                    $parray = json_decode($link, true);

                    echo "<tr>" . "<td>" . $place ++ . "</td>" . "<td><img class='avatar' src='" . $parray['response']['players'][0]['avatarfull'] . "'>" . $row["name"] . "</td>" . "<td>" . $row["score"] .  "</td>" . "<td>" . $row["kills"] . "</td>" . "<td>" . $row["first_connect_at"] . "</td>" . "<br>";
                  }
                  $result->close();
                }
              ?>
    </div>

    <div class="columna">
        <br>
    </div>
    

    </body>
    
</html>