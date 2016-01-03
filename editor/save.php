<?php
if (isset($_GET['file']) && isset($_POST)) {
    $table = preg_replace("/[^A-Za-z0-9]/", '', $_GET['file']);
    if ($table == 'login') exit;
    require 'conn.php';
    $res = $conn->Query("SHOW TABLES LIKE '".$table."'");
    if ($res->num_rows > 0) {
        exists:
        echo 'Succesfully updated:';
foreach ($_POST as $e => $v) {
	$result = isset($_POST[$e]) ? html_entity_decode($_POST[$e]) : 'Change me';
	$result = preg_replace("/<br>$/", "", $result);
	$result = $conn->real_escape_string($result);
	$e_escape = $conn->real_escape_string($e);
    $table_num = $conn->Query('SELECT * FROM '.$table.' WHERE elementId="'.$e_escape.'"');
    if (mysqli_num_rows($table_num) > 0) {
        $sql = "UPDATE " . $table . " SET content='".$result."' WHERE elementId='".$e_escape."'";
        if ($conn->query($sql) === TRUE) {
            echo " ".$e_escape;
        } else {
            echo " Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $sql = "INSERT INTO ".$table." (elementId, content) VALUES ('".$e_escape."','".$result."')";
        if ($conn->query($sql) === TRUE) {
            echo " ".$e_escape;
        } else {
            echo " Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
$conn->close();

    } else {
        $conn->Query("create table ".$table." ( elementId text, content text );");
        goto exists;
    }
}
?>