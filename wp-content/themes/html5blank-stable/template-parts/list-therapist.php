<?php /* Template Name: List Therapist Template */ get_header();
?>

<!-- Breadcrumb -->
<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo get_home_url(); ?>">Página principal</a></li>
									<li class="breadcrumb-item active" aria-current="page">Lista de Terapeutas</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Lista de Terapeutas</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->

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
									<option value="users_registered" <?php echo selected($_GET['orderby'], 'users_registered'); ?>>Lo mas Nuevo</option>
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
			$term_search_id = get_term_by('name', $profesion, 'profesion');
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
<!-- Upcoming Appointment Tab -->
	<div class="tab-pane show active" id="upcoming-appointments">
		<div class="card card-table mb-0">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover table-center mb-0 wppb-table">
						<thead>
							<tr>
								<th scope="col" colspan="2" class="wppb-sorting text-center">Perfil de usuario</th>
								<th scope="col" class="wppb-sorting">Nombre Completo</th>
								<th scope="col" class="wppb-sorting">Rol de usuario</th>
								<th scope="col" class="wppb-sorting">Pagina Web</th>
								<th scope="col" class="wppb-sorting">Profesion</th>
								<th scope="col">More</th>
							</tr>
						</thead>
<?php
if (isset($terapeutas)):
?>

						
						<tbody>
						<?php
						foreach($terapeutas as $terapeuta):
							$datos = $terapeuta->data;
							

						?>
							<tr>
								<td data-label="Avatar" class="wppb-avatar"><a href="<?php echo the_author_meta( 'foto_usuario'); ?>" class="booking-doc-img">
  <img src="<?php echo the_author_meta( 'foto_usuario'); ?>" class="img-fluid" alt="User Image"></a></td>
								<td data-label="UserEmail" class="wppb-login"><?php echo $datos->user_email; ?></td>
								<td data-label="DisplayName" class="wppb-name"><?php echo $datos->display_name; ?></td>
								<td data-label="Role" class="wppb-role"><?php echo $terapeuta->roles[0]; ?></td>
								<td data-label="WebPage" class="wppb-posts"><?php echo $terapeuta->user_url; ?></td>
								<td data-label="Profession" class="wppb-signup"><?php $terms_usuario = wp_get_object_terms($datos->ID, $taxonomia);
																						foreach($terms_usuario as $term_usuario):
																							echo $term_usuario->name;
																						endforeach; ?></td>
								<td data-label="More" class="wppb-moreinfo"><a href="<?php echo get_author_posts_url($datos->ID); ?>">Ver perfil</a></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					
<?php
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

?>
						<tbody>
<?php
	foreach($users as $user):
		$datos = $user->data;
?>
							<tr>
								<td data-label="Avatar" class="wppb-avatar"><a href="<?php echo the_author_meta( 'foto_usuario'); ?>" class="booking-doc-img">
  <img src="<?php echo the_author_meta( 'foto_usuario'); ?>" class="img-fluid" alt="User Image"></a></td>
								<td data-label="Username" class="wppb-login"><?php echo $datos->user_email; ?></td>
								<td data-label="Firstname" class="wppb-name"><?php echo $datos->display_name; ?></td>
								<td data-label="Role" class="wppb-role"><?php echo $user->roles[0]; ?></td>
								<td data-label="Posts" class="wppb-posts"><?php echo $user->user_url; ?></td>
								<td data-label="Sign-up Date" class="wppb-signup"><?php $terms_usuario = wp_get_object_terms($datos->ID, $taxonomia);
																						foreach($terms_usuario as $term_usuario):
																							echo $term_usuario->name;
																						endforeach; ?></td>
								<td data-label="More" class="wppb-moreinfo"><a href="<?php echo get_author_posts_url($datos->ID); ?>">Ver perfil</a></td>
							</tr>
<?php endforeach; ?>
						</tbody>

<?php
endif;
?>
					</table>
				</div>
			</div>
		</div>
	</div>
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

        if ('users_registered' === orderBy) {
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