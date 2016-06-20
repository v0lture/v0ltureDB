<?php
    require_once "load.php";
    global $lang;
    if(testConn() != "Success"){
        http_response_code(403);
        die();
    }
?>

<div class="list-group">
    <?php
        $dat = fetchDatabases();
        while($res = $dat->fetch_assoc()) {
            if($res["Database"] != $lang["config_db_name"]) {
              echo
              '<a href="#!" onclick="loadDb(\''.$res["Database"].'\')" class="list-group-item v-text-blue">
                '.$res["Database"].'
              </a>';
            } else {
              echo
              '<a href="#!" onclick="loadDb(\''.$res["Database"].'\')" class="list-group-item v-text-blue">
                '.$res["Database"].' '.$lang["db_view_config_db"].'
              </a>';
            }
        }
    ?>
</div>
