<?php
include_once "utils.php";

$db = new mysqli(HOST, USER, PASSW, DBNAME);

$action = get("action");
$token = get("token");



try{

  if ($db->connect_error) {
    throw new Exception("Connect Error ({$mysqli->connect_errno}) {$mysqli->connect_error}");
  }

  if ( $token !== VALID_TOKEN ) {
    throw new Exception("invalid token");
  }

  switch( $action ){
    case "read";
      //db.php?token=ESEMPIODITOKENVALIDO&action=read&table=tablename&where={"field1":1,"field1":2}
      $table = get("table");
      $where = getJSON("where");
      $sql = buildSELECT($table, $where);
      $rs = $db->query( $sql );
      if( $rs ){
        while ($row = $rs->fetch_object()){
          $result[] = $row;
        }
        if( empty($result) ){
          $result = array(
            "message" => "empty result set "
          );
        }
      } else {
        $result = array(
          "error" => "query fail"
        );
      }
      break;
    case "delete";
      //db.php?token=ESEMPIODITOKENVALIDO&action=delete&table=tablename&where={"field1":1,"field1":2}
      $table = get("table");
      $where = getJSON("where");
      $sql = buildDELETE($table, $where);
      $rs = $db->query( $sql );
      if( $rs ){
        $result = array(
          "message" => "{$db->affected_rows} row(s) deleted"
        );
      } else {
        $result = array(
          "error" => "query fail"
        );
      }
      break;
    default:
    $result = array(
      "error" => "action undefined"
    );
  }
} catch ( Exception $e) {
  $result = array(
    "error" => $e->getMessage()
  );
}


$db->close();
echo json_encode( $result );
