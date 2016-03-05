<?php
include 'conn.php';
$user = $conn->real_escape_string($_POST['username']);
$pass = $_POST["password"];
$sql1 = "SELECT * FROM login WHERE userid = '$user'";
$result = $conn->query($sql1);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
		$hash = $row['password'];
		if(password_verify($pass, $hash) == true){
			session_start();
			$_SESSION['user'] = $user;
			header('Location: '.'index.php');
		}else {
			header('Location: '.'index.php?msg=Wrong%20username%20or%20password');
		}
	}else {
		header('Location: '.'index.php?msg=Wrong%20username%20or%20password');
	}
$conn->close();
?>