<?php
acf_form_head();

get_header();

$ID = $_POST['post_id'];
?>

<!-- Breadcrumb -->
<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo get_home_url();?>">Página principal</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo get_home_url();?>">Perfil del Terapeuta</a></li>
									<li class="breadcrumb-item active" aria-current="page">Agregar Videos</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Galeria de Videos</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
	<div class="container-fluid">
		<div class="row">

<?php get_template_part('template-parts/sidebar-user');?>
<div class="col-md-7 col-lg-8 col-xl-9">
<h4 class="mb-4">Editar <?php echo get_the_title( $ID ); ?></h4>
<div class="card">
	<div class="card-body">
<?php
acf_form(array(
	'post_id'		=> $ID,
	'post_title'	=> true,
    'form' => true,
    'submit_value'  => 'Editar video',
	'updated_message' => __("Se ha actualizado un video", 'acf'),
));
?>
<a href="<?php echo home_url().'/galeria-videos';?>"><button class="acf-button button button-primary button-large btn btn-primary">Regresar</button></a>

</div>
</div>
</div>
</div>
</div>
</div>
<?php get_footer(); ?>