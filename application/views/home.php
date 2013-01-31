<div class="hero-unit hero-home">

	<h1>Our data. Open.</h1>
	
	<p>The University of Lincoln is making some of its institutional data available to the world.</p>

</div>

<div class="row">

	<div class="span6">
	
		<h3>What is Data.Lincoln?</h3>
		
		<p>Data.Lincoln lists all of the University of Lincoln's Open Data; data which is available under licences which allow the use and re-use of the data for almost anything.</p>
		
		<p>Open Data helps to make the world a better place by making it faster and easier to get information, as well as encouraging people to build new ways of viewing, analyzing and understanding data.</p>
	
	</div>
	
	<div class="span6">
	
		<h3>Get The Data</h3>
		
		<p>Getting our data is easy. Just pick a data catalogue to see what's available.</p>
		
		<ul class="nav nav-pills nav-stacked">
		
		<?php
		
		foreach ($catalogues as $catalogue)
		{
			echo '<li><a href="' . site_url('catalogue/' . $catalogue->slug) . '">' . $catalogue->name . '</a></li>';
		}
		
		?>
		
		</ul>
	
	</div>
	
</div>

<hr>

<div class="row">
	
	<div class="span6">
	
		<h3>Publish My Data</h3>
		
		<p>If you're part of the University of Lincoln and want to publish some or all of your data, we're here to help.</p>
		
		<p><a class="btn" href="<?php echo site_url('share'); ?>">Find Out More</a></p>
	
	</div>
	
	<div class="span6">
	
		<h3>Research Data</h3>
		
		<p>Data.Lincoln stores the University of Lincoln's institutional data. If you're looking for our open research data, take a look at our CKAN repository.</p>
		
		<p><a class="btn" href="https://ckan.lincoln.ac.uk">Visit CKAN</a></p>
	
	</div>

</div>