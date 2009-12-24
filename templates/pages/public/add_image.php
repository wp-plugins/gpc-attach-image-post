<?php
/**
 * Template to add image to post
 *
 * @package GpcAttachImagePost
 * 
 */
?>
<?php get_header();?>
	<div id="content" class="narrowcolumn" role="main">
		<?php include(GpcAttachImagePost::$plugin_dir . '/includes/msg.php'); ?><br />		
		<?php if ($show_form) { ?>
		<form action="" method="post" enctype="multipart/form-data">
		<table class="form-table">
		<tbody>
		<tr>
			<th><label for="description"><?php _e('Select an image'); ?></label></th>
			<td><input id="image" class="regular-text" type="file" style="width: auto;" name="image"/><br />
			<span class="description"><?php _e('Only .jpg and .png are allowed.'); ?></span></td>
		</tr>
		</tbody>		
		</table>
		<p class="submit">
		<input class="button-primary" type="submit" name="submit" value="Upload"/>
		</p></form>
		<?php } ?>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
