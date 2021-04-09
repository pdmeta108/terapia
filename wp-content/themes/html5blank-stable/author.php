<?php 
get_header(); ?>

<!-- Breadcrumb -->
<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index-2.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Perfil Terapeuta</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Perfil Terapeuta</h2>
						</div>
					</div>
				</div>
			</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
				<div class="container">

<!-- Doctor Widget -->
<div class="card">
	<div class="card-body">
		<div class="doctor-widget">
			<div class="doc-info-left">
				<div class="doctor-img">
				<a href="<?php echo the_author_meta( 'foto_usuario'); ?>">
  					<img src="<?php echo the_author_meta( 'foto_usuario'); ?>" class="img-fluid" alt="User Image">
  				</a>
				</div>
				<div class="doc-info-cont">
					<h4 class="doc-name">Dr. <?php echo get_the_author();?></h4>
					<!-- <p class="doc-speciality">BDS, MDS - Oral & Maxillofacial Surgery</p> -->
					<p class="doc-department"><img src="<?php echo get_stylesheet_directory_uri();?>/assets/img/specialities/specialities-05.png" class="img-fluid" alt="Specialidad">Terapeuta</p>
					<div class="rating">
						<i class="fas fa-star filled"></i>
						<i class="fas fa-star filled"></i>
						<i class="fas fa-star filled"></i>
						<i class="fas fa-star filled"></i>
						<i class="fas fa-star"></i>
						<span class="d-inline-block average-rating">(35)</span>
					</div>
					<div class="clinic-details">
						<p class="doc-location"><i class="fas fa-map-marker-alt"></i> Newyork, USA - <a href="javascript:void(0);">Ver Dirección</a></p>
						<ul class="clinic-gallery">
							<li>
								<a href="<?php echo get_stylesheet_directory_uri();?>/assets/img/features/feature-01.jpg" data-fancybox="gallery">
									<img src="<?php echo get_stylesheet_directory_uri();?>/assets/img/features/feature-01.jpg" alt="Feature">
								</a>
							</li>
							<li>
								<a href="<?php echo get_stylesheet_directory_uri();?>/assets/img/features/feature-02.jpg" data-fancybox="gallery">
									<img  src="<?php echo get_stylesheet_directory_uri();?>/assets/img/features/feature-02.jpg" alt="Feature Image">
								</a>
							</li>
							<li>
								<a href="<?php echo get_stylesheet_directory_uri();?>/assets/img/features/feature-03.jpg" data-fancybox="gallery">
									<img src="<?php echo get_stylesheet_directory_uri();?>/assets/img/features/feature-03.jpg" alt="Feature">
								</a>
							</li>
							<li>
								<a href="<?php echo get_stylesheet_directory_uri();?>/assets/img/features/feature-04.jpg" data-fancybox="gallery">
									<img src="<?php echo get_stylesheet_directory_uri();?>/assets/img/features/feature-04.jpg" alt="Feature">
								</a>
							</li>
						</ul>
					</div>
					<div class="clinic-services">
					<?php $terms_usuario = wp_get_object_terms(get_the_author_ID(), 'profesion');
							foreach($terms_usuario as $term_usuario):
								echo '<span>'. $term_usuario->name . '</span>';
							endforeach; ?>
					</div>
				</div>
			</div>
			<div class="doc-info-right">
				<div class="clini-infos">
					<ul>
						<li><i class="far fa-thumbs-up"></i> <?php echo the_author_meta( 'first_name'); ?></li>
						<li><i class="far fa-comment"></i> <?php echo the_author_meta( 'last_name'); ?></li>
						<li><i class="fas fa-map-marker-alt"></i> <?php echo the_author_meta( 'user_email');?></li>
						<li><i class="far fa-money-bill-alt"></i> <?php echo the_author_meta( 'user_url');?> </li>
					</ul>
				</div>
				<div class="doctor-action">
					<a href="javascript:void(0)" class="btn btn-white fav-btn">
						<i class="far fa-bookmark"></i>
					</a>
					<a href="chat.html" class="btn btn-white msg-btn">
						<i class="far fa-comment-alt"></i>
					</a>
					<a href="javascript:void(0)" class="btn btn-white call-btn" data-toggle="modal" data-target="#voice_call">
						<i class="fas fa-phone"></i>
					</a>
					<a href="javascript:void(0)" class="btn btn-white call-btn" data-toggle="modal" data-target="#video_call">
						<i class="fas fa-video"></i>
					</a>
				</div>
				<div class="clinic-booking">
					<a class="apt-btn" href="booking.html">Book Appointment</a>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Doctor Widget -->
						</div>
						</div>

<?php get_footer(); ?>
