<?php
// initialize variables
$pswd = "";
$code = "";
$error = "";
$valid = true;
$color = "#FF0000";
$rm = "";

include "Kripto/VC.php";
include "Kripto/RC4.php";

// if form was submit
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	// declare encrypt and decrypt funtions
	// set the variables
	$pswd = $_POST['pswd'];
	// $code = $_POST['code'];
	
	// check if password is provided
	if (empty($_POST['pswd']))
	{
		$error = "Masukan Key!";
		$valid = false;
	}
	
	// check if text is provided
	/*else if (empty($_POST['code']))
	{
		$error = "Please enter some text or code to encrypt or decrypt!";
		$valid = false;
	}*/
	
	// check if password is alphanumeric
	else if (isset($_POST['pswd']))
	{
		if (!ctype_alpha($_POST['pswd']))
		{
		$error = "Key harus merupakan huruf alfabet!";
		$valid = false;
		}
	}
	
	// inputs valid
	if ($valid)
	{ 
			// if decrypt button was clicked
		if (isset($_POST['encrypt']))
		{
			include('functions.php');
			$start_time = microtime(true);
			$error = "Sukses !!";
			$color = "#526F35";
			$pswd = $_POST['pswd'];
			$file_name = $_FILES['file']['name'];
			$file_type = $_FILES['file']['type'];
			$file_size = $_FILES['file']['size'];
			$file_tem_Loc = $_FILES['file']['tmp_name'];
			$file_store = $file_name;
			move_uploaded_file($file_tem_Loc, $file_store);

			$img = imagecreatefrompng($file_name);
 
			// Read the message dimensions.
			$width = imagesx($img);
			$height = imagesy($img);

			// Set the message.
			$binaryMessage = '';

			// Initialise message buffer.
			$binaryMessageCharacterParts = [];
			$count=0;

			for ($y = 0; $y < $height; $y++) {
				for ($x = 0; $x < $width; $x++) {

				  // Extract the colour.
				  $rgb = imagecolorat($img, $x, $y);
				  $colors = imagecolorsforindex($img, $rgb);

				  $blue = $colors['blue'];

				  // Convert the blue to binary.
				  $binaryBlue = decbin($blue);

				  // Extract the least significant bit into out message buffer..
				  $binaryMessageCharacterParts[] = $binaryBlue[strlen($binaryBlue) - 1];
				  if (count($binaryMessageCharacterParts) == 8) {
				    // If we have 8 parts to the message buffer we can update the message string.
				    $binaryCharacter = implode('', $binaryMessageCharacterParts);
				    $binaryMessageCharacterParts = [];
					echo "<script>console.log(\"Binary message: $binaryCharacter\")</script>";
					if ($binaryCharacter == '11111111') {
						// If the 'end of text' character is found then stop looking for the message.
					//    break 2;
					$count=$count + 1;
					echo "<script>console.log(\"Finded: $count x\")</script>";
					 }
				//     if ($binaryCharacter == '11111111'&&'11111111'&&'11111111') {
				//       // If the 'end of text' character is found then stop looking for the message.
				//     //   break 2;
				// 	$count=$count + 1;
				//    }
				    else {
				    //   Append the character we found into the message.
					$count = 0;
				}

				$binaryMessage .= $binaryCharacter;

					if($count == 6) {
						$binaryMessage = substr_replace($binaryMessage,'', strlen($binaryMessage)-48, strlen($binaryMessage));
						echo "<script>console.log(\"Binary message: $binaryMessage\")</script>";
						break 2;
					}
				  }
				}
			}

			// Convert the binary message we have found into text.
			$message = '';
			$msg_length = strlen($binaryMessage);
			echo "<script>console.log(\"Binary message length: $msg_length\")</script>";
			for ($i = 0; $i < strlen($binaryMessage); $i += 8) {
				$character = mb_substr($binaryMessage, $i, 8);
				$message .= chr(bindec($character));
			}
			// FUNGSI 3 ALGORITMA
			$loop 	= (strlen($message) % 16 == 0) ? strlen($message)/16 : intVal(strlen($message)/16) + 1;
			echo "<script>console.log(\"Rivest Code 4: $message\")</script>";	
			$plainText = "";
			for ($i=0; $i<$loop; $i++) {
				$start    = $i * 16;
				$txt	  = substr($message, $start, 16);
				$rc4 	 = new rc4($pswd);
				$decrypt = $rc4->decrypt($txt);				

				$plainText		.= $decrypt;
			}								
			$rm = decrypt($pswd, $plainText);
			echo "<script>console.log(\"Vigenere: $plainText\")</script>";
					
			unlink($file_name);
		}
		$endtime = microtime(true);
		$execution_time = ($endtime - $start_time);
		echo "<script>console.log(\"Execution time : $execution_time\")</script>";
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
<body>


	<div class="container-contact100">
		<div class="wrap-contact100">
			<form class="contact100-form validate-form" method="post" enctype="multipart/form-data"">
				<span class="contact100-form-title">
					<i class="fa fa-unlock" aria-hidden="true">&nbsp Dekripsi Pesan</i>
				</span>

<!-- 				<label class="label-input100" for="email">Enter your email *</label>
<div class="wrap-input100 validate-input">
	<input id="email" class="input100" type="text" name="email" placeholder="Eg. example@email.com">
	<span class="focus-input100"></span>
</div>

<label class="label-input100" for="email">Enter your destination email *</label>
<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
	<input id="email" class="input100" type="text" name="email" placeholder="Eg. example@email.com">
	<span class="focus-input100"></span>
</div> -->

				<label class="label-input100" for="message">Kunci Rahasia (Key) *</label>
				<div class="wrap-input100 validate-input" data-validate = "Message is required">
					<input type="text" name="pswd" id="pass" value="<?php echo htmlspecialchars($pswd); ?>" class="input100" placeholder="Masukan Kunci Rahasia">
					<span class="focus-input100"></span>
				</div>
				
				<?php if ($rm != "") {?>
					<label class='label-input100' for='message'>Pesan *</label>
					<div class='wrap-input100'>
						<textarea class='input100'><?= $rm ?></textarea>
						<span class='focus-input100'></span>
					</div>
				<?php } ?>

				<label class="label-input100" for="">Unggah File .jpg *</label>
				<div class="wrap-input100">
				   <input type="file" name="file" class="custom-file-input">
				   <label class="input100 custom-file-label" ><input placeholder= "Contoh: secret.jpg"></label>
				</div>

				

				<td>
					<center><div style="color: <?php echo htmlspecialchars($color) ?>"><?php echo htmlspecialchars($error) ?></div></center>
				</td>

<!-- 			<tr>
	<td>
		<label>Select image to upload:</label>
		<p><input type="file" name="file"></p>
	</td>
</tr>
 -->
			<div class="container-contact100-form-btn">
				<button class="mr-3 contact100-form-btn" type="submit" name="encrypt" class="button" onclick="validate(1)">
					<i class="fa fa-unlock" aria-hidden="true">&nbsp Dekripsi Pesan</i>
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
						<a href="index.php" class="btn btn-outline-light btn-sm " role="button" aria-pressed="true"><i class="fa fa-lock" aria-hidden="true"> &nbsp Enkripsi Pesan </i></a>
						<button type="button" class=""></button>
					 </h6> 
 				</span>

				 <span class="txt2">
					<h6>
						<a href="FromByte.php" class="btn btn-outline-light btn-sm " role="button" aria-pressed="true"><i class="fa fa-unlock" aria-hidden="true"> &nbsp Convert Byte Array </i></a>
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
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-23581568-13');
	</script>

	<script>
	// Add the following code if you want the name of the file appear on select
		$(".custom-file-input").on("change", function() {
		var fileName = $(this).val().split("\\").pop();
		$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
		});
	</script>
</body>
</html>
