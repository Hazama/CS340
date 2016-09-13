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
        <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/admin/AdminStaff.php">Add/Edit Staff</a></li>
        <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/admin/add_lab_test.php">Add Lab Test</a></li>
      </ul>
    <h3>Common</h3>
    <ul>
    <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/dept_phone.php">Department Phone Numbers</a></li>
  </ul>
  </nav>

  <div>
    <h3>Current Medical Record Listing: </h3>
    <table>
      <tr>
        <th>Description</th>
      </tr>
    <?php
      if(!($stmt= $mysqli->prepare("SELECT description FROM medical_record"))){
        echo "Prepare failed: (". $stmt->errno.") ".$stmt->error;
      }
      if(!($stmt->execute())){
        echo "Execute failed: (". $stmt->errno.") ".$stmt->error;
      }
      
      if(!($stmt->bind_result($description))){
        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
      }

      while($stmt->fetch()){
        echo "<tr><td>" . $description . "</td></tr>";
      }
    ?>
    </table>

    <form method="post" action="#">
      <fieldset>
        <legend>Add Medical Record Desciption</legend>
        <label for="new_descrip">Description: </label>
        <input type="text" name="new_descript">
        <input type="submit" name="submit">
      </fieldset>
    </form>
    <?php
      if(isset($_POST['submit'])){
        if(!($stmt = $mysqli->prepare("INSERT INTO medical_record (description) VALUES (?)"))){
          echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!($stmt->bind_param('s', $_POST['new_descript']))){
          echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }

        if(!($stmt->execute())){
          echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }
        else {
          echo "Added to Medical Record.";
        }
      }
    ?>
    <div>
      <a href="http://web.engr.oregonstate.edu/~mcinnisb/medical_staff/medical_main.html">Back</a>
    </div>
  </div>
  </body>
</html>
