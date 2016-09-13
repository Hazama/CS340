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
	<table id = "patient_table">
		<tr>
			<td>Patients</td>
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

$sq = "'";
if($_POST['pid'] == '')
{$filter[] = " (id LIKE '%' or id is NULL) ";}
else
{$filter[] = " id = " . $_POST['pid']; }

if($_POST['fname'] == '')
{$filter[] = " (fname LIKE '%' or fname is NULL) ";}
else
{$filter[] = " fname = " . $sq . $_POST['fname'] . $sq;}

if($_POST['lname'] == '')
{$filter[] = " (lname LIKE '%' or lname is NULL) ";}
else
{$filter[] = " lname = " . $sq . $_POST['lname'] . $sq; }

if($_POST['bdate'] == '')
{$filter[] = " (birthdate LIKE '%' or birthdate is NULL) ";}
else
{$filter[] = " birthdate = " . $sq . $_POST['bdate'] . $sq;}

if($_POST['weight'] == '')
{$filter[] = " (weight LIKE '%' or weight is NULL) ";}
else
{$filter[] = " weight = " . $_POST['weight']; }

if($_POST['height'] == '')
{$filter[] = " (height LIKE '%' or height is NULL) ";}
else
{$filter[] = " height = " . $_POST['height'];}

if($_POST['sex'] == '')
{$filter[] = " (sex LIKE '%' or sex is NULL) ";}
else
{$filter[] = " sex = " . $sq .  $_POST['sex'] . $sq; }

if($_POST['status'] == '')
{$filter[] = " (pat_status LIKE '%' or pat_status is NULL) ";}
else
{$filter[] = " pat_status = " . $sq . $_POST['status'] . $sq;}

if($_POST['adate'] == '')
{$filter[] = " (admit_date LIKE '%' or admit_date is NULL) ";}
else
{$filter[] = " admit_date = " . $sq . $_POST['adate'] . $sq; }

if($_POST['ddate'] == '')
{$filter[] = " (discharge LIKE '%' or discharge is NULL) ";}
else
{$filter[] = " discharge = " . $sq . $_POST['ddate'] . $sq;}


$query = "SELECT * FROM patients";

$query .= " WHERE " . implode(" AND ", $filter);

if(!($stmt = $mysqli->prepare($query))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($pid, $fname, $lname, $bdate,
$weight, $height, $sex, $status, $adate, $ddate)){
echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
echo "<tr><td>" . $pid . "</td><td>" . $fname . "</td><td>" . $lname . "</td><td>"
. $bdate . "</td><td>" . $weight . "</td><td>" . $height . "</td><td>" 
. $sex . "</td><td>" . $status . "</td><td>" . $adate . "</td><td>" . $ddate . "</td></tr>";
}
$stmt->close();
?>
	</table>
</div>
<div>
  <a href="http://web.engr.oregonstate.edu/~mcinnisb/front_desk/SearchPatient.php">Back</a>
  </div>
</body>
</html>
