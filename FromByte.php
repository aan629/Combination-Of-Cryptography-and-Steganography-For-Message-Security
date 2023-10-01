<?php
$code = "";
$error = "";
$valid = true;
$color = "#FF0000";


if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	
	$code = $_POST['code'];
	
	if (empty($_POST['code']))
	{
		$error = "Masukan teks Byte Array !!!";
		$valid = false;
	}
	

	if ($valid)
	{ 
		if (isset($_POST['encrypt']))
		{	
			$decoded = base64_decode($code);
            $file = 'Hasil.pdf';
            file_put_contents($file, $decoded);

            if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
            }
		}

        if (isset($_POST['encrypt2']))
		{	
			$decoded = base64_decode($code);
            $file = 'Hasil.rar';
            file_put_contents($file, $decoded);

            if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
            }
		}

		if (isset($_POST['encrypt3']))
		{	
			$decoded = base64_decode($code);
            $file = 'Hasil.mp3';
            file_put_contents($file, $decoded);

            if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
            }
		}

		if (isset($_POST['encrypt4']))
		{	
			$decoded = base64_decode($code);
            $file = 'Hasil.mp4';
            file_put_contents($file, $decoded);

            if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
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
				<i class="fa fa-unlock" aria-hidden="true">&nbsp Convert Byte Array</i>
				</span>

				<label class="label-input100" for="message">Byte Array * &nbsp (<input style="color : #FF3B3B" size="3" value=1000000 name=text_num>Karakter Tersedia)</label>
				<div id="limiter" class="wrap-input100 validate-input" data-validate = "Message is required">
					<textarea onKeyPress=check_length(this.form); onKeyDown=check_length(this.form); id="box" name="code" class="form-control" placeholder="Masukan Byte Array (Base64)"><?php echo htmlspecialchars($code); ?></textarea>
					
					<span class="focus-input100"></span>
				</div>

				<td>
					<center><div style="color: <?php echo htmlspecialchars($color) ?>"><?php echo htmlspecialchars($error) ?></div></center>
				</td>

				<div class="container-contact100-form-btn">
					<button class="ml-3 bg-primary contact100-form-btn" type="submit" name="encrypt" class="button" onclick="validate(1)">
						<i class="fa fa-download" aria-hidden="true">&nbsp Unduh PDF</i>
					</button>

					<button class="ml-3 bg-primary contact100-form-btn" type="submit" name="encrypt2" class="button" onclick="validate(1)">
						<i class="fa fa-download" aria-hidden="true">&nbsp Unduh RAR</i>
					</button>

					<button class="ml-3 bg-primary contact100-form-btn" type="submit" name="encrypt3" class="button" onclick="validate(1)">
						<i class="fa fa-download" aria-hidden="true">&nbsp Unduh AUDIO</i>
					</button>

					<button class="ml-3 bg-primary contact100-form-btn" type="submit" name="encrypt4" class="button" onclick="validate(1)">
						<i class="fa fa-download" aria-hidden="true">&nbsp Unduh VIDEO</i>
					</button>
				</div>


			</form>

			<div class="contact100-more flex-col-c-m" style="background-image: url('assets/images/bg-skripsi.jpg');">


				<span class="txt1 p-r-25" style="padding-bottom: 180px; text-align: center;">
					<h4>Convert Byte Array To File</h4>
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
						<a href="index.php" class="btn btn-outline-light btn-sm " role="button" aria-pressed="true"><i class="fa fa-lock" aria-hidden="true">&nbsp  Back To Implementasi </i></a>
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