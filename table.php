<?php

    // Working directory of any
    $wd = getcwd();
    // Working directory of first executing file
    $lcwd = dirname(__FILE__);

    require_once $lcwd."/assets/php/session.php";
    require_once $lcwd."/assets/page_rsc/load.php";

    if(testConn() != "Success") {
      header("Location: auth.php?confirm=reauth");

      if(!isset($_GET["db"])) {
        header("Location: index.php");
      } else {
        $db = $_GET["db"];
      }
    }

    if(!isset($_GET["view"])) {
      header("Location: table.php?db=".$_GET["db"]."&tbl=".$_GET["tbl"]."&view=compact");
    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <?php require_once "assets/page_rsc/head.php"; ?>

    </head>

    <body onload="tableInit();">

        <?php
            // require navigation bar
            require_once $lcwd."/assets/page_rsc/navbar.php";
        ?>

        <!-- Editor -->
        <div class="modal fade" id="editorModal" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <form method="POST" action="assets/page_rsc/editor.php?do=edit">
                <div class="modal-header">

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                  <h4 class="modal-title" id="editorLabel"><?php echo $lang["editor_title"]; ?></h4>

                </div>

                <div class="modal-body">

                  <div class="progress" id="editor-loading" style="display: block;">
                      <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                  </div>

                  <div id="editor-xhr">

                  </div>

                </div>

                <div class="modal-footer">
                  <div class="btn-group">
                    <button type="button" class="btn v-bg-blue"><?php echo $lang["tbl_drop"]; ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang["btn_close"]; ?></button>
                    <button type="submit" class="btn v-bg-dark-purple"><?php echo $lang["editor_save_changes"]; ?></button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="modal fade" id="newModal" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <form method="POST" action="assets/page_rsc/editor.php?do=insert">
                <div class="modal-header">

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                  <h4 class="modal-title" id="newLabel"><?php echo $lang["editor_new_title"]; ?></h4>

                </div>

                <div class="modal-body">

                  <div class="progress" id="new-loading" style="display: block;">
                      <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                  </div>

                  <div id="new-xhr">

                  </div>

                </div>

                <div class="modal-footer">
                  <div class="btn-group">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang["btn_close"]; ?></button>
                    <button type="submit" class="btn v-bg-dark-purple"><?php echo $lang["editor_new"]; ?></button>
                  </div>
                </div>
              </form>
            </div>
          </div>

        </div>

        <div class="container">
            <div class="alert alert-danger" role="alert" id="error" style="display:none; ">
                <h4>Error</h4>
                <p>Failed to do something.</p>
            </div>
        </div>

        <div class="row">

            <div class="col-md-3" id="tables">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a id="tables-loading-btn" href="javascript:loadDb('<?php echo $_GET["db"]; ?>', 'compact');" class="btn v-bg-blue v-text-grey btn-xs pull-right" style="margin-top: -3px;" data-loading-text="..."><?php echo $lang["btn_refresh"]; ?></a>
                        <h3 class="panel-title"><?php echo $lang["tbl_in_prefix"].$_GET["db"]; ?></h3>

                    </div>

                    <div class="panel-body">

                        <div class="progress" id="tables-loading" style="display: none;">
                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                        </div>

                    </div>

                    <div id="tables-xhr">

                      <?php include "assets/page_rsc/tables.php"; ?>

                    </div>

                </div>

            </div>

            <div class="col-md-9" id="maincontent">

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="btn-group pull-right">
                          <a href="javascript:tableInit();" class="btn v-bg-grey btn-xs panel-title-btn">Reset Popovers</a>

                          <a id="main-loading-btn" href="javascript:fetchTableData('<?php echo $_GET["db"]; ?>', '<?php echo $_GET["tbl"]; ?>');" class="btn v-bg-light-purple btn-xs panel-title-btn" data-loading-text="..."><?php echo $lang["btn_refresh"]; ?></a>
                        </div>
                        <h3 class="panel-title" id="tableName"><?php echo $_GET["tbl"]; ?></h3>

                    </div>

                    <div class="panel-body">

                        <div class="progress" id="main-loading" style="display: none;">
                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                        </div>

                    </div>

                    <div id="main-xhr" style="max-width: 100%; width: 100%;">
                        <?php include "assets/page_rsc/table_data.php"; ?>
                    </div>

                </div>

            </div>

        </div>

    </body>
</html>
