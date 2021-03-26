<?php /* Template Name: Client Profile Template */ get_header(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo get_home_url(); ?>">Página principal</a></li>
									<li class="breadcrumb-item active" aria-current="page">Perfil del Cliente</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Perfil del Cliente</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
				<div class="container-fluid">
					
					<div class="row">
						<div class="col-md-8 offset-md-2">
								
							<!-- Register Content -->
							<div class="account-content">
								<div class="row align-items-center justify-content-center">
									<div class="col-md-7 col-lg-6 login-left">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/login-banner.png" class="img-fluid" alt="Doccure Register">	
									</div>
									<div class="col-md-12 col-lg-6 login-right">
										<div class="login-header">
											<h3>Perfil del Cliente </h3>
										</div>
										
										<!-- Edit Profile Form -->

										<?php  echo do_shortcode('[wppb-edit-profile]');
										// $current_user = get_current_user_id();
										// $all_meta_for_user = array_map( function( $a ){ return $a[0]; }, get_user_meta( $current_user ) );
										// print_r( $all_meta_for_user['user_email'] )
										// $user_info = get_userdata( $current_user );
										// print_r($user_info);
										?>

										
									</div>
								</div>
							</div>
							<!-- /Register Content -->
								
						</div>
					</div>

				</div>

			</div>		
			<!-- /Page Content -->

<?php get_footer(); ?>