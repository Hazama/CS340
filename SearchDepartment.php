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
    <title>Administration</title>
	<link rel="stylesheet" href="style.css" type="text/css">
  </head>
  <body>
  <h1>Admin - View and Create Departments</h1>
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
	<table id = "Dept_table">
		<tr>
			<td>All Departments</td>
		</tr>
		<tr>
			<td>Department ID</td>
			<td>Name</td>
			<td>Building</td>
			<td>Phone Number</td>
			<td>Budget</td>
			<td>Expenditures</td>
		</tr>
 <?php
if(!($stmt = $mysqli->prepare("SELECT id, name, bldg, phone, ann_budget, ann_expend FROM department"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $name, $bldg, $phone, $budget, $exp)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
 echo "<tr><td>" . $id . "</td><td>" . $name . "</td><td>" . $bldg. "</td><td>" .
 $phone . "</td><td>" . $budget . "</td><td>" . $exp . "</td></tr>";
}
$stmt->close();
?>
</table>
</div>
  <div id="AD">
  <h2>Add Department</h2>
  <form action="http://web.engr.oregonstate.edu/~mcinnisb/admin/AddDept.php" method="post">
	<fieldset>
	<legend>Data</legend>
	<label>Name:<input type="text" required name="name" size="20" maxlength="100"></label>
	<label>Building:<input type="text" required name="bld" size="20" maxlength="100"></label>
	<label>Phone:<input type="text" required name="pnum" size="20" maxlength="100"></label>
	</br>
	</br>
	<label>Budget:<input type="text" required name="bud" size="20" maxlength="100"></label>
	<label>Expenditures:<input type="text" required name="exp" size="20" maxlength="100"</label>
	</fieldset>
  <input type="reset" value="Reset">
  <input type="submit" value="Submit">
  </form>
  </div>
  <div>
  <a href="http://web.engr.oregonstate.edu/~mcinnisb/admin/admin_main.html">Back</a>
  </div>
    <div id="SD">
  <h2>Search Departments</h2>
  <form action="http://web.engr.oregonstate.edu/~mcinnisb/admin/SDept.php" method="post">
	<fieldset>
	<legend>Data</legend>
	<label>Name:<input type="text" name="name" size="20" maxlength="100"></label>
	<label>Building:<input type="text" name="bld" size="20" maxlength="100"></label>
	<label>Phone:<input type="text" name="pnum" size="20" maxlength="100"></label>
	</br>
	</br>
	<label>Budget:<input type="text" name="bud" size="20" maxlength="100"></label>
	<label>Expenditures:<input type="text" name="exp" size="20" maxlength="100"</label>
	</fieldset>
  <input type="reset" value="Reset">
  <input type="submit" value="Submit">
  </form>
  </div>
  <div>
  <a href="http://web.engr.oregonstate.edu/~mcinnisb/admin/admin_main.html">Back</a>
  </div>
 </div>
  </body>
</html>
