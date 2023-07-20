<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // access
        $secretKey = '6Lch3TwnAAAAAPyjbXTYWvgUaRcJz8iv7FOq_krF';
        $captcha = $_POST['g-recaptcha-response'];

        if(!$captcha){
          echo '<p class="alert alert-warning">Please check the the captcha form.</p>';
          exit;
        }

        # FIX: Replace this email with recipient email
        //$mail_to = "ankushprajapati77@gmail.com";
        
        # Sender Data
        //$subject = "Enquiry From Rajindia/";
        $name = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["name"])));
        //$address = trim($_POST["address"]);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        //$subject1 = trim($_POST["subject"]);
        //$address = $_POST["address"];
        $phone = $_POST["phone"];
        $comments = $_POST["Comment"];
        
        
        
        
        if ( empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            # Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo '<p class="alert alert-warning">Please complete the form and try again.</p>';
            exit;
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
        $responseKeys = json_decode($response,true);

        if(intval($responseKeys["success"]) !== 1) {
          echo '<p class="alert alert-warning">Please check the the captcha form.</p>';
        } else {
            # Mail Content
           
            $content ='
<html>

<table cellspacing="4" cellpadding="4" border="1">';
  
  $content .='
  
  <tr>
  <td align="center" bgcolor="#CBF1C0">Your Name</td>
  <td align="center">'.$name.'</td>
  </tr>
 
 <tr>
  <td align="center" bgcolor="#CBF1C0">Email</td>
  <td align="center">'.$email.'</td>
  
  </tr>
   
  
   
    <tr>
  <td align="center" bgcolor="#CBF1C0">Phone</td>
  <td align="center">'.$phone.'</td>
  
  </tr>
    <tr>
  <td align="center" bgcolor="#CBF1C0">Comments</td>
  <td align="center">'.$comments.'</td>
  
  </tr>
  
  
</table>
  
</html>
';

            # email headers.
            
$mail_to = "akhileshenterprises545@gmail.com";
$bcc = "ankushprajapati77@gmail.com";
$subject = "Enquiry Received From Coldstone";

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
$headers .= "From:".$email."\r\n";
$headers.="reply-To:".$email."\r\n";
$headers.="Bcc:".$bcc."\r\n";
            # Send the email.
            $success = mail($mail_to, $subject, $content, $headers);
            if ($success) {
                # Set a 200 (okay) response code.
                http_response_code(200);
                //echo '<p class="alert alert-success">Thank You! Your message has been sent.</p>';
                 header("Location:https://www.akhileshenterprises.com/thank-you.php");
	    exit();
            } else {
                # Set a 500 (internal server error) response code.
                http_response_code(500);
                echo '<p class="alert alert-warning">Oops! Something went wrong, we couldnt send your message.</p>';
            }
        }

    } else {
        # Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo '<p class="alert alert-warning">There was a problem with your submission, please try again.</p>';
    }
    

?>