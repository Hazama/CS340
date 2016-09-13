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
			<td>Filtered Departments</td>
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
$sq = "'";
if($_POST['name'] == '')
{$filter[] = " (name LIKE '%' or name is NULL) ";}
else
{$filter[] = " name = " . $sq . $_POST['name'] . $sq;}
if($_POST['bld'] == '')
{$filter[] = " (bldg LIKE '%' or bldg is NULL) ";}
else
{$filter[] = " bldg = " . $sq . $_POST['bld'] . $sq;}
if($_POST['pnum'] == '')
{$filter[] = " (phone LIKE '%' or phone is NULL) ";}
else
{$filter[] = " phone = " . $sq . $_POST['pnum'] . $sq; }
if($_POST['bud'] == '')
{$filter[] = " (ann_budget LIKE '%' or ann_budget is NULL) ";}
else
{$filter[] = " ann_budget = " . $sq . $_POST['bud'] . $sq;}
if($_POST['exp'] == '')
{$filter[] = " (ann_expend LIKE '%' or ann_expend is NULL) ";}
else
{$filter[] = " ann_expend = " . $sq . $_POST['exp'] . $sq;}
$query = "SELECT id, name, bldg, phone, ann_budget, ann_expend
FROM department";
$query .= " WHERE " . implode(" AND ", $filter);
if(!($stmt = $mysqli->prepare($query))){
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
<div>
  <a href="http://web.engr.oregonstate.edu/~mcinnisb/admin/SearchDepartment.php">Back</a>
  </div>
</body>
</html>
