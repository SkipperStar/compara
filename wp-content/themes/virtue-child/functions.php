<?php

add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
    
function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
   wp_enqueue_style( 'bootstrap', get_template_directory_uri().'/assets/css/bootstrap.css' );
}

add_action( 'init', 'register_deposits' );
 
function register_deposits() {
	$labels = array(
		'name' => 'Banks',
		'singular_name' => 'Bank',
		// 'post_type' => 'post',
		'add_new_item' => 'Add new bank', // заголовок тега <title>
		'add_new' => 'Add new bank',
		'edit_item' => 'Edit Bank',
		'menu_name' => 'Deposits',
		'show_in_admin_bar' => 'true',
	);
	$args = array(
        'labels' => $labels,
        // 'exclude_from_search' => false,
		'public' => true,
		'show_ui' => true, // показывать интерфейс в админке
		'has_archive' => true, 
		// 'rewrite' => 'Banks',
		'menu_icon' => 'dashicons-chart-pie', // иконка в меню
		'menu_position' => 20, // порядок в меню
		'supports' => array( 'title', 'custom-fields')
	);
	register_post_type('deposits', $args);
	
	register_taxonomy(
		'banks_term',
		'deposits',
		array(
			'label' => 'Term',
			'hierarchical' => true,
		)
	);

    register_taxonomy(
        'banks_currency',
        'deposits',
        array(
            'label' => 'Currencies',
            'hierarchical' => true,
        )
    );

    register_taxonomy(
        'banks_types',
        'deposits',
        array(
            'label' => 'Types of deposits',
            'hierarchical' => true,
        )
    );

}

// Register New Menu Location for Deposits Page
add_action( 'after_setup_theme', 'deposits_header_menu' );
function deposits_header_menu() {
	register_nav_menu( 'deposits_header_menu', 'Deposits Header Menu' );
}

// Register New Script for Deposits Page
add_action( 'wp_enqueue_scripts', 'deposits_register_scripts', 1000 );
function deposits_register_scripts(){
	wp_enqueue_script( 'deposits', get_stylesheet_directory_uri() . '/source/js/deposits.js', array(), null, true);
	wp_enqueue_script( 'bootstrap', get_stylesheet_directory_uri() . '/source/js/bootstrap.min.js', array(), null, true);
}

// AJAX for Deposits
add_action('wp_ajax_filters', 'deposits_form_filters');
add_action('wp_ajax_nopriv_filters', 'deposits_form_filters');
function deposits_form_filters() {
	
}


add_action('admin_menu', 'register_my_custom_submenu_page');

function register_my_custom_submenu_page() {
    add_submenu_page( 'edit.php?post_type=deposits', 'Archive', 'Banks archive', 'manage_options', 'archive-page', 'archive_page_callback' );
}

function archive_page_callback() {
    // контент страницы
    echo '<div class="wrap">';
    echo '<h2>'. get_admin_page_title() .'</h2>';

    $wpb_all_query = new WP_Query(array('post_type'=>'deposits', 'post_status'=>'draft', 'posts_per_page'=>-1));

    if ( $wpb_all_query->have_posts() ) : ?>

    <table class="wp-list-table widefat fixed striped posts">
        <thead>
            <tr>
                <td id="cb" class="manage-column column-cb check-column">
                    <label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox">
                </td>
                <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
                    <a href="http://bank.loc/wp-admin/edit.php?post_type=deposits&amp;page=archive-page&amp;orderby=title&amp;order=asc">
                        <span>Title</span><span class="sorting-indicator"></span>
                    </a>
                </th>
                <th scope="col" id="currency" class="manage-column column-currency">Currencies</th>
                <th scope="col" id="types" class="manage-column column-types">Types</th>
                <th scope="col" id="date" class="manage-column column-date sortable asc">
                    <a href="http://bank.loc/wp-admin/edit.php?post_type=deposits&amp;page=archive-page&amp;orderby=date&amp;order=desc">
                        <span>Date</span><span class="sorting-indicator"></span>
                    </a>
                </th>
            </tr>
        </thead>
        <tbody id="the-list">
        <!-- the loop -->
        <?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
            <tr id="post-<?php echo get_the_ID();?>" class="iedit author-self level-0 post-<?php echo get_the_ID();?> type-deposits status-draft hentry">
                <th scope="row" class="check-column">
                    <label class="screen-reader-text" for="cb-select-<?php echo get_the_ID();?>">Select Bank 3</label>
                    <input id="cb-select-<?php echo get_the_ID();?>" type="checkbox" name="post[]" value="<?php echo get_the_ID();?>">
                    <div class="locked-indicator">
                        <span class="locked-indicator-icon" aria-hidden="true"></span>
                        <span class="screen-reader-text">“<?php echo get_the_title();?>” is locked</span>
                    </div>
                </th>
                <td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
                    <div class="locked-info">
                        <span class="locked-avatar"></span>
                        <span class="locked-text"></span>
                    </div>
                    <strong>
                        <a class="row-title" href="http://bank.loc/wp-admin/post.php?post=<?php echo get_the_ID(); ?>&amp;action=edit" aria-label="“<?php echo get_the_title();?>” (Edit)"><?php echo get_the_title();?></a> — <span class="post-state">Draft</span>
                    </strong>

                    <div class="hidden" id="inline_<?php echo get_the_ID(); ?>">
                        <div class="post_title"><?php echo get_the_title();?></div><div class="post_name">bank-3-2</div>
                        <div class="post_author">1</div>
                        <div class="comment_status">closed</div>
                        <div class="ping_status">closed</div>
                        <div class="_status"><?php echo get_post_status(); ?></div>
                        <div class="jj">03</div>
                        <div class="mm">01</div>
                        <div class="aa">2019</div>
                        <div class="hh">10</div>
                        <div class="mn">57</div>
                        <div class="ss">23</div>
                        <div class="post_password"></div>
                        <div class="page_template">default</div>
                        <div class="post_category" id="banks_term_<?php echo get_the_ID(); ?>"></div>
                        <div class="sticky"></div></div>
                    <div class="row-actions">
                        <span class="edit"><a href="http://bank.loc/wp-admin/post.php?post=<?php echo get_the_ID(); ?>&amp;action=edit" aria-label="Edit “<?php echo get_the_title();?>”">Edit</a> | </span><span class="inline hide-if-no-js"><a href="#" class="editinline" aria-label="Quick edit “<?php echo get_the_title();?>” inline">Quick&nbsp;Edit</a> | </span><span class="trash"><a href="http://bank.loc/wp-admin/post.php?post=<?php echo get_the_ID(); ?>&amp;action=trash&amp;_wpnonce=07a17e0afd" class="submitdelete" aria-label="Move “<?php echo get_the_title();?>” to the Trash">Trash</a> | </span><span class="view"><a href="http://bank.loc/?post_type=deposits&amp;p=<?php echo get_the_ID(); ?>&amp;preview=true" rel="bookmark" aria-label="Preview “<?php echo get_the_title();?>”">Preview</a></span></div><button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
                </td>
                <td class="currency column-currency" data-colname="Currencies">
                    <?php
                        $fields = get_fields(get_the_ID());
                        $term_array = array();
                        $term_list = wp_get_post_terms(get_the_ID(), 'banks_currency', array("fields" => "all"));
                        if ($term_list) {
                            foreach($term_list as $term_single) {
                                $term_array[] = $term_single->name ;
                                ?>
                                <span style="display: inline-block; border: 1px solid #000; border-radius: 3px; padding: 2px 6px; margin: 4px;"><?php echo $term_single->name; ?></span>
                                <?php
                            }
                        }
                    ?>
                </td>
                <td class="types column-types" data-colname="Types">
                    <?php
                    $types_array = array();
                    $types_list = wp_get_post_terms(get_the_ID(), 'banks_types', array("fields" => "all"));

                    foreach ($types_list as $type_single) {
                        $types_array[] = $type_single->name;
                        ?>
                        <span style="display: block"><?php echo $type_single->name; ?></span>
                    <?php } ?>
                </td>
                <td class="date column-date" data-colname="Date">
                    Last Modified<br><abbr title="<?php echo get_the_modified_date('Y/m/d g:i:s A'); ?>"><?php echo get_the_modified_date(); ?></abbr>
                </td>
            </tr>
        <?php endwhile; ?>
        <!-- end of the loop -->
        <tbody>
        <tfoot>
            <tr>
                <td class="manage-column column-cb check-column">
                    <label class="screen-reader-text" for="cb-select-all-2">Select All</label>
                    <input id="cb-select-all-2" type="checkbox">
                </td>
                <th scope="col" class="manage-column column-title column-primary sortable desc">
                    <a href="http://bank.loc/wp-admin/edit.php?post_type=deposits&amp;orderby=title&amp;order=asc">
                        <span>Title</span>
                        <span class="sorting-indicator"></span>
                    </a>
                </th>
                <th scope="col" class="manage-column column-currency">Currencies</th>
                <th scope="col" class="manage-column column-types">Types</th>
                <th scope="col" class="manage-column column-date sortable asc">
                    <a href="http://bank.loc/wp-admin/edit.php?post_type=deposits&amp;orderby=date&amp;order=desc">
                        <span>Date</span>
                        <span class="sorting-indicator"></span>
                    </a>
                </th>
            </tr>
        </tfoot>
    </table>

    <?php wp_reset_postdata();

    else : ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
    <?php endif;

    echo '</div>';

}


add_action( 'admin_enqueue_scripts', function(){
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() .'/assets/css/bootstrap.css' );
    wp_enqueue_style( 'bootstrap-slider', get_template_directory_uri() .'/assets/css/bootstrap-slider.min.css' );
    wp_enqueue_style( 'bootstrap-select', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css' );
    wp_enqueue_style( 'admin', get_template_directory_uri() .'/assets/css/admin-main.css' );
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js' );
    wp_enqueue_script('tether', 'https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js' );
    wp_enqueue_script('bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.js' );
    wp_enqueue_script('bootstrap-slider', get_template_directory_uri() .'/assets/js/bootstrap-slider.min.js' );
    wp_enqueue_script('bootstrap-bundle', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.bundle.min.js' );
    wp_enqueue_script('bootstrap-select', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js' );
    wp_enqueue_script('admin-scripts', get_template_directory_uri() .'/assets/js/admin-main.js', array(), 1.0, true );
}, 99 );

add_action( 'admin_init', 'add_metabox_donor' );

function add_metabox_donor( ){
    add_meta_box( 'postbox-container-2',
        'Currency Settings',
        'display_donor_meta_box',
        'deposits', 'normal', 'low'
    );

}

function display_donor_meta_box($donor) {
//    $donor_post_meta = get_post_meta($donor->ID);
//    $currencies = $donor_post_meta['currencies'];
//
    $taxonomyTerms = wp_get_post_terms($donor->ID, 'banks_term', array('fields' => 'names'));
    $jsonTerms = json_encode($taxonomyTerms);

    $taxonomyCurrency = wp_get_post_terms($donor->ID, 'banks_currency', array('fields' => 'names'));
        if ($taxonomyCurrency) {
    ?>
    <div class="form-group">
        <div class="errBlock" id="errorMsg">
            <div class="alert alert-danger" role="alert"></div>
        </div>
        <label for="currencySelect">Select currency</label>
        <select class="currencyPicker" id="currencySelect" multiple name="currencySelect[]">
            <?php foreach ($taxonomyCurrency as $key => $value) { ?>
                <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
      <input type="hidden" name="allCurrency" id="arrayCurrency"> <!--  hidden-->
    </div>
    <?php }?>

    <hr>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist" id="currencyTab">

        </ul>
        <!-- Tab panes -->
        <div class="tab-content" id="currencyContent">
        </div>


    <?php

    do_action('edit_form_');

}

add_action('edit_form_','add_variable_script', 10, 0 );

function add_variable_script() {
    $jsonMetaData = '';
    if (get_post_meta(get_the_ID(), 'currency_settings')) {
        $metaData = wp_unslash(get_post_meta(get_the_ID(), 'currency_settings'));
        $jsonMetaData = json_encode($metaData[0]);
    }

    $taxonomyTerms = wp_get_post_terms(get_the_ID(), 'banks_term', array('fields' => 'names'));
    $jsonTerms = json_encode($taxonomyTerms);
    echo "<script type=\"text/javascript\">var taxonomyTermJson = '$jsonTerms';</script>";
    echo "<script type=\"text/javascript\">var metaDataDatabase = JSON.stringify($jsonMetaData);</script>";
}

add_action('init', function () {

    $allData = [];

    if (isset($_POST['allCurrency'])) {

        $tabCurrency = $_POST['allCurrency'];
        $arrayTabs = explode(',', $tabCurrency);

        foreach ($arrayTabs as $key => $value) {
            $allData[$value] = $_POST['select'.$value];
        }
        update_post_meta($_POST['post_ID'], 'currency_settings', wp_slash($allData));
    }

//    print_r($_POST);exit;

});


function post_ajax_request() {

    // The $_REQUEST contains all the data sent via ajax
    if ( isset($_REQUEST) ) {
        $postId = $_REQUEST['postId'];

        $openPost = get_post($postId);
        $postLogo = get_field('acf_bank_logo', $postId);
        $postSite = get_field('acf_bank_link', $postId);
        $postPhone = get_field('phone', $postId);
        $postAddres = get_field('address', $postId);
        $postMinDepos = get_field('acf_bank_minimum', $postId);
        $postDetails = get_field('acf_bank_details', $postId);
        $details = '';

        if ($postDetails) {
            $details = '<p class="lead" style="font-size: 16px; line-height: 1.2;">'.$postDetails.'</p>';
        } else {
            $details = '<p style="text-align: center;font-size: 16px;">No details for this bank</p>';
        }

        $data = '
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Info about '.  $openPost->post_title .'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 text-center p-2"><img src="'.$postLogo.'" alt="'.$openPost->post_title.'" style="max-width: 75%;"></div>
                <div class="col-md-12">
                  <ul class="list-group">
                      <li class="list-group-item row">
                          <div class="col-md-4 p-0"><b>Phone</b></div>
                          <div class="col-md-8 p-0 text-right"><a href="tel:'.$postPhone.'">'.$postPhone.'</a></div>
                      </li>
                      <li class="list-group-item row">
                          <div class="col-md-4 p-0"><b>Address</b></div>
                          <div class="col-md-8 p-0 text-right">'.$postAddres.'</div>
                      </li>
                      <li class="list-group-item row">
                          <div class="col-md-4 p-0"><b>Bank website</b></div>
                          <div class="col-md-8 p-0 text-right"><a href="'.$postSite.'">'.$postSite.'</a></div>
                      </li>
                      <li class="list-group-item row">
                          <div class="col-md-4 p-0"><b>Bank minimum deposit</b></div>
                          <div class="col-md-8 p-0 text-right">'.$postMinDepos.'<span class="currency"> USD</span></div>
                      </li>
                  </ul>
                </div>
                <div class="col-md-12 p-0 pt-4">
                
                    <div class="jumbotron jumbotron-fluid p-0">
                      <div class="container ">
                        <h4 style="font-size:2.1rem;font-weight:300;line-height:1.2;">Bank additional details</h4>
                        '.$details.'
                      </div>
                    </div>
                    
                </div>
            </div>
        ';

        echo $data;

    }

    // Always die in functions echoing ajax content
    die();
}

add_action( 'wp_ajax_post_ajax_request', 'post_ajax_request' );
add_action( 'wp_ajax_nopriv_post_ajax_request', 'post_ajax_request' );