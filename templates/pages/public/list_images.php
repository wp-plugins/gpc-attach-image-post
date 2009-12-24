<?php
/**
 * Template to list images of post
 *
 * @package GpcAttachImagePost
 * 
 */
?>
<?php get_header(); ?>
<div id="content" class="narrowcolumn" role="main">
<br /><?php include(GpcAttachImagePost::$plugin_dir . '/includes/msg.php'); ?>
<table>
<?php 
foreach ($images_urls as $images_urls_item) {
?>
<tr><td>
<a href="<?php echo $images_urls_item['full']?>"><img src="<?php echo $images_urls_item['thumb']?>"></a>
<br>
<label><?php echo __('Uploaded by ') ?><a href="<?php echo $images_urls_item['profile_link'] ?>"><?php echo $images_urls_item['user_login']?></a></label>
</td></tr>
<?php
}
?>
</table>
<?php if (count($images_urls)==0) { 
	_e('No image uploaded for this post yet.');
}?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>