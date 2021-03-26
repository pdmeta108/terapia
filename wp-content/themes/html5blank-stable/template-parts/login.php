<?php /* Template Name: Login Template */ get_header(); ?>



	<!-- Page Content -->
    <div class="content">
				<div class="container-fluid">
					
					<div class="row">
						<div class="col-md-8 offset-md-2">
							
							<!-- Login Tab Content -->
							<div class="account-content">
								<div class="row align-items-center justify-content-center">
									<div class="col-md-7 col-lg-6 login-left">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/login-banner.png" class="img-fluid" alt="Doccure Login">	
									</div>
									<div class="col-md-12 col-lg-6 login-right">
										<div class="login-header">
											<h3>Iniciar <span>Sesión</span></h3>
										</div>
                                        <?php echo do_shortcode("[wppb-login]"); ?>
                                        <?php if (!(is_user_logged_in())) { ?>
                                        <div class="text-right">
												<a class="forgot-link" href="<?php echo get_home_url(); ?>/recuperar-contrasena">¿ Olvidó su contraseña ?</a>
											</div>
                                            <?php } ?>
                                        <div class="login-or">
												<span class="or-line"></span>
												<span class="span-or">o</span>
											</div>
                                            <?php if (!(is_user_logged_in())) { ?>
                                            <div class="row form-row social-login">
												<div class="col-6">
													<a href="#" class="btn btn-facebook btn-block"><i class="fab fa-facebook-f mr-1"></i> Login</a>
												</div>
												<div class="col-6">
													<a href="#" class="btn btn-google btn-block"><i class="fab fa-google mr-1"></i> Login</a>
												</div>
											</div>
                                            <div class="text-center dont-have">¿No tienes una cuenta? <a href="<?php echo get_home_url(); ?>/registro-cliente">Regístrate</a></div>
                                            <?php  } ?>
									</div>
								</div>
							</div>
							<!-- /Login Tab Content -->
								
						</div>
					</div>

				</div>

			</div>		
			<!-- /Page Content -->

<?php get_footer(); ?>
