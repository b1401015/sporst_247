<?php
helper('url');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sports News</title>

   

	<!-- <link href="css/bootstrap.min.css" rel="stylesheet" > -->
    <link rel="stylesheet" href="<?= base_url('media_frontend/css/bootstrap.min.css') ?>" />
    <link href="<?= base_url('media_frontend/fonts/css/fontawesome.min.css') ?>" rel="stylesheet" >
	<link href="<?= base_url('media_frontend/fonts/css/brands.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('media_frontend/fonts/css/solid.min.css') ?>" rel="stylesheet" />
	<link href="<?= base_url('media_frontend/css/global.css') ?>" rel="stylesheet">
	<link href="<?= base_url('media_frontend/css/index.css') ?>" rel="stylesheet">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Playwrite+GB+S:ital,wght@0,100..400;1,100..400&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>

<?= view_cell('MenuCell::render') ?>

   <?= $this->renderSection('content') ?>
 <section id="footer" class="pt-5 pb-5 bg_violet_dark">
   <div class="container-xl">
     <div class="row row-cols-1 row-cols-md-4">
	    <div class="col">
		  <div class="footer_left">
		    <b class="fs-4  d-block text-uppercase text-white center_sm"> <i class="fa fa-football col_yellow me-1"></i> Sports News</b>
			<p class="gray_bright mt-3">Your source for the lifestyle news. This demo is crafted specifically to exhibit the use of the theme as a lifestyle site. Visit our main page for more demos.</p>
			<p class="gray_bright">We're accepting new partnerships right now.</p>
			<ul class="gray_bright font_12">
		    <li class="d-flex"><span class="text-white me-3">Email Us:</span> info@example.com</li>
			<li class="d-flex mt-1"><span class="text-white me-3">Contact:</span>  +1-234-0123-431</li>
		   </ul>
		   <ul class="mb-0 d-flex social mt-3">
		  <li><a class="d-block rounded-circle text-center text-white  link" href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
		  <li class="ms-2"><a class="d-block rounded-circle text-center text-white link" href="#"><i class="fa-brands fa-youtube"></i></a></li>
		   <li class="ms-2"><a class="d-block rounded-circle text-center text-white link" href="#"><i class="fa-brands fa-x"></i></a></li>
		   <li class="ms-2"><a class="d-block rounded-circle text-center text-white link" href="#"><i class="fa-brands fa-pinterest"></i></a></li>
		   <li class="ms-2"><a class="d-block rounded-circle text-center text-white link" href="#"><i class="fa-brands fa-instagram"></i></a></li>
		</ul>
		  </div>
		</div>
		<div class="col">
		  <div class="footer_left">
		    <b class="text-uppercase text-white font_13 d-block mb-4 mt-1 center_sm">Contact Info</b>
			<p class="gray_bright">quasi, eum. class corporis nostra rem voluptatibus habitant? Fames, vivamus minim nemo enim, gravida lobortis quasi, eum.</p>
			<ul class="mb-0 font_10 mt-4">
			    <li class="d-flex text-uppercase">
				 <span class="col_yellow fs-4 d-inline-block me-3 lh-1 mt-1">
				   <i class="fa fa-user"></i>
				 </span>
				  <span class="flex-column">
				   <b class="text-white">Join our Team</b>
				   <span class="gray_bright d-block">info@gmail.com</span>
				 </span>
				</li>
				<li class="d-flex text-uppercase mt-4">
				 <span class="col_yellow fs-4 d-inline-block me-3 lh-1 mt-1">
				   <i class="fa fa-map-location"></i>
				 </span>
				  <span class="flex-column">
				   <b class="text-white">Contact Us</b>
				   <span class="gray_bright d-block">info@gmail.com</span>
				 </span>
				</li>
				<li class="d-flex text-uppercase mt-4">
				 <a class="gray_bright" href="#"><i class="fa-brands fa-facebook-f text-white me-1"></i> Facebook</a>
				 <a class="gray_bright mx-2" href="#"><i class="fa-brands fa-twitter text-white me-1"></i> Twitter</a>
				  <a class="text-white" href="#"><i class="fa-brands fa-google-plus-g col_yellow me-1"></i> Google+</a>
				</li>
			  </ul>
		 </div>
		</div>
		<div class="col">
		  <div class="footer_left">
		    <b class="text-uppercase text-white font_13 d-block mb-4 mt-1 center_sm">Popular News</b>
		<ul class="mb-0">
		     <li class="d-flex">
			   <span class="flex-column">
			     <span class="d-inline-block bg_yellow text-white p-1 px-3 font_10 rounded-3 text-uppercase">The Team</span>
				 <b class="d-block  text-uppercase"><a class="font_11 text-white" href="#">Praesent sapien massa,  a  pellentesque nec, egestas</a></b>
				 <span class="gray_bright font_10">Aug 13, 2016</span>
			   </span>
			 </li>
			 <li class="d-flex mt-2">
			   <span class="flex-column">
			     <span class="d-inline-block bg-info text-white p-1 px-3 font_10 rounded-3 text-uppercase">Injuries</span>
				 <b class="d-block  text-uppercase"><a class="font_11 text-white" href="#">CONSECTETUR ADIPISCING ELIT, SED DO EIUSMOD PORTA</a></b>
				 <span class="gray_bright font_10">Aug 13, 2016</span>
			   </span>
			 </li>
			 <li class="d-flex mt-2">
			   <span class="flex-column">
			     <span class="d-inline-block bg-danger text-white p-1 px-3 font_10 rounded-3 text-uppercase">Sport</span>
				 <b class="d-block  text-uppercase"><a class="font_11 text-white" href="#">TEMPOR INCIDIDUNT UT LABORE UT ENIM AD MINIM SEMPER</a></b>
				 <span class="gray_bright font_10">Aug 13, 2016</span>
			   </span>
			 </li>
		   </ul>
		 </div>
		</div>
		<div class="col">
		  <div class="footer_left">
		    <b class="text-uppercase text-white font_13 d-block mb-4 mt-1 center_sm">Instagram Widget</b>
            <ul class="mb-0 widget">
			 <li class="d-flex">
			   <a href="#"><img src="<?= base_url('media_frontend/image/10.jpg') ?>" width="80" alt="abc"></a>
			   <a class="mx-2" href="#"><img src="<?= base_url('media_frontend/image/11.jpg') ?>" width="80" alt="abc"></a>
			   <a href="#"><img src="<?= base_url('media_frontend/image/12.jpg') ?>" width="80" alt="abc"></a>
			 </li>
			 <li class="d-flex mt-2">
			   <a href="#"><img src="<?= base_url('media_frontend/image/14.jpg') ?>" width="80" alt="abc"></a>
			   <a class="mx-2" href="#"><img src="<?= base_url('media_frontend/image/15.jpg') ?>" width="80" alt="abc"></a>
			   <a href="#"><img src="<?= base_url('media_frontend/image/36.jpg') ?>" width="80" alt="abc"></a>
			 </li>
			  <li class="mt-4 center_sm">
			   <a class="font_10 text-uppercase button fw-bold d-inline-block rounded-1" href="#">Follow Our Instagram <i class="fa fa-chevron-right ms-2 font_8"></i> </a>
			 </li>
			</ul>
		 </div>
		</div>
	 </div>
   </div>
 </section>
 
 <section id="footer_bottom" class="bg_violet_extra_dark">
    <div class="container-fluid p-0">
     	 <div class="row mx-0">
	       <div class="col-md-2 p-0">
		     <div class="footer_bottom_left bg_yellow p-4 position-relative">
			    
			 </div>
		   </div>
		   <div class="col-md-8 p-0">
		     <div class="footer_bottom_center">
			      <ul class="mb-0 text-uppercas d-flex justify-content-center font_10 text-uppercase fw-bold flex-wrap">
				   <li><a class="d-block" href="#">Home</a></li>
				   <li><a class="d-block active" href="#">Cricket</a></li>
				   <li><a class="d-block" href="#">Tennis</a></li>
				   <li><a class="d-block" href="#">Football</a></li>
				   <li><a class="d-block" href="#">News</a></li>
				   <li><a class="d-block" href="#">Contact</a></li>
				  </ul>
			 </div>
		   </div>
		   <div class="col-md-2 p-0">
		     <div class="footer_bottom_right bg_yellow p-4 position-relative">
			    
			 </div>
		   </div>
		 </div>
	</div>
   </section>
		
<script src="<?= base_url('media_frontend/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('media_frontend/js/theme.min.js') ?>"></script>

</body>
</html>