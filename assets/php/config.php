<?php

  function configEnabled() {
    // Is the config enabled and prepared?
    global $db;
    global $lang;

    $dbtst = $db->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".$lang["config_db_name"]."'");
    if($dbtst->num_rows == 0) {
      return false;
    } else {
      return true;
    }
  }

  function configItem($key) {
    // Fetch an config item from the section and key.
    global $db;
    global $lang;

    if(configEnabled() == true) {
      $resp = $db->query("SELECT `val` FROM `".$lang["config_db_name"]."`.`".$lang["config_table_name"]."` WHERE `key` = '".$key."' LIMIT 1");
      if($resp) {
        if($resp->num_rows == 0) {
          return "Unknown key";
        } else {
          while($data = $resp->fetch_assoc()) {
            return $data["val"];
          }
        }
      } else {
        return "Unknown key";
      }
    } else {
      return "Not enabled";
    }
  }

  function resetConfig() {
    global $db;
    global $lang;

    if(configEnabled() == true) {

      if($res = $db->query('TRUNCATE `'.$lang["config_db_name"].'`.`'.$lang["config_table_name"].'`')) {

        if($res = $db->query("INSERT IGNORE INTO `".$lang["config_db_name"]."`.`".$lang["config_table_name"]."` (`id`, `key`, `val`) VALUES (NULL, 'limit_col_count', 'false'), (NULL, 'settings_gui', 'true'), (NULL, 'show_system_tables', 'true')")) {
          return "Reset";
        } else {
          return "Cannot insert rows. Error: ".$db->error;
        }

      } else {
        return "Cannot truncate. Error: ".$db->error;
      }

    } else {
      return "Config never been initialized.";
    }
  }

  function prepConfig() {

    global $db;
    global $lang;

    if($report = $db->query("CREATE DATABASE IF NOT EXISTS ".$lang["config_db_name"]."")) {

      // Generate safety table
      if($report = $db->query("CREATE TABLE IF NOT EXISTS `".$lang["config_db_name"]."`.`".$lang["config_table_name"]."` ( `id` INT(6) NOT NULL AUTO_INCREMENT, `key` VARCHAR(100) NOT NULL, UNIQUE (`key`), `val` VARCHAR(100) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;")) {

        return "Ready";

      } else {

        return "Failed to create table. Error: ".$db->error;

      }

    } else {

      return "Failed to create database. Error: ".$db->error;

    }

  }
 ?>
