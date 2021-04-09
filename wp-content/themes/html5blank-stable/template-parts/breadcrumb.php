<?php global $wp;
    $current_slug = add_query_arg( array(), $wp->request );
	if (strpos($current_slug, '/') !== false):
    	$slugs = explode('/', $current_slug);
		$last_slug = end($slugs);
		$active = ucwords(str_replace('-', ' ', $last_slug));
    else:
		$active = ucwords(str_replace('-', ' ', $current_slug));
	endif;
    ?>
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo get_home_url();?>">Página principal</a></li>
									<?php if(!is_404()):?>
									<li class="breadcrumb-item active" aria-current="page"><?php echo $active; ?></li>
									<?php else:?>
									<li class="breadcrumb-item active" aria-current="page"><?php echo "Error 404"; ?></li>
									<?php endif;?>
								</ol>
							</nav>
							<?php if(!is_404()):?>
							<h2 class="breadcrumb-title"><?php echo $active; ?></h2>
							<?php else:?>
							<h2 class="breadcrumb-title"><?php echo "Pagina no encontrada"; ?></h2>
							<?php endif;?>
						</div>
					</div>
				</div>
			</div>
<!-- /Breadcrumb -->