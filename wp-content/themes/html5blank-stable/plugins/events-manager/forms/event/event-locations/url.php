<?php
global $EM_Event;
?>
<div class="em-input-field em-input-field-text em-location-data-url">
	<label for="event_location_url"><?php esc_html_e( 'URL', 'events-manager')?></label>
	<input class="form-control" id="event_location_url" type="text" name="event_location_url" value="<?php if( $EM_Event->has_event_location('url') ) echo esc_attr($EM_Event->get_event_location()->url); ?>" />
</div>
<div class="em-input-field em-input-field-text em-location-data-url-text">
	<label for="event_location_url_text"><?php esc_html_e( 'Link Text', 'events-manager')?></label>
	<input class="form-control" id="event_location_url_text" type="text" name="event_location_url_text" value="<?php if( $EM_Event->has_event_location('url') ) echo esc_attr($EM_Event->get_event_location()->text); ; ?>" />
</div>