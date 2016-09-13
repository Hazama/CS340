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
  <h2>Patient Chart</h2>
  <?php
  if (!($stmt = $mysqli->prepare("SELECT fname, lname, birthdate, weight, height, sex, pat_status, admit_date FROM patients WHERE id=?"))){
      echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!($stmt->bind_param('i', $_POST['patient']))){
      echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!$stmt->execute()){
      echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
    }
    
    if(!$stmt->bind_result($fname, $lname, $birthdate, $weight, $height, $sex, $pstat, $admit)){
      echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
    }

    $stmt->store_result();
    $stmt->fetch();

    echo "<h3>Patient Data for " . $fname . " " .$lname . "</h3><form method=\"post\" action=\"http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/update_record.php\"><input type=\"hidden\" name=\"patient\"\n value=\"" . $_POST['patient'] . "\"><table>\n<tr>\n<th>Birthdate: </th>\n<td>" . $birthdate . "</td>\n</tr>\n<tr>\n<th>Weight (pounds): </th>\n<td>" . $weight . "</td>\n</tr>\n<tr>\n<th>Height (inches): </th>\n<td>" . $height . "</td>\n</tr>\n<tr>\n<th>Sex: </th>\n<td>" . $sex . "</td>\n</tr>\n<tr>\n<th>Status: </th>\n<td>" . $pstat . "</td>\n</tr>\n<tr>\n<th>Admit Date: </th>\n<td>" . $admit . "</td>\n</tr>\n</table><h4>Medical History</h4>\n<table>\n<tr>\n<th>Description</th>\n</tr>";

    if (!($stmt = $mysqli->prepare("SELECT medical_record.description FROM patients INNER JOIN patient_medical_record ON patients.id=patient_medical_record.pid INNER JOIN medical_record ON patient_medical_record.mrid=medical_record.id WHERE patients.id=?"))){
      echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!($stmt->bind_param('i', $_POST['patient']))){
      echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!$stmt->execute()){
      echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
    }
    
    if(!$stmt->bind_result($description)){
      echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
    }

    while($stmt->fetch()){
      echo "<tr>\n<td>" . $description . "</td>\n</tr>";
    }
  
    echo "</table><br/><br/><input type=\"submit\" name=\"submit\" value=\"Edit Medical History\"></form>\n";

    echo "<h4>Lab Testing</h4><table><tr><th>Date</th>\n<th>Name</th>\n<th>Description</th>\n<th>Units</th>\n<th>Result</th>\n<th>Note</th></tr>";

    if (!($stmt = $mysqli->prepare("SELECT patient_lab_test.test_date, lab_test.name, lab_test.description, lab_test.unit, patient_lab_test.result, lab_test.low, lab_test.high FROM patients INNER JOIN patient_lab_test ON patients.id=patient_lab_test.pid INNER JOIN lab_test ON patient_lab_test.ltid=lab_test.id WHERE patients.id=?"))){
      echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!($stmt->bind_param('i', $_POST['patient']))){
      echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!$stmt->execute()){
      echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
    }
    
    if(!$stmt->bind_result($date, $name, $description, $unit, $result, $low, $high)){
      echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
    }

    while($stmt->fetch()){
      echo "<tr>\n<td>" . $date . "</td>\n<td>" . $name . "</td>\n<td>" . $description . "</td>\n<td>" . $unit . "</td>\n<td>" . $result . "</td>\n<td>";
      if ($result != NULL){
        if ($low != NULL && $result < $low){
          echo "<span style=\"color:red\">LOW</span></td></tr>";
        }
        elseif ($high != NULL && $result > $high){
          echo "<span style=\"color:red\">HIGH</span></td></tr>";
        }
        else {
          echo "<span>NORMAL</span></td></tr>";
        }
      }
      else {
        echo "<span></span></td></tr>";
      }
    }
  
    echo "</table>\n<form action=\"http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/EditLabRes.php\" ><input type=\"submit\" value=\"Edit Lab Test\"></form>";
    ?>
    <div>
      <a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/medical_main.html">Back</a>
    </div>
  </div>
  </body>
</html>
