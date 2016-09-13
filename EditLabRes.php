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
  <h1>Medical Staff - Edit Lab Results</h1>
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
        <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/admin/AdminStaff.php">Add/Edit Staff</a></li>
        <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/admin/add_lab_test.php">Add Lab Test</a></li>
      </ul>
  <h3>Common</h3>
  <ul>
    <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/dept_phone.php">Department Phone Numbers</a></li>
  </ul>
  </nav>
 <div id="SP">
 <div>
	<table id = "labtest_table">
		<tr>
			<td>All ordered labs</td>
		</tr>
		<tr>
			<td>Patient ID</td>
			<td>Lab Test ID</td>
			<td>Patient First Name</td>
			<td>Patient Last Name</td>
			<td>Lab Name</td>
			<td>Description</td>
			<td>Units</td>
			<td>Low Threshold</td>
			<td>High Threshold</td>
			<td>Result</td>
			<td>Date Ordered</td>
		</tr>
 <?php
if(!($stmt = $mysqli->prepare("SELECT patient_lab_test.pid, patient_lab_test.ltid, fname, lname, lab_test.name, lab_test.description,
lab_test.unit, lab_test.low, lab_test.high, patient_lab_test.result, patient_lab_test.test_date
FROM patients INNER JOIN patient_lab_test on patients.id = patient_lab_test.pid
INNER JOIN lab_test on patient_lab_test.ltid = lab_test.id"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($pid, $ltid, $fname, $lname, $name, $desc, $unit, $low, $high, $res, $date)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
 echo "<tr><td>" . $pid . "</td><td>" . $ltid . "</td><td>" . $fname . "</td><td>" . $lname . "</td><td>" . $name. "</td><td>" .
 $desc . "</td><td>" . $unit . "</td><td>" . $low . "</td><td>" .
 $high . "</td><td>" . $res . "</td><td>" . $date . "</td></tr>";
}
$stmt->close();
?>
</table>
</div>
  <div id="ELab">
  <h2>Edit lab results</h2>
  <p>To update a result please enter the corresponding patient ID, lab test ID, and date the test was ordered.</p>
  <form action="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/EditLab.php" method="post">
	<fieldset>
	<legend>Edit Lab</legend>
	<label>Patient ID:<input type="number" required name="pid" size="20" maxlength="100"></label>
	<label>Lab Test ID:<input type="number" required name="ltid" size="20" maxlength="100"></label>
	<label>Date:<input type="date" required name="odate" size="20" maxlength="100"></label>
	</br>
	</br>
	<label>Result:<input type="text" name="res" size="20" maxlength="100"></label>
	</fieldset>
  <input type="reset" value="Reset">
  <input type="submit" value="Submit">
  </form>
  </div>
  <div>
  <a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/medical_main.html">Back</a>
  </div>
 </div>
  </body>
</html>
