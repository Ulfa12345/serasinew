<?php

include "conf/conn.php";

?>
<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <!-- Meta Tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="keywords" content="Site keywords here">
		<meta name="description" content="">
		<meta name='copyright' content=''>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<!-- Title -->
        <title>SERASI - Sistem Persetujuan Denah PBF.</title>
		
		<!-- Favicon -->
        <link rel="icon" href="img/favicon.png">
		
		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Nice Select CSS -->
		<link rel="stylesheet" href="css/nice-select.css">
		<!-- Font Awesome CSS -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
		<!-- icofont CSS -->
        <link rel="stylesheet" href="css/icofont.css">
		<!-- Slicknav -->
		<link rel="stylesheet" href="css/slicknav.min.css">
		<!-- Owl Carousel CSS -->
        <link rel="stylesheet" href="css/owl-carousel.css">
		<!-- Datepicker CSS -->
		<link rel="stylesheet" href="css/datepicker.css">
		<!-- Animate CSS -->
        <link rel="stylesheet" href="css/animate.min.css">
		<!-- Magnific Popup CSS -->
        <link rel="stylesheet" href="css/magnific-popup.css">
		
		<!-- Medipro CSS -->
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/responsive.css">
		
    </head>
    <body>
	
		<!-- Preloader -->
        <div class="preloader">
            <div class="loader">
                <div class="loader-outter"></div>
                <div class="loader-inner"></div>

                <div class="indicator"> 
                    <svg width="16px" height="12px">
                        <polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                        <polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                    </svg>
                </div>
            </div>
        </div>
        <!-- End Preloader -->
		
		<!-- Get Pro Button -->
		
	
		<!-- Header Area -->
		<header class="header" >
			
			<!-- Header Inner -->
			<div class="header-inner">
				<div class="container">
					<div class="inner">
						<div class="row">
							<div class="col-lg-3 col-md-3 col-12">
								<!-- Start Logo -->
								<div class="logo">
									<a href="index.html"><img src="img/logo-header.png" alt="#"></a>
								</div>
								<!-- End Logo -->
								<!-- Mobile Nav -->
								<div class="mobile-nav"></div>
								<!-- End Mobile Nav -->
							</div>
							<div class="col-lg-7 col-md-9 col-12">
								<!-- Main Menu -->
								<div class="main-menu">
									<nav class="navigation">
										<ul class="nav menu">
											<li class="active"><a href="index.html">Home</a>
											</li>
											<li><a href="user/login.php">Login </a></li>
											<li><a href="user/signup.php">Registrasi </a></li>
										</ul>
									</nav>
								</div>
								<!--/ End Main Menu -->
							</div>
							<div class="col-lg-2 col-12">
								<div class="get-quote">
									<a href="user/signup.php" class="btn">DAFTAR AKUN PBF</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Header Inner -->
		</header>
		<!-- End Header Area -->
		
		<!-- Slider Area -->
		<section class="slider">
			<div class="hero-slider">
				<!-- Start Single Slider -->
				<div class="single-slider" style="background-image:url('img/slider.jpg')">
					<div class="container">
						<div class="row">
							<div class="col-lg-7">
								<div class="text">
									<!--<h1>We Provide <span>Medical</span> Services That You Can <span>Trust!</span></h1>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris sed nisl pellentesque, faucibus libero eu, gravida quam. </p>-->
									<div class="button">
										<!--<a href="#" class="btn">REGISTER</a>
										<a href="#" class="btn primary">Learn More</a>-->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- End Single Slider -->
				<!-- Start Single Slider -->
				<div class="single-slider" style="background-image:url('img/slider1.jpg')">
					<div class="container">
						<div class="row">
							<div class="col-lg-7">
								<div class="text">
									<h1>Kini semakin mudah <span>Pendaftaran Konsultasi Denah PBF <span></h1>
									<p>Yuks daftarkan segera, klik link dibawah ini </p>
									<div class="button">
										<a href="user/signup.php" class="btn">Pendaftaran</a>
										<a href="#" class="btn primary">About Us</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Start End Slider -->
				<!-- Start Single Slider -->
				<!--End Single Slider -->
			</div>
		</section>
		<!-- End Slider Area -->
		
		
		
		<!-- Start Newsletter Area -->
		<section class="newsletter section">
			<div class="container">
				<div class="row ">
					<div class="col-lg-6  col-12">
						<!-- Start Newsletter Form -->
						<div class="subscribe-text ">
							<h6>Sign up for newsletter</h6>
							<p class="">Cu qui soleat partiendo urbanitas. Eum aperiri indoctum eu,<br> homero alterum.</p>
						</div>
						<!-- End Newsletter Form -->
					</div>
					<div class="col-lg-6  col-12">
						<!-- Start Newsletter Form -->
						<div class="subscribe-form ">
							<form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">
								<input name="EMAIL" placeholder="Your email address" class="common-input" onfocus="this.placeholder = ''"
									onblur="this.placeholder = 'Your email address'" required="" type="email">
								<button class="btn">Subscribe</button>
							</form>
						</div>
						<!-- End Newsletter Form -->
					</div>
				</div>
			</div>
		</section>
		<!-- /End Newsletter Area -->
		
		<!-- Footer Area -->
		<footer id="footer" class="footer ">
			<!-- Footer Top -->
			<div class="footer-top">
				<div class="container">
					<div class="row">
						<div class="col-lg-4 col-md-6 col-12">
							<div class="single-footer">
								<h2>About Us</h2>
								<p> SERASI merupakan aplikasi berbasis website untuk Pengajuan Denah PBF (Pedagang Besar Farmasi) di Balai Besar POM di Surabaya</p>
								<!-- Social -->
								<ul class="social">
									<li><a href="https://www.instagram.com/bpom.surabaya/"><i class="icofont-instagram"></i></a></li>
									<li><a href="https://x.com/BPOM_Surabaya"><i class="icofont-twitter"></i></a></li>
									<li><a href="https://www.facebook.com/bpom.surabaya"><i class="icofont-facebook"></i></a></li>
								</ul>
								<!-- End Social -->
							</div>
						</div>
						<div class="col-lg-4 col-md-6 col-12">
							<div class="single-footer f-link">
								<h2>Quick Links</h2>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-12">
										<ul>
											<li><a href="https://surabaya.pom.go.id/"><i class="fa fa-caret-right" aria-hidden="true"></i>Website BBPOM Surabaya</a></li>
											<li><a href="https://www.pom.go.id/"><i class="fa fa-caret-right" aria-hidden="true"></i>Website BPOM</a></li>
											<li><a href="https://cekbpom.pom.go.id/"><i class="fa fa-caret-right" aria-hidden="true"></i>Cek POM</a></li>	
										</ul>
									</div>
									<div class="col-lg-6 col-md-6 col-12">
										<ul>
											<li><a href="https://new-aero.pom.go.id/"><i class="fa fa-caret-right" aria-hidden="true"></i>New Aero</a></li>
											<li><a href="https://e-bpom.pom.go.id/"><i class="fa fa-caret-right" aria-hidden="true"></i>E-BPOM</a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6 col-12">
							<div class="single-footer">
								<h2>Open Hours</h2>
								<ul class="time-sidual">
									<li class="day">Senin - Kamis <span> 08.00-16.30</span></li>
									<li class="day">Jumat <span> 08.00-16.00</span></li>
									<li class="day">Sabtu - Minggu dan Hari Libur Nasional - Layanan atas Permintaan atau Kasus Khusus</li>
								</ul>
							</div>
						</div>
						
					</div>
				</div>
			</div>
			<!--/ End Footer Top -->
			<!-- Copyright -->
			<div class="copyright">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-12">
							<div class="copyright-content">
								<p>© Copyright 2018  |  Tim IT <a href="https://www.wpthemesgrid.com" target="_blank">BBPOM Surabaya</a> </p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Copyright -->
		</footer>
		<!--/ End Footer Area -->
		
		<!-- jquery Min JS -->
        <script src="js/jquery.min.js"></script>
		<!-- jquery Migrate JS -->
		<script src="js/jquery-migrate-3.0.0.js"></script>
		<!-- jquery Ui JS -->
		<script src="js/jquery-ui.min.js"></script>
		<!-- Easing JS -->
        <script src="js/easing.js"></script>
		<!-- Color JS -->
		<script src="js/colors.js"></script>
		<!-- Popper JS -->
		<script src="js/popper.min.js"></script>
		<!-- Bootstrap Datepicker JS -->
		<script src="js/bootstrap-datepicker.js"></script>
		<!-- Jquery Nav JS -->
        <script src="js/jquery.nav.js"></script>
		<!-- Slicknav JS -->
		<script src="js/slicknav.min.js"></script>
		<!-- ScrollUp JS -->
        <script src="js/jquery.scrollUp.min.js"></script>
		<!-- Niceselect JS -->
		<script src="js/niceselect.js"></script>
		<!-- Tilt Jquery JS -->
		<script src="js/tilt.jquery.min.js"></script>
		<!-- Owl Carousel JS -->
        <script src="js/owl-carousel.js"></script>
		<!-- counterup JS -->
		<script src="js/jquery.counterup.min.js"></script>
		<!-- Steller JS -->
		<script src="js/steller.js"></script>
		<!-- Wow JS -->
		<script src="js/wow.min.js"></script>
		<!-- Magnific Popup JS -->
		<script src="js/jquery.magnific-popup.min.js"></script>
		<!-- Counter Up CDN JS -->
		<script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
		<!-- Bootstrap JS -->
		<script src="js/bootstrap.min.js"></script>
		<!-- Main JS -->
		<script src="js/main.js"></script>
    </body>
</html>