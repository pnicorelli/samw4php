<?php

// CONSTANTS
define("HOST", "localhost");
define("DBNAME", "test");
define("USER", "web");
define("PASSW", "web");
define("VALID_TOKEN", "ESEMPIODITOKENVALIDO");

//FUNCTIONS
function get( $field ){
  $result = isset($_REQUEST[$field])?$_REQUEST[$field]:null;
  return $result;
}

function getJSON( $field ){
  $value = isset($_REQUEST[$field])?$_REQUEST[$field]:null;
  $result = json_decode($value, true);
  if( strlen($_REQUEST[$field]) > 0 && empty( $result ) ){
    throw new Exception("malformed json parameters");
  }
  return $result;
}

function buildSELECT($table, $where){
  $whereStr = "";
  if( !empty($where)){
    foreach ($where as $key => $value) {
      $whereStr .= " AND {$key} = '{$value}'";
    }
  }
  $sql = "SELECT * FROM `{$table}` WHERE 1=1 {$whereStr}";
  return $sql;
}

function buildDELETE($table, $where){
  $whereStr = "";
  if( !empty($where)){
    foreach ($where as $key => $value) {
      $whereStr .= " AND {$key} = '{$value}'";
    }
  }
  $sql = "DELETE FROM `{$table}` WHERE 1=1 {$whereStr}";
  return $sql;
}
