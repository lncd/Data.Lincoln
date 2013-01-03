<div class="hero-unit hero-home">

	<h1>Unleash the data!</h1>
	
	<p>The University of Lincoln is opening up some of its institutional data for you to do something cool with.</p>

</div>

<div class="row">

	<div class="span6">
	
		<h3>What?</h3>
		
		<p>Data.Lincoln provides you with a collection of Open Data from the University of Lincoln, under licences which encourage you to use the data for just about anything.</p>
		
		<p>Open Data helps to make the world a better place by making it faster and easier to get information, as well as encouraging people to build new ways of viewing, analyzing and understanding data.</p>
	
	</div>
	
	<div class="span6">
	
		<h3>Get The Data</h3>
		
		<p>Getting our data is easy. Just pick a catalogue to see what's available.</p>
		
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
	
		<h3>Share My Stuff</h3>
		
		<p>If you're part of the University of Lincoln and want to share some of your data with the world, we're here to help.</p>
		
		<p><a class="btn" href="<?php echo site_url('share'); ?>">Find Out More</a></p>
	
	</div>
	
	<div class="span6">
	
		<h3>Research Data</h3>
		
		<p>Data.Lincoln stores the University of Lincoln's institutional data. If you're looking for our open research data, take a look at our CKAN repository.</p>
		
		<p><a class="btn" href="https://ckan.lincoln.ac.uk">Visit CKAN</a></p>
	
	</div>

</div>