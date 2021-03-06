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
    <form method="post" action="#">
      <fieldset>
        <legend>Assign Lab Test</legend>
        <h3>Select Patient</h3>
        <select name="Patient">
          <?php
          if(!($stmt = $mysqli->prepare("SELECT id, fname, lname FROM patients"))){
            echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
          }

          if(!($stmt->execute())){
            echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }

          if(!($stmt->bind_result($id, $fname, $lname))){
            echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }

          while($stmt->fetch()){
            echo '<option value=" '. $id . ' "> ' . $fname ." ". $lname . '</option>\n';
          }
          $stmt->close();
          ?>
        </select>
        <h3>Select Test</h3>
        <select name="Labtest">
          <?php
          if(!($stmt = $mysqli->prepare("SELECT id, name FROM lab_test"))){
            echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
          }

          if(!($stmt->execute())){
            echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }

          if(!($stmt->bind_result($lid, $name))){
            echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }

          while($stmt->fetch()){
            echo '<option value=" '. $lid . ' "> ' . $name . '</option>\n';
          }
          $stmt->close();
          ?>
        </select><br/><br/>
        <input type="submit" name="submit" value="Assign Test"/>
      </fieldset>
    </form>
    <?php
    if(isset($_POST['submit'])){

      $tdate = date("Y-m-d");

      if (!($stmt = $mysqli->prepare("INSERT INTO patient_lab_test (pid, ltid, test_date) VALUES (?, ?, ?)"))){
        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
      }

      if(!($stmt->bind_param('iis', $_POST['Patient'], $_POST['Labtest'], $tdate))){
        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
      }

      if(!($stmt->execute())){
        echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
      }
      else {
        echo "Lab Test Ordered";
      }
/*
      echo "<h3>Assigned Lab Tests</h3>\n<table>\n<tr>\n<th>Patient First Name</th>\n<th>Patient Last Name</th>\n<th>Lab Test</th>\n<th>Date Assigned</th>\n</tr>\n";

      if(!($stmt = $mysqli->prepare("SELECT fname, lname, name, test_date FROM patients INNER JOIN patient_lab_test ON id = pid INNER JOIN lab_test ON ltid=id WHERE pid=?"))){
        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
      }

      if(!($stmt->bind_param('i', $_POST['Labtest']))){
        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
      }

      if(!($stmt->execute())){
        echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
      }

      if(!($stmt->bind_result($fname, $lname, $name, $test_date))){
        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
      }

      while($stmt->fetch()){
        echo "<tr>\n<td>\n" . $fname . "</td>\n<td>\n" . $lname . "</td>\n<td>\n<" . $name . "/td>\n<td>\n" . $test_date . "</td>\n</tr></table>";
      }*/
    }
    ?>
    <div>
      <a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/medical_main.html">Back</a>
    </div>
  </div>
  </body>
</html>
