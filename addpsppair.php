<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$servername = "oniddb.cws.oregonstate.edu";
$username = "";
$password = "";
$dbname = "mcinnisb-db";

$mysqli = new mysqli($servername, $username, $password, $dbname);
//Checks connection to database
if ($mysqli->connect_errno){
    die("Connection failed: (" . $mysqli->connect_errno.")".$mysqli->connect_error);
}
?>

<?php
if(!($stmt = $mysqli->prepare("INSERT INTO patient_staff_history(pid, sid, description, proc_date) VALUES (?,?,?,?)"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("ssss", $_POST['patient'], $_POST['staffDoc'], $_POST['desc'], $_POST['cdate']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Doctor successfully assigned.";
}
?>