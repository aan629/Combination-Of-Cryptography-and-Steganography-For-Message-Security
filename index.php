<?php
$pswd = "";
$code = "";
$error = "";
$valid = true;
$color = "#FF0000";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/phpmailer/src/Exception.php';
require_once __DIR__ . '/vendor/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/vendor/phpmailer/src/SMTP.php';

// passing true in constructor enables exceptions in PHPMailer
$mail = new PHPMailer(true);

include "Kripto/VC.php";
include "Kripto/RC4.php";

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	
	$pswd = $_POST['pswd'];
	$code = $_POST['code'];
	
	
	if (empty($_POST['pswd']))
	{
		$error = "Isi form terlebih dahulu !!";
		$valid = false;
	}

	else if (empty($_POST['code']))
	{
		$error = "Masukan teks untuk Enkripsi dan Dekripsi";
		$valid = false;
	}
	
	else if (isset($_POST['pswd']))
	{
		if (!ctype_alpha($_POST['pswd']))
		{
		$error = "Key harus merupakan huruf alfabet";
		$valid = false;
		}
	}

	
	if ($valid)
	{ 
	    //If you klick Kirim Pesan		
		if (isset($_POST['encrypt']))
		{
			include('functions.php');
			$start_time = microtime(true);
			$enkrip = encrypt($pswd, $code);
			$loop 		= (strlen($enkrip) % 16 == 0) ? strlen($enkrip)/16 : intVal(strlen($enkrip)/16) + 1;
			echo "<script>console.log(\"Vigenere : $enkrip\")</script>";
			$cipherText	= "";
			for ($i=0; $i<$loop; $i++) {
				$start    = $i * 16;
				$txt	  = substr($enkrip, $start, 16);
				
				$rc4 	 = new rc4($pswd);
				$enkrip2 = $rc4->encrypt($txt);

				$cipherText	.= $enkrip2;	
			}
//			var_dump($cipherText);
			$code 	= $cipherText;		
			echo "<script>console.log(\"Rivest Code 4: $code\")</script>";	
			$error = "Sukses";
			$color = "#526F35";
			$pswd = $_POST['pswd'];
			$penerima = $_POST['penerima'];			
			$file_name = $_FILES['file']['name'];
			$file_type = $_FILES['file']['type'];
			$file_size = $_FILES['file']['size'];
			$file_tem_Loc = $_FILES['file']['tmp_name'];
			$file_store = $file_name;

			if (move_uploaded_file($file_tem_Loc, $file_store))
			{
				$message = $code;
				$binaryMessage = '';
				$length = strlen($message);
				$mb_length = mb_strlen($message);
				//echo "<script>console.log(\"length: $length\")</script>";
				//echo "<script>console.log(\"mb_length: $mb_length\")</script>";
				for ($i = 0; $i < strlen($message); ++$i) {
					$character = ord($message[$i]);
					$binaryMessage .= str_pad(decbin($character), 8, '0', STR_PAD_LEFT);
					$character_pad = str_pad(decbin($character), 8, '0', STR_PAD_LEFT);
					// echo "<script>console.log(\"CHARACTER NUMBER: $i\")</script>";
					// echo "<script>console.log(\"BINARY CHARACTER: $character_pad at index $i\")</script>";

				}
				$msgLngth = strlen($binaryMessage);
				echo "<script>console.log(\"Panjang Binary Pesan: $msgLngth\")</script>";
				//binaryMessage used for delimeter in deskripsi
				$binaryMessage .= '111111111111111111111111111111111111111111111111';
				echo "<script>console.log(\"Binary Blue Pesan: $binaryMessage:\")</script>";
				$img = imagecreatefromjpeg($file_name);

				$width = imagesx($img);
				$height = imagesy($img);

				$messagePosition = 0;

				for ($y = 0; $y < $height; $y++) {
					for ($x = 0; $x < $width; $x++) {

					  if (!isset($binaryMessage[$messagePosition])) {
					    
					    break 2;
					  }

					  $rgb = imagecolorat($img, $x, $y);
					  $colors = imagecolorsforindex($img, $rgb);

					  $red = $colors['red'];
					  $green = $colors['green'];
					  $blue = $colors['blue'];
					  $alpha = $colors['alpha'];

					
					  $binaryBlue = str_pad(decbin($blue), 8, '0', STR_PAD_LEFT);

					  $binaryBlue[strlen($binaryBlue) - 1] = $binaryMessage[$messagePosition];
					  $newBlue = bindec($binaryBlue);

					  $newColor = imagecolorallocatealpha($img, $red, $green, $newBlue, $alpha);
					  imagesetpixel($img, $x, $y, $newColor);
					
					  $messagePosition++;
					}
				}
				$newImage = str_shuffle('aanadrian629341').'.jpg';
  				imagepng($img, $newImage, 9);
				unlink($file_name);
				try {
					// Server settings
					/*$mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output*/
					$mail->SMTPDebug = false;
					$mail->isSMTP();
					$mail->Host = 'smtp.gmail.com';
					$mail->SMTPAuth = true;
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
					$mail->Port = 587;
					$mail->Username = '1187050001@student.uinsgd.ac.id'; // YOUR gmail email
					$mail->Password = 'zzvvhtzvaxzgrpmh'; // YOUR gmail password

					// Sender and recipient settings
					$mail->setFrom('1187050001@student.uinsgd.ac.id', '1187050001@student.uinsgd.ac.id');
					$mail->addAddress($penerima);
					$mail->addReplyTo('1187050001@student.uinsgd.ac.id', '1187050001@student.uinsgd.ac.id'); // to set the reply to

					// Setting the email content
					$mail->IsHTML(true);
					$mail->Subject = $file_name;
					// $mail->AddEmbeddedImage($newImage, "my-attach", $newImage);
					$mail->Body = 'http://localhost/enkripsiLSB&VC&RC4/dekripsi.php';
					$mail->AltBody = 'http://localhost/enkripsiLSB&VC&RC4/dekripsi.php';
					$mail->AddAttachment($newImage);
					$mail->send();
					unlink($newImage);

					echo "<script>alert('Email Berhasil Terkirim');
							 location.href='';
						 	</script>";
				} catch (Exception $e) {
					echo "<div class='text-danger'>Error in sending email. Mailer Error: {$mail->ErrorInfo}</div>";
				}
			}
			$endtime = microtime(true);
			$execution_time = ($endtime - $start_time);
			echo "<script>console.log(\"Execution time : $execution_time\")</script>";
		}

		if (isset($_POST['encrypt2']))
		{
			//If you klick unduh Pesan
			include('functions.php');
			$enkrip = encrypt($pswd, $code);
			$loop 		= (strlen($enkrip) % 16 == 0) ? strlen($enkrip)/16 : intVal(strlen($enkrip)/16) + 1;

			$cipherText	= "";
			for ($i=0; $i<$loop; $i++) {
				$start    = $i * 16;
				$txt	  = substr($enkrip, $start, 16);
				
				$rc4 	 = new rc4($pswd);
				$enkrip2 = $rc4->encrypt($txt);
		
				$cipherText	.= $enkrip2;		
			}
			
			$code 	= $cipherText;			
			$error = "Sukses";
			$color = "#526F35";
			$pswd = $_POST['pswd'];
			$file_name = $_FILES['file']['name'];
			$file_type = $_FILES['file']['type'];
			$file_size = $_FILES['file']['size'];
			$file_tem_Loc = $_FILES['file']['tmp_name'];
			$file_store = $file_name;

			if (move_uploaded_file($file_tem_Loc, $file_store))
			{
				$message = $code;
				$binaryMessage = '';

				for ($i = 0; $i < strlen($message); ++$i) {
					$character = ord($message[$i]);
					$binaryMessage .= str_pad(decbin($character), 8, '0', STR_PAD_LEFT);
				}
				//binaryMessage used for delimeter in deskripsi
				$binaryMessage .= '111111111111111111111111111111111111111111111111';

				$img = imagecreatefromjpeg($file_name);
				
				$width = imagesx($img);
				$height = imagesy($img);

				$messagePosition = 0;

				for ($y = 0; $y < $height; $y++) {
					for ($x = 0; $x < $width; $x++) {

					  if (!isset($binaryMessage[$messagePosition])) {
					    break 2;
					  }

					  $rgb = imagecolorat($img, $x, $y);
					  $colors = imagecolorsforindex($img, $rgb);

					  $red = $colors['red'];
					  $green = $colors['green'];
					  $blue = $colors['blue'];
					  $alpha = $colors['alpha'];

					  $binaryBlue = str_pad(decbin($blue), 8, '0', STR_PAD_LEFT);

					  $binaryBlue[strlen($binaryBlue) - 1] = $binaryMessage[$messagePosition];
					  $newBlue = bindec($binaryBlue);

					  $newColor = imagecolorallocatealpha($img, $red, $green, $newBlue, $alpha);
					  imagesetpixel($img, $x, $y, $newColor);

					  $messagePosition++;
					}
				}
				
				$newImage = str_shuffle('aanadrian629341').'.jpg';
  				imagepng($img, $newImage, 9);

				unlink($file_name);
				$file_url = $newImage;

				header('Content-Type: application/octet-stream');
				header("Content-Transfer-Encoding: Binary"); 
				header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
				readfile($file_url);
				header("Location: /");
				unlink($newImage);
			}
		}
	}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Stegano x Kripto</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="assets/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/css/maincss.css">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

	
<!--===============================================================================================-->
</head>

<script>

function check_length(my_form)
{
maxLen = 1000000; // max number of characters input
if (my_form.code.value.length >= maxLen) {
// Alert message if maximum limit is reached. 
// If required Alert can be removed. 
var msg = "Jumlah karakter sudah melebihi batas :) ";
alert(msg);
// Reached the Maximum length so trim the textarea
	my_form.code.value = my_form.code.value.substring(0, maxLen);
 }
else{ // Maximum length not reached so update the value of my_text counter
	my_form.text_num.value = maxLen - my_form.code.value.length;
}
}

</script>

<body>


	<div class="container-contact100">
		<div class="wrap-contact100">
			<form class="contact100-form validate-form" method="post" enctype="multipart/form-data"">
				<span class="contact100-form-title">
				<i class="fa fa-lock" aria-hidden="true">&nbsp Enkripsi Pesan</i>
				</span>


				<label class="label-input100" for="message">Kunci Rahasia (Key) *</label>
				<div class="wrap-input100 validate-input" data-validate = "Message is required">
					<input type="text" name="pswd" id="pass" value="<?php echo htmlspecialchars($pswd); ?>" class="form-control" placeholder="Masukan Kunci Rahasia">
					<span class="focus-input100"></span>
				</div>

				<label class="label-input100" for="message">Pesan * &nbsp (<input style="color : #FF3B3B" size="3" value=1000000 name=text_num>Karakter Tersedia)</label>
				<div id="limiter" class="wrap-input100 validate-input" data-validate = "Message is required">
					<textarea onKeyPress=check_length(this.form); onKeyDown=check_length(this.form); id="box" name="code" class="form-control" placeholder="Masukan Pesan .."><?php echo htmlspecialchars($code); ?></textarea>
					
					<span class="focus-input100"></span>
				</div>

				<label class="label-input100" for="message">Email</label>
				<div class="wrap-input100">
					<input type="text" id="box" name="penerima" class="form-control" placeholder="Masukan Alamat Email" />
					<span class="focus-input100"></span>
				</div>

				<label class="label-input100" for="">Unggah File .jpg *</label>
				<div class="wrap-input100">
				   <input type="file" name="file" class="custom-file-input">
				   <label class="form-control custom-file-label" ><input placeholder="Contoh: Gambar.jpg"></label>
				</div>

				<td>
					<center><div style="color: <?php echo htmlspecialchars($color) ?>"><?php echo htmlspecialchars($error) ?></div></center>
				</td>

				<div class="container-contact100-form-btn">
					<button class="mr-3 contact100-form-btn" type="submit" name="encrypt" class="button" onclick="validate(1)">
						<i class="fa fa-paper-plane-o" aria-hidden="true">&nbsp Kirim Pesan</i>
					</button>

					<button class="ml-3 bg-primary contact100-form-btn" type="submit" name="encrypt2" class="button" onclick="validate(1)">
						<i class="fa fa-download" aria-hidden="true">&nbsp Unduh Pesan</i>
					</button>
				</div>

			
			</form>

			<div class="contact100-more flex-col-c-m" style="background-image: url('assets/images/bg-skripsi.jpg');">


				<span class="txt1 p-r-25" style="padding-bottom: 180px; text-align: center;">
					<h4>IMPLEMENTASI ALGORITMA LEAST SIGNIFICANT BIT DAN KOMBINASI VIGENERE CIPHER DENGAN RC4 UNTUK PENGAMANAN PESAN EMAIL</h4>
				</span>

				<div class="flex-w size1 ">
					<div class="txt1 p-r-25">
						<span class="fa fa-user-o"></span>
					</div>

					<div class="flex-col size2">
						<span class="txt1 p-b-20">
							Aan Adrian Khothibulumam
							<br><span class="txt2">1187050001</span>
						</span>

					</div>
				</div>

				<div class="dis-flex size1 ">
					<div class="txt1 p-r-25">
						<span class="fa fa-envelope-o"></span>
					</div>

					<div class="flex-col size2">
						<span class="txt1 p-b-20">
							Mail
							<br><span class="txt3">1187050001@student.uinsgd.ac.id</span>
						</span>

					</div>
				</div>

				<span class="txt1">
					<h6>
						<a href="dekripsi.php" class="btn btn-outline-light btn-sm " role="button" aria-pressed="true"><i class="fa fa-unlock" aria-hidden="true">&nbsp  Dekripsi Pesan </i></a>
						<button type="button" class=""></button>
					 </h6> 
 				</span>

				 <span class="txt2">
					<h6>
						<a href="ToByte.php" class="btn btn-outline-light btn-sm " role="button" aria-pressed="true"><i class="fa fa-lock" aria-hidden="true">&nbsp  Convert File? </i></a>
						<button type="button" class=""></button>
					 </h6> 
 				</span>

	<!-- 			<div class="dis-flex size1">
					<div class="txt1 p-r-25">
						<span class="lnr lnr-envelope"></span>
					</div>

					<div class="flex-col size2">
						<span class="txt1 p-b-20">
							General Support
						</span>

						<span class="txt3">
							contact@example.com
						</span>
					</div>
				</div> -->

			</div>
		</div>
	</div>



	<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
	<script src="assets/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/vendor/bootstrap/js/popper.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/vendor/select2/select2.min.js"></script>
	<script>
		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});
	</script>
<!--===============================================================================================-->
	<script src="assets/vendor/daterangepicker/moment.min.js"></script>
	<script src="assets/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="assets/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="assets/js/main.js"></script>
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-23581568-13');
	</script>

	<script>
		$(".custom-file-input").on("change", function() {
		var fileName = $(this).val().split("\\").pop();
		$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
		});
	</script>
</body>
</html>