<?php
/**
 * Template to add image to post
 *
 * @package GpcAttachImagePost
 * 
 */
?>
<?php get_header();?>
	<div id="content">
	<div class="padder">
		<?php include(GpcAttachImagePost::$plugin_dir . '/includes/msg.php'); ?><br />		
		<?php if ($show_form) { ?>
		<form action="" method="post" enctype="multipart/form-data">
			<div class="activity">
				<ul class="activity-list item-list" id="activity-stream">
					<li>
						<label for="description"><?php _e('Select an image'); ?></label>
						<input id="image" class="regular-text" type="file" style="width: auto;" name="image"/><br />
						<span class="description"><?php _e('Only .jpg and .png are allowed.'); ?></span>
						<br><br>
						<input type="submit" name="submit" value="Upload"/>
					</li>
				</ul>
			</div>
		</form>
		<?php } ?>
	</div>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
