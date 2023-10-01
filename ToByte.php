<?php
// initialize variables
$color = "#FF0000";
$rm = "";

// if form was submit
if ($_SERVER['REQUEST_METHOD'] == "POST")
{

	// if decrypt button was clicked
	if (isset($_POST['encrypt']))
	{
		//include('Ebase64.php');
		$file = file_get_contents($_FILES['file']['tmp_name']); 
		$rm = base64_encode($file);		
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
					<i class="fa fa-lock" aria-hidden="true">&nbsp Convert File</i>
				</span>

				<?php if ($rm != "") {?>
					<label class='label-input100' for='message'>Pesan *</label>
					<div class='wrap-input100'>
						<textarea class='input100'><?= $rm ?></textarea>
						<span class='focus-input100'></span>
					</div>
				<?php } ?>

				<label class="label-input100" for="">Unggah File*</label>
				<div class="wrap-input100">
				   <input type="file" name="file" class="custom-file-input">
				   <label class="input100 custom-file-label" ><input placeholder= "Contoh: file.pdf"></label>
				</div>


			<div class="container-contact100-form-btn">
				<button class="mr-3 contact100-form-btn" type="submit" name="encrypt" class="button" onclick="validate(1)">
					<i class="fa fa-unlock" aria-hidden="true">&nbsp Convert</i>
				</button>
			</div>

			
			</form>

			<div class="contact100-more flex-col-c-m" style="background-image: url('assets/images/bg-skripsi.jpg');">


				<span class="txt1 p-r-25" style="padding-bottom: 180px; text-align: center;">
					<h4>Convert File To Byte Array (Base64)</h4>
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
						<a href="index.php" class="btn btn-outline-light btn-sm " role="button" aria-pressed="true"><i class="fa fa-lock" aria-hidden="true"> &nbsp Back To Implementasi </i></a>
						<button type="button" class=""></button>
					 </h6> 
 				</span>

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