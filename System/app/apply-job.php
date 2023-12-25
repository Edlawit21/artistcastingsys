<?php
require '../constants/settings.php';
date_default_timezone_set($default_timezone);
$apply_date = date('m/d/Y');

session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
    $myid = $_SESSION['myid'];
    $myrole = $_SESSION['role'];
    $opt = $_GET['opt'];

    if ($myrole != "employer") {
        include '../constants/db_config.php';

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT * FROM tbl_job_applications WHERE member_no = '$myid' AND job_id = :jobid");
            $stmt->bindParam(':jobid', $opt);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $rec = count($result);

            if ($rec == 0) {
                $videoUrl = $_GET['video_link']; // Get the video URL from the URL parameter

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $conn->prepare("INSERT INTO tbl_job_applications (member_no, job_id, application_date, url)
                                            VALUES (:memberno, :jobid, :appdate, :url)");
                    $stmt->bindParam(':memberno', $myid);
                    $stmt->bindParam(':jobid', $opt);
                    $stmt->bindParam(':appdate', $apply_date);
                    $stmt->bindParam(':url', $videoUrl);

                    $stmt->execute();

                    print '<br>
                           <div class="alert alert-success">
                               You have successfully applied for this job.
                           </div>
                           ';
                } catch (PDOException $e) {
                    // Handle the exception
                }
            } else {
                foreach ($result as $row) {
                    print '<br>
                           <div class="alert alert-warning">
                               You have already applied for this job before. You cannot apply again.
                           </div>
                           ';
                }
            }
        } catch (PDOException $e) {
            // Handle the exception
        }
    }
}
?>
