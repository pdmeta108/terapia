<?php 
/*
 * This file contains the HTML generated for full calendars. You can copy this file to yourthemefolder/plugins/events-manager/templates and modify it in an upgrade-safe manner.
 *
 * Note that leaving the class names for the previous/next links will keep the AJAX navigation working.
 *
 * There are two variables made available to you: 
 */
/* @var array $calendar - contains an array of information regarding the calendar and is used to generate the content */
/* @var array $args - the arguments passed to EM_Calendar::output() */

$cal_count = count($calendar['cells']); //to prevent an extra tr
$col_count = $tot_count = 1; //this counts collumns in the $calendar_array['cells'] array
$col_max = count($calendar['row_headers']); //each time this collumn number is reached, we create a new collumn, the number of cells should divide evenly by the number of row_headers
$EM_DateTime = new EM_DateTime($calendar['month_start'], 'UTC');
?>

<div class="card">
	<div class="card-body">

	<div class="fc fc-unthemed fc-ltr">
	<div class="fc-toolbar fc-header-toolbar">
		<div class="fc-left">
			<div class="fc-button-group">
				<a class="em-calnav full-link em-calnav-prev" href="<?php echo esc_url($calendar['links']['previous_url']); ?>">
					<button type="button" class="fc-prev-button fc-button fc-state-default fc-corner-left">
						<span class="fc-icon fc-icon-left-single-arrow">

						</span>
					</button>
				</a>
				<a class="em-calnav full-link em-calnav-next" href="<?php echo esc_url($calendar['links']['next_url']); ?>">
					<button class="fc-next-button fc-button fc-state-default fc-corner-right">
						<span class="fc-icon fc-icon-right-single-arrow">
					
						</span>
					</button>
				</a>
			</div>
		</div>
		<div class="fc-right"></div>
		<div class="fc-center month_name">
		<h2><?php echo esc_html($EM_DateTime->i18n(get_option('dbem_full_calendar_month_format'))); ?></h2>
		</div>
		<div class="fc-clear"></div>
	</div>
	<div class="fc-view-container">
		<div class="fc-view">
			<table>
				<thead class="fc-head">
					<tr class="days-names">
						<th class="fc-day-header fc-widget-header">
						<?php echo implode('</th><th class="fc-day-header fc-widget-header">',$calendar['row_headers']); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="fc-widget-content">
							<div class="fc-scroller fc-day-grid-container">
								<div class="fc-day-grid">
									<div class="fc-row fc-week fc-widget-content fc-rigid">
										<div class="fc-bg">
										<tr style="height: 105px;">
											<?php
											foreach($calendar['cells'] as $date => $cell_data ){
												$class = ( !empty($cell_data['events']) && count($cell_data['events']) > 0 ) ? 'fc-day-top eventful':'fc-day-top eventless';
												if (!empty($cell_data['type'])){
													if(strcmp($cell_data['type'], 'pre') == 0):
														$class .= " fc-other-month";
													elseif (strcmp($cell_data['type'], 'post') == 0):
														$class .= " fc-other-month";
													elseif( strcmp($cell_data['type'], 'today') == 0):
														$class.= " fc-state-higlight";
													endif;
												}
												//In some cases (particularly when long events are set to show here) long events and all day events are not shown in the right order. In these cases, 
												//if you want to sort events cronologically on each day, including all day events at top and long events within the right times, add define('EM_CALENDAR_SORTTIME', true); to your wp-config.php file 
												if( defined('EM_CALENDAR_SORTTIME') && EM_CALENDAR_SORTTIME ) ksort($cell_data['events']); //indexes are timestamps
												?>
												<td class="<?php echo esc_attr($class); ?>">
													<?php if( !empty($cell_data['events']) && count($cell_data['events']) > 0 ): ?>
													<a href="<?php echo esc_url($cell_data['link']); ?>" title="<?php echo esc_attr($cell_data['link_title']); ?>"><?php echo esc_html(date('j',$cell_data['date'])); ?></a>
													<div class="event-container">
														<?php echo EM_Events::output($cell_data['events'],array('format'=>get_option('dbem_full_calendar_event_format'))); ?>
														<?php if( $args['limit'] && $cell_data['events_count'] > $args['limit'] && get_option('dbem_display_calendar_events_limit_msg') != '' ): ?>
														<li><a href="<?php echo esc_url($cell_data['link']); ?>"><?php echo get_option('dbem_display_calendar_events_limit_msg'); ?></a></li>
														<?php endif; ?>
													</div>
													<?php else:?>
													<?php echo esc_html(date('j',$cell_data['date'])); ?>
													<?php endif; ?>
												</td>
												<?php
												//create a new row once we reach the end of a table collumn
												$col_count= ($col_count == $col_max ) ? 1 : $col_count+1;
												echo ($col_count == 1 && $tot_count < $cal_count) ? '</tr><tr style="height: 105px;">':'';
												$tot_count ++; 
											}
											?>
										</tr>
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

	</div>
</div>

