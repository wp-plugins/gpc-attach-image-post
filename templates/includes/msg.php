<?php 
if (isset($msg_notify)) { 
	$msg_notify = (array) $msg_notify;
	foreach ($msg_notify as $msg_notify_item) {
		?>
		<div id="message" class="info">
		<p><?php echo $msg_notify_item?></p>
		</div>
		<?php
	}
} ?>
<?php if (isset($msg_error)) { 
	$msg_error = (array) $msg_error;
	foreach ($msg_error as $msg_error_item) {
	?>
	<div id="message" class="error">
	<p><?php echo $msg_error_item?></p>
	</div>
<?php 
	}
} ?>