<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
	'default-color' => 'FFF',
	'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
	'default-image'			=> get_template_directory_uri() . '/img/headers/default.jpg',
	'header-text'			=> false,
	'default-text-color'		=> '000',
	'width'				=> 1000,
	'height'			=> 198,
	'random-default'		=> false,
	'wp-head-callback'		=> $wphead_cb,
	'admin-head-callback'		=> $adminhead_cb,
	'admin-preview-callback'	=> $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// HTML5 Blank navigation
function html5blank_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
		'menu'            => '',
		'container'       => 'div',
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul>%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

    	wp_register_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0'); // Conditionizr
        wp_enqueue_script('conditionizr'); // Enqueue it!

        wp_register_script('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), '2.7.1'); // Modernizr
        wp_enqueue_script('modernizr'); // Enqueue it!

        wp_register_script('html5blankscripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('html5blankscripts'); // Enqueue it!
    }
}

// Load HTML5 Blank conditional scripts
function html5blank_conditional_scripts()
{
    if (is_page('pagenamehere')) {
        wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
        wp_enqueue_script('scriptname'); // Enqueue it!
    }
}

// Load HTML5 Blank styles
function html5blank_styles()
{
    wp_register_style('normalize', get_template_directory_uri() . '/normalize.css', array(), '1.0', 'all');
    wp_enqueue_style('normalize'); // Enqueue it!

    wp_register_style('html5blank', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('html5blank'); // Enqueue it!
}

// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'html5blank'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }


function load_favicon_file() {
    ?>
    <!-- Favicons -->
		<link type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon.png" rel="icon">
    <?php
}

/* Registrar estilos del tema Doccure */
function load_css_theme_files() {
    wp_register_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap');
    wp_register_style('fontawesome', get_template_directory_uri() . '/assets/plugins/fontawesome/css/fontawesome.min.css');
    wp_enqueue_style('fontawesome');
    wp_register_style('fontawesome_all', get_template_directory_uri() . '/assets/plugins/fontawesome/css/all.min.css');
    wp_enqueue_style('fontawesome_all');
    wp_register_style('style', get_template_directory_uri() . '/assets/css/style.css');
    wp_enqueue_style('style');
    wp_register_style('custom', get_template_directory_uri() . '/assets/css/custom.css');
    wp_enqueue_style('custom');
}

/* Registrar JQuery del tema Doccure */
function load_jquery() {
    if (!wp_script_is('jquery', 'enqueued')) {
        wp_enqueue_script('jquery',  get_template_directory_uri() . '/assets/js/jquery.min.js');
    }
}

/* Registrar javascript del tema Doccure */
function load_javascript_theme_files() {
    wp_enqueue_script('popper', get_template_directory_uri() . '/assets/js/popper.min.js',  array( 'jquery' ));
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js',  array( 'jquery' ));
    wp_enqueue_script('slick', get_template_directory_uri() . '/assets/js/slick.js',  array( 'jquery' ));
    wp_enqueue_script('script', get_template_directory_uri() . '/assets/js/script.js',  array( 'jquery' ));
}

function load_fancybox_script() {
    if (is_author()) {
        wp_register_style('fancybox', get_template_directory_uri() . '/assets/plugins/fancybox/jquery.fancybox.min.css');
        wp_enqueue_style('fancybox');
        wp_enqueue_script('fancybox', get_template_directory_uri() . '/assets/plugins/fancybox/jquery.fancybox.min.js',  array( 'jquery' ));
    }
}

function load_sticky_script() {
    global $wp;
    $current_slug = add_query_arg( array(), $wp->request );
    if ($current_slug === 'terapeutas-lista'){
        wp_enqueue_script('resizesensor', get_template_directory_uri() . '/assets/plugins/theia-sticky-sidebar/ResizeSensor.js',  array( 'jquery' ));
        wp_register_script('stickysidebar', get_template_directory_uri() . '/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js',  array( 'jquery' ));
        wp_enqueue_script('stickysidebar');
    }    
}

function doccure_ajax_files() {
    wp_enqueue_script('app',  get_template_directory_uri() . '/js/app.js');
}


function add_type_attribute($tag, $handle, $src) {
    
    if ('app' === $handle ) {
        $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
    }
    // change the script tag by adding type="module" and return it.
    return $tag;
}

function load_more_posts() {
    $next_page = $_POST['current_page'] + 1;
    $query = new WP_Query([
        'post_type' => 'videos',
        'post_status' => 'publish',
        'posts_per_page' => 3,
        'author' => $current_user->ID,
        'paged' => $next_page,
    ]);
    if ($query->have_posts()) :

        ob_start();
    
    while ($query->have_post()) : $query->the_post();
        get_template_part('template-parts/videos-content');
    endwhile;

    wp_send_json_success(ob_get_clean());

    else:
        wp_send_json_error('No hay mas videos');
    endif;
}

add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');
add_action('wp_ajax_load_more_posts', 'load_more_posts');

/* Agregar script para borrar CPT (videos) */
function delete_frontend_script() {
    wp_enqueue_script( 'delete_script', get_template_directory_uri() . '/js/delete_script.js', array( 'jquery' ) );
    wp_localize_script( 'delete_script', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}

function my_delete_post(){
 
    $permission = check_ajax_referer( 'my_delete_post_nonce', 'nonce', false );
    if( $permission == false ) {
        echo 'error';
    }
    else {
        wp_delete_post( $_REQUEST['id'] );
        wp_redirect( home_url().'/galeria-videos?deleted=true' );
    }
 
    die();
 
}

//Redirect after deleting the post in the frontend
function trash_redirection_frontend($post_id) {
    if ( filter_input( INPUT_GET, 'frontend', FILTER_VALIDATE_BOOLEAN ) ) {
        wp_redirect( home_url().'/galeria-videos?deleted=true' );
        exit;
    }
}

/* Quitar estilos que tiene el formulario ACF por defecto */
function acf_form_deregister_styles(){
    
    // Deregister ACF Form style
    wp_deregister_style('acf-global');
    wp_deregister_style('acf-input');
    
    // Avoid dependency conflict
    wp_register_style('acf-global', false);
    wp_register_style('acf-input', false);
    
}

function acf_form_bootstrap_styles($args){
    
    // Before ACF Form
    if(!$args['html_before_fields'])
        $args['html_before_fields'] = '<div class="row">'; // May be .form-row
    
    // After ACF Form
    if(!$args['html_after_fields'])
        $args['html_after_fields'] = '</div>';
    
    // Success Message
    if($args['html_updated_message'] == '<div id="message" class="updated"><p>%s</p></div>')
        $args['html_updated_message'] = '<div id="message" class="updated alert alert-success">%s</div>';
    
    // Submit button
    if($args['html_submit_button'] == '<input type="submit" class="acf-button button button-primary button-large" value="%s" />')
        $args['html_submit_button'] = '<input type="submit" class="acf-button button button-primary button-large btn btn-primary" value="%s" />';
    
    return $args;
    
}

function acf_form_fields_bootstrap_styles($field){
    
    // Target ACF Form Front only
    if(is_admin() && !wp_doing_ajax())
        return $field;
    
    // Add .form-group & .col-12 fallback on fields wrappers
    $field['wrapper']['class'] .= ' form-group col-12';
    
    // Add .form-control on fields
    $field['class'] .= ' form-control';
    
    return $field;
    
}

function acf_form_fields_required_bootstrap_styles($label){
    
    // Target ACF Form Front only
    if(is_admin() && !wp_doing_ajax())
        return $label;
    
    // Add .text-danger
    $label = str_replace('<span class="acf-required">*</span>', '<span class="acf-required text-danger">*</span>', $label);
    
    return $label;
    
}

/**
 * Ordenar lista de terminos de taxonomia segun padre, hijo
 */
function get_terms_tree( Array $args) {
    $new_args = $args;
    $new_args['parent'] = $new_args['parent'] ?? 0;
    $new_args['hide_empty'] = 0;

    // The terms for this level
    $terms = get_terms( $new_args );

    // The children of each term on this level
    foreach( $terms as &$this_term ) {
        $new_args['parent'] = $this_term->term_id;
        $this_term->children = get_terms_tree( $new_args );
    }

    return $terms;
}

/**
 * Output the form.
 *
 * @param      array  $atts   User defined attributes in shortcode tag
 */
function wpcfu_output_file_upload_form( $atts ) {
    global $current_user;
	$atts = shortcode_atts( array(), $atts );
	$html = '';
	$html .= '<form class="wpcfu-form" method="POST" enctype="multipart/form-data">';

	$html .= '<div class="upload-img">';
    $html .= '<div class="change-photo-btn">';
    $html .= '<span><i class="fa fa-file"></i> Buscar Archivo</span>';
	$html .= '<input type="file" name="wpcfu_file" class="upload">';
    $html .= '<input type="hidden" name="user_id" value="'. $current_user->ID .'">';
	$html .= '</div>';
	$html .= '<div class="change-photo-btn">';

	// Output the nonce field
	$html .= wp_nonce_field( 'upload_wpcfu_file', 'wpcfu_nonce', true, false );
    $html .= '<span><i class="fa fa-upload"></i> Subir</span>';
	$html .= '<input type="submit" class="upload" name="submit_wpcfu_form" value="' . esc_html__( 'Subir', 'theme-text-domain' ) . '">';
    $html .= '</div><small class="form-text text-muted">Formatos permitidos JPG, GIF o PNG. Tamaño máximo de 2MB</small></div>';

	$html .= '</form>';

	echo $html;
}

/**
 * Add the shortcode '[wpcfu_form]'.
 */
add_shortcode( 'wpcfu_form', 'wpcfu_output_file_upload_form' );


/**
	 * Handles the file upload request.
	 */
function wpcfu_handle_file_upload() {
	// Stop immidiately if form is not submitted
	if ( ! isset( $_POST['submit_wpcfu_form'] ) ) {
		return;
	}

    if (isset( $_POST['user_id'] )) {
        $user_id = $_POST['user_id'];
    }

	// Verify nonce
	if ( ! wp_verify_nonce( $_POST['wpcfu_nonce'], 'upload_wpcfu_file' ) ) {
		wp_die( esc_html__( 'Nonce mismatched', 'theme-text-domain' ) );
	}

		// Throws a message if no file is selected
	if ( ! $_FILES['wpcfu_file']['name'] ) {
		wp_die( esc_html__( 'Por favor escoja primero un archivo para subir', 'theme-text-domain' ) );
	}

	$allowed_extensions = array( 'jpg', 'jpeg', 'png' );
	$file_type = wp_check_filetype( $_FILES['wpcfu_file']['name'] );
	$file_extension = $file_type['ext'];

	// Check for valid file extension
	if ( ! in_array( $file_extension, $allowed_extensions ) ) {
		wp_die( sprintf(  esc_html__( 'Extension de archivo invalido, solo se permiten: %s', 'theme-text-domain' ), implode( ', ', $allowed_extensions ) ) );
	}

	$file_size = $_FILES['wpcfu_file']['size'];
	$allowed_file_size = 2048000; // Here we are setting the file size limit to 500 KB = 500 × 1024

	// Check for file size limit
	if ( $file_size >= $allowed_file_size ) {
		wp_die( sprintf( esc_html__( 'Limite de tamaño excedido, tamaño de archivo debe de ser menor a %d KB', 'theme-text-domain' ), $allowed_file_size / 1000 ) );
	}

		// These files need to be included as dependencies when on the front end.
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );

	// Let WordPress handle the upload.
	// Remember, 'wpcfu_file' is the name of our file input in our form above.
	// Here post_id is 0 because we are not going to attach the media to any post.
	$attachment_id = media_handle_upload( 'wpcfu_file', 0 );
	if ( is_wp_error( $attachment_id ) ) {
		// There was an error uploading the image.
		wp_die( $attachment_id->get_error_message() );
	} else {
		// We will redirect the user to the attachment page after uploading the file successfully.
        $input_value = wp_get_attachment_url( $attachment_id );
        $foto_usuario = get_the_author_meta('foto_usuario', $user_id);
        if ($foto_usuario):
            $old_input = attachment_url_to_postid($foto_usuario);
            wp_delete_attachment($old_input);
        endif;
        update_user_meta( $user_id, 'foto_usuario', $input_value );
		wp_redirect( home_url().'/perfil-terapeuta?uploaded=true' );
		exit;
	}
}


/**
 * Hook the function that handles the file upload request.
 */
add_action( 'init', 'wpcfu_handle_file_upload' );

/*
** Crear taxonomia para usuarios del role terapeuta
** @see 
*/

function add_user_therapist_taxonomy() {
    $labels = array(
            'name'                      =>'Profesiones',
            'singular_name'             =>'Profesion',
            'menu_name'                 =>'Profesiones',
            'search_items'              =>'Buscar Profesiones',
            'popular_items'             =>'Profesiones Populares',
            'all_items'                 =>'Todas las Profesiones',
            'edit_item'                 =>'Editar Profesion',
            'update_item'               =>'Actualizar Profesion',
            'add_new_item'              =>'Añadir Nueva Profesion',
            'new_item_name'             =>'Nuevo Nombre de Profesion ',
            'separate_items_with_commas'=>'Separar profesiones con comas',
            'add_or_remove_items'       =>'Añadir o remover profesiones',
            'choose_from_most_used'     =>'Escoger las profesiones más populares',
    );

    $args = array (
        'hierarchical'      => true,
        'single_value' => false,
        'show_admin_column' => true,
        'labels'            => $labels,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array(
            'with_front'                =>true,
            'slug'                      =>'terapeuta/profesion',
        ),
        'capabilities'  => array(
            'manage_terms'              =>'edit_users',
            'edit_terms'                =>'edit_users',
            'delete_terms'              =>'edit_users',
            'assign_terms'              =>'read',
        ),
    );
    
    register_taxonomy('profesion', 'user', $args);
}



/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'html5blank_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
// add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
add_action('init', 'create_post_type_html5'); // Add our HTML5 Blank Custom Post Type
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether


/* My Functions Actions and Filters */
add_action('wp_head', 'load_favicon_file');
add_action('wp_enqueue_scripts', 'load_css_theme_files');
add_action('wp_enqueue_scripts', 'load_jquery');
add_action('wp_enqueue_scripts', 'load_javascript_theme_files');
add_action('wp_enqueue_scripts', 'load_fancybox_script');
add_action('wp_enqueue_scripts', 'load_sticky_script');
add_action('wp_enqueue_scripts', 'doccure_ajax_files');
add_action( 'init', 'add_user_therapist_taxonomy', 0);
add_action( 'wp_ajax_my_delete_post', 'my_delete_post');
add_action('trashed_post','trash_redirection_frontend');
add_action('wp_enqueue_scripts', 'acf_form_deregister_styles');
add_filter('acf/validate_form', 'acf_form_bootstrap_styles');
add_filter('acf/prepare_field', 'acf_form_fields_bootstrap_styles');
add_filter('acf/get_field_label', 'acf_form_fields_required_bootstrap_styles');
add_filter('script_loader_tag', 'add_type_attribute' , 10, 3);

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called HTML5-Blank
function create_post_type_html5()
{
    register_taxonomy_for_object_type('category', 'html5-blank'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'html5-blank');
    register_post_type('html5-blank', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('HTML5 Blank Custom Post', 'html5blank'), // Rename these to suit
            'singular_name' => __('HTML5 Blank Custom Post', 'html5blank'),
            'add_new' => __('Add New', 'html5blank'),
            'add_new_item' => __('Add New HTML5 Blank Custom Post', 'html5blank'),
            'edit' => __('Edit', 'html5blank'),
            'edit_item' => __('Edit HTML5 Blank Custom Post', 'html5blank'),
            'new_item' => __('New HTML5 Blank Custom Post', 'html5blank'),
            'view' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'view_item' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'search_items' => __('Search HTML5 Blank Custom Post', 'html5blank'),
            'not_found' => __('No HTML5 Blank Custom Posts found', 'html5blank'),
            'not_found_in_trash' => __('No HTML5 Blank Custom Posts found in Trash', 'html5blank')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));
}

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}

?>