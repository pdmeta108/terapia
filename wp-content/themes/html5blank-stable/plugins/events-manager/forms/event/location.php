<?php
global $EM_Event;
$required = apply_filters('em_required_html','<i>*</i>');

//determine location types (if neexed)
$location_types = array();
if( !get_option('dbem_require_location') ){
	$location_types[0] = array(
		'selected' =>  $EM_Event->location_id === '0' || $EM_Event->location_id === 0,
		'description' => esc_html__('Sin ubicación','events-manager'),
	);
}
if( EM_Locations::is_enabled() ){
	$location_types['location'] = array(
		'selected' =>  !empty($EM_Event->location_id),
		'display-class' => 'em-location-type-place',
		'description' => esc_html__('Ubicación física','events-manager'),
	);
}
foreach( EM_Event_Locations\Event_Locations::get_types() as $event_location_type => $EM_Event_Location_Class ){ /* @var EM_Event_Locations\Event_Location $EM_Event_Location_Class */
	if( $EM_Event_Location_Class::is_enabled() ){
		$location_types[$EM_Event_Location_Class::$type] = array(
			'display-class' => 'em-event-location-type-'. $EM_Event_Location_Class::$type,
			'selected' => $EM_Event_Location_Class::$type == $EM_Event->event_location_type,
			'description' => $EM_Event_Location_Class::get_label(),
		);
	}
}
?>
<div class="em-input-field em-input-field-select em-location-types <?php if( count($location_types) == 1 ) echo 'em-location-types-single'; ?>">
	<label><?php esc_html_e ( 'Tipo de ubicación', 'events-manager')?></label>
	<select name="location_type" class="em-location-types-select" data-active="<?php echo esc_attr($EM_Event->event_location_type); ?>">
		<?php foreach( $location_types as $location_type => $location_type_option ): ?>
		<option value="<?php echo esc_attr($location_type); ?>" <?php if( !empty($location_type_option['selected']) ) echo 'selected="selected"'; ?> data-display-class="<?php if( !empty($location_type_option['display-class']) ) echo esc_attr($location_type_option['display-class']); ?>">
			<?php echo esc_html($location_type_option['description']); ?>
		</option>
		<?php endforeach; ?>
	</select>
	<?php if( $EM_Event->has_event_location() ): ?>
		<div class="em-location-type-delete-active-alert em-notice-warning">
			<div class="warning-bold">
				<p><em><?php esc_html_e('Estás cambiando el tipo de ubicación, si tu actualizas este evento tus datos de ubicación del evento previo serán borrados.', 'events-manager'); ?></em></p>
			</div>
			<?php $EM_Event->get_event_location()->admin_delete_warning(); ?>
		</div>
	<?php endif; ?>
</div>
<?php if( EM_Locations::is_enabled() ): ?>
<div id="em-location-data" class="em-location-data em-location-type em-location-type-place <?php if( count($location_types) == 1 ) echo 'em-location-type-single'; ?>">
	<div id="location_coordinates" style='display: none;'>
		<input id='form-control location-latitude' name='location_latitude' type='text' value='<?php echo esc_attr($EM_Event->get_location()->location_latitude); ?>' size='15' />
		<input id='form-control location-longitude' name='location_longitude' type='text' value='<?php echo esc_attr($EM_Event->get_location()->location_longitude); ?>' size='15' />
	</div>
	<table class="em-location-data">
		<?php if( get_option('dbem_use_select_for_locations') || !$EM_Event->can_manage('edit_locations','edit_others_locations') ) : ?>
		<tbody class="em-location-data">
			<tr class="em-location-data-select">
				<th><?php esc_html_e('Ubicación:','events-manager') ?> </th>
				<td>
					<select name="location_id" id='location-select-id' size="1">
						<?php
						if ( count($location_types) == 1 && !get_option('dbem_require_location') ){ // we don't consider optional locations as a type for ddm
							?>
							<option value="0"><?php esc_html_e('No hay ubicación','events-manager'); ?></option>
							<?php
						}elseif( empty(get_option('dbem_default_location')) ){
							?>
							<option value="0"><?php esc_html_e('Seleccionar ubicación','events-manager'); ?></option>
							<?php
						}
						$ddm_args = array('private'=>$EM_Event->can_manage('read_private_locations'));
						$ddm_args['owner'] = (is_user_logged_in() && !current_user_can('read_others_locations')) ? get_current_user_id() : false;
						$locations = EM_Locations::get($ddm_args);
						$selected_location = !empty($EM_Event->location_id) || !empty($EM_Event->event_id) ? $EM_Event->location_id:get_option('dbem_default_location');
						foreach($locations as $EM_Location) {
							$selected = ($selected_location == $EM_Location->location_id) ? "selected='selected' " : '';
							if( $selected ) $found_location = true;
					        ?>
					        <option value="<?php echo esc_attr($EM_Location->location_id) ?>" title="<?php echo esc_attr("{$EM_Location->location_latitude},{$EM_Location->location_longitude}"); ?>" <?php echo $selected ?>><?php echo esc_html($EM_Location->location_name); ?></option>
					        <?php
						}
						if( empty($found_location) && !empty($EM_Event->location_id) ){
							$EM_Location = $EM_Event->get_location();
							if( $EM_Location->post_id ){
								?>
						        <option value="<?php echo esc_attr($EM_Location->location_id) ?>" title="<?php echo esc_attr("{$EM_Location->location_latitude},{$EM_Location->location_longitude}"); ?>" selected="selected"><?php echo esc_html($EM_Location->location_name); ?></option>
						        <?php
							}
						}
						?>
					</select>
				</td>
			</tr>
		</tbody>
		<?php else : ?>
		<tbody class="em-location-data">
			<?php
			global $EM_Location;
			if( $EM_Event->location_id !== 0 ){
				$EM_Location = $EM_Event->get_location();
			}elseif(get_option('dbem_default_location') > 0){
				$EM_Location = em_get_location(get_option('dbem_default_location'));
			}else{
				$EM_Location = new EM_Location();
			}
			?>
			<tr class="em-location-data-name">
				<th><?php _e ( 'Nombre de ubicación:', 'events-manager')?></th>
				<td>
					<input class="mb-4 form-control" id='location-id' name='location_id' type='hidden' value='<?php echo esc_attr($EM_Location->location_id); ?>' size='15' />
					<input class="mb-4 form-control" id="location-name" type="text" name="location_name" value="<?php echo esc_attr($EM_Location->location_name, ENT_QUOTES); ?>" /><?php echo $required; ?>
					<br />
					<em id="em-location-search-tip"><?php esc_html_e( 'Crear una ubicación o comienza a teclear para buscar una ubicación previamente creada.', 'events-manager')?></em>
					<em id="em-location-reset" style="display:none;"><?php esc_html_e('No puedes editar ubicaciones guardadas aquí.', 'events-manager'); ?> <a href="#"><?php esc_html_e('Reiniciar este formulario para crear una ubicación o busca otra vez.', 'events-manager')?></a></em>
				</td>
		    </tr>
			<tr class="em-location-data-address">
				<th><?php _e ( 'Dirección:', 'events-manager')?>&nbsp;</th>
				<td>
					<input class="mb-4 form-control" id="location-address" type="text" name="location_address" value="<?php echo esc_attr($EM_Location->location_address); ; ?>" /><?php echo $required; ?>
				</td>
			</tr>
			<tr class="em-location-data-town">
				<th><?php _e ( 'Ciudad/Pueblo:', 'events-manager')?>&nbsp;</th>
				<td>
					<input class="mb-4 form-control" id="location-town" type="text" name="location_town" value="<?php echo esc_attr($EM_Location->location_town); ?>" /><?php echo $required; ?>
				</td>
			</tr>
			<tr class="em-location-data-state">
				<th><?php _e ( 'Estado/Condado:', 'events-manager')?>&nbsp;</th>
				<td>
					<input class="mb-4 form-control" id="location-state" type="text" name="location_state" value="<?php echo esc_attr($EM_Location->location_state); ?>" />
				</td>
			</tr>
			<tr class="em-location-data-postcode">
				<th><?php _e ( 'Código Postal:', 'events-manager')?>&nbsp;</th>
				<td>
					<input class="mb-4 form-control" id="location-postcode" type="text" name="location_postcode" value="<?php echo esc_attr($EM_Location->location_postcode); ?>" />
				</td>
			</tr>
			<tr class="em-location-data-region">
				<th><?php _e ( 'Región:', 'events-manager')?>&nbsp;</th>
				<td>
					<input class="mb-4 form-control" id="location-region" type="text" name="location_region" value="<?php echo esc_attr($EM_Location->location_region); ?>" />
				</td>
			</tr>
			<tr class="em-location-data-country">
				<th><?php _e ( 'País:', 'events-manager')?>&nbsp;</th>
				<td>
					<select class="mb-4 select" id="location-country" name="location_country">
						<option value="0" <?php echo ( $EM_Location->location_country == '' && $EM_Location->location_id == '' && get_option('dbem_location_default_country') == '' ) ? 'selected="selected"':''; ?>><?php _e('No se ha seleccionado','events-manager'); ?></option>
						<?php foreach(em_get_countries() as $country_key => $country_name): ?>
						<option value="<?php echo esc_attr($country_key); ?>" <?php echo ( $EM_Location->location_country == $country_key || ($EM_Location->location_country == '' && $EM_Location->location_id == '' && get_option('dbem_location_default_country')==$country_key) ) ? 'selected="selected"':''; ?>><?php echo esc_html($country_name); ?></option>
						<?php endforeach; ?>
					</select><?php echo $required; ?>
				</td>
			</tr>
			<tr class="mb-4 em-location-data-url">
				<th><?php esc_html_e( 'URL:', 'events-manager')?>&nbsp;</th>
				<td>
					<input class="form-control" id="location-url" type="text" name="location_url" value="<?php echo esc_attr($EM_Location->location_url); ; ?>" />
				</td>
			</tr>
		</tbody>
		<?php endif; ?>
	</table>
	<?php if ( get_option( 'dbem_gmap_is_active' ) ):?>
		<?php em_locate_template('forms/map-container.php',true); ?>
	<?php endif; ?>
	<br style="clear:both;" />
</div>
<?php endif; ?>
<div class="em-event-location-data">
	<?php foreach( EM_Event_Locations\Event_Locations::get_types() as $event_location_type => $EM_Event_Location_Class ): /* @var EM_Event_Locations\Event_Location $EM_Event_Location_Class */ ?>
		<?php if( $EM_Event_Location_Class::is_enabled() ): ?>
			<div class="em-location-type em-event-location-type-<?php echo esc_attr($event_location_type); ?>  <?php if( count($location_types) == 1 ) echo 'em-location-type-single'; ?>">
			<?php $EM_Event_Location_Class::load_admin_template(); ?>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
</div>