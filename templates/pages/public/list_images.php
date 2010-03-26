<?php
/**
 * Template to list images of post
 *
 * @uses	array	$images_urls	Array with images to show
 * @uses 	string	$post_name		Name of the post the images belongs to
 * @uses 	string	$post_url		URL of the post the images belongs to
 * @uses 	int		$post_id		ID of the post the images belongs to
 * 
 * @package GpcAttachImagePost
 * 
 */
?>
<?php get_header(); ?>
<div id="content" class="narrowcolumn" role="main">
<div class="padder">
<?php _e('Images of: ') ?><a href="<?php echo $post_url?>"><?php echo "$post_name (ID: $post_id)"?></a>
<br /><?php include(GpcAttachImagePost::$plugin_dir . '/includes/msg.php'); ?>
<ul>
<?php 
foreach ($images_urls as $images_urls_item) {
?>
<li>
<a href="<?php echo $images_urls_item['full']?>"><img src="<?php echo $images_urls_item['thumb']?>"></a>
<br>
<label><?php echo __('Uploaded by ') ?><a href="<?php echo $images_urls_item['profile_link'] ?>"><?php echo $images_urls_item['user_login']?></a></label>
</li>
<?php
}
?>
</ul>
<?php if (count($images_urls)==0) { 
	_e('No image uploaded for this post yet.');
}?></div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>