<?php  
 $connect = mysqli_connect("127.0.0.1", "root", "", "dotd");  
 $query ="SELECT * FROM stats ORDER BY kills DESC";
 $result = mysqli_query($connect, $query) or die("DOTD | Error: Could not connect to leaderboard database". mysqli_error($connect));
?>

<html>

<head>

<meta charset="utf-8">
    <link rel="stylesheet" href="data/css/leaderboard.css">
    <link rel="stylesheet" href="data/css/bstables.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <script src="data/js/filter.js"></script>
    <script src="data/js/sort.js"></script>'
    <script src="data/js/onLoad.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>

<body onload="makeTableScroll();">
    <ul>
        <li><img class="logo" src="data/img/dotdd.png">
        <li><a class="first" href="#home">Home</a></li>
        <li><a class="active" href="#leaderboard">Leaderboard</a></li>
    </ul>


    <div class="statscontainer">
        <center>
        <img src="data/img/dotdd.png">
        <p class="mainheader"> Top Server Stats </p>

        <fieldset class="statscard">
        <img src="https://i.imgur.com/8iM5h2f.png"></img>
            <legend> Top Hero </legend>
            <?php
            $array = array();
            $sql = "SELECT zkills, name FROM stats ORDER BY zkills DESC LIMIT 1";
            $sql_result = mysqli_query($connect, $sql);
            while ($row = mysqli_fetch_array($sql_result)) {
                echo '<label class="playername">' . $row['name'] . '</label> <br>';
                echo '<label class="statsblue">' . $row['zkills'] . ' Zombie Kills</label>';
            }?>
        </fieldset>

        <fieldset class="statscard">
            <legend> Top Kill / Death Ratio </legend>
            <?php
            $array = array();
            $sql = "SELECT name, kills, deaths,  kills / deaths as kdr FROM stats ORDER BY kdr DESC LIMIT 1";
            $sql_result = mysqli_query($connect, $sql);

            while ($row = mysqli_fetch_array($sql_result)) {
                echo '<label class="playername">' . $array[] = $row['name'] . '</label> <br>';
                echo '<label class="statsgreen">' . $array[] =  round(($row['kdr']),2) . ' KDR</label>';
            }?>
        </fieldset>

        <fieldset class="statscard">
            <legend> Top Bandit </legend>
            <?php
            $array = array();
            $sql = "SELECT kills, name FROM stats ORDER BY kills DESC LIMIT 1";
            $sql_result = mysqli_query($connect, $sql);

            while ($row = mysqli_fetch_array($sql_result)) {
                echo '<label class="playername">' . $array[] = $row['name'] . '</label> <br>';
                echo '</label> <label class="statsred">' . $row['kills'] . ' Player Kills</label>';
            }?>
        </fieldset>
        </center>

        <div class="lbbreak">
            <div class="lbheader">
            <p> 👑  Leaderboard </p>
            </div>
        </div>
    </div>

    <div class="tablecontainer">
    <center>


        <div class="table-toolbar">
        <input type="text" id="searchFilter" class="searchbox" onkeyup="searchFilter()" placeholder="Search Username">
        
    <table id="leaderboard">
        <tr class="dontflip">
            <th class="avatar">Steam Avatar</th>
            <th class="name">Name</th>
            <th class="item">Kills</th>
            <th class="item">Deaths</th>
            <th class="item">Zombie Kills</th>
            <th class="item">K / D</th>
        </tr>
        
        <?php
              while ($row = mysqli_fetch_array($result)) {
                $currentPosition = 0;
                $STEAM_ID = $row["uid"];
                $APIKEY = 'FD3A9BC13D94276543267EE264BE4E2B';
                $profileLink = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . $APIKEY . '&steamids=' . $STEAM_ID);
                $decode = json_decode($profileLink);
                $ava = $decode->response->players[0]->avatarfull;
                if($ava == null) {
                    echo 'No Avatar.';
                } else {
                    $playerava = $decode->response->players[0]->avatarfull;
                }
                
            echo '<tr>
                    <td> <img class="playersava" src=' . $playerava . 
                    '></td><td>' . $row["name"] . 
                    '</td><td>' . $row["kills"] . 
                    '</td><td>' . $row["deaths"] . 
                    '</td><td>' . $row["zkills"] . 
                    '</td><td>' . round(($row['kills'] / $row['deaths']),2)  . 
                    '</td></tr>';
              }
        ?>
        </table>
    </center>
    </div>
</div>


</body>

<script>
 $('th.item').click(function(){
    var table = $(this).parents('table').eq(0)
    var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
    this.asc = !this.asc
    if (!this.asc){rows = rows.reverse()}
    for (var i = 0; i < rows.length; i++){table.append(rows[i])}
})
function comparer(index) {
    return function(a, b) {
        var valA = getCellValue(a, index), valB = getCellValue(b, index)
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
    }
}
function getCellValue(row, index){ return $(row).children('td').eq(index).text() }

</script>

</html>