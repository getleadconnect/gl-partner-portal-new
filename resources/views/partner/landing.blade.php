<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ env('SITE_TITLE') }}</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
		integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	
	<link rel="stylesheeet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

		<link rel="stylesheet" href="./css/style.css"> 

	<!-- FAVICONS -->
	<link rel="icon" href="images/favicons/favicon.ico">
	<link rel="apple-touch-icon" href="images/favicons/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/favicons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/favicons/apple-touch-icon-114x114.png">

</head>

<body>

	<header>
		<nav class="navbar sticky-top navbar-expand-lg ">
			<div class="container-fluid">
				<a class="navbar-brand" href="#">Logo</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse"
					data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
					aria-label="Toggle navigation">
					<i class="fas fa-bars"></i>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto w-100 justify-content-end">
						<li class="nav-item active">
							<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">About</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Contact</a>
						</li>
					</ul>
					<div class="social-icons">
						<ul>
							<li>
								<a href="#">
									<i class="fa-brands fa-facebook-f"></i>
								</a>
							</li>
							<li>
								<a href="#">
									<i class="fa-brands fa-twitter"></i>
								</a>
							</li>
							<li>
								<a href="#">
									<i class="fa-brands fa-facebook-f"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
	</header>


	<section class="banner-section">
		<div class="container">
			<div class="banner-contents">
				<h2>Lorem ipsum dolor<br> sit amet....</h2>
				<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, </p>
				<a href="#">
					Learn more
				</a>
			</div>

		</div>
	</section>



	<div class="social-icons social-icons-fixed">
		<ul>
			<li>
				<a href="#">
					<i class="fa-brands fa-facebook-f"></i>
				</a>
			</li>
			<li>
				<a href="#">
					<i class="fa-brands fa-twitter"></i>
				</a>
			</li>
			<li>
				<a href="#">
					<i class="fa-brands fa-facebook-f"></i>
				</a>
			</li>
		</ul>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
		integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
		crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/all.min.js"></script>
</body>

</html>