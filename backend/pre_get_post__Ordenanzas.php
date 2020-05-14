<?php

 function gmOrd_date_search_filter($query) {
    if ( ! is_admin() && $query->is_main_query() ) {

        if (is_post_type_archive('ordenanza')){
            if(isset($_GET['status_ordenanza'])){
                $meta_query = array(array(
                    'key'     => 'gadmur_ordenanza_status',
                    'value'   => $_GET['status_ordenanza'],
                    'compare' => '=',
                ));

                $query->set( 'meta_query', $meta_query );
                $query->set( 'meta_key', 'gadmur_ordenanza_status' );
                return;
            }
            if(
                isset( $_GET['date_start'] ) &&
                isset( $_GET['date_end'] ) 
            ){
                // https://wordpress.stackexchange.com/questions/34888/how-do-i-search-events-between-two-set-dates-inside-wp
                $meta_query = array(array(
                    'key'     => 'gadmur_ordenanza_fecha_publicacion',
                    'value'   => array($_GET['date_start'], $_GET['date_end']),
                    'compare' => 'BETWEEN',
                    'type' => 'DATE'
                ));
                $query->set( 'meta_key', 'gadmur_ordenanza_fecha_publicacion' );
                $query->set( 'meta_query', $meta_query );
                $query->set( 'orderby', 'meta_value' );
                $query->set( 'order', 'ASC' );
            }
        }else{
            return;
        }
    }
}
add_action( 'pre_get_posts', 'gmOrd_date_search_filter' ); 