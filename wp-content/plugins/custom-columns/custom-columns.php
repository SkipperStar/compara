<?php
/**
*Plugin Name: Custom Columns
*/

add_filter('manage_deposits_posts_columns', function ($columns) {

    $custom_columns = [
        'currency'  =>  'Currencies',
        'types'     =>  'Types',
//        'hide'     =>   'Hide',
    ];

    return array_slice($columns, 0, 2) + $custom_columns + $columns;
});


add_filter('manage_deposits_posts_custom_column', function ( $column_name, $post_ID ) {

    $fields = get_fields($post_ID);

    if ( $column_name === 'currency' ) {

            $term_array = array();
            $term_list = wp_get_post_terms($post_ID, 'banks_currency', array("fields" => "all"));
            foreach($term_list as $term_single) {
                $term_array[] = $term_single->name ;
                ?>
                <span style="display: inline-block; border: 1px solid #000; border-radius: 3px; padding: 2px 6px; margin: 4px;"><?php echo $term_single->name; ?></span>
                <?php
            }

    }

    if ( $column_name === 'types' ) {

        $types_array = array();
        $types_list = wp_get_post_terms($post_ID, 'banks_types', array("fields" => "all"));

            foreach ($types_list as $type_single) {
                $types_array[] = $type_single->name;
                ?>
                <span style="display: block"><?php echo $type_single->name; ?></span>
            <?php }

    }


    return $column_name;

}, 10, 2);



