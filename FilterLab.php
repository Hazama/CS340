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
	<table id = "labtest_table">
		<tr>
			<td>Search Results</td>
		</tr>
		<tr>
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
$sq = "'";
if($_POST['fname'] == '')
{$filter[] = " (fname LIKE '%' or fname is NULL) ";}
else
{$filter[] = " fname = " . $sq . $_POST['fname'] . $sq;}
if($_POST['lname'] == '')
{$filter[] = " (lname LIKE '%' or lname is NULL) ";}
else
{$filter[] = " lname = " . $sq . $_POST['lname'] . $sq;}
if($_POST['labname'] == '')
{$filter[] = " (lab_test.name LIKE '%' or lab_test.name is NULL) ";}
else
{$filter[] = " lab_test.name = " . $sq . $_POST['labname'] . $sq; }
if($_POST['res'] == '')
{$filter[] = " (patient_lab_test.result LIKE '%' or patient_lab_test.result is NULL) ";}
else
{$filter[] = " patient_lab_test.result = " . $sq . $_POST['res'] . $sq;}
if($_POST['odate'] == '')
{$filter[] = " (patient_lab_test.test_date LIKE '%' or patient_lab_test.test_date is NULL) ";}
else
{$filter[] = " patient_lab_test.test_date = " . $sq . $_POST['odate'] . $sq;}
$query = "SELECT fname, lname, lab_test.name, lab_test.description,
lab_test.unit, lab_test.low, lab_test.high, patient_lab_test.result, patient_lab_test.test_date
FROM patients INNER JOIN patient_lab_test on patients.id = patient_lab_test.pid
INNER JOIN lab_test on patient_lab_test.ltid = lab_test.id";
$query .= " WHERE " . implode(" AND ", $filter);
if(!($stmt = $mysqli->prepare($query))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($fname, $lname, $name, $desc, $unit, $low, $high, $res, $date)){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
 echo "<tr><td>" . $fname . "</td><td>" . $lname . "</td><td>" . $name. "</td><td>" .
 $desc . "</td><td>" . $unit . "</td><td>" . $low . "</td><td>" .
 $high . "</td><td>" . $res . "</td><td>" . $date . "</td></tr>";
}
$stmt->close();
?>
	</table>
</div>
<div>
  <a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/SearchLab.php">Back</a>
  </div>
</body>
</html>
