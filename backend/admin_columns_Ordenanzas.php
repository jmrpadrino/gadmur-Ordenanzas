<?php

add_filter( 'manage_posts_columns', 'gmOrd_columns_head' );
add_action( 'manage_posts_custom_column', 'gmOrd_columns_content', 10, 2 );
add_action('admin_head', 'gmOrd_styling_admin_order_list' );
function gmOrd_styling_admin_order_list() {
?>
    <style>
        .label-status{
            display: block;
            border-radius: 4px;
            background-color: lightgray;
            padding: 7px 7px;
            text-align: center;
            width: 120px;
            min-width: 80px;
        }
		.status-1{
            color: green;
            border-left: 5px solid lime;
			font-weight: bold;
        }
		.status-2{
    		color: darkorange;
            border-left: 5px solid orange;
			font-weight: bold;
        }
        .status-3{
    		color: red;
            border-left: 5px solid red;
			font-weight: bold;
        }
    </style>
<?php 
}

function gmOrd_columns_head($defaults){
    if ( $_GET['post_type'] == 'ordenanza' ){
        $defaults['publicada'] = 'Fecha Publicación';
        $defaults['norden'] = 'N° Orden';
        $defaults['estado'] = 'Estado';
    }
    return $defaults;
}

function gmOrd_columns_content($column_name, $post_ID){

    if ( $_GET['post_type'] == 'ordenanza' ){

        if ( $column_name == 'publicada'){
            echo date(
                'd-m-Y',
                strtotime(
                    get_post_meta( $post_ID, 'gadmur_ordenanza_fecha_publicacion', true)
                )
            );
        }
        if ( $column_name == 'norden' ){
            echo get_post_meta( $post_ID, 'gadmur_ordenanza_numero', true);
        }
        if ( $column_name == 'estado' ){
            $estado = get_post_meta( $post_ID, 'gadmur_ordenanza_status', true);
            echo '<span class="label-status status-'.$estado.'">'.GADMUR__ESTADOS[$estado].'</span>';
        }
    }

}

function gmOrd_add_dashboard_widget() {

	wp_add_dashboard_widget(
		'gmOrd_listado_ordenanzas',         
		'<img width="20" src="'.GADMUR_ORDENANZAS_PLUGIN_URL.'images/gadmur-admin-menu-icon.png"> GADMUR - ' . _x('Últimas ordenanzas agregadas en WordPress', 'likoer24'),        
		'gmOrd_dashboard_order_label_statues' 
	);	
}
add_action( 'wp_dashboard_setup', 'gmOrd_add_dashboard_widget' );
function gmOrd_dashboard_order_label_statues() {

    $args = array(
        'post_type' => 'ordenanza',
        'posts_per_page' => 15,
        'post_status' => 'publish'
    );
    $ordenanzas = new WP_Query($args);

	if (!$ordenanzas->have_posts()){
        echo 'No hay ordenanzas agregadas aún.';
    }else{
		echo '<table class="lk24-dashboard-table" width="100%" border="0" align="center">';
		echo '<thead>';
		echo '<tr>';
		echo '<td><strong>Nombre</strong></td>';
		echo '<td><strong>Publicada</strong></td>';
		echo '<td><strong>Estado</strong></td>';
		echo '<td>&nbsp;</td>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
		while($ordenanzas->have_posts()){
            $ordenanzas->the_post();
//			var_dump($order->get_status());
			echo '<tr>';
			echo '<td height="40">'. get_the_title() .'</td>';
            echo '<td>'. date('d-m-Y', strtotime(get_post_meta(get_the_ID(),'gadmur_ordenanza_fecha_publicacion', true)) ) .'</td>';
            $estado = get_post_meta( get_the_ID(), 'gadmur_ordenanza_status', true);
			echo '<td><span class="label-status status-'.$estado.'">'.GADMUR__ESTADOS[$estado].'</span></td>';
			echo '<td aligh="center"><a href="'. get_edit_post_link(get_the_ID()).'"><span class="dashicons dashicons-admin-generic"></span></a></td>';
			echo '</tr>';
		}
		echo '</tbody>';
		echo '<tfoot>';
		echo '<tr>';
		echo '<td><strong>Nombre</strong></td>';
		echo '<td><strong>Publicada</strong></td>';
		echo '<td><strong>Estado</strong></td>';
		echo '<td>&nbsp;</td>';
		echo '</tr>';
		echo '</tfoot>';
		echo '</table>';
	}
}
