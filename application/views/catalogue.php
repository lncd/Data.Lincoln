<div class="page-header">
	<h1><?php echo $catalogue->name; ?></h1>
</div>

<?php
	
if (count($datasets) > 0):

else:

?>

<img src="<?php echo base_url(); ?>assets/img/error.png" style="float:right;padding-left:25px;height:180px;width:180px;">

<p class="lead">It looks like there isn't any Open Data available in the <?php echo $catalogue->name; ?> catalogue yet. Sorry about that.</p>

<p>If you own any data that would belong in this catalogue then why not consider <a href="<?php echo site_url('share'); ?>">sharing your data</a>?

<?php
endif;
?>