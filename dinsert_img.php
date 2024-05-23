<?php
require 'connection.php';
session_start();

// Check if the form was submitted


    // Retrieve form data
    $patientID = $_POST['pssn'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $description = $_POST['description'];
    $doctorID = $_SESSION["userID"];
    $uploadDirectory = 'uploads';

    // Handle file uploads and database insertion
    if (!empty($_FILES['prescription_files']['name'][0])) {
        // Loop through each uploaded file
        foreach ($_FILES['prescription_files']['name'] as $key => $fileName) {
            if (!empty($fileName)) {
                $fileTmpName = $_FILES['prescription_files']['tmp_name'][$key];
                $targetFilePath = $uploadDirectory . basename($fileName);

                // Move uploaded file to target directory
                if (move_uploaded_file($fileTmpName, $targetFilePath)) {
                    // Insert metadata into database
                    $sql = "INSERT INTO images (doctor_id, patient_id, date, time, description, file_path) 
                            VALUES ('$doctorID',  '$patientID', '$date', '$time', '$description', '$targetFilePath')";

                    if ($conn->query($sql) === TRUE) {
                        header("Location: dinsert.php?login=success");
                        exit();
                    } else {
                        header("Location: dinsert.php?error=wronguser");
                        exit();
                    }
                } else {
                    header("Location: dinsert.php?error=fileupload");
                    exit();
                }
            }
        }
    } else {
        header("Location: dinsert.php?error=nofiles");
        exit();
    }

    // Close database connection
?>