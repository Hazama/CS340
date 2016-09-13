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
  <h1>Front Desk - Search Patients</h1>
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
 <div id="SP">
 <div>
	<table id = "patient_table">
		<tr>
			<td>All Patients</td>
		</tr>
		<tr>
			<td>PID</td>
			<td>First Name</td>
			<td>Last Name</td>
			<td>Birthday</td>
			<td>Weight</td>
			<td>Height</td>
			<td>Sex</td>
			<td>Status</td>
			<td>Admit Date</td>
			<td>Discharge Date</td>
		</tr>

 <?php
if(!($stmt = $mysqli->prepare("SELECT * FROM patients"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($pid, $fname, $lname, $birthdate, $height, $weight, $sex, $pat_status, $admit_date, $discharge)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr>\n<td>\n" . $pid . "\n</td>\n<td>\n" . $fname . "\n</td>\n<td>\n" . $lname . "\n</td>\n<td>\n" . $birthdate . "\n</td>\n<td>\n" . $height . "\n</td>\n<td>\n" . $weight . "\n</td>\n<td>\n" . $sex . "\n</td>\n<td>\n" . $pat_status . "\n</td>\n<td>\n" . $admit_date . "\n</td>\n<td>\n" . $discharge . "\n</td>\n</tr>";
}
$stmt->close();
?>
</div>
  <div id="SPat">
  <h2>Search Patients</h2>
  <form action="http://web.engr.oregonstate.edu/~mcinnisb/front_desk/FilterPatient.php" method="post">
	<fieldset>
	<legend>Search parameters</legend>
	<label>Patient ID:<input type="number" name="pid" size="20" maxlength="100"></label>
	<label>First Name:<input type="text" name="fname" size="20" maxlength="100"></label>
	<label>Last Name:<input type="text" name="lname" size="20" maxlength="100"></label>
	</br>
	</br>
	<label>Birthdate:<input type="date" name="bdate" size="20" maxlength="100"></label>
	<label>Weight:<input type="number" name="weight" size="20" maxlength="100"></label>
	<label>Height:<input type="number" name="height" size="20" maxlength="100"></label>
	</br>
	</br>
	 <label>Sex:<select name="sex">
		<option value = ""></option> 
        <option value="F">Female</option>
        <option value="M">Male</option>
        <option value="O">Other</option>
    </select>
	</label>
	<label>Status:<select name="status">
	<option value=""></option>
	<option value="inpatient">Inpatient</option>
	<option value="outpatient">Outpatient</option>
	</select>
	</label>
	<label>Admit Date:<input type="date" name="adate" size="20" maxlength="100"></label>
	<label>Discharge Date:<input type="date" name="ddate" size="20" maxlength="100"></label>
	</fieldset>
  <input type="reset" value="Reset">
  <input type="submit" value="Submit">
  </form>
  </div>
  <div>
  <a href="http://web.engr.oregonstate.edu/~mcinnisb/front_desk/mainpage.html">Back</a>
  </div>
 </div>
  </body>
</html>
