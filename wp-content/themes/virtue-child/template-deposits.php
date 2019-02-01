<?php
/*
Template Name: Deposits
*/
?>

<?php
    // Custom Functions
    function objectToArray($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return array_map(__FUNCTION__, $d);
        }
        else {
            // Return array
            return $d;
        }
    }

    $queried_object = get_queried_object();
?>

<section class="deposits">
    <?php

        $allTypesArr = []; // array with all existing types
        $allCurrArr = []; // array with all existing currencies
        $allTermsArr = []; // array with all existing terms

        // Get all currency to array
        $allCurr = get_terms([ 'taxonomy' => 'banks_currency','hide_empty' => false ]);
        foreach ($allCurr as $key => $value) {
            array_push($allCurrArr,$value->name);
        }

        // Get all terms to array
        $allTerms = get_terms([ 'taxonomy' => 'banks_term', 'hide_empty' => false ]);
        foreach ($allTerms as $k => $v) {
            array_push($allTermsArr,$v->name);
        }

        // Get all types to array
        $allTypes = get_terms([ 'taxonomy' => 'banks_types', 'hide_empty' => false ]);
        foreach ($allTypes as $ky => $vl) {
            array_push($allTypesArr,$vl->name);
        }
    ?>

    <div class="container">
        <div class="row">
            <!-- deposits header block -->
            <div class="col-md-12">
                <form action="" id="deposits-form">
                    <div class="deposits__header">
                        <div class="deposits__header-box" style="background-image: url('<?php the_field('deposits_page_image') ?>');">
                            <h1 class="deposits__header-title"><?php the_title(); ?></h1>
                            <p class="deposits__header-descr"><?php the_field('deposits_page_descr') ?></p>
                            <div class="deposits__search">
                                <form class="deposits__search-form" action="">
                                    <div class="deposits__search-top">
                                        <input class="deposits__search-input js-deposits-search-value" name="number" value="10000" type="number">
                                    </div>
                                    <div class="deposits__search-slider">
                                        <div id="slider"></div>
                                        <div class="slider-amount">
                                            <span class="slider-min">10,000</span>
                                            <span class="slider-max">1,000,000</span>
                                        </div>
                                    </div>
                                    <button class="deposits__search-submit" type="submit">Compare</button>
                                </form>
                            </div>
                        </div>
    <?php
//      Loop with Posts
        if (!$_GET) {
            $args = array(
                'post_type' => 'deposits',
                'post_status' => 'publish',
                'orderby'   => array('title' => 'DESC')
            );

            $query = new WP_Query($args);

            // HTML Design
        ?>

                        <!--        Start show posts-->
                        <div class="deposits__filters">
                            <!-- Filters -->
                            <div class="filters__list">
                                <div class="filters__item filters__item--img">
                                    <img src="<?php the_field('deposits_page_filter_image'); ?>" alt="">
                                </div>
                                <div class="filters__item">
                                    <span>Filter By</span>
                                </div>
                                <div class="filters__item">
                                    <select name="currency" id="">
                                        <option value="">Any currency</option>
                                        <?php foreach ($allCurrArr as $k => $currency) { ?>
                                            <option value="<?php echo strtolower($currency); ?>"><?php echo $currency; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="filters__item">
                                    <select name="months" id="">
                                        <option value="">Any term</option>
                                        <?php foreach ($allTermsArr as $k => $term) { ?>
                                            <option value="<?php echo $term; ?>"><?php echo $term; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="filters__item">
                                    <select name="kind" id="">
                                        <option value="">Any type</option>
                                        <?php foreach ($allTypesArr as $k => $type) { ?>
                                            <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Right text and counter -->
                            <div class="filters__count">
                                <span>Banks with selected deposits: <span class="banks-count"><?php echo $query->post_count; ?></span></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- deposits header block end -->

        <div class="row">
            <div class="col-md-12">
                <!-- deposits banks -->
                <div class="deposits__banks">
                    <ul class="banks__list">
                        <li class="bank__item bank__item--header">
                            <div class="bank__logo">
                                <span class="bank__item-text">Provider</span>
                            </div>
                            <div class="bank__rate">
                                <span class="bank__item-text">Rate</span>
                            </div>
                            <div class="bank__term">
                                <span class="bank__item-text">Term</span>
                            </div>
                            <div class="bank__type">
                                <span class="bank__item-text">Type</span>
                            </div>
                            <div class="bank__deposit">
                                <span class="bank__item-text">Minimum deposit</span>
                            </div>
                            <div class="bank__details">
                                <span class="bank__item-text">Additional details</span>
                            </div>
                        </li>
                        <?php

                        if( $query->have_posts() ) {
                            while( $query->have_posts() ){ $query->the_post();

                            ?>
                                <li class="bank__item">
                                    <div class="bank__logo">
                                        <a class="bank__logo-link" href="#">
                                            <?php

                                            $bank = get_field('acf_bank_name');
                                            $logo = get_field('acf_bank_logo');
                                            $rate = get_field('acf_bank_rate');
                                            $term = get_field('acf_bank_term');
                                            $minDep = get_field('acf_bank_minimum');
                                            $details = get_field('acf_bank_details');


                                                echo the_title();
                                            ?>
                                        </a>
                                    </div>
                                    <div class="bank__rate">
                                        <span class="bank__item-text"><span class="rate"><?php echo $rate; ?></span> %</span>
                                    </div>
                                    <div class="bank__term">
                                        <?php
                                        $term_array = array();
                                        $term_list = wp_get_post_terms(get_the_ID(), 'banks_term', array("fields" => "all"));
                                        foreach($term_list as $term_single) {
                                            array_push($term_array, $term_single->name);
                                        }
                                        ?>
                                        <span style="display: block; color: #555; font-weight: 400; font-size: 14px;"><?php if ($term_array) echo max($term_array); ?></span>
                                    </div>
                                    <div class="bank__type">
                                        <div class="bank__item-text">

                                            <?php

                                            $types_list = wp_get_post_terms(get_the_ID(), 'banks_types', array("fields" => "all"));

                                            foreach ($types_list as $type_single) {
                                                $types_array[] = $type_single->name;
                                                ?>
                                                <span style="display: block"><?php echo $type_single->name; ?></span>
                                            <?php }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="bank__deposit">
                                        <div class="bank__item-text"><?php echo $minDep.' '; ?><span class="currency">USD</span></div>
                                    </div>
                                    <div class="bank__details">
                                        <button type="button" class="btn btn-outline-info show-modal-info" data-toggle="modal" data-target="#bankInfo" data-id="<?php echo get_the_ID(); ?>">Bank info</button>
                                    </div>
                                </li>
                                <?php
                            }
                            wp_reset_postdata();
                        } else {

                            echo 'No one bank!';

                        }
                        ?>
                        <!--Modal window-->
                        <div class="modal" id="bankInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <!--Input from Js file-->
                                </div>
                            </div>
                        </div>
                        <!--Modal window-->
                    </ul>
                </div>
            </div>
        </div>
        <!--        End show posts-->

        <?php } ?>


    <?php
          if ($_GET)  {

            $args = array(
                'post_type' => 'deposits',
                'post_status' => 'publish',
                'tax_query' => [
                    'relation' => 'AND',
                ],
                'orderby'   => array('title' => 'DESC')
            );

            if (isset($_GET['currency']) && !empty($_GET['currency'])) {
                $args['tax_query'][] = [
                    'taxonomy' => 'banks_currency',
                    'field'    => 'slug',
                    'terms'    => $_GET['currency']
                ];
            }

            if (isset($_GET['months']) && !empty($_GET['months'])) {
                $args['tax_query'][] = [
                    'taxonomy' => 'banks_term',
                    'field'    => 'name',
                    'terms'    => $_GET['months']
                ];
            }

            if (isset($_GET['kind']) && !empty($_GET['kind'])) {
                $args['tax_query'][] = [
                    'taxonomy' => 'banks_types',
                    'field'    => 'name',
                    'terms'    => $_GET['kind']
                ];
            }

            $query = new WP_Query($args);

          // HTML Design

    ?>

                        <!--        Start show posts-->
                        <div class="deposits__filters">
                            <!-- Filters -->
                            <div class="filters__list">
                                <div class="filters__item filters__item--img">
                                    <img src="<?php the_field('deposits_page_filter_image'); ?>" alt="">
                                </div>
                                <div class="filters__item">
                                    <span>Filter By</span>
                                </div>
                                <div class="filters__item">
                                    <select name="currency" id="">
                                        <option value="">Any currency</option>
                                        <?php foreach ($allCurrArr as $k => $currency) { ?>
                                            <option value="<?php echo strtolower($currency); ?>"><?php echo $currency; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="filters__item">
                                    <select name="months" id="">
                                        <option value="">Any term</option>
                                        <?php foreach ($allTermsArr as $k => $term) { ?>
                                            <option value="<?php echo $term; ?>"><?php echo $term; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="filters__item">
                                    <select name="kind" id="">
                                        <option value="">Any type</option>
                                        <?php foreach ($allTypesArr as $k => $type) { ?>
                                            <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Right text and counter -->
                            <div class="filters__count">
                                <span>Banks with selected deposits: <span class="banks-count"><?php echo $query->post_count; ?></span></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- deposits header block end -->

        <div class="row">
            <div class="col-md-12">
                <!-- deposits banks -->
                <div class="deposits__banks">
                    <ul class="banks__list">
                        <li class="bank__item bank__item--header">
                            <div class="bank__logo">
                                <span class="bank__item-text">Provider</span>
                            </div>
                            <div class="bank__rate">
                                <span class="bank__item-text">Rate</span>
                            </div>
                            <div class="bank__term">
                                <span class="bank__item-text">Term</span>
                            </div>
                            <div class="bank__type">
                                <span class="bank__item-text">Type</span>
                            </div>
                            <div class="bank__deposit">
                                <span class="bank__item-text">Minimum deposit</span>
                            </div>
                            <div class="bank__details">
                                <span class="bank__item-text">Additional details</span>
                            </div>
                        </li>
                        <?php

                        if( $query->have_posts() ) {
                            while( $query->have_posts() ){ $query->the_post();

                                $arrOfPosts = array(); //post which we are looking for through the request

                                //  Post meta from Post
                                $postMetaArr = get_post_meta(get_the_ID(), 'currency_settings');   // Получаем Post Meta каждого поста

                                $postMeta = $postMetaArr[0][strtoupper($_GET['currency'])];             // Выбираем из массива Post Meta конкретную валюту

                                $metaTerm = '';
                                $metaTable = '';

                                if ($postMeta) {

                                    foreach ($postMeta as $k => $v) {
                                        //key - 'term', 'rates', 'tableData'
                                        //value - 'N month', 'rates From - To', 'tableData'
                                        switch ($k) {
                                            case '\'term\'':
                                                $metaTerm = $v;
                                                break;
                                            case '\'tableData\'':
                                                $metaTable = $v;
                                                break;
                                        }
                                    }

                                    $metaTableArr = array();
                                    if ($metaTable) {
                                        $metaTable = json_decode(wp_unslash($metaTable));
                                        array_push($metaTableArr, $metaTable);
                                    }

                                    foreach ($metaTableArr as $item) {
                                        foreach ($item as $tableRow) {

                                            $row = get_object_vars($tableRow);

                                            if ($row['term'] === $_GET['months'] && ($_GET['number']>=$row['from']) && ($_GET['number']<=$row['to'])) {
                                                array_push($arrOfPosts, $row);
                                                continue;
                                            }

                                            if ($_GET['months']) {
                                                if ($row['term'] === $_GET['months'] ) {
                                                    array_push($arrOfPosts, $row);
                                                }
                                            }

                                            if ($_GET['number']) {
                                                if (($_GET['number']>=$row['from']) && ($_GET['number']<=$row['to']) ) {
                                                    array_push($arrOfPosts, $row);
                                                }
                                            }

                                        }
                                    }

                                    if ($arrOfPosts) {
                                        foreach ($arrOfPosts as $post) {

                                            // output posts ?>


                                            <li class="bank__item">
                                                <div class="bank__logo">
                                                    <?php echo $query->post->post_title; ?>
                                                </div>
                                                <div class="bank__rate">
                                                    <span class="bank__item-text"><span class="rate"><?php echo $post['rate']; ?></span> %</span>
                                                </div>
                                                <div class="bank__term">
                                                    <span style="display: block; color: #555; font-weight: 400; font-size: 14px;"><?php echo $post['term']; ?></span>
                                                </div>
                                                <div class="bank__type">
                                                    <div class="bank__item-text">
                                                        <?php
                                                        $term_list = wp_get_post_terms($query->post->ID, 'banks_types', array("fields" => "all"));
                                                        foreach($term_list as $term_single) { ?>
                                                            <span style="display: block;"><?php echo $term_single->name; ?></span>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="bank__deposit">
                                                    <div class="bank__item-text"><?php echo get_post_meta($query->post->ID,'acf_bank_minimum', true)?><span class="currency"></span></div>
                                                </div>
                                                <div class="bank__details">
                                                    <div class="bank__item-text">
                                                        <button type="button" class="btn btn-outline-info show-modal-info" data-toggle="modal" data-target="#bankInfo" data-id="<?php echo $query->post->ID; ?>">Bank info</button>
                                                    </div>
                                                </div>
                                            </li>

                                            <?php // end output posts
                                        }
                                    }
                                }
                            }
                            wp_reset_postdata();
                        } else {

                            echo 'No one bank!';

                        }
                        ?>
                        <!--Modal window-->
                        <div class="modal" id="bankInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <!--Input from Js file-->
                                </div>
                            </div>
                        </div>
                        <!--Modal window-->
                    </ul>
                </div>
            </div>
        </div>
        <!--        End show posts-->

          <?php } ?>

   </div>
</section>
<?php 
    /**
    * @hooked virtue_page_comments - 20
    */
    do_action('kadence_page_footer');
?>
</div><!-- /.main -->