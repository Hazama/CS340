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
  <h1>Front Desk - Search Staff</h1>
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
      </ul>>
  <h3>Common</h3>
  <ul>
    <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/dept_phone.php">Department Phone Numbers</a></li>
  </ul>
  </nav>
 <div id="SP">
 <div>
	<table id = "staff_table">
		<tr>
			<td>Staff</td>
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
$sq = "'";
$sq = "'";
if($_POST['sid'] == '')
{$filter[] = " (hospital_staff.id LIKE '%' or hospital_staff.id is NULL) ";}
else
{$filter[] = " hospital_staff.id = " . $_POST['sid']; }
if($_POST['fname'] == '')
{$filter[] = " (fname LIKE '%' or fname is NULL) ";}
else
{$filter[] = " fname = " . $sq . $_POST['fname'] . $sq;}
if($_POST['lname'] == '')
{$filter[] = " (lname LIKE '%' or lname is NULL) ";}
else
{$filter[] = " lname = " . $sq . $_POST['lname'] . $sq; }
if($_POST['title'] == '')
{$filter[] = " (title LIKE '%' or title is NULL) ";}
else
{$filter[] = " title = " . $sq . $_POST['title'] . $sq;}
if($_POST['hdate'] == '')
{$filter[] = " (hire LIKE '%' or hire is NULL) ";}
else
{$filter[] = " hire = " . $sq . $_POST['hdate'] . $sq; }
if($_POST['salary'] == '')
{$filter[] = " (salary LIKE '%' or salary is NULL) ";}
else
{$filter[] = " salary = " . $sq . $_POST['salary'] . $sq; }
if($_POST['did'] == '')
{$filter[] = " (department.id LIKE '%' or department.id is NULL) ";}
else
{$filter[] = " department.id = " . $sq . $_POST['did'] . $sq;}
$query = "SELECT hospital_staff.id, fname, lname, title, hire, salary, department.name FROM (hospital_staff INNER JOIN department ON dept = department.id)";
$query .= " WHERE " . implode(" AND ", $filter);
if(!($stmt = $mysqli->prepare($query))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($sid, $fname, $lname, $title, $hire, $salary, $dept)){
echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
echo "<tr><td>" . $sid . "</td><td>" . $fname . "</td><td>" . $lname . "</td><td>" . $title . "</td><td>"
. $hire . "</td><td>" . $salary . "</td><td>" . $dept . "</td></tr>";
}
$stmt->close();
?>
	</table>
</div>
<div>
  <a href="http://web.engr.oregonstate.edu/~mcinnisb/admin/ASearchStaff.php">Back</a>
  </div>
</body>
</html>
	</table>
</div>
<div>
  <a href="http://web.engr.oregonstate.edu/~gossje/ASearchStaff.php">Back</a>
  </div>
</body>
</html>
