<?php

  include('PHPMailer/class.smtp.php');
  include('PHPMailer/class.phpmailer.php');
  include('PHPMailer/PHPMailerAutoload.php');

  $servername = "localhost";
  $username = "packs_db_user";
  $password = "zJV-Lx5-zvm-Xep";

  // $servername = "localhost";
  // $username = "root";
  // $password = "";

  $conn = new PDO("mysql:host=$servername;dbname=packs", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  try {
    $conn = new PDO("mysql:host=$servername;dbname=packs", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    // echo "Connected successfully"; 
  }
  catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
  }

  if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $current_date = date('Y-m-d H:i:s');

    if($conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION)) {
      $sendmsgQuery = "INSERT INTO `user_messages` SET `name`='$name', `email`='$email', `message`='$message', `created_at`='$current_date'";
      if($conn->exec($sendmsgQuery)){

        $mail = new PHPMailer;
        
        //From email address and name
        $mail->From = "robin-vo@web.de";
        $mail->FromName = "Packs Contact Form";

        //To address and name
        $mail->addAddress("robin.van.opstal@mhmk.de", "Robin");

        //Address to which recipient will reply
        $mail->addReplyTo($email, $name);

        //Send HTML or Plain Text email
        $mail->isHTML(true);

        $mail->Subject = "Packs Contact Form Message";
        $mail->Body = "Hello Packs Admin,<br><br>You have got a new message from Packs contact form. Please have a look at the details:<br><br>Name: ".$name."<br>Email Address: ".$email."<br>Message: ".$message."";

        if(!$mail->send()) 
        {
           echo "Mailer Error: " . $mail->ErrorInfo;
        } 
        else 
        {
           echo "sent";
        }

        // require("PHPMailer/class.PHPMailer.php");
        // $userName = $_POST['name'];
        // $userEmail = $_POST['email'];
        // $userMessage = $_POST['message'];

        // $mail = new PHPMailer();
        // $mail->IsSMTP();                                      // set mailer to use SMTP
        // $mail->Host = "smtp.web.de";  // specify main and backup server
        // $mail->SMTPAuth = true;     // turn on SMTP authentication
        // $mail->Port       = 587;
        // $mail->SMTPSecure = "tls";
        // $mail->Username = "robin-vo@web.de";  // SMTP username
        // $mail->Password = "Pro71810"; // SMTP password
        // $mail->From = "robin-vo@web.de";
        // $mail->FromName = "Robin VO";
        // $mail->AddAddress("robin.van.opstal@mhmk.de", "Robin");
        // $mail->Subject = "packs-user: $userName";
        // $mail->Body    = "Name: $userName Email: $userEmail Message: $userMessage";
        // $mail->AltBody = "Name: $userName Email: $userEmail Message: $userMessage";

        // if(!$mail->Send()) {
        //    echo "Message could not be sent.";
        //    echo "Mailer Error: " . $mail->ErrorInfo;
        //    exit;
        // } else {
        //    // echo "<script>window.location = 'success.html'</script>";
        //    echo 'sent';
        // }

      } else {
          echo false;
      }
    }    
  }
?>
