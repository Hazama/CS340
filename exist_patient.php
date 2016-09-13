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
    <title>Update Patient</title>
	<link rel="stylesheet" href="style.css" type="text/css">

  </head>
  <body>
  <h1>Front Desk - Update Patient</h1>
  <div width="100%">
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
        <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/admin/AdminStaff.php">Add/Edit Staff</a></li>
        <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/admin/add_lab_test.php">Add Lab Test</a></li>
      </ul>
  <h3>Common</h3>
  <ul>
    <li><a href="http://web.engr.oregonstate.edu/~mcinnisb/dept_phone.php">Department Phone Numbers</a></li>
  </ul>
  </nav>
  
  <div float="left" width="70%">
  <div id="SP" float="left" width="70%">
  <h2>Search Patients</h2>
  <form action="#" method="post">
	<fieldset>
	<legend>Search parameters</legend>
	<label>Patient ID:<input type="text" name="pid" size="20" maxlength="100"></label>
	<label>First Name:<input type="text" name="fname" size="20" maxlength="100"></label>
	<label>Last Name:<input type="text" name="lname" size="20" maxlength="100"></label>
	</br>
	<label>Height:<input type="text" name="height" size="20" maxlength="100"></label>
	<label>Weight:<input type="number" name="weight" size="20" maxlength="100"></label>
	<label>Sex:
	<select name="sex">
	    <option selected diabled hidden style='display:none' value=''>
		<option value="M">Male</option>
		<option value="F">Female</option>
		<option value="O">Other</option>
	</select></label>

	</br>
	<label>Admit Date:<input type="date" name="adate" size="20" maxlength="100"></label>
	<label>Birthdate:<input type="date" name="bdate" size="20" maxlength="100"></label>
	<label>Status:<select name="pstat">
      <option selected disabled hidden style='display: none' value=''></option>
	  <option value="INPATIENT">Inpatient</option>
	  <option value="OUTPATIENT">Outpatient</option>
	</select>
	</label>
	</br>
	<label>Discharge Date:<input type="date" name="ddate" size="20" maxlength="100"></label>
	</fieldset>
  <input type="reset" value="Reset">
  <input type="submit" name="submit" value="Submit">
  </form>
  </div>
<?php
    //grabs data from text input (if populated)
    if (isset($_POST['submit'])) {
      
      $vals = '';
      
      if (!empty($_POST['pid'])){
        $vals .= ' id=' . $_POST['pid'] . 'AND ';
      }

      if (!empty($_POST['fname'])){
        $vals .= ' fname=' .'\'' . $_POST['fname'] . '\'' .'AND ';
      }

      if (!empty($_POST['lname'])){
        $vals .= ' lname=' .'\'' . $_POST['lname'] . '\'' .'AND ';
      }

      if (!empty($_POST['height'])){
        $vals .= ' height=' . $_POST['height'] . 'AND ';
      }

      if (!empty($_POST['weight'])){
        $vals .= ' weight=' . $_POST['weight'] . 'AND ';
      }

      if (!empty($_POST['sex'])){
        $vals .= ' sex=' . '\'' .$_POST['sex'] . '\'' .'AND ';
      }

      if (!empty($_POST['adate'])){
        $vals .= ' admit_date=' .'\'' . $_POST['adate'] .'\'' . 'AND ';
      }

      if (!empty($_POST['bdate'])){
        $vals .= ' birthdate=' .'\'' . $_POST['bdate'] .'\'' . 'AND ';
      }

      if (!empty($_POST['pstat'])){
        $vals .= ' pat_status=' .'\'' . $_POST['pstat'] . '\'' .'AND ';
      }

      if (!empty($_POST['ddate'])){
        $vals .= ' discharge=' .'\'' . $_POST['ddate'] .'\'' . 'AND ';
      }
      
      if (empty($vals)){
        echo "<script type= \"text/javascript\">alert(\"The text fields can\'t be empty!\");</script>";
        exit(0);
      }

      $vals = rtrim($vals, 'AND ');
      //search 'patients' MySQL table and display results in html table 
      $sql = "SELECT id, fname, lname, birthdate, height, weight, sex, pat_status, admit_date, discharge FROM patients WHERE" . $vals;

      echo "<div id=\"searchResults\" float=\"left\" width=\"70%\"><table>\n<tr>\n<th>ID</th>\n<th>First Name</th>\n<th>Last Name</th>\n<th>Birth Date</th>\n<th>Height</th>\n<th>Weight</th>\n<th>Sex</th>\n<th>Status</th>\n<th>Admit Date</th>\n<th>Discharge Date</th>\n</tr>";

      if (!($stmt = $mysqli->prepare($sql))){
        echo "Prepare failed: (". $mysqli->errno.") ".$mysqli->error;
      }

      if (!($stmt->execute())){
        echo "Execute failed: (". $stmt->errno.") ".$stmt->error;
      }

      if (!($stmt->bind_result($id, $fname, $lname, $birthdate, $height, $weight, $sex, $pat_status, $admit_date, $discharge))){
        echo "Bind result failed: (". $stmt->errno.") ".$stmt->error;
      }

      while ($stmt->fetch()){
        echo "<form method=\"POST\" action=\"http://web.engr.oregonstate.edu/~mcinnisb/front_desk/update_patient.php\"><tr>\n<td><input type=\"text\" name=\"up_id\" size=\"3\" value=\"" . $id . "\" readonly=\"readonly\"></td>\n<td><input type=\"text\" name=\"up_fname\" size=\"10\" value=\"" . $fname . "\"></td>\n<td><input type=\"text\" name=\"up_lname\" size=\"10\" value=\"" . $lname . "\"></td>\n<td><input type=\"text\" name=\"up_birth\" size=\"10\" value=\"" . $birthdate . "\"></td>\n</td>\n<td><input type=\"text\" name=\"up_height\" size=\"3\" value=\"" . $height . "\"></td>\n</td>\n<td><input type=\"text\" name=\"up_weight\" size=\"4\" value=\"" . $weight . "\"></td>\n</td>\n<td><input type=\"text\" name=\"up_sex\" size=\"2\" value=\"" . $sex . "\"></td>\n</td>\n<td><input type=\"text\" name=\"up_pat_status\" size=\"10\" value=\"" . $pat_status . "\"></td>\n</td>\n<td><input type=\"text\" name=\"up_admit_date\" size=\"10\" value=\"" . $admit_date . "\"></td>\n</td>\n<td><input type=\"text\" name=\"up_discharge\" size=\"10\" value=\"" . $discharge . "\"></td>\n<td><input type=\"submit\" name=\"update\" value=\"Update\"></td></tr></form>";
      }
      
      echo "</table></div>";
    }

    ?>
    </div>
  <div>
  <a href="http://web.engr.oregonstate.edu/~mcinnisb/front_desk/mainpage.html">Back</a>
  </div>
  
   </div>
  </body>
</html>
