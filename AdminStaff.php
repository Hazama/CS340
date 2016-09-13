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
  <h1>Admin - View and Hire Staff</h1>
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
  	<table id = "staff_table">
		<tr>
			<td>All Staff</td>
		</tr>
		<tr>
			<td>SID</td>
			<td>First Name</td>
			<td>Last Name</td>
			<td>Title</td>
			<td>Hire Date</td>
			<td>Salary</td>
			<td>Department</td>
		</tr>
 <?php
if(!($stmt = $mysqli->prepare("SELECT hospital_staff.id, fname, lname, title, hire, salary, department.name FROM hospital_staff INNER JOIN department on dept = department.id"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($sid, $fname, $lname, $title, $hire, $salary, $dept)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr><td>" . $sid . "</td><td>" . $fname . "</td><td>" . 
 $lname . "</td><td>" . $title . "</td><td>" . $hire . "</td><td>" . $salary . 
 "</td><td>" . $dept . "</td></tr>";
}
$stmt->close();
?>
</table>

  <div id="AS">
  <h2>Add Staff</h2>
   <form action="http://web.engr.oregonstate.edu/~mcinnisb/admin/AddStaff.php" method="post">
	<fieldset>
	<legend>Staff Data</legend>
	<label>First Name:<input type="text" required name="fname" size="20" maxlength="100"></label>
	<label>Last Name:<input type="text" required name="lname" size="20" maxlength="100"></label>
	<label>Title:<input type="text" required name="title" size="20" maxlength="100"></label>
	</br>
	</br>
	<label>Hire Date:<input type="date" required name="hdate" size="20" maxlength="100"></label>
	<label>Salary:<input type="text" required name="salary" size="20" maxlength="100"></label>
	<label>Department:<select name="department">
	<?php
if(!($stmt = $mysqli->prepare("SELECT id, name FROM department"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $name)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $name . '</option>\n';
}
$stmt->close();
?>
</select>
 </label>
	</fieldset>
  <input type="reset" value="Reset">
  <input type="submit" value="Submit">
  </form>
  </div>
  
    <div id="ES">
  <h2>Edit Staff</h2>
   <form action="http://web.engr.oregonstate.edu/~mcinnisb/admin/EditStaff.php" method="post">
	<fieldset>
	<legend>Staff Data</legend>
	<label>Staff ID:<input type="number" required name="sid" size="20" maxlength="100"></label>
	<label>First Name:<input type="text" required name="fname" size="20" maxlength="100"></label>
	<label>Last Name:<input type="text" required name="lname" size="20" maxlength="100"></label>
	</br>
	</br>
	<label>Title:<input type="text" required name="title" size="20" maxlength="100"></label>
	<label>Salary:<input type="text" required name="salary" size="20" maxlength="100"></label>
	<label>Department:<select name="department">
	<?php
if(!($stmt = $mysqli->prepare("SELECT id, name FROM department"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $name)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $name . '</option>\n';
}
$stmt->close();
?>
</select>
 </label>
	</fieldset>
  <input type="reset" value="Reset">
  <input type="submit" value="Submit">
  </form>
  </div>
  <div>
  <a href="http://web.engr.oregonstate.edu/~mcinnisb/admin/admin_main.html">Back</a>
  </div>
  </body>
</html>
