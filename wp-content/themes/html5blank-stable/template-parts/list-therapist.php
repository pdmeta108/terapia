<?php /* Template Name: List Therapist Template */ get_header();

get_template_part('template-parts/breadcrumb');
?>


<!-- Page Content -->
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-4 col-xl-3 theiaStickySidebar">	
			<!-- Search Filter -->
				<div class="card search-filter">
					<div class="card-header">
						<h4 class="card-title mb-0">Profesiones</h4>
					</div>
					<div class="card-body">
						<form action="" method="GET">
							<div class="filter-widget">	
								<select name="orderby" id="orderby">
									<option value="registered" <?php echo selected($_GET['orderby'], 'registered'); ?>>Fecha de registro</option>
									<option value="display_name" <?php echo selected($_GET['orderby'], 'display_name'); ?>>Alfabetico</option>
								</select>
								<input id="order" type="hidden" name="order" value="<?php echo (isset($_GET['order']) && $_GET['order'] == 'ASC') ? 'ASC': 'DESC'; ?>">
							</div>
							<div class="filter-widget">
								<input type="text" class="form-control" name="search" value="<?php echo (isset($_GET['search'])) ? $_GET['search']: '';?>" id="s" placeholder="Buscar Usuario" />
							</div>
							<?php
								$args=array(
									'object_type' => array('user'),
								    'show_admin_column' => true
									  );
							    $taxonomies = get_taxonomies( $args, "objects");
                                foreach ($taxonomies as $taxonomy) {
                                    $pterms = get_terms($taxonomy->name, array('parent' => 0, 'orderby' => 'slug', 'hide_empty' => false ));
                                    foreach ($pterms as $pterm) {
                            			if ($pterm->count == 0):
											continue;
										endif; ?>
										<div class="filter-widget">
											<h4><?php echo $pterm->name; ?></h4>
							<?php
                                    		$terms = get_terms($taxonomy->name, array( 'parent' => $pterm->term_id, 'orderby' => 'slug', 'hide_empty' => false ));
                                            foreach ($terms as $term) {
												if (($term->parent == 0) || ($term->count == 0)) { 
													continue;
												}
                            ?>
												<div>
													<label class="custom_check">
														<input type="checkbox" 
														name="profesion[]"
														value="<?php echo $term->slug;?>"
														<?php echo checked(isset($_GET['profesion']) && in_array($term->slug, $_GET['profesion']) ); ?>
														>
														<span class="checkmark"></span><?php echo $term->name; ?></label>
												</div>
							<?php
                                            }
							?>
										</div>
							<?php
                                    }
                                }
							?>
								
							<div class="btn-search">
								<button type="submit" class="btn btn-block">Buscar</button>
							</div>
						</form>
										
					</div>
				</div>
			<!-- /Search Filter -->				
		</div>

<div class="col-md-12 col-lg-8 col-xl-9">

<?php
$taxonomia = 'profesion';
if(array_key_exists('profesion', $_GET)):
	$terminos = get_terms($taxonomia);
	$terapeutas = array();
	if (isset($_GET['profesion'])):
		foreach($_GET['profesion'] as $profesion):
			$term_search_id = get_term_by('slug', $profesion, 'profesion');
			if ($term_search_id->count == 0):
				continue;
			endif;
			$usuarios = get_objects_in_term( $term_search_id->term_id, $taxonomia );

			$args1 = array(
				'role'           => 'terapeuta',
				'include'        => $usuarios,
			);
			if ($_GET['orderby'] == 'display_name') {
				$args2 = array(
					'meta_key' => 'first_name',
    				'orderby'  => 'meta_value',
				);
				$args = array_merge($args1, $args2);
			}
			$my_user_query = new WP_User_Query($args);
			$terapeuta_data = $my_user_query->get_results();
			foreach($terapeuta_data as $data):
				if (is_object_in_term($data->data->ID, $taxonomia, $term_search_id->name)) {
					$terapeutas[] = $data;
				}
			endforeach;
		endforeach;
	endif;

elseif (array_key_exists('search', $_GET)):
	$name = ( isset($_GET['search']) ) ? sanitize_text_field($_GET['search']) : false ;
	if ($search){
    	$my_users = new WP_User_Query(

        	array(
            	'role' => 'terapeuta',
            	'fields'     => 'all',
				'search' => '*'.esc_attr( $search ).'*',
            	'search_columns' => array( 'first_name', 'last_name', 'user_email', 'user_url' )
			));
		
		$terapeutas = $my_users->get_results();

	} 
endif;
?>




<?php
if (isset($terapeutas)):
	foreach($terapeutas as $terapeuta):
		$args = array(
			'user' => $terapeuta
		);
		get_template_part('template-parts/list', 'user', $args);
 endforeach;

else:
	if ($_GET['orderby'] == 'display_name') {
		$args = array(
			'role'    => 'terapeuta',
			'meta_key' => 'first_name',
			'orderby'  => 'meta_value',
		);
		$users = get_users( $args );
	} else {
		$args = array(
			'role'    => 'terapeuta',
		);
		$users = get_users( $args );
	}

	foreach($users as $user):
		$args = array(
			'user' => $user
		);
		get_template_part('template-parts/list', 'user', $args);
	endforeach;
endif;
?>
<!-- /Upcoming Appointment Tab -->
</div>
</div>
</div>
<script type="application/javascript">
const archiveOrderby = document.getElementById('orderby');
const archiveOrder = document.getElementById('order');

if (archiveOrder && archiveOrderby) {

    const setOrder = () => {

        const orderBy = archiveOrderby.options[archiveOrderby.selectedIndex].value;

        if ('registered' === orderBy) {
            archiveOrder.value = 'ASC';
        } else {
            archiveOrder.value = 'DESC';
        }
    }

    archiveOrderby.addEventListener('change', setOrder);
    setOrder();
}
</script>
<?php get_footer(); ?>