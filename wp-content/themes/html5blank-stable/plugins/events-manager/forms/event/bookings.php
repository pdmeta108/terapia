<?php
global $EM_Event, $post, $allowedposttags, $EM_Ticket, $col_count;
$reschedule_warnings = !empty($EM_Event->event_id) && $EM_Event->is_recurring() && $EM_Event->event_rsvp;
?>
<div id="event-rsvp-box">
	<input id="event-rsvp" name='event_rsvp' value='1' type='checkbox' <?php echo ($EM_Event->event_rsvp) ? 'checked="checked"' : ''; ?> />
	&nbsp;&nbsp;
	<?php _e ( 'Activar el registro para este evento', 'events-manager')?>
</div>
<div id="event-rsvp-options" style="<?php echo ($EM_Event->event_rsvp) ? '':'display:none;' ?>">
	<?php 
	do_action('em_events_admin_bookings_header', $EM_Event);
	//get tickets here and if there are none, create a blank ticket
	$EM_Tickets = $EM_Event->get_tickets();
	if( count($EM_Tickets->tickets) == 0 ){
		$EM_Tickets->tickets[] = new EM_Ticket();
		$delete_temp_ticket = true;
	}
	?>
	<div class="event-rsvp-options-tickets <?php if( $reschedule_warnings ) echo 'em-recurrence-reschedule'; ?>">
		<?php
		//output title
		if( get_option('dbem_bookings_tickets_single') && count($EM_Tickets->tickets) == 1 ){
			?>
			<h4><?php esc_html_e('Opciones de Ticket','events-manager'); ?></h4>
			<?php
		}else{
			?>
			<h4><?php esc_html_e('Tickets','events-manager'); ?></h4>
			<?php
		}
		//If this event is a recurring template, we need to warn the user that editing tickets will delete previous bookings
		if( $reschedule_warnings ){ 
			?>
			<div class="recurrence-reschedule-warning">
			    <p><?php esc_html_e( 'Modificaciones para los tickets del evento causarán que las reservaciones de todas las recurrencias individuales de este evento sean borradas.', 'events-manager'); ?></p>
	    		<p>			
			    	<a href="<?php echo esc_url( add_query_arg(array('scope'=>'all', 'recurrence_id'=>$EM_Event->event_id), em_get_events_admin_url()) ); ?>">
						<strong><?php esc_html_e('Puedes editar recurrencias individuales y desasociarlas con este evento recurrente.', 'events-manager'); ?></strong>
					</a>
                </p>
	    	</div>
			<?php 
		}
		$container_classes = array();
		if( $reschedule_warnings && empty($_REQUEST['recreate_tickets']) ) $container_classes[] = 'reschedule-hidden';
		if( get_option('dbem_bookings_tickets_ordering') ) $container_classes[] = 'em-tickets-sortable';
		?>
		<div id="em-tickets-form" class="em-tickets-form <?php echo implode(' ', $container_classes); ?>">
		<?php
		//output ticket options
		if( get_option('dbem_bookings_tickets_single') && count($EM_Tickets->tickets) == 1 ){
			$col_count = 1;	
			$EM_Ticket = $EM_Tickets->get_first();				
			include( em_locate_template('forms/ticket-form.php') ); //in future we'll be accessing forms/event/bookings-ticket-form.php directly
		}else{
			?>
			<p><em><?php esc_html_e('Puedes tener tickets individuales o múltiples, donde ciertos tickets se pueden volver disponibles de acuerdo a ciertas condiciones, por ejemplos reservaciones tempranas, grupos de descuento, reservaciones máximas por ticket, etc.', 'events-manager'); ?> <?php esc_html_e('HTML Básico es permitido en las descripciones y la identificación del ticket.','events-manager'); ?></em></p>					
			<table class="form-table">
				<thead>
					<tr valign="top">
						<th colspan="2"><?php esc_html_e('Nombre del ticket','events-manager'); ?></th>
						<th><?php esc_html_e('Precio','events-manager'); ?></th>
						<th><?php esc_html_e('Min/Max','events-manager'); ?></th>
						<th><?php esc_html_e('Comienzo/Fin','events-manager'); ?></th>
						<th><?php esc_html_e('Espacios Disponibles','events-manager'); ?></th>
						<th><?php esc_html_e('Espacios Reservados','events-manager'); ?></th>
					</tr>
				</thead>    
				<tfoot>
					<tr valign="top">
						<td colspan="7">
							<a href="#" id="em-tickets-add"><?php esc_html_e('Añadir nuevo ticket','events-manager'); ?></a>
						</td>
					</tr>
				</tfoot>
				<?php
					$EM_Ticket = new EM_Ticket();
					$EM_Ticket->event_id = $EM_Event->event_id;
					array_unshift($EM_Tickets->tickets, $EM_Ticket); //prepend template ticket for JS
					$col_count = 0;
					foreach( $EM_Tickets->tickets as $EM_Ticket){
						/* @var $EM_Ticket EM_Ticket */
						$class_name = $col_count == 0 ? 'em-ticket-template':'em-ticket';
						?>
						<tbody id="em-ticket-<?php echo $col_count ?>" class="<?php echo $class_name; ?>">
							<tr class="em-tickets-row">
								<td class="ticket-status">
									<span class="dashicons dashicons-menu <?php if($EM_Ticket->ticket_id && $EM_Ticket->is_available(true, true)){ echo 'ticket-on'; }elseif($EM_Ticket->ticket_id > 0){ echo 'ticket-off'; }else{ echo 'ticket-new'; } ?>"></span>
								</td>
								<td class="ticket-name">
									<span class="ticket_name"><?php if($EM_Ticket->ticket_members) echo '* ';?><?php echo wp_kses_data($EM_Ticket->ticket_name); ?></span>
									<div class="ticket_description"><?php echo wp_kses($EM_Ticket->ticket_description,$allowedposttags); ?></div>
									<div class="ticket-actions">
										<a href="#" class="ticket-actions-edit"><?php esc_html_e('Editar','events-manager'); ?></a>
										<?php if( $EM_Ticket->get_bookings_count() == 0 ): ?>
										| <a href="<?php bloginfo('wpurl'); ?>/wp-load.php" class="ticket-actions-delete"><?php esc_html_e('Borrar','events-manager'); ?></a>
										<?php else: ?>
										| <a href="<?php echo esc_url(add_query_arg('ticket_id', $EM_Ticket->ticket_id, $EM_Event->get_bookings_url())); ?>"><?php esc_html_e('Ver reservas','events-manager'); ?></a>
										<?php endif; ?>
									</div>
								</td>
								<td class="ticket-price">
									<span class="ticket_price"><?php echo ($EM_Ticket->ticket_price) ? esc_html($EM_Ticket->get_price_precise(true)) : esc_html__('Gratis','events-manager'); ?></span>
								</td>
								<td class="ticket-limit">
									<span class="ticket_min">
										<?php  echo ( !empty($EM_Ticket->ticket_min) ) ? esc_html($EM_Ticket->ticket_min):'-'; ?>
									</span> /
									<span class="ticket_max"><?php echo ( !empty($EM_Ticket->ticket_max) ) ? esc_html($EM_Ticket->ticket_max):'-'; ?></span>
								</td>
								<td class="ticket-time">
									<span class="ticket_start ticket-dates-from-normal"><?php echo ( !empty($EM_Ticket->ticket_start) ) ? $EM_Ticket->start()->format(get_option('dbem_date_format')):''; ?></span>
									<span class="ticket_start_recurring_days ticket-dates-from-recurring"><?php if( !empty($EM_Ticket->ticket_meta['recurrences']) ) echo $EM_Ticket->ticket_meta['recurrences']['start_days']; ?></span>
									<span class="ticket_start_recurring_days_text ticket-dates-from-recurring <?php if( !empty($EM_Ticket->ticket_meta['recurrences']) && !is_numeric($EM_Ticket->ticket_meta['recurrences']['start_days']) ) echo 'hidden'; ?>"><?php _e('día(s)','events-manager'); ?></span>
									<span class="ticket_start_time"><?php echo ( !empty($EM_Ticket->ticket_start) ) ? $EM_Ticket->start()->format( em_get_hour_format() ):''; ?></span>
									<br />
									<span class="ticket_end ticket-dates-from-normal"><?php echo ( !empty($EM_Ticket->ticket_end) ) ? $EM_Ticket->end()->format(get_option('dbem_date_format')):''; ?></span>
									<span class="ticket_end_recurring_days ticket-dates-from-recurring"><?php if( !empty($EM_Ticket->ticket_meta['recurrences']) ) echo $EM_Ticket->ticket_meta['recurrences']['end_days']; ?></span>
									<span class="ticket_end_recurring_days_text ticket-dates-from-recurring <?php if( !empty($EM_Ticket->ticket_meta['recurrences']) && !is_numeric($EM_Ticket->ticket_meta['recurrences']['end_days']) ) echo 'hidden'; ?>"><?php _e('día(s)','events-manager'); ?></span>
									<span class="ticket_end_time"><?php echo ( !empty($EM_Ticket->ticket_end) ) ? $EM_Ticket->end()->format( em_get_hour_format() ):''; ?></span>
								</td>
								<td class="ticket-qty">
									<span class="ticket_available_spaces"><?php echo $EM_Ticket->get_available_spaces(); ?></span>/
									<span class="ticket_spaces"><?php echo $EM_Ticket->get_spaces() ? $EM_Ticket->get_spaces() : '-'; ?></span>
								</td>
								<td class="ticket-booked-spaces">
									<span class="ticket_booked_spaces"><?php echo $EM_Ticket->get_booked_spaces(); ?></span>
								</td>
								<?php do_action('em_event_edit_ticket_td', $EM_Ticket); ?>
							</tr>
							<tr class="em-tickets-row-form" style="display:none;">
								<td colspan="<?php echo apply_filters('em_event_edit_ticket_td_colspan', 7); ?>">
									<?php include( em_locate_template('forms/event/bookings-ticket-form.php')); ?>
									<div class="em-ticket-form-actions">
									<button type="button" class="ticket-actions-edited"><?php esc_html_e('Cerrar Editor de Tickets','events-manager')?></button>
									</div>
								</td>
							</tr>
						</tbody>
						<?php
						$col_count++;
					}
					array_shift($EM_Tickets->tickets);
				?>
			</table>
		<?php 
		}
		?>
		</div>
		<?php if( $reschedule_warnings ): //If this event is a recurring template, we need to warn the user that editing tickets will delete previous bookings ?>
		<div class="recurrence-reschedule-buttons">
		    <a href="<?php echo esc_url(add_query_arg('recreate_tickets', null)); ?>" class="button-secondary em-button em-reschedule-cancel<?php if( empty($_REQUEST['recreate_tickets']) ) echo ' reschedule-hidden'; ?>" data-target=".em-tickets-form">
		    	<?php esc_html_e('Cancelar Recreación de Ticket', 'events-manager'); ?>
		    </a>
		    <a href="<?php echo esc_url(add_query_arg('recreate_tickets', '1')); ?>" class="em-reschedule-trigger em-button button-secondary<?php if( !empty($_REQUEST['recreate_tickets']) ) echo ' reschedule-hidden'; ?>" data-target=".em-tickets-form">
		    	<?php esc_html_e('Modificar Eventos Recurrentes Tickets ', 'events-manager'); ?>
		    </a>
	    	<input type="hidden" name="event_recreate_tickets" class="em-reschedule-value" value="<?php echo empty($_REQUEST['recreate_tickets']) ? 0:1 ?>" />
    	</div>
		<?php endif; ?>
	</div>
	<div id="em-booking-options" class="em-booking-options">
	<?php if( !get_option('dbem_bookings_tickets_single') || count($EM_Ticket->get_event()->get_tickets()->tickets) > 1 ): ?>
	<h4><?php esc_html_e('Opciones de Evento','events-manager'); ?></h4>
	<p>
		<label><?php esc_html_e('Espacios en Total','events-manager'); ?></label>
		<input class="form-control" type="text" name="event_spaces" value="<?php if( $EM_Event->event_spaces > 0 ){ echo $EM_Event->event_spaces; } ?>" /><br />
		<em><?php esc_html_e('Tickets individuales con espacios faltantes no estarán disponibles si el total de espacios reservados alcanzan este límite. Dejarlo en blanco para poner sin límite.','events-manager'); ?></em>
	</p>
	<p>
		<label><?php esc_html_e('Espacios Máximos Por Reserva','events-manager'); ?></label>
		<input class="form-control" type="text" name="event_rsvp_spaces" value="<?php if( $EM_Event->event_rsvp_spaces > 0 ){ echo $EM_Event->event_rsvp_spaces; } ?>" /><br />
		<em><?php esc_html_e('Si se establece, el número total de espacios por una sola reserva a este evento no puede excederse a esta cantidad.','events-manager'); ?><?php esc_html_e('Leave blank for no limit.','events-manager'); ?></em>
	</p>
	<p>
		<label><?php esc_html_e('Reserva de Fecha de Corte','events-manager'); ?></label>
		<span class="em-booking-date-normal">
			<span class="em-date-single">
				<input  class="evento-corte" id="em-bookings-date-loc" class="em-date-input-loc" type="text" />
				<input  class="evento-corte" id="em-bookings-date" class="em-date-input" type="hidden" name="event_rsvp_date" value="<?php echo $EM_Event->event_rsvp_date; ?>" />
			</span>
		</span>
		<span class="em-booking-date-recurring">
			<input class="evento-corte" type="text" name="recurrence_rsvp_days" size="3" value="<?php echo absint($EM_Event->recurrence_rsvp_days); ?>" />
			<?php _e('día(s)','events-manager'); ?>
			<select class="select" name="recurrence_rsvp_days_when">
				<option value="before" <?php if( !empty($EM_Event->recurrence_rsvp_days) && $EM_Event->recurrence_rsvp_days <= 0) echo 'selected="selected"'; ?>><?php echo sprintf(_x('%s el evento comienza','antes o después','events-manager'),__('Antes','events-manager')); ?></option>
				<option value="after" <?php if( !empty($EM_Event->recurrence_rsvp_days) && $EM_Event->recurrence_rsvp_days > 0) echo 'selected="selected"'; ?>><?php echo sprintf(_x('%s el evento comienza','antes o después','events-manager'),__('Después','events-manager')); ?></option>
			</select>
			<?php _e('en','events-manager'); ?>
		</span>
		<input class="evento-corte" type="text" name="event_rsvp_time" class="em-time-input" maxlength="8" size="8" value="<?php if (!empty($EM_Event->event_rsvp_time)) echo $EM_Event->rsvp_end()->format(em_get_hour_format()); ?>" />
		<br />
		<em><?php esc_html_e('Esta es la fecha definitiva en la cual las reservaciones serán cerradas por éste evento, sin importar las opciones del ticket individual arriba. El valor por defecto será la fecha del comienzo del evento.','events-manager'); ?></em>
	</p>
	<?php endif; ?>
	</div>
	<?php
		if( !empty($delete_temp_ticket) ){
			array_pop($EM_Tickets->tickets);
		}
		do_action('em_events_admin_bookings_footer', $EM_Event); 
	?>
</div>