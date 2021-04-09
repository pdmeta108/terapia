<?php
global $current_user, $wp_query;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
acf_form_head();

get_header();
$args = array(  
    'post_type' => 'videos',
    'post_status' => 'publish',
    'posts_per_page' => 3,
    'author' => $current_user->ID,
    'orderby' => 'title',
    'order' => 'ASC',
    'paged' => $paged
);

$wp_query = new WP_Query( $args );

get_template_part('template-parts/breadcrumb');
?>


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
$args = array(
	'user' => $current_user->ID
);
if($wp_query->have_posts()):
    while($wp_query->have_posts()):
        $wp_query->the_post();

			get_template_part('template-parts/videos', 'content', $args);
        
    endwhile;
    wp_reset_postdata();
    if ($paged):
        get_template_part('pagination');
    endif;
else:
    ?>
    <div class="title">
    <h1>No hay videos para mostrar</h1>
    </div>
    <?php
endif;

?> 
</main>

<h4 class="mb-4">Agrega un nuevo video</h4>
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