<?php
/* Taxonomia material post type Ordenazas */
if (!function_exists('tax_materia_ordenanza')) {

    // Register Custom Taxonomy
    function tax_materia_ordenanza()
    {

        $labels = array(
            'name'                       => _x('Materias', 'Taxonomy General Name', 'gadmur'),
            'singular_name'              => _x('Materia', 'Taxonomy Singular Name', 'gadmur'),
            'menu_name'                  => __('Materia', 'gadmur'),
            'all_items'                  => __('Todas', 'gadmur'),
            'parent_item'                => __('Item padre', 'gadmur'),
            'parent_item_colon'          => __('Item padre:', 'gadmur'),
            'new_item_name'              => __('Nuevo nombre', 'gadmur'),
            'add_new_item'               => __('Agregar nueva materia', 'gadmur'),
            'edit_item'                  => __('Editar materia', 'gadmur'),
            'update_item'                => __('Actualizar materia', 'gadmur'),
            'view_item'                  => __('Ver materia', 'gadmur'),
            'separate_items_with_commas' => __('Separe las materias con comas', 'gadmur'),
            'add_or_remove_items'        => __('Agregar o quitar materias', 'gadmur'),
            'choose_from_most_used'      => __('Seleccionar de los mas usados', 'gadmur'),
            'popular_items'              => __('Materias populares', 'gadmur'),
            'search_items'               => __('Buscar materia', 'gadmur'),
            'not_found'                  => __('No encontrado', 'gadmur'),
            'no_terms'                   => __('Sin materia', 'gadmur'),
            'items_list'                 => __('Lista de materias', 'gadmur'),
            'items_list_navigation'      => __('Navegación de la lista de materias', 'gadmur'),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => false,
            'query_var'                  => 'materia',
            'show_in_rest'               => true,
            'rest_base'                  => 'rest_materias',
        );
        register_taxonomy('materia', array('ordenanza'), $args);
    }
    add_action('init', 'tax_materia_ordenanza', 0);
}
function gmOrd_random_color_part()
{
    return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
}
function gmOrd_random_color()
{
    return gmOrd_random_color_part() . gmOrd_random_color_part() . gmOrd_random_color_part();
}
function gmOrd_color_picker_assets($hook_suffix) {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'gadmur-scripts', GADMUR_ORDENANZAS_PLUGIN_URL . '/js/common-script.js', array( 'wp-color-picker' ), false, true );
 }
add_action( 'admin_enqueue_scripts', 'gmOrd_color_picker_assets' );
function gmOrd_taxonomy_add_custom_field()
{
    $color = gmOrd_random_color();
?>
    <div class="form-field">
        <style scoped>
            .color-term{
                display: inline-block;
                width: 15px;
                height: 15px;
                border-radius: 50%;
                background-color: #<?php echo $color; ?>;
            }
        </style>
        <label for="materia-color"><?php _e('Color para el término', 'gadmur'); ?></label>
        <p><strong>Color preseleccionado: <span class="color-term"></span></strong></p>
        <input class="materia-color" type="text" name="materia-color" id="materia-color" value="#<?php echo $color; ?>">
        <p class="description"><?php _e('Seleccione un color para esta materia.', 'gadmur'); ?></p>
    </div>
<?php
}
// https://gist.github.com/ms-studio/fc21fd5720f5bbdfaddc
add_action('materia_add_form_fields', 'gmOrd_taxonomy_add_custom_field', 10, 2);

function gmOrd_taxonomy_edit_custom_meta_field($term) {

    $color = get_term_meta($term->term_id, 'materia-color', true);
   ?>
    <tr class="form-field">
    <th scope="row" valign="top"><label for="materia-color"><?php _e('Color para el término', 'gadmur'); ?></label></th>
        <td>
            <input class="materia-color" type="text" name="materia-color" id="materia-color" value="<?php echo $color ?>">
            <p class="description"><?php _e('Seleccione un color para esta materia.', 'gadmur'); ?></p>
        </td>
    </tr>
<?php
}

add_action( 'materia_edit_form_fields', 'gmOrd_taxonomy_edit_custom_meta_field', 10, 2 );

add_action( 'edit_materia',   'gmOrd_save_term_meta_text' );
add_action( 'create_materia', 'gmOrd_save_term_meta_text' );

function ggmOrd_save_term_meta_text( $term_id ) {

    $old_value  = get_term_meta( $term_id, 'materia-color', true );
    $new_value = isset( $_POST['materia-color'] ) ?  sanitize_text_field ( $_POST['materia-color'] ) : '';


    if ( $old_value && '' === $new_value )
        delete_term_meta( $term_id, 'materia-color' );

    else if ( $old_value !== $new_value )
        update_term_meta( $term_id, 'materia-color', $new_value );
}

add_filter( 'manage_edit-materia_columns', 'gmOrd_edit_term_columns', 10, 3 );

function gmOrd_edit_term_columns( $columns ) {

    $columns['term_color'] = '<span>' . __( 'color', 'text_domain' ) . '</span>';

    return $columns;
}

// RENDER COLUMNS (render the meta data on a column)

add_filter( 'manage_materia_custom_column', 'gmOrd_manage_term_custom_column', 10, 3 );

function gmOrd_manage_term_custom_column( $out, $column, $term_id ) {

    if ( 'term_color' === $column ) {

        $color = get_term_meta($term_id, 'materia-color', true);

        if ( ! $color )
            $color = 'gray';

        $out = '<span style="display: inline-block; width: 15px; height: 15px; border-radius: 50%; background-color: '.esc_attr( $color ).';"></span>';
    }

    return $out;
}