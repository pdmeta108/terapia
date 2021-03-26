<?php
global $current_user, $wp_query;
acf_form_head();

get_header();
$args = array(  
    'post_type' => 'videos',
    'post_status' => 'publish',
    'posts_per_page' => 3,
    'author' => $current_user->ID,
    'orderby' => 'title',
    'order' => 'ASC',
);

$loop = new WP_Query( $args );

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

            <?php
				get_template_part('template-parts/sidebar-user');
			?>

            <div class="col-md-7 col-lg-8 col-xl-9">

                <h4 class="mb-4">Tus Videos</h4>
				<?php
				if ($_GET['deleted']):
					echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Exito!</strong> Tu video se ha borrado.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
				endif;
				?>
				<main
				class="posts-list"
				data-page="<?php get_query_var('paged') ? get_query_var('paged') : 1;?>"
				data-max="<?php $wp_query->max_num_pages;?>"
				>
<?php
if($loop->have_posts()):
    while($loop->have_posts()) :
        $loop->the_post();

			get_template_part('template-parts/videos-content');
        
    endwhile;

    wp_reset_postdata();
else:
    ?>
    <div class="title">
    <h1><?php echo "No hay videos para mostrar"; ?></h1>
    </div>
    <?php
endif;

?> 
</main>
<?php if($loop->have_posts()): ?>
<button class="btn btn-primary btn-block btn-lg login-btn load-more">Cargar Más Videos</button>
<h4 class="mb-4">Agrega un nuevo video</h4>
<?php endif; ?>
<div class="card">
	<div class="card-body">
<?php
acf_form(array(
	'post_id'		=> 'new_post',
	'post_title'	=> true,
    'form' => true,
    'new_post'		=> array(
        'post_type'		=> 'videos',
        'post_status'	=> 'publish'
    ),
    'submit_value'  => 'Crear nuevo video',
	'updated_message' => __("Se ha creado un nuevo Video", 'acf'),
));
?>

</div>
</div>
</div>
<?php get_footer();?>