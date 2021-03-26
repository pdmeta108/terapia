<?php /* Template Name: Therapist Profile Template */
global $current_user, $wp_roles;
$error = array();
$taxonomia = "profesion";
$url = get_permalink();

if ('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['action']) && $_POST['action'] == 'update-user') {
    /* Update user password. */
    if ( !empty($_POST['passw1'] ) && !empty( $_POST['passw2'] ) ) {
        if ( $_POST['passw1'] == $_POST['passw2'] )
            wp_update_user( array( 'ID' => $current_user->ID, 'user_pass' => esc_attr( $_POST['passw1'] ) ) );
        else
            $error[] = __('Las contraseñas que ingresaste no concuerdan.  La contraseña no se ha actualizado.', 'profile');
    }

    /* Update user information. */
    if ( !empty( $_POST['user_url'] ) )
        wp_update_user( array( 'ID' => $current_user->ID, 'user_url' => esc_url( $_POST['user_url'] ) ) );
    if ( !empty( $_POST['user_email'] ) ){
        $new_email = sanitize_email( $_POST['user_email'] );
        if (!is_email(esc_attr( $new_email )))
            $error[] = __('El correo electrónico que ingresó es invalido.  Por favor intente de nuevo.', 'profile');
        elseif(email_exists($new_email) != $current_user->id )
            $error[] = __('El correo electrónico que ingresó lo está usando otro usuario.  Intente con otro.', 'profile');
        else{
            wp_update_user( array ('ID' => $current_user->ID, 'user_email' => $new_email));
        }
    }

    if ( !empty( $_POST['first_name'] ) )
        update_user_meta( $current_user->ID, 'first_name', esc_attr( $_POST['first_name'] ) );
    if ( !empty( $_POST['last_name'] ) )
        update_user_meta($current_user->ID, 'last_name', esc_attr( $_POST['last_name'] ) );

    /* Redirect so the page will show updated info.*/
  /*I am not Author of this Code- i dont know why but it worked for me after changing below line to if ( count($error) == 0 ){ */
    if ( count($error) == 0 ) {
        //action hook for plugins and extra fields saving
        do_action('edit_user_profile_update', $current_user->ID);
        wp_safe_redirect($url.'?updated=true');
        exit;
    }
}

get_header();


?>

<!-- Breadcrumb -->
<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo get_home_url();?>">Página principal</a></li>
									<li class="breadcrumb-item active" aria-current="page">Perfil del Terapeuta</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Perfil del Terapeuta</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
	<div class="container-fluid">
		<div class="row">

        <?php
				get_template_part('template-parts/sidebar-user');
		?>

            <!-- Profile Settings Form -->
            <div class="col-md-7 col-lg-8 col-xl-9">
				<div class="card">
					<div class="card-body">
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>
                            <div id="post-<?php the_ID();?>">
                            <?php if ( !is_user_logged_in() ) :?>
                                <div class="alert alert-warning alert-dismissible fade show warning" role="alert">
                                    <?php _e('Debes de iniciar tu sesión para poder editar tu perfil.', 'profile');?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </div><!-- .warning -->
                            <?php else: ?>
                                <?php if ( count($error) > 0 ) : 
                                    echo '<div class="alert alert-danger alert-dismissible fade show error" role="alert"> <strong>Error!</strong> ' . implode("<br />", $error) . '
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button></div>';
                                elseif ($_GET['updated']):
                                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Exito!</strong> Tu perfil ha sido actualizado.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                                elseif ($_GET['uploaded']):
                                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Exito!</strong> Tu perfil ha actualizado una foto.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                            endif;
                            ?>

                                        <div class="col-md-12">
											<div class="form-group">
												<div class="change-avatar">
													<div class="profile-img">
                                                    <?php 
                                                    $foto_usuario = get_the_author_meta( 'foto_usuario', $current_user->ID );
                                                    if ($foto_usuario){
                                                     ?>
                                                      <img src="<?php echo $foto_usuario;?>" alt="foto_usuario">
                                                    <?php } else { ?>
														<img src="<?php echo get_stylesheet_directory_uri();?>/assets/img/doctors/doctor-thumb-02.jpg" alt="User Image">
													<?php } ?>
                                                    </div>
													<?php echo do_shortcode('[wpcfu_form]'); ?>
												</div>
											</div>
										</div>
							<!-- Edit Profile Form -->
                            <form method="POST" action="<?php the_permalink();?>">
                                <div class="row form-row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">Nombre</label>
                                            <input class="form-control" name="first_name" type="text" id="first_name" value="<?php the_author_meta( 'first_name', $current_user->ID );?>" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Apellidos</label>
                                            <input class="form-control" name="last_name" type="text" id="last_name" value="<?php the_author_meta( 'last_name', $current_user->ID );?>" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="user_email">Correo electronico</label>
                                            <input class="form-control" name="user_email" type="text" id="user_email" value="<?php the_author_meta( 'user_email', $current_user->ID );?>"></input>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="user_url">Pagina Web</label>
                                            <input class="form-control" name="user_url" type="text" id="user_url" value="<?php the_author_meta( 'user_url', $current_user->ID );?>">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="passw1"><?php _e('Contraseña *', 'profile'); ?> </label>
                                            <input class="text-input form-control" name="passw1" type="password" id="passw1" />
                                        </div>
                                    </div><!-- .form-password -->
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="passw2"><?php _e('Repetir Contraseña *', 'profile'); ?></label>
                                            <input class="text-input form-control" name="passw2" type="password" id="passw2" />
                                        </div>
                                    </div><!-- .form-password -->
                                                    
                                    <?php 
                                        //action hook for plugin and extra fields
                                        do_action('edit_user_profile',$current_user);
                                    ?>
                                </div>
                                <div class="submit-section">
                                    <input class="btn btn-primary btn-block btn-lg login-btn" type="submit" value="Editar">
                                    <?php wp_nonce_field( 'update-user' );?>
                                            
                                    <input name="action" type="hidden" id="action" value="update-user" />
                                </div>
                            </form>
                        </div>                   
                        <?php endif;
                        endwhile;
                    endif;?>										
				</div>
			</div>
		</div>
		<!-- /Register Content -->
								
						</div>
					</div>

				</div>		
			<!-- /Page Content -->

<?php get_footer();?>

<?php
                                          
                                        
                                        // echo do_shortcode('[wppb-edit-profile]');
										// $current_user = get_current_user_id();
										// $all_meta_for_user = array_map( function( $a ){ return $a[0]; }, get_user_meta( $current_user ) );
										// print_r( $all_meta_for_user['user_email'] )
										// $user_info = get_userdata( $current_user );
										// print_r($user_info);
										?>

<!-- <label for="profesion">Profesion</label>
                                            <input name="profesion" type="text" id="profesion" value="<?php  ?>"> -->
                                            <?php

//     $terms = get_terms_tree([ 'taxonomy' => $taxonomia ]);
//     $select = "<select name='profesion' id='profesion' class=''>n";
//     $select.= "<option value='-1'>Selecciona Tu Profesion</option>n";
//     $user_t = NULL;
//     $user_c = NULL;
//     $terms_usuario = wp_get_object_terms($current_user->ID, $taxonomia);
// 										foreach($terms_usuario as $term_u):
// 											if ($term_u->parent == 0):
//                                                 $user_t = $term_u->term_id;
//                                             elseif ($term_u->parent != 0):
//                                                 $user_c = $term_u->term_id;
//                                             endif;

// 										endforeach;

//     foreach ($terms as $term) {
//         if ($term->parent == 0) {
//             $select.= "<option disabled value='".$term->slug."'>".$term->name."</option>";
//         }
//         if (isset($term->children)) {
//             foreach($term->children as $children) {
//                 if ($user_c == $children->term_id):
//                     $select.= "<option selected value='".$children->slug."'>- ".$children->name."</option>";
//                 else:
//                     $select.= "<option value='".$children->slug."'>- ".$children->name."</option>";
//                 endif;
//             }
//         }
//    }
  
//    $select.= "</select>";
  
//    echo $select; ?>