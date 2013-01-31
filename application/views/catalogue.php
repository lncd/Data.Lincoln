<div class="page-header">
	<h1><?php echo $catalogue->name; ?></h1>
</div>

<?php
	
if (count($datasets) > 0):

?>

<?php echo auto_typography($catalogue->blurb); ?>

<h3>Datasets</h3>

<ul id="resourceTabs" class="nav nav-tabs">

<?php

$active = ' active';

foreach ($datasets as $dataset):
?>

<li class="<?php echo $active; ?>"><a href="#dset-tab-<?php echo $dataset->dataset_id; ?>" data-toggle="tab"><?php echo $dataset->dataset_name; ?></a></li>

<?php

$active = '';

endforeach;
?>

</ul>

<div id="resourceTabsContent" class="tab-content">

<?php

$active = ' in active';

foreach ($datasets as $dataset):

?>

<div class="tab-pane fade<?php echo $active; ?>" id="dset-tab-<?php echo $dataset->dataset_id; ?>">
	<div class="row">
	
		<div class="span8">
		
			<?php echo auto_typography($dataset->dataset_blurb); ?>
			
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Name</th>
						<th>URL</th>
						<th>Format</th>
					</tr>
				</thead>
				<tbody>
			
					<?php foreach ($resources[$dataset->dataset_id] as $resource): ?>
					
					<tr>
						<td><?php echo $resource->resource_name; ?></td>
						<td><code><a href="<?php echo $resource->resource_uri; ?>"><?php echo ellipsize($resource->resource_uri, 50, .5); ?></a></code></td>
						<td><?php echo $resource->format_name; ?></td>
					</tr>
					
					<?php endforeach; ?>
					
				</tbody>
			</table>
			
		</div>
		
		<div class="span4">
		
			<div class="well">
				<h4><?php echo $dataset->licence_name; ?></h4>
				
				<?php if ($dataset->licence_statement !== NULL): ?>
				
				<?php echo auto_typography($dataset->licence_statement); ?>
				
				<?php else: ?>
				
				<p>This dataset is made available under the <?php echo $dataset->licence_name; ?>: <a href="<?php echo $dataset->licence_url; ?>"><?php echo $dataset->licence_url; ?></a>.</p>
				
				<?php endif; ?>
			</div>
			
			<div class="well">
				<h4>Corrections</h4>
				
				<p>If you find an error in this dataset please email corrections to <?php echo $dataset->corrections_name; ?> at <a href="mailto:<?php echo $dataset->corrections_email; ?>"><?php echo $dataset->corrections_email; ?></a>.</p>
				
			</div>
			
			<div class="well">
			
				<h4>Data Quality</h4>
				
				<p class="lead">This is <?php echo $dataset->dataset_stars; ?> ★ Data<br>
				<img src="<?php echo base_url(); ?>assets/img/stars/badge-<?php echo $dataset->dataset_stars; ?>.png"></p>
				
				<p>We rate all of the data on Data.Lincoln against <a href="http://5stardata.info/">5 ★ Open Data</a> criteria.<p>
			
				<small>Badge from <a href="http://lab.linkeddata.deri.ie/2010/lod-badges/">Linked Open Data Star Badges</a></small>
			
			</div>
			
		</div>
	</div>
</div>

<?php

$active = '';

endforeach;

?>

</div>

<?php
else:
?>

<img src="<?php echo base_url(); ?>assets/img/error.png" style="float:right;padding-left:25px;height:180px;width:180px;">

<p class="lead">There isn't any data available in the <?php echo $catalogue->name; ?> catalogue yet.</p>

<p>If you own any data that would belong in this catalogue then why not consider <a href="<?php echo site_url('publish'); ?>">publishing your data</a>?

<?php
endif;
?>