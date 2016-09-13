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
    <title>Medical Staff</title>
    <link rel="stylesheet" href="style.css" type="text/css">
  </head>
  <body>
    <h1>Medical Staff</h1>
    <nav>
      <h3>Front Desk</h3>
      <ul>
    <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/front_desk/new_patient.php">New Patient</a></li>
    <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/front_desk/exist_patient.php">Existing Patient</a></li>
    <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/front_desk/SearchPatient.php">Search Patients</a></li>
    <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/front_desk/SearchStaff.php">Search Staff</a></li>
    <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/front_desk/AssignDoc.php">Assign Doctor</a></li>
  </ul>
  <h3>Medical Staff</h3>
  <ul>
      <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/patient_chart.php">Patient Charts</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/assign_lab_test.php">Order Lab Test</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/SearchLab.php">Search Lab Tests</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/EditLabRes.php">Update Lab Results</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/add_medical_record.php">Add to Medical Record</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/update_patient_record.php">Update Patient Record</a></li>
    </ul>
    <h3>Administration</h3>
    <ul>
      <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/admin/SearchDepartment.php">Search/Add Departments</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/admin/EditDepartment.php">Edit Departments</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/admin/ASearchStaff.php">Search Staff</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/admin/AdminStaff.php">Add/Edit Staff</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/admin/add_lab_test.php">Add Lab Test</a></li>
    </ul>
    <h3>Common</h3>
    <ul>
      <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/dept_phone.php">Department Phone Numbers</a></li>
    </ul>
  </nav>

  <div>

<?php
if(!($stmt = $mysqli->prepare("INSERT INTO department(name, bldg, phone, ann_budget, ann_expend) VALUES (?,?,?,?,?)"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("sssss", $_POST['name'], $_POST['bld'], $_POST['pnum'], $_POST['bud'], $_POST['exp']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Department successfully created.";
}
?>
 <div>
  <a href="http://web.engr.oregonstate.edu/~mcinnisb/admin/SearchDepartment.php">Back</a>
</div>
</body>
</html>
