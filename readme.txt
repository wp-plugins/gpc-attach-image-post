=== Gpc Attach Image to Posts ===
Contributors: leticia_larr,poolie
Tags: attach,image,post,thumbnail
Tested up to: 2.9
Requires at least: 2.8.5
Stable tag: trunk

This plugin allow registered users attach an images to a posts and pages.

== Description ==
This plugin install the scripts to allow registered users attach an image to a post and a see a page where 
all the uplaoded images are display with thumbs.

Administration Pages:
The plugin has a page in administration panel located in menu block "Attach Image" to set Max Size for the upload images.

== About Public Pages ==
To add a picture for a post, the user needs to go to:
	http://<wordpress installation url>/<post name or page name>/upload-image
	
To see the list of all added images thumbnails for the current authenticated user, he/she needs to go to:
	http://<wordpress installation url>/<post name or page name>/images
	
The max size of thumbnail are the same values setted in administration panel under: Settings>>Media

To see the list of images a member has upload, the user needs to go to:
	http://<wordpress installation url>/members/<member login>/member-images

== About Template Tags ==
* The template tag GpcAttachImagePost::new_image_tag_for_post() can be used as follow to display a post thumbnails (if has any image associated) within a category/archive.
<?php if (class_exists('GpcAttachImagePost')) GpcAttachImagePost::new_image_tag_for_post() ?>

* The template tag GpcAttachImagePost::images_total_for_member() can be used as follow to display the total number of image-uploads a user made.
<?php if (class_exists('GpcAttachImagePost')) GpcAttachImagePost::images_total_for_member() ?>

* The template tag GpcAttachImagePost::images_for_member() can be used as follow to display the images a user upload.
<?php if (class_exists('GpcAttachImagePost')) GpcAttachImagePost::images_for_member() ?>
	
== Installation ==
1. Upload the whole plugin folder to your /wp-content/plugins/ folder.
2. Go to the 'Plugins' page in the menu and activate the plugin.
3. Create folder /wp-content/uploads/. Give to web server user write permission in this folder.