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
foreach ($datasets as $dataset):
?>

<li><a href="#dset-tab-<?php echo $dataset->dataset_id; ?>" data-toggle="tab"><?php echo $dataset->dataset_name; ?></a></li>

<?php
endforeach;
?>

</ul>

<div id="resourceTabsContent" class="tab-content">

<?php
foreach ($datasets as $dataset):
?>

<div class="tab-pane fade" id="dset-tab-<?php echo $dataset->dataset_id; ?>">
	<div class="row">
	
		<div class="span8">
		
			<?php echo auto_typography($dataset->dataset_blurb); ?>
			
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Format</th>
						<th>URL</th>
					</tr>
				</thead>
				<tbody>
			
					<?php foreach ($resources[$dataset->dataset_id] as $resource): ?>
					
					<tr>
						<td><?php echo $resource->format_name; ?></td>
						<td><a href="<?php echo $resource->resource_uri; ?>"><?php echo $resource->resource_uri; ?></a></td>
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
				
				<p>If you spot an error in this dataset please email corrections to FOO at BAR.</p>
				
			</div>
			
		</div>
	</div>
</div>

<?php
endforeach;
?>

</div>

<?php
else:
?>

<img src="<?php echo base_url(); ?>assets/img/error.png" style="float:right;padding-left:25px;height:180px;width:180px;">

<p class="lead">It looks like there isn't any Open Data available in the <?php echo $catalogue->name; ?> catalogue yet. Sorry about that.</p>

<p>If you own any data that would belong in this catalogue then why not consider <a href="<?php echo site_url('share'); ?>">sharing your data</a>?

<?php
endif;
?>