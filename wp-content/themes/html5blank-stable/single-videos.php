<?php
acf_form_head();

get_header();

$ID = $_POST['post_id'];
$user_id = $_POST['user_id'];

get_template_part('template-parts/breadcrumb');
?>


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
if (isset($_POST) && isset($user_id)):
	acf_form(array(
		'post_id'		=> $ID,
		'post_title'	=> true,
		'form' => true,
		'submit_value'  => 'Editar video',
		'updated_message' => __("Se ha actualizado un video", 'acf'),
	));
else:
?>
	<h4>Error, Acceso no autorizado</h4>
<?php
endif;
?>
<a href="<?php echo home_url().'/galeria-videos';?>"><button class="acf-button button button-primary button-large btn btn-primary">Regresar</button></a>

</div>
</div>
</div>
</div>
</div>
</div>
<?php get_footer(); ?>