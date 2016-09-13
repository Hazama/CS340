<?php
//Turn on error reporting
    ini_set('display_errors', 'On');

    $servername = "oniddb.cws.oregonstate.edu";
    $username = "";
    $password = "";
    $dbname = "mcinnisb-db";

    //Connects to database
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
    <title>Admit Patient</title>
    <link rel="stylesheet" href="style.css" type="text/css">
  </head>
  <body>
  <h1>Front Desk - Admit New Patient</h1>

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

<div id="admitPatient">
  <h2>Admit New Patient</h2>
    <form method="post" action="#">
      <fieldset>
        <legend>New Patient Information:</legend>
        <label for="fname">First Name: </label>
        <input type="text" name="fname" id="fname">
        <label for="lname">Last Name: </label>
        <input type="text" name="lname" id="lname">
        <label for="birthdate">Birthdate (yyyy/mm/dd): </label>
        <input type="text" name="birthdate" id="birthdate"><br/><br/>
        <label for="weight">Weight (lbs): </label>
        <input type="text" name="weight" id="weight">
        <label for="height">Height (inches): </label>
        <input type="text" name="height" id="height">
        <label for "sex">Sex: </label>
        <select name="sex">
        	<option value="F">Female</option>
        	<option value="M">Male</option>
        	<option value="O">Other</option>
        </select>
      </fieldset>
      <br/>
      <fieldset>
      	<legend>Medical History</legend>
        <?php
          if(!($stmt = $mysqli->prepare("SELECT description FROM medical_record"))){
            echo "Prepare failed: (". $stmt->errno.") ".$stmt->error;
          }

          if(!($stmt->execute())){
            echo "Execute failed: (". $stmt->errno.") ".$stmt->error;
          }
      
          if(!($stmt->bind_result($description))){
            echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }

          while($stmt->fetch()){
            echo "<input type=\"checkbox\" name=\"history[]\" value=\"" . $description . "\">" . $description ."<br/>";
          }
        ?>
      	<!--
        <input type="checkbox" name="history[]" value="TOBACCO USE">Tobacco Use
      	<input type="checkbox" name="history[]" value="ALCOHOL USE">Alcohol Use<br/>
      	<input type="checkbox" name="history[]" value="CANCER">Cancer
      	<input type="checkbox" name="history[]" value="ARTHRITIS">Arthritis<br/>
      	<input type="checkbox" name="history[]" value="STROKE">Stroke
      	<input type="checkbox" name="history[]" value="DIABETES">Diabetes<br/>
      	<input type="checkbox" name="history[]" value="AUTOIMMUNE">Autoimmune
      	<input type="checkbox" name="history[]" value="HEART ATTACK">Heart Attack<br/>
        <input type="checkbox" name="history[]" value="HEART DISEASE">Heart Disease-->
      </fieldset>
      <br/>
      <fieldset>
      	<legend>Patient Status</legend>
      	<input type="radio" name="pat_status" value="inpatient">Inpatient<br/>
      	<input type="radio" name="pat_status" value="outpatient">Outpatient<br/>
      </fieldset>
      <br/>
      <input type="reset" value="Reset">
      <input type="submit" name="submit" id="newPatient" value="Admit New Patient">
    </form>
    </div>
    <div>
      <a href="http://web.engr.oregonstate.edu/~mcinnisb/front_desk/mainpage.html">Back</a>
    </div>
<?php
  if (isset($_POST['submit'])) {
    $fname = strtoupper($_POST['fname']);
    $lname = strtoupper($_POST['lname']);
    $pstat = strtoupper($_POST['pat_status']);
    $admit = date("Y-m-d"); //gets the current date
    //$checkBox = implode(',', $_POST['history']); 
    $count = count($_POST['history']);
    
    if (!($stmt = $mysqli->prepare("INSERT INTO patients (fname, lname, birthdate, weight, height, sex, pat_status, admit_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"))){
    	echo "Prepare failed: (". $stmt->errno.") ".$stmt->error;
    }

    if(!($stmt->bind_param('sssiisss', $fname, $lname, $_POST['birthdate'], $_POST['weight'], $_POST['height'], $_POST['sex'], $pstat, $admit))){
    	echo "Bind failed: (". $stmt->errno.") ".$stmt->error;
    }

    if(!($stmt->execute())){
    	echo "Execute failed: (". $stmt->errno.") ".$stmt->error; 
    }
    else {
    	echo "1 record added";
    }

    if ($count != 0){
    	if (!($stmt = $mysqli->prepare("SELECT id FROM patients WHERE fname='$fname' AND lname='$lname'"))){
    	    echo "Prepare failed: (". $stmt->errno.") ".$stmt->error;
        }
    
        if(!($stmt->execute())){
    	    echo "Execute failed: (". $stmt->errno.") ".$stmt->error; 
        }
        else{
          $res = $stmt->get_result();
          $row = $res->fetch_assoc();
          $pid = $row['id'];
        }
        
        $vals = '';
        
        for ($i=0; $i < $count; $i++){
        	$vals .= ' description=' . '\'' . $_POST['history'][$i] . '\' OR';
        } 

        $vals = rtrim($vals, 'OR');
        
        $sql = "SELECT id FROM medical_record WHERE" . $vals;
        
        if (!($stmt = $mysqli->prepare($sql))){
      	    echo "Prepare failed: (". $mysqli->errno.") ".$mysqli->error;
        }
        
        if (!($stmt->execute())){
        	echo "Execute failed: (". $stmt->errno.") ".$stmt->error;
        }

        if (!($stmt->bind_result($id))){
        	echo "Bind result failed: (". $stmt->errno.") ".$stmt->error;
        }

        $vals = '';

        while ($stmt->fetch()){
        	$vals .= '(' . $pid . ', ' . $id . '), ';
        }

        $vals = rtrim($vals, ', ');

        $sql = "INSERT INTO patient_medical_record (pid, mrid) VALUES" . $vals;
        
        if (!($stmt = $mysqli->prepare($sql))){
        	echo "Prepare failed: (". $mysqli->errno.") ".$mysqli->error;
        }

        if (!($stmt->execute())){
            echo "Execute failed: (". $stmt->errno.") ".$stmt->error;	
        }
    }

    $mysqli->close();
  }
?>
  </body>
</html>
