<?php
/* Custon post type Ordenazas */
if ( ! function_exists('cpt_ordenanza') ) {

    // Register Custom Post Type
    function cpt_ordenanza() {
    
        $labels = array(
            'name'                  => _x( 'Ordenanzas', 'Post Type General Name', 'gadmur' ),
            'singular_name'         => _x( 'Ordenanza', 'Post Type Singular Name', 'gadmur' ),
            'menu_name'             => __( 'Ordenanzas', 'gadmur' ),
            'name_admin_bar'        => __( 'Ordenanza', 'gadmur' ),
            'archives'              => __( 'Archivo de ordenanzas', 'gadmur' ),
            'attributes'            => __( 'Atributos de la ordenanza', 'gadmur' ),
            'parent_item_colon'     => __( 'Parent Item:', 'gadmur' ),
            'all_items'             => __( 'Todas las ordenanzas', 'gadmur' ),
            'add_new_item'          => __( 'Agregar nueva ordenanza', 'gadmur' ),
            'add_new'               => __( 'Agregar nueva', 'gadmur' ),
            'new_item'              => __( 'Nueva ordenanza', 'gadmur' ),
            'edit_item'             => __( 'Editar ordenanza', 'gadmur' ),
            'update_item'           => __( 'Actualiza ordenanza', 'gadmur' ),
            'view_item'             => __( 'Ver ordenanza', 'gadmur' ),
            'view_items'            => __( 'Ver ordenanzas', 'gadmur' ),
            'search_items'          => __( 'Buscar ordenanza', 'gadmur' ),
            'not_found'             => __( 'No se encuentra', 'gadmur' ),
            'not_found_in_trash'    => __( 'No se encuentra en papelera', 'gadmur' ),
            'featured_image'        => __( 'Imagen destacada', 'gadmur' ),
            'set_featured_image'    => __( 'Colocar imagen destacada', 'gadmur' ),
            'remove_featured_image' => __( 'Quitar imagen destacada', 'gadmur' ),
            'use_featured_image'    => __( 'Usar como imagen destacada', 'gadmur' ),
            'insert_into_item'      => __( 'Insertar en el item', 'gadmur' ),
            'uploaded_to_this_item' => __( 'Cargado a este item', 'gadmur' ),
            'items_list'            => __( 'Lista de ordenanzas', 'gadmur' ),
            'items_list_navigation' => __( 'Navegación de la lista de ordenanzas', 'gadmur' ),
            'filter_items_list'     => __( 'Filtrar la lista de ordenanzas', 'gadmur' ),
        );
        $rewrite = array(
            'slug'                  => 'ordenanza',
            'with_front'            => true,
            'pages'                 => true,
            'feeds'                 => true,
        );
        $args = array(
            'label'                 => __( 'Ordenanza', 'gadmur' ),
            'description'           => __( 'Post Type Description', 'gadmur' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'thumbnail', 'revisions'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => GADMUR_ORDENANZAS_PLUGIN_URL . 'images/gadmur-admin-menu-icon.png',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => 'ordenanzas',
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'rewrite'               => $rewrite,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
            'rest_base'             => 'rest_ordenanzas',
        );
        register_post_type( 'ordenanza', $args );
    
    }
    add_action( 'init', 'cpt_ordenanza', 0 );
    
    }