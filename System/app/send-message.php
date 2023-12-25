<?php
include '../constants/settings.php';
require_once "../db.php";

$myfname = ucwords($_POST['fullname']);
$myemail = $_POST['email'];
$mymessage = $_POST['message'];

require '../mail/PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->isSMTP();
$mail->Host = $smtp_host;
$mail->SMTPAuth = true;
$mail->Username = $smtp_user;
$mail->Password = $smtp_pass;
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom($myemail, $myfname);
$mail->addAddress($contact_mail);

$mail->isHTML(true);

$mail->Subject = 'Contact';
$mail->Body = $mymessage;
$mail->AltBody = $mymessage;

if (!$mail->send()) {
    header("location:../contact.php?r=2974");
} else {
    // Save data to the database
    $sql = "INSERT INTO tbl_contact_us (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $myfname, $myemail, $mymessage);
    $stmt->execute();
    $stmt->close();

    header("location:../contact.php?r=5634");
}
?>
