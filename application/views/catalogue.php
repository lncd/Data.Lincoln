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
		</div>
		<div class="span4">
			<div class="well">
				<h4><?php echo $dataset->licence_name; ?></h4>
				
				<p>This dataset is made available under the <?php echo $dataset->licence_name; ?>: <a href="<?php echo $dataset->licence_url; ?>"><?php echo $dataset->licence_url; ?></a>.</p>
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