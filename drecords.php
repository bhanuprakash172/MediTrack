<?php
 session_start();
 if(!$_SESSION["userID"])
 {
   header("Location:doctor.login.php");
 }
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="apple-touch-icon" sizes="180x180" href="Resource/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="Resource/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="Resource/favicon/favicon-16x16.png">
    <link rel="manifest" href="Resource/favicon/site.webmanifest">
    <link rel="stylesheet" type="text/css" href="css/drecords_style.css">

<style>
	.navigation-bar a{
		font-size: 16px;
	}
  
  </style>

    <title>Records</title>
  </head>
  <body>


    <div class="top_img"><img src="Resource/logo250.png"></div>
    <div class="navigation-bar" style="text-align: center">
      <a href="ddashboard.php" >Home</a>
      <a href="drecords.php">Records </a>
      <a href="dsearch.php">Search</a>
      <a href="dinsert.php">Insert</a>
      <a class='logout' href="logout.php">Logout</a>
    </div>

    <?php
      require "connection.php";

      $uid=$_SESSION["userID"];

      #Consultation
      $sql="SELECT CONCAT(p.SSN,d.SSN,DATE_FORMAT(c.Date_Time,'%Y%m%d%s%i%k')) AS Reference, DATE_FORMAT(c.Date_Time,'%M %D %Y %r') AS Date_Time, CONCAT(p.F_Name,' ',p.L_Name) AS patient_fullname,Patient_SSN, Complains, Findings, Treatments, Allergies FROM consultation c,patient p, doctor d WHERE Doctor_SSN=? AND p.SSN=Patient_SSN AND Doctor_SSN=d.SSN";
      $stmt= mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location:drecords.php?error=sqlerror");
      }
      else {
        mysqli_stmt_bind_param($stmt, "s", $uid);
        mysqli_stmt_execute($stmt);
        $result= mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result)>0)
        {
          echo "<div class='welcome'><h2 class='mssg'> Counsultation Records </h2></div>
          <div class='table_box'>
            <table class='content-table'>
              <thead>
              <tr>
              <th>Date & Time</th>
              <th>Patient Name</th>
              <th>Patient ID</th>
              <th>Complains</th>
              <th>Findings</th>
              <th>Treatments</th>
              <th>Allergies</th>
              <th>Reference No</th>
              </tr>
              </thead>

          ";

        while ($row = mysqli_fetch_assoc($result)) {
          $ref=$row["Reference"];
          $dt=$row["Date_Time"];
          $dfullname=$row["patient_fullname"];
          $comp=$row["Complains"];
          $find=$row["Findings"];
          $treat=$row["Treatments"];
          $alg=$row["Allergies"];
          $dssn=$row["Patient_SSN"];

          echo "
          <tbody>
          <tr>
            <td>$dt</td>
            <td>$dfullname</td>
            <td>$dssn</td>
            <td>$comp</td>
            <td>$find</td>
            <td>$treat</td>
            <td>$alg</td>
            <td>$ref</td>
          </tr>
          ";

        }
        echo "</tbody></table>

        </div>";
        }
        elseif (mysqli_num_rows($result)==0) {
          echo "<div class='welcome'><h2 class='mssg'> No Consultation Records Found </h2></div>";
        }
      }

      #Surgery
      $sql="SELECT CONCAT(p.SSN,d.SSN,DATE_FORMAT(c.Date_Time,'%Y%m%d%s%i%k')) AS Reference, DATE_FORMAT(c.Date_Time,'%M %D %Y %r') AS Date_Time, CONCAT(p.F_Name,' ',p.L_Name) AS patient_fullname, Patient_SSN, Description, Complications, Allergies FROM operation c,patient p, doctor d WHERE Doctor_SSN=? AND p.SSN=Patient_SSN AND Doctor_SSN=d.SSN";
      $stmt= mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location:drecords.php?error=sqlerror");
      }
      else {
        mysqli_stmt_bind_param($stmt, "s", $uid);
        mysqli_stmt_execute($stmt);
        $result= mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result)>0)
        {
          echo "<div class='welcome'><h2 class='mssg'> Surgery Records </h2></div>
          <div class='table_box'>
            <table class='content-table'>
              <thead>
              <tr>
              <th>Date & Time</th>
              <th>Patient Name</th>
              <th>Patient ID</th>
              <th>Description</th>
              <th>Complications</th>
              <th>Allergies</th>
              <th>Reference No</th>
              </tr>
              </thead>
          ";

        while ($row = mysqli_fetch_assoc($result)) {
          $ref=$row["Reference"];
          $dt=$row["Date_Time"];
          $dfullname=$row["patient_fullname"];
          $desc=$row["Description"];
          $compl=$row["Complications"];
          $alg=$row["Allergies"];
          $dssn=$row["Patient_SSN"];

          echo "
          <tbody>
          <tr>
            <td>$dt</td>
            <td>$dfullname</td>
            <td>$dssn</td>
            <td>$desc</td>
            <td>$compl</td>
            <td>$alg</td>
            <td>$ref</td>
          </tr>
          ";

        }
        echo "</tbody></table></div>";
        }
        elseif (mysqli_num_rows($result)==0) {
          echo "<div class='welcome'><h2 class='mssg'> No Surgery Records Found </h2></div>";
        }
      }

      #Diagnosis
      $sql="SELECT CONCAT(p.SSN,d.SSN,DATE_FORMAT(c.Date_Time,'%Y%m%d%s%i%k')) AS Reference, DATE_FORMAT(c.Date_Time,'%M %D %Y %r') AS Date_Time, CONCAT(p.F_Name,' ',p.L_Name) AS patient_fullname,Patient_SSN, c.Diagnosis_Name, Description, Complications, Allergies FROM diagnosis c,patient p, doctor d WHERE Doctor_SSN=? AND p.SSN=Patient_SSN AND Doctor_SSN=d.SSN";
      $stmt= mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location:precords.php?error=sqlerror");
      }
      else {
        mysqli_stmt_bind_param($stmt, "s", $uid);
        mysqli_stmt_execute($stmt);
        $result= mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result)>0)
        {
          echo "<div class='welcome'><h2 class='mssg'> Diagnosis Records </h2></div>
          <div class='table_box'>
            <table class='content-table'>
              <thead>
              <tr>
              <th>Date & Time</th>
              <th>Patient Name</th>
              <th>Patient ID</th>
              <th>Diagnosis Name</th>
              <th>Description</th>
              <th>Complications</th>
              <th>Allergies</th>
              <th>Reference No</th>
              </tr>
              </thead>

          ";

        while ($row = mysqli_fetch_assoc($result)) {
          $ref=$row["Reference"];
          $dt=$row["Date_Time"];
          $dfullname=$row["patient_fullname"];
          $dn=$row["Diagnosis_Name"];
          $desc=$row["Description"];
          $compl=$row["Complications"];
          $alg=$row["Allergies"];
          $dssn=$row["Patient_SSN"];

          echo "
          <tbody>
          <tr>
            <td>$dt</td>
            <td>$dfullname</td>
            <td>$dssn</td>
            <td>$dn</td>
            <td>$desc</td>
            <td>$compl</td>
            <td>$alg</td>
            <td>$ref</td>
          </tr>
          ";

        }
        echo "</tbody></table></div>";
        }
        elseif (mysqli_num_rows($result)==0) {
          echo "<div class='welcome'><h2 class='mssg'> No Diagnosis Records Found </h2></div>";
        }
      }
      $uid = $_SESSION["userID"];
$sql = "SELECT doctor_id,  patient_id, date, time, description, file_path FROM images WHERE doctor_id = ?";

$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: drecords.php?error=sqlerror");
    exit();
}

mysqli_stmt_bind_param($stmt, "s", $uid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Display image details
if (mysqli_num_rows($result) > 0) {
    echo "<div class='welcome'><h2 class='mssg'> Uploaded Image Details </h2></div>";
    echo "<div class='table_box'>";
    echo "<table class='content-table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Doctor ID</th>";
    echo "<th>Patient ID</th>";
    echo "<th>Date</th>";
    echo "<th>Time</th>";
    echo "<th>Description</th>";
    echo "<th>Image</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($row = mysqli_fetch_assoc($result)) {
        $doctor_id = $row["doctor_id"];
        $patient_id = $row["patient_id"];
        $date = $row["date"];
        $time = $row["time"];
        $description = $row["description"];
        $image_path = $row["file_path"];

        echo "<tr>";
        echo "<td>$doctor_id</td>";
        echo "<td>$patient_id</td>";
        echo "<td>$date</td>";
        echo "<td>$time</td>";
        echo "<td>$description</td>";
        echo "<td><img src='$image_path' alt='Uploaded Image' onclick='zoomImage(this)' style='max-width: 100px; cursor: pointer;'></td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    echo "<div class='welcome'><h2 class='mssg'> No Uploaded Images Found </h2></div>";
}

// Close the prepared statement and database connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!-- JavaScript to handle image zoom functionality -->
<script>
    function zoomImage(img) {
        // Create a modal element for image zoom
        var modal = document.createElement('div');
        modal.style.position = 'fixed';
        modal.style.zIndex = '999';
        modal.style.left = '0';
        modal.style.top = '0';
        modal.style.width = '100%';
        modal.style.height = '100%';
        modal.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
        modal.style.display = 'flex';
        modal.style.justifyContent = 'center';
        modal.style.alignItems = 'center';

        // Create an image element within the modal
        var zoomedImage = document.createElement('img');
        zoomedImage.src = img.src;
        zoomedImage.style.maxWidth = '90%';
        zoomedImage.style.maxHeight = '90%';

        // Add the image to the modal
        modal.appendChild(zoomedImage);

        // Append the modal to the document body
        document.body.appendChild(modal);

        // Close the modal on click outside the image
        modal.onclick = function() {
            document.body.removeChild(modal);
        };
    }
</script>

      


    <div class="footer">
    </div>
  </body>
</html>
