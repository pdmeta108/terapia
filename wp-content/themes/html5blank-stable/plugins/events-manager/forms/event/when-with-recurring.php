<?php
/* Used by the buddypress and front-end editors to display event time-related information */
global $EM_Event;
$days_names = em_get_days_names();
$hours_format = em_get_hour_format();
$admin_recurring = is_admin() && $EM_Event->is_recurring();
?>
<!-- START recurrence postbox -->
<div id="em-form-with-recurrence" class="event-form-with-recurrence event-form-when">
	<p><?php _e('Este es un evento recurrente.', 'events-manager'); ?> <input type="checkbox" id="em-recurrence-checkbox" name="recurring" value="1" <?php if($EM_Event->is_recurring()) echo 'checked' ?> /></p>
	<div class="form-group em-date-range">
		<span class="em-recurring-text"><?php _e ( 'El evento aparece desde...', 'events-manager'); ?></span>
		<span class="em-event-text"><?php _e ( 'Desde ', 'events-manager'); ?></span>				
		<input class="mb-4 form-control datetimepicker em-date-start em-date-input-loc" type="text" />
		<input class="form-control em-date-input" type="hidden" name="event_start_date" value="<?php echo $EM_Event->start()->getDate(); ?>" />
		<span class="em-recurring-text"><?php _e('hasta','events-manager'); ?></span>
		<span class="em-event-text"><?php _e('hasta','events-manager'); ?></span>
		<input class="form-control datetimepicker em-date-end em-date-input-loc" type="text" />
		<input class="form-control em-date-input" type="hidden" name="event_end_date" value="<?php echo $EM_Event->end()->getDate(); ?>" />
	</div>
	<div class="form-group">
		<span class="em-recurring-text"><?php _e('El evento comienza desde...','events-manager'); ?></span>
		<span class="em-event-text"><?php _e('El evento comienza','events-manager'); ?></span>
		<input class="mb-4 form-control em-time-input em-time-start" type="text" size="8" maxlength="8" name="event_start_time" value="<?php echo $EM_Event->start()->i18n($hours_format); ?>" />
		<?php _e('hasta','events-manager'); ?>
		<input class="mb-4 form-control em-time-input em-time-end" type="text" size="8" maxlength="8" name="event_end_time" value="<?php echo $EM_Event->end()->i18n($hours_format); ?>" />
		<?php _e('Todo el día','events-manager'); ?> <input type="checkbox" class="em-time-allday" name="event_all_day" id="em-time-all-day" value="1" <?php if(!empty($EM_Event->event_all_day)) echo 'checked="checked"'; ?> />
	</div>
	<?php if( get_option('dbem_timezone_enabled') ): ?>
	<div class="form-group em-timezone">
		<label for="event-timezone"><?php esc_html_e('Huso horario', 'events-manager'); ?></label>
		<select class="select" id="event-timezone" name="event_timezone" aria-describedby="timezone-description">
			<?php echo wp_timezone_choice( $EM_Event->get_timezone()->getName(), get_user_locale() ); ?>
		</select>
	</div>
	<?php endif; ?>
	<div class="em-recurring-text">
		<p>
			<?php _e ( 'Este evento se repite', 'events-manager'); ?> 
			<select class="select" id="recurrence-frequency" name="recurrence_freq">
				<?php
					$freq_options = array ("daily" => __ ( 'Diariamente', 'events-manager'), "weekly" => __ ( 'Semanalmente', 'events-manager'), "monthly" => __ ( 'Mensualmente', 'events-manager'), 'yearly' => __('Anualmente','events-manager') );
					em_option_items ( $freq_options, $EM_Event->recurrence_freq ); 
				?>
			</select>
			<?php _e ( 'Cada', 'events-manager')?>
			<input class="recurrence-interval" id="recurrence-interval" name='recurrence_interval' size='2' value='<?php echo $EM_Event->recurrence_interval ; ?>' />
			<span class='interval-desc' id="interval-daily-singular"><?php _e ( 'día', 'events-manager')?></span>
			<span class='interval-desc' id="interval-daily-plural"><?php _e ( 'días', 'events-manager') ?></span>
			<span class='interval-desc' id="interval-weekly-singular"><?php _e ( 'en la semana', 'events-manager'); ?></span>
			<span class='interval-desc' id="interval-weekly-plural"><?php _e ( 'en las semanas', 'events-manager'); ?></span>
			<span class='interval-desc' id="interval-monthly-singular"><?php _e ( 'en el mes', 'events-manager')?></span>
			<span class='interval-desc' id="interval-monthly-plural"><?php _e ( 'en los meses', 'events-manager')?></span>
			<span class='interval-desc' id="interval-yearly-singular"><?php _e ( 'año', 'events-manager')?></span> 
			<span class='interval-desc' id="interval-yearly-plural"><?php _e ( 'años', 'events-manager') ?></span>
		</p>
		<p class="alternate-selector" id="weekly-selector">
			<?php
				$saved_bydays = ($EM_Event->is_recurring()) ? explode ( ",", $EM_Event->recurrence_byday ) : array(); 
				em_checkbox_items ( 'recurrence_bydays[]', $days_names, $saved_bydays ); 
			?>
		</p>
		<p class="alternate-selector" id="monthly-selector" style="display:inline;">
			<select class="select" id="monthly-modifier" name="recurrence_byweekno">
				<?php
					$weekno_options = array ("1" => __ ( 'primero', 'events-manager'), '2' => __ ( 'segundo', 'events-manager'), '3' => __ ( 'tercero', 'events-manager'), '4' => __ ( 'cuarto', 'events-manager'), '5' => __ ( 'quinto', 'events-manager'), '-1' => __ ( 'último', 'events-manager') ); 
					em_option_items ( $weekno_options, $EM_Event->recurrence_byweekno  ); 
				?>
			</select>
			<select class="select" id="recurrence-weekday" name="recurrence_byday">
				<?php em_option_items ( $days_names, $EM_Event->recurrence_byday  ); ?>
			</select>
			<?php _e('de cada mes','events-manager'); ?>
		</p>
		<p class="em-duration-range">
			<?php echo sprintf(__('Cada evento aparece en %s día(s)','events-manager'), '<input class="recurrence-interval" id="end-days" type="text" size="8" maxlength="8" name="recurrence_days" value="'. $EM_Event->recurrence_days .'" />'); ?>
		</p>
		<p class="em-range-description"><em><?php _e( 'Para un evento recurrente, el evento de un día será creado en cada fecha recurrente entre el rango de fecha.', 'events-manager'); ?></em></p>
	</div>
	<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready( function($) {
		$('#em-recurrence-checkbox').on('change', function(){
			if( $('#em-recurrence-checkbox').is(':checked') ){
				$('.em-recurring-text').show();
				$('.em-event-text').hide();
			}else{
				$('.em-recurring-text').hide();
				$('.em-event-text').show();						
			}
		});
		$('#em-recurrence-checkbox').trigger('change');
	});
	//]]>
	</script>
</div>