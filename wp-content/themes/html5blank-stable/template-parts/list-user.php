<?php $datos = $args['user']->data;?>
<!-- Doctor Widget -->
<div class="card">
								<div class="card-body">
									<div class="doctor-widget">
										<div class="doc-info-left">
											<div class="doctor-img">
											<a href="<?php echo get_the_author_meta( 'foto_usuario', $datos->ID);?>" class="booking-doc-img">
  												<img src="<?php echo get_the_author_meta( 'foto_usuario', $datos->ID);?>" class="img-fluid" alt="User Image"></a>
											</div>
											<div class="doc-info-cont">
												<h4 class="doc-name"><a href="<?php echo get_author_posts_url($datos->ID);?>"><?php echo $datos->display_name;?></a></h4>
												<!-- <p class="doc-speciality">MDS - Periodontology and Oral Implantology, BDS</p> -->
												<h5 class="doc-department"><img src="<?php  echo get_template_directory_uri();?>/assets/img/specialities/specialities-05.png" class="img-fluid" alt="Speciality"><?php echo ucfirst($args['user']->roles[0]);?></h5>
												<div class="rating">
													<i class="fas fa-star filled"></i>
													<i class="fas fa-star filled"></i>
													<i class="fas fa-star filled"></i>
													<i class="fas fa-star filled"></i>
													<i class="fas fa-star"></i>
													<span class="d-inline-block average-rating">(17)</span>
												</div>
												<div class="clinic-details">
													<p class="doc-location"><i class="fas fa-map-marker-alt"></i> Florida, USA</p>
													<ul class="clinic-gallery">
														<li>
															<a href="<?php  echo get_template_directory_uri();?>/assets/img/features/feature-01.jpg" data-fancybox="gallery">
																<img src="<?php  echo get_template_directory_uri();?>/assets/img/features/feature-01.jpg" alt="Feature">
															</a>
														</li>
														<li>
															<a href="<?php  echo get_template_directory_uri();?>/assets/img/features/feature-02.jpg" data-fancybox="gallery">
																<img  src="<?php  echo get_template_directory_uri();?>/assets/img/features/feature-02.jpg" alt="Feature">
															</a>
														</li>
														<li>
															<a href="<?php  echo get_template_directory_uri();?>/assets/img/features/feature-03.jpg" data-fancybox="gallery">
																<img src="<?php  echo get_template_directory_uri();?>/assets/img/features/feature-03.jpg" alt="Feature">
															</a>
														</li>
														<li>
															<a href="<?php  echo get_template_directory_uri();?>/assets/img/features/feature-04.jpg" data-fancybox="gallery">
																<img src="<?php  echo get_template_directory_uri();?>/assets/img/features/feature-04.jpg" alt="Feature">
															</a>
														</li>
													</ul>
												</div>
												<div class="clinic-services">
												<?php $terms_usuario = wp_get_object_terms($datos->ID, 'profesion');
												foreach($terms_usuario as $term_usuario):
													echo '<span>'. $term_usuario->name . '</span>';
												endforeach; ?>
												</div>
											</div>
										</div>
										<div class="doc-info-right">
											<div class="clini-infos">
												<ul>
													<li><i class="far fa-thumbs-up"></i><?php echo get_the_author_meta('first_name', $datos->ID);?></li>
													<li><i class="far fa-comment"></i><?php echo get_the_author_meta('last_name', $datos->ID);?></li>
													<li><i class="fas fa-map-marker-alt"></i><?php echo $datos->user_email;?></li>
													<li><i class="far fa-money-bill-alt"></i> <?php echo $datos->user_url;?> </li>
												</ul>
											</div>
											<div class="clinic-booking">
												<a class="view-pro-btn" href="<?php echo get_author_posts_url($datos->ID);?>">Ver Perfil</a>
												<!-- <a class="apt-btn" href="booking.html">Book Appointment</a> -->
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- /Doctor Widget -->