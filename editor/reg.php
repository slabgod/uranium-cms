<?php
	include 'conn.php';
	$chk = $conn->Query("SHOW TABLES LIKE 'login'");
    if ($chk->num_rows == 0) {
    	$conn->Query("create table login ( userid VARCHAR(255), password char(255));");
    }
	session_start();
	$logcontent = $conn->Query("select * from login");
	//$_SESSION['user']
	
	if(isset($_POST['password'])) {
			
			if (($logcontent->num_rows == 0) OR (isset($_SESSION['user']))) {
				$user = $conn->real_escape_string($_POST['username']);
				$pass = $_POST['password'];
				$options = [    'cost' => 12,];
				$hash=password_hash($pass, PASSWORD_BCRYPT, $options);
				$sql = "INSERT INTO login (userid, password) VALUES ('".$user."', '".$hash."')";
				
				if ($conn->query($sql) === TRUE) {
					echo "New record created successfully";
					header('Location: '.'index.php?msg=User%20succesfully%20created');
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}

			} else {
				echo 'not authorized';
			}


	} elseif (($logcontent->num_rows == 0) OR (isset($_SESSION['user']))) {
		?>
<!DOCTYPE html>
<html>
    <head>
        <title>Create User</title>
    </head>
<body> 
<h1>Register</h1>
<form action="reg.php" method="post">
  <label for="username">Username:</label>
  <input id="username" name="username" type="text">
  <label for="password">Password:</label>
  <input id="password" name="password" type="password">
  <input type="submit" value="Create">
</form>
</body>
</html>
<?php
	} else {
		echo 'you must be logged in to adjust users';
	}

	?>
