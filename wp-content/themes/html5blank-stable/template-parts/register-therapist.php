<?php /* Template Name: Register Therapist Template */ get_header(); ?>

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
											<h3>Registro del Terapeuta <a href="<?php echo get_home_url(); ?>/registro-cliente">¿Eres un Cliente?</a></h3>
										</div>
										
										<!-- Register Form -->

										<?php echo do_shortcode('[wppb-register role="terapeuta"]'); ?>

										
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