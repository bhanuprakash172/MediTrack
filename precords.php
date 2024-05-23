<?php
 session_start();
 if(!$_SESSION["userID"])
 {
   header("Location:patient.login.php");
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
    <link rel="stylesheet" type="text/css" href="css/precords_style.css">



    <title>Records</title>
  </head>
  <body>


    <div class="top_img"><img src="Resource/logo250.png"></div>
    <div class="navigation-bar" style="text-align: center">
      <a href="pdashboard.php" >Home</a>
      <a href="precords.php">Records </a>
      <a href="psearch.php">Search</a>
      <a class='logout' href="logout.php">Logout</a>
    </div>

    <?php
      require "connection.php";

      $uid=$_SESSION["userID"];

      #Consultation
      $sql="SELECT CONCAT(p.SSN,d.SSN,DATE_FORMAT(c.Date_Time,'%Y%m%d%s%i%k')) AS Reference, DATE_FORMAT(c.Date_Time,'%M %D %Y %r') AS Date_Time, CONCAT(d.F_Name,' ',d.L_Name) AS doctor_fullname,Doctor_SSN, Complains, Findings, Treatments, Allergies FROM consultation c,patient p, doctor d WHERE Patient_SSN=? AND p.SSN=Patient_SSN AND Doctor_SSN=d.SSN";
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
          echo "<div class='welcome'><h2 class='mssg'> Counsultation Records </h2></div>
          <div class='table_box'>
            <table class='content-table'>
              <thead>
              <tr>
              <th>Date & Time</th>
              <th>Doctor Name</th>
              <th>Doctor ID</th>
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
          $dfullname=$row["doctor_fullname"];
          $comp=$row["Complains"];
          $find=$row["Findings"];
          $treat=$row["Treatments"];
          $alg=$row["Allergies"];
          $dssn=$row["Doctor_SSN"];

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
      $sql="SELECT CONCAT(p.SSN,d.SSN,DATE_FORMAT(c.Date_Time,'%Y%m%d%s%i%k')) AS Reference, DATE_FORMAT(c.Date_Time,'%M %D %Y %r') AS Date_Time, CONCAT(d.F_Name,' ',d.L_Name) AS doctor_fullname,Doctor_SSN, Description, Complications, Allergies FROM operation c,patient p, doctor d WHERE Patient_SSN=? AND p.SSN=Patient_SSN AND Doctor_SSN=d.SSN";
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
          echo "<div class='welcome'><h2 class='mssg'> Surgery Records </h2></div>
          <div class='table_box'>
            <table class='content-table'>
              <thead>
              <tr>
              <th>Date & Time</th>
              <th>Doctor Name</th>
              <th>Doctor ID</th>
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
          $dfullname=$row["doctor_fullname"];
          $desc=$row["Description"];
          $compl=$row["Complications"];
          $alg=$row["Allergies"];
          $dssn=$row["Doctor_SSN"];

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
      $sql="SELECT CONCAT(p.SSN,d.SSN,DATE_FORMAT(c.Date_Time,'%Y%m%d%s%i%k')) AS Reference, DATE_FORMAT(c.Date_Time,'%M %D %Y %r') AS Date_Time, CONCAT(d.F_Name,' ',d.L_Name) AS doctor_fullname,Doctor_SSN, c.Diagnosis_Name, Description, Complications, Allergies FROM diagnosis c,patient p, doctor d WHERE Patient_SSN=? AND p.SSN=Patient_SSN AND Doctor_SSN=d.SSN";
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
              <th>Doctor Name</th>
              <th>Doctor ID</th>
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
          $dfullname=$row["doctor_fullname"];
          $dn=$row["Diagnosis_Name"];
          $desc=$row["Description"];
          $compl=$row["Complications"];
          $alg=$row["Allergies"];
          $dssn=$row["Doctor_SSN"];

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

      #Medicine Administration

      $sql="SELECT CONCAT(p.SSN,d.SSN,DATE_FORMAT(c.Date_Time,'%Y%m%d%s%i%k')) AS Reference, DATE_FORMAT(c.Date_Time,'%M %D %Y %r') AS Date_Time, CONCAT(d.F_Name,' ',d.L_Name) AS staff_fullname,Staff_SSN,d.Designation, c.Description, c.Complication,c.Medicine, c.Allergies FROM medical_adminstration c,patient p, medical_staff d WHERE Patient_SSN=? AND p.SSN=Patient_SSN AND Staff_SSN=d.SSN";
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
          echo "<div class='welcome'><h2 class='mssg'> Medical Staff Dosage Record </h2></div>
          <div class='table_box'>
            <table class='content-table'>
              <thead>
              <tr>
              <th>Date & Time</th>
              <th>Staff Name</th>
              <th>Staff SSN</th>
              <th>Designation</th>
              <th>Description</th>
              <th>Complications</th>
              <th>Medicine</th>
              <th>Allergies</th>
              <th>Reference No</th>
              </tr>
              </thead>

          ";

        while ($row = mysqli_fetch_assoc($result)) {
          $ref=$row["Reference"];
          $dt=$row["Date_Time"];
          $dfullname=$row["staff_fullname"];
          $dn=$row["Designation"];
          $desc=$row["Description"];
          $compl=$row["Complication"];
          $med=$row["Medicine"];
          $alg=$row["Allergies"];
          $dssn=$row["Staff_SSN"];

          echo "
          <tbody>
          <tr>
            <td>$dt</td>
            <td>$dfullname</td>
            <td>$dssn</td>
            <td>$dn</td>
            <td>$desc</td>
            <td>$compl</td>
            <td>$med</td>
            <td>$alg</td>
            <td>$ref</td>
          </tr>
          ";
        }
        echo "</tbody></table>
        </div>";
        }
        elseif (mysqli_num_rows($result)==0) {
          echo "<div class='welcome'><h2 class='mssg'> No Dosage Records Found </h2></div>";
        }
      }
$uid = $_SESSION["userID"];

// Prepare SQL query to fetch doctor details associated with the patient
$sql = "SELECT doctor_id,patient_id, date, time, description, file_path
        FROM images
        WHERE patient_id = ?";

$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: drecords.php?error=sqlerror");
    exit();
}

mysqli_stmt_bind_param($stmt, "s", $uid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Display doctor details associated with the patient
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
        echo "<td><img src='$image_path' alt='Uploaded Image' class='table-image' onclick='openModal(\"$image_path\", \"$description\")'></td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    echo "<div class='welcome'><h2 class='mssg'> No Uploaded Images Found </h2></div>";
}
?>

<!-- JavaScript for Image Modal -->
<script>
function openModal(imagePath, description) {
    // Create modal HTML
    const modalContent = `
        <div id="imageModal" class="modal">
            <span class="close" onclick="closeModal()">&times;</span>
            <img class="modal-content" src="${imagePath}" alt="${description}">
        </div>
    `;
    
    // Inject modal HTML into the document body
    document.body.insertAdjacentHTML('beforeend', modalContent);

    // Show the modal
    document.getElementById('imageModal').style.display = "block";
}

function closeModal() {
    // Hide the modal and remove from DOM
    const modal = document.getElementById('imageModal');
    if (modal) {
        modal.style.display = "none";
        modal.remove();
    }
}

// Close modal if user clicks outside of the image
window.onclick = function(event) {
    const modal = document.getElementById('imageModal');
    if (event.target == modal) {
        closeModal();
    }
};
</script>

<!-- CSS for Table Images and Image Modal -->
<style>
.table-image {
    max-width: 100px; /* Adjust the maximum width of the image */
    max-height: 100px; /* Adjust the maximum height of the image */
    object-fit: cover; /* Ensure the image covers the entire space without stretching */
    border-radius: 5px; /* Add rounded corners to the image */
    cursor: pointer; /* Add pointer cursor to indicate clickable */
}

.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.9);
}

.modal-content {
    margin: auto;
    display: block;
    max-width: 80%;
    max-height: 80%;
    border: 2px solid #fff; /* Add border for better visibility */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Add shadow for depth */
}

.close {
    color: #fff;
    font-size: 30px;
    font-weight: bold;
    position: absolute;
    top: 15px;
    right: 35px;
    cursor: pointer;
}
</style>
      


    <div class="footer">
    </div>
  </body>
</html>
