<?php
include '../includes/uniques.php';
include '../database/config.php';
$myid = mysqli_real_escape_string($conn, $_POST['user']);

$sql = "SELECT * FROM tbl_users WHERE user_id = '$myid' OR email = '$myid'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
$myuserid = $row['user_id'];
$myemail = $row['email'];
$myfname = $row['first_name'];
$mylname = $row['last_name'];
$myfullname = "$myfname $mylname";
$new_password = get_rand_alphanumeric(10);
$encpass = md5($new_password);
$sql = "UPDATE tbl_users SET login='$encpass' WHERE user_id='$myuserid'";

if ($conn->query($sql) === TRUE) {

$message = "Hellow $myfullname, we received a request for your new password for the <b>Online Examination System</b> account, therefore your password have been changed to <br><b style='font-size:20px;color:red;background-color:lightgrey;'>$new_password</b>";   
require '../mail/PHPMailerAutoload.php';

$mail = new PHPMailer;
                          

$mail->isSMTP();                                      
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;                               
$mail->Username = '22072000kunal@gmail.com';           
$mail->Password = '7765999781';                         
$mail->SMTPSecure = 'tls';                            
$mail->Port = 587;                                   

$mail->setFrom('22072000kunal@gmail.com', 'Admin');
$mail->addAddress($myemail , $myfullname);              
$mail->addReplyTo('22072000kunal@gmail.com', 'Admin');
   
$mail->isHTML(true);                                 

$mail->Subject = 'OES Password Reset';
$mail->Body    = $message;
$mail->AltBody = $message;

if(!$mail->send()) {

} else {
header("location:../forgot_pw.php?rp=1804");
}


} else {
header("location:../forgot_pw.php?rp=1100");
}

	
    }
} else {
header("location:../forgot_pw.php?rp=8924");
}
$conn->close();






