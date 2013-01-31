<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Data.Lincoln</title>
	<meta name="description" content="Data.Lincoln provides Open Data for the University of Lincoln">
	<meta name="author" content="Online Services Team; ost@lincoln.ac.uk">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="<?php echo $_SERVER['CWD_BASE_URI']; ?>favicon.ico">
	<link rel="apple-touch-icon" href="<?php echo $_SERVER['CWD_BASE_URI']; ?>icon.png">

	<link rel="stylesheet" href="<?php echo $_SERVER['CWD_BASE_URI']; ?>cwd.min.css">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,600,700" rel="stylesheet" type="text/css">

	<!--[if (lt IE 9) & (!IEMobile)]>
		<link rel="stylesheet" href="<?php echo $_SERVER['CWD_BASE_URI']; ?>html5shiv.min.js"></script>
	<![endif]-->
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/data.css">

</head>

<body>

	<div id="cwd-wrap">

		<div id="cwd-main">

			<aside class="navbar navbar-inverse navbar-static-top hidden-phone" id="cwd-global-nav">
				<nav class="navbar-inner"></nav>
			</aside>

			<header id="cwd-header">

				<div class="container">

					<hgroup id="cwd-hgroup">

						<h1>Data.Lincoln</h1>

					</hgroup>

					<div class="navbar">
						<div class="navbar-inner">

							<a id="cwd-menu-collapse" data-toggle="collapse" data-target=".nav-collapse">
								Navigation <i class="icon-caret-down"></i>
							</a>

							<div class="nav-collapse">

								<ul class="nav">
								
									<li<?php if ($page == 'home') echo ' class="active"'; ?>><a href="<?php echo site_url(); ?>">Home</a></li>
									<li class="<?php if ($page == 'catalogue') echo 'active '; ?>dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown">
											Catalogues
											<b class="caret"></b>
										</a>
										<ul class="dropdown-menu">
										
											<?php
											
											$catalogues = $this->catalogue_model->all();
											
											foreach ($catalogues as $catalogue)
											{
												echo '<li><a href="' . site_url('catalogue/' . $catalogue->slug) . '">' . $catalogue->name . '</a></li>';
											}
											
											?>
										</ul>
									</li>
									<li<?php if ($page == 'publish') echo ' class="active"'; ?>><a href="<?php echo site_url('publish'); ?>">Publish</a></li>
									<li<?php if ($page == 'develop') echo ' class="active"'; ?>><a href="<?php echo site_url('develop'); ?>">Develop</a></li>
									
								</ul>

							</div>
						</div>
					</div>

				</div>

			</header>

			<div class="container">