<?php global $current_user, $wp;?>

<!-- Profile Sidebar -->
<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
					<div class="profile-sidebar">
					    <div class="widget-profile pro-widget-content">
							<div class="profile-info-widget">
								<a href="<?php echo get_the_author_meta( 'foto_usuario', $current_user->ID );?>" class="booking-doc-img">
									<?php 
									$foto_usuario = get_the_author_meta( 'foto_usuario', $current_user->ID );
									if ($foto_usuario) {
									?>
										<img src="<?php echo $foto_usuario;?>" alt="User Image">
									<?php
									} else {
										?>
									<img src="<?php echo get_stylesheet_directory_uri();?>/assets/img/patients/patient.jpg" alt="User Image">
									<?php
									}
									?>
								</a>
								<div class="profile-det-info">
									<h3><?php echo get_the_author_meta( 'display_name', $current_user->ID );?></h3>
									<!-- <div class="patient-details">
										<h5><i class="fas fa-birthday-cake"></i> 24 Jul 1983, 38 years</h5>
										<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Newyork, USA</h5>
									</div> -->
								</div>
							</div>
						</div>
						<div class="dashboard-widget">
							<nav class="dashboard-menu">
								<ul>
								<?php
								$current_page = home_url( $wp->request )
								?>
                                    <li <?php if (strpos($current_page, 'perfil-terapeuta')) { ?> class="active" <?php } ?>>
										<a href="<?php echo home_url().'/perfil-terapeuta';?>">
											<i class="fas fa-user-cog"></i>
											<span>Opciones de Perfil</span>
										</a>
									</li>
									<li <?php if (strpos($current_page, 'videos')) { ?> class="active" <?php } ?>>
										<a href="<?php echo home_url().'/galeria-videos';?>">
											<i class="fas fa-columns"></i>
											<span>Agregar Videos</span>
										</a>
									</li>
								    <li <?php if (strpos($current_page, 'post')) { ?> class="active" <?php } ?>>
										<a href="<?php echo home_url().'/perfil-terapeuta';?>">
											<i class="fas fa-bookmark"></i>
											<span>Crear / Editar Posts</span>
										</a>
									</li>
									<li <?php if (strpos($current_page, 'eventos')) { ?> class="active" <?php } ?>>
										<a href="<?php echo home_url().'/perfil-terapeuta';?>">
											<i class="fas fa-comments"></i>
											<span>Eventos</span>
											<!-- <small class="unread-msg">23</small> -->
										</a>
									</li>
									<li <?php if (strpos($current_page, 'terapeutas-lista')) { ?> class="active" <?php } ?>>
										<a href="<?php echo home_url().'/terapeutas-lista';?>">
											<i class="fas fa-user"></i>
											<span>Mis Clientes</span>
										</a>
									</li>
									<li>
										<a href="<?php echo wp_logout_url(); ?>">
											<i class="fas fa-sign-out-alt"></i>
											<span>Cerrar Sesión</span>
										</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
			<!-- /Profile Sidebar -->