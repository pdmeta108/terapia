<?php /* Template Name: Events Therapist Template */ get_header();

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
<div class="card">
					<div class="card-body">
<?php echo do_shortcode('[event_form]'); ?>
</div>
</div>
</div>
</div>
</div>
</div>
<?php get_footer(); ?>