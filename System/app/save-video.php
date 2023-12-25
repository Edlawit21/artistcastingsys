<?php
require '../constants/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $memberId = $_POST['memberId'];
    $jobId = $_POST['jobId'];
    $videoUrl = $_POST['videoUrl'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO tbl_job_applications (member_no, job_id, application_date, url)
                               VALUES (:memberno, :jobid, :appdate, :url)");
        $stmt->bindParam(':memberno', $memberId);
        $stmt->bindParam(':jobid', $jobId);
        $stmt->bindParam(':appdate', date('m/d/Y'));
        $stmt->bindParam(':url', $videoUrl);

        $stmt->execute();

        echo 'Video URL saved successfully.';
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
