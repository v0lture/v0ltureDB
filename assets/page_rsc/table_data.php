<?php
    require_once "load.php";
    global $lang;

    $columnlimit = 10;

    if(testConn() != "Success"){
        http_response_code(403);
        die("Not authenticated.");
    }
    if(!isset($_GET["db"]) && !isset($_GET["tbl"])) {
        http_response_code(400);
        die("Database and table required.");
    } else {

      // Variable declaration
      $dbl = $_GET["db"];
      $tbl = $_GET["tbl"];

      if(isset($_GET["page"])) {
        $page = $_GET["page"];
      } else {
        $page = 1;
      }
      $headers_defined = false;
      $headers_count = 0;
      $table_head = "";
      $error = "";
      $tbldat = "";
      $keyvalues = NULL;
      $toomanycolumns = false;
      $paginationmodule = "";
      $data = fetchTableData($dbl, $tbl, $page);
      $tdct = 0;
      $rownum = 0;

      if($dbl == $lang["config_db_name"]) {
        $error .=
        '<div class="alert alert-danger" role="alert" style="margin-left: 25px; margin-right: 25px;">
            <h4>'.$lang["config_db_edit_title"].'</h4>
            <p>'.$lang["config_db_edit_msg"].'</p>
          </div>';

        $error .=
        '<div class="alert alert-primary" role="alert" style="margin-left: 25px; margin-right: 25px;">
            <h4>'.$lang["config_db_edith_title"].'</h4>
            <p>'.$lang["config_db_edith_msg"].'</p>
          </div>';
      }

      if($data == "MySQL error") {
        die("Unable to fetch data from the table.");
      } elseif($data->num_rows == 0) {
        $error .=
        '<div class="alert alert-danger" role="alert" style="margin-left: 25px; margin-right: 25px;">
            <h4>'.$lang["mysql_empty_result"].'</h4>
            <p>'.$lang["mysql_empty_result_ctx"].'</p>
          </div>';
      } else {

        // Fetch table primary key (if applicable)
        $key = fetchTablePrimaryKey($dbl, $tbl);
        $keycount = 0;

        if($key->num_rows > 0) {
          // Define all keys into an array
          while($keys = $key->fetch_assoc()) {
            $keycount++;
            if($keycount <= $columnlimit) {
              $keyarray[$keycount] = $keys["COLUMN_NAME"];
              $inlinekey = $keys["COLUMN_NAME"];
            }
          }
          $inlinebtn = "class='btn v-bg-light-purple'";
        } else {
          // No primary keys
          $error .=
          '<div class="alert alert-danger" role="alert" style="margin-left: 25px; margin-right: 25px;">
              <h4>'.$lang["mysql_no_primary_key"].'</h4>
              <p>'.$lang["mysql_no_primary_key_ctx"].'</p>
            </div>';
            $keyarray[1] = "";
            $inlinebtn = "class='btn btn-default' data-container='body' data-toggle='tooltip' data-placement='right' title='".$lang["editor_inline_no_key"]."'";
            $inlinekey = "ERROR_KEY_IS_NOT_SET";
        }

        while($res = $data->fetch_assoc()) {

          // Table headers
          if($headers_defined == false) {

            $keys = array_keys($res);
            foreach($keys as &$header) {
              $headers_count++;

              if($headers_count <= 10 || configItem($lang["config_table_safety_name"], 'limit_col_count') == "false") {
                $is_primary_key = "";
                if(in_array($header, $keyarray)) {
                  $is_primary_key = $lang["tbl_key"];
                }

                $table_head .= "<th style=\"text-overflow: ellipsis;\" data-container=\"body\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"".$header."\">".$header." ".$is_primary_key."</th>";

                // Dump header names and types for popovers and inline editing
                $headertypearray[$headers_count] = fetchTableType($tbl, $header);
                $headernamearray[$headers_count] = $header;

              } else {
                // Appends error only once into the error variable
                if($toomanycolumns == false) {
                  $error .=
                  '<div class="alert alert-danger" role="alert" style="margin-left: 25px; margin-right: 25px;">
                      <h4>'.$lang["mysql_too_many_columns"].'</h4>
                      <p>'.$lang["mysql_too_many_columns_ctx"].'</p>
                      <br />
                      <div class="btn-group">
                          <a href="javascript:loadTableData(\''.$dbl.'\', \''.$tbl.'\', \'true\');" class="btn btn-primary">'.$lang["btn_temp_show_all"].'</a>
                          <a href="settings.php?jump=safety" class="btn btn-default">'.$lang["btn_disable"].'</a>
                      </div>
                    </div>
                  ';
                  $toomanycolumns = true;
                }
              }
            }
            $headers_defined = true;
          }

          // Pagination for 50+ items per page
          $paginationmodule = "";
          if($data->num_rows < 50) {
            $paginationmodule = "";
          } else {
            $pages = round(tableCount($dbl, $tbl) / 50, 0, PHP_ROUND_HALF_UP) - 1;
            $pgct = 0;
            while($pgct < $pages) {
              $pgct++;
              if($pgct == $page) {
                $paginationmodule .= "<li class='active'><a href='table.php?db=".$dbl."&tbl=".$tbl."&page=".$pgct."'>".$pgct."</a></li>";
              } else {
                $paginationmodule .= "<li><a href='table.php?db=".$dbl."&tbl=".$tbl."&page=".$pgct."'>".$pgct."</a></li>";
              }

            }
          }


          // Table data
          $tbldat .= '<tr>';
          $tblcount = 0;
          $rownum++;

          foreach($res as &$tabledat) {
            $tblcount++;
            $tdct++;
            if($tblcount <= 10 || configItem($lang["config_table_safety_name"], 'limit_col_count') == "false") {

              $valid = $headernamearray[$tblcount].$tdct;

              if($lang["tbl_popover_entire_value"] == "") {
                $popovervalue = $headernamearray[$tblcount];
              } else {
                $popovervalue = $lang["tbl_popover_entire_value"];
              }

              $cur_header = $headernamearray[$tblcount];
              if(in_array($cur_header, $keyarray)){
                $keyvalues[$rownum] = $tabledat;
              }

              $tbldat .= '<td ondblclick="loadEditor(\''.$dbl.'\', \''.$tbl.'\', \''.$inlinekey.'\', \''.$keyvalues[$rownum].'\');"     data-container="body"
                data-placement="bottom"
                data-toggle="popover"
                data-html="true"
                title="'.$popovervalue.' <span class=\'label label-primary\'>'.$headertypearray[$tblcount]["DATA_TYPE"].'</span>" data-content="
                  <form action=&#34;javascript:inlineChange(&#39;'.$dbl.'&#39;, &#39;'.$tbl.'&#39;, &#39;'.$inlinekey.'&#39;, &#39;'.$headernamearray[$tblcount].'&#39;, &#39;'.$valid.'&#39;, &#39;'.$keyvalues[$rownum].'&#39;); &#34;>
                    <div class=\'input-group\'>
                      <input id=\''.$valid.'\' type=\'text\' value=\''.$tabledat.'\' class=\'form-control\'>
                      <span class=\'input-group-btn\'>
                        <button '.$inlinebtn.' type=\'submit\' id=\'inlineFormBtn\' data-loading-text=\''.$lang["editor_inline_updating"].'\'>'.$lang["editor_inline_update"].'
                        </button>
                      </span>
                    </div>
                  </form>
                  ">'.$tabledat.'</td>';
            }

          }

          $tbldat .= '</tr>';

        }
      }
    }
?>

<table class="table table-striped table-hover table-responsive sortable-theme-bootstrap" data-sortable>

    <?php echo $error; ?>

    <thead>
        <tr>
            <?php echo $table_head; ?>
        </tr>
    </thead>
    <tbody>
        <?php echo $tbldat; ?>
    </tbody>

</table>

<nav style="margin-left: 25px; margin-right: 25px;">
  <ul class="pagination">
    <?php echo $paginationmodule; ?>
  </ul>
</nav>
