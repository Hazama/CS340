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

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Front Desk</title>
	<link rel="stylesheet" href="style.css" type="text/css">
  </head>
  <body>
  <h1>Front Desk - Assign Doctor to Patient</h1>
   <nav>
  <h3>Front Desk</h3>
  <ul>
        <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/front_desk/mainpage.html">FrontDesk Main</a></li>
        <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/front_desk/new_patient.php">New Patient</a></li>
        <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/front_desk/exist_patient.php">Existing Patient</a></li>
        <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/front_desk/SearchPatient.php">Search Patients</a></li>
        <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/front_desk/SearchStaff.php">Search Staff</a></li>
        <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/front_desk/AssignDoc.php">Assign Doctor</a></li>
      </ul>
  <h3>Medical Staff</h3>
  <ul>
          <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/medical_main.html">Medical Staff Main</a></li>
          <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/patient_chart.php">Patient Charts</a></li>
          <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/assign_lab_test.php">Order Lab Test</a></li>
          <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/SearchLab.php">Search Lab Tests</a></li>
          <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/EditLabRes.php">Update Lab Results</a></li>
          <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/add_medical_record.php">Add to Medical Record</a></li>
          <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/update_patient_record.php">Update Patient Record</a></li>
        </ul>
  <h3>Administration</h3>
  <ul>
        <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/admin/admin_main.html">Administration Main</a></li>
        <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/admin/SearchDepartment.php">Search/Add Departments</a></li>
        <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/admin/EditDepartment.php">Edit Departments</a></li>
        <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/admin/ASearchStaff.php">Search Staff</a></li>
        <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/admin/ASearchStaff.php">Search Staff</a></li>
        <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/admin/AdminStaff.php">Add/Edit Staff</a></li>
        <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/admin/add_lab_test.php">Add Lab Test</a></li>
      </ul>
  <h3>Common</h3>
  <ul>
    <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/dept_phone.php">Department Phone Numbers</a></li>
  </ul>
  </nav>
  <div>
  <table id = "patient_staffpair">
		<tr>
			<td>Current Staff and Patient pairs</td>
		</tr>
	<tr>
			<td>Staff Name</td>
			<td>Patient Name</td>
			<td>Description</td>
			<td>Date Assigned</td>
	</tr>	
 <?php
if(!($stmt = $mysqli->prepare("SELECT hospital_staff.fname, hospital_staff.lname, patients.fname, patients.lname, description, proc_date FROM
patient_staff_history INNER JOIN patients on patient_staff_history.pid = patients.id
INNER JOIN hospital_staff ON patient_staff_history.sid = hospital_staff.id"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($sfname, $slname, $pfname, $plname, $desc, $dateA)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
 echo "<tr><td>" . $sfname . ' ' . $slname . "</td><td>" . $pfname . ' ' . $plname . "</td><td>" 
 . $desc . "</td><td>" . $dateA . "</td></tr>";
}
$stmt->close();
?>
</table>		
</br>
</br>		
	<form method="post" action="http://web.engr.oregonstate.edu/~mcinnisb/front_desk/addpsppair.php"> 
	<fieldset>
	<legend>Assign Staff</legend>
	<label>Staff:<select name="staffDoc">
	<?php
if(!($stmt = $mysqli->prepare("SELECT id, fname, lname, title FROM hospital_staff"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $fname, $lname, $title)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $fname . ' ' . $lname . ' - ' . $title .'</option>\n';
}
$stmt->close();
?>
</select>
 </label>
<label>Patient:<select name="patient">

<?php
if(!($stmt = $mysqli->prepare("SELECT id, fname, lname FROM patients"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $fname, $lname)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $fname . ' ' . $lname .'</option>';
}
$stmt->close();
?>
</select>
</label>
</br>
</br>
<label>Description:<input type="text" name="desc" size="20" maxlength="100"></label>
<label>Date:<input type="date" name="cdate" size="20" maxlength="100"></label>
</fieldset>
<input type="submit" value="Submit">
</form>
</div>
  <div>
  <a href="http://web.engr.oregonstate.edu/~mcinnisb/front_desk/mainpage.html">Back</a>
  </div>
</body>
</html>
