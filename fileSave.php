<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';
include_once('./header.php');
include_once('./CreatePDF.php');
?>

<?php

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$msg = "";
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $msg = '<span class="text-danger">Sorry, file already exists. </span>';
    $uploadOk = 0;
}
// Check file size
if ($_FILES["file"]["size"] > 1000000) {
    $msg = '<span class="text-danger">Sorry, your file is too large. </span>';
    $uploadOk = 0;
}
// Allow certain file formats
if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
) {
    $msg = '<span class="text-danger">Sorry, only JPG, JPEG, PNG  files are allowed. </span>';
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $msg = '<span class="text-danger">Sorry, your file was not uploaded. </span>';
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $msg = 'The file <span class="text-info">' . basename($_FILES["file"]["name"]) . " </span> has been uploaded.";
    } else {
        $msg = '<span class="text-danger">Sorry, there was an error uploading your file. </span>';
    }
}

$mail = new PHPMailer(true);
try {

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(80, 12, 'FILE NAME : '.basename($_FILES["file"]["name"]), 0, 1);
    $pdf->Cell(80, 12, 'EMAIL: '.$_POST['email'], 0, 1);
    $pdf->Cell(80, 12, 'IMAGE:', 0, 1);
    $pdf->Image($target_file, 20, 70, 150);
    $filename = $_POST['email'].basename($_FILES["file"]["name"]).".pdf";
    $pdf->Output('F', 'pdfs/' .$filename, true);

    //Server settings                   
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.mailtrap.io';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'a48b69dcd9a6c9';                     // SMTP username
    $mail->Password   = '691c7ece0987d8';                               // SMTP password
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress($_POST['email'], 'Joe User');

    // Attachments
    $mail->addAttachment($target_file);     // Optional name
    $mail->addAttachment('./pdfs/'.$filename);
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    $msg .= ' And,email has been sent';

} catch (Exception $e) {
    $msg .= " Mail could not be sent. Mailer Error: {$mail->ErrorInfo}";
}



?>

<div class="w-100 container mx-auto mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-8 border p-3">
            <h4><? echo $msg ?></h4>
        </div>
    </div>
</div>


<?php
include_once('./footer.php');
?>