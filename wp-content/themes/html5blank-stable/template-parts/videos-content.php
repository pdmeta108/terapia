<div <?php post_class() ?>>
        <div class="card">
			<div class="card-body">
				<div class="doctor-widget">
					<div class="doc-info-left">
						<!-- <div class="doctor-img">
                            <div class="embed-container"> -->
                                
                            <!-- </div>
                        </div> -->
                        <div class="doc-info-cont">
                            <div>
                                <?php 
                                    $url_video = get_field('url_video');
                                ?>
                                <iframe width="560" height="315" src="<?php echo $url_video;?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>?>
                                </iframe>
                            </div>
                            <h4 class="doc-name"><a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a></h4>
                            <p><?php
                                the_excerpt();
                            ?></p>
                            <p><?php the_field('descripcion'); ?></p>
                        </div>
                    </div>
                    <div class="doc-info-right">
                        <div class="mb-4 clinic-booking">
                            <?php 
                             if( current_user_can( 'delete_post' ) ) :
                                $nonce = wp_create_nonce('my_delete_post_nonce'); ?>
                                <a href="<?php echo admin_url( 'admin-ajax.php?action=my_delete_post&id=' . get_the_ID() . '&nonce=' . $nonce ) ?>" data-id="<?php echo get_the_ID(); ?>" data-nonce="<?php echo $nonce; ?>" class="delete-post apt-btn">Borrar</a>
                            <?php endif; ?>
                        </div>
                        
                            <form method="POST" action="<?php echo the_permalink(); ?>">
                                    <?php $id_post = get_the_ID(); ?>
                                    <input type="hidden" name="post_id" value="<?php echo $id_post;?>">
                                    <input style="font-size: 16px" class="btn btn-primary btn-block btn-lg login-btn" type="submit" value="EDITAR">
                            </form>
                        
                    </div>
                </div>
            </div>
        </div>
        </div>