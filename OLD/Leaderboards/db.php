<?php
      $dbServerName = "47.232.2.30";
      $dbUsername = "cvpadmin";
      $dbPassword = "cp123";
      $dbName = "exile";

      // create connection
      $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

      // check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }
  ?>

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