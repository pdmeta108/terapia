<?php
/*
* This file is called by templates/forms/location-editor.php to display fields for uploading images on your event form on your website. This does not affect the admin featured image section.
* You can override this file by copying it to /wp-content/themes/yourtheme/plugins/events-manager/forms/event/ and editing it there.
*/
global $EM_Event;
/* @var $EM_Event EM_Event */
?>
<p id="event-image-img">
<?php if ($EM_Event->get_image_url() != '') : ?>
	<img src='<?php echo $EM_Event->get_image_url('medium'); ?>' alt='<?php echo $EM_Event->event_name ?>'/>
<?php else : ?> 
	<?php _e('No hay una imagen subida para este evento', 'events-manager') ?>
<?php endif; ?>
</p>
<label for='event_image'><?php _e('Subir/Cambiar imagen', 'events-manager') ?></label> <input id='event-image' name='event_image' id='event_image' type='file' size='40' />
<br />
<?php if ($EM_Event->get_image_url() != '') : ?>
<label for='event_image_delete'><?php _e('¿Borrar Imagen?', 'events-manager') ?></label> <input id='event-image-delete' name='event_image_delete' id='event_image_delete' type='checkbox' value='1' />
<?php endif; ?>