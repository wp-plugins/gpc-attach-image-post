<?php
/**
 * Template to show the administrator's setting
 *
 * @uses string $data['max_size']
 * 
 * @package admin
 * 
 * <code>
 * <?php
	$data['max_size'] = '128';
 * ?>
 * </code>
 * 
 */
?>
<div class="wrap">
<h2><?php _e('General Settings')?></h2>
<form action="" method="post">
  <table class="form-table">
    <tr class="form-field">
      <th><label for="max_size"><?php _e('Max Size') ?></label></th>
      <td><input type="text" name="max_size" id="max_size" value="<?php echo $data['max_size'] ?>" /><p class="description"><?php _e('Please enter the max size in mb allowed for upload images') ?></p></td>
    </tr>
  </table>
  <p class="submit">
    <input type="submit" value="<?php _e('Save changes') ?>" class="button-primary" name="Submit" />
  </p>
</form>
</div>