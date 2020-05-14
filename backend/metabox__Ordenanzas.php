<?php
/* Ordenanzas Metaboxes */
function gmOrd_meta_box() {

    add_meta_box(
        'gadmur_meta_ordenanza',
        '<img src="'.GADMUR_ORDENANZAS_PLUGIN_URL.'images/gadmur-admin-menu-icon.png"> GADMUR - ' .__( 'Datos adicionales para la ordenanza', 'gadmur' ),
        'gmOrd_meta_box_callback',
        'ordenanza',
        'normal',
        'high'
    );
}

add_action( 'add_meta_boxes', 'gmOrd_meta_box' );

function gmOrd_meta_box_callback(){
    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'global_notice_nonce', 'global_notice_nonce' );

    $estados = array(
        1 => 'VIGENTE',
        2 => 'Perdió vigencia',
        3 => 'DEROGADO'
    );
?>
<div class="hcf_box">
    <script>
        // https://www.sitepoint.com/adding-a-media-button-to-the-content-editor/
        jQuery(document).ready(function(){
            jQuery('#insert-my-pdf').click(open_media_window);
        });
        function open_media_window() {
            if (this.window === undefined) {
                this.window = wp.media({
                        title: 'Insertar un PDF',
                        library: {type: 'application/pdf'},
                        multiple: false,
                        button: {text: 'Seleccionar'}
                    });

                var self = this; // Needed to retrieve our variable in the anonymous function below
                this.window.on('select', function() {
                        var first = self.window.state().get('selection').first().toJSON();
                        console.log(first.url);
                        jQuery('#ordenanza_pdf').val(first.url)
                    });
            }

            this.window.open();
            return false;
        }
    </script>
    <style scoped>
        .inputs-placeholder {
            display: flex;
            flex-direction: column;
        }
        .input-placeholder {
            display: flex;
            width: 100%;
            border-radius: 6px;
            justify-content: space-between;
        }
        .input-placeholder-row { display: flex; }
        .input-placeholder-col {
            width: 50%;
            margin: 0 10px;
        }
        .input-placeholder-col-fullw{ width: 100%; }
        .input-label {
            font-weight: bold;
            width: 120px;
        }
        .input-field { width: calc(100% - 120px); }
        .help-text {
            color: gray;
            font-size: 10px;
            display: block;
            margin: 5px 0;
        }
        .required-field { color: darkred; }
        .input-field textarea { width: 100%; }
        .gadmur_ordenanza_pdf { width: 70%; }
    </style>
    <div class="inputs-placeholder">
        <div class="input-placeholder-row">
            <div class="input-placeholder-col">
                <div class="input-placeholder">
                    <div class="input-label">
                        <label for="ordenanza_fecha">Fecha de publicación</label>
                    </div>
                    <div class="input-field">
                        <input id="ordenanza_fecha" 
                            type="date" 
                            name="gadmur_ordenanza_fecha_publicacion"
                            required
                            value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'gadmur_ordenanza_fecha_publicacion', true ) ); ?>">
                        <span class="help-text"><span class="required-field">Campo Requerido.</span></span>
                    </div>
                </div>
            </div>
            <div class="input-placeholder-col">
                <div class="input-placeholder">
                    <div class="input-label">
                        <label for="ordenanza_status">Status de la publicación</label>
                    </div>
                    <div class="input-field">
                        <select id="ordenanza_status"
                            name="gadmur_ordenanza_status">
                            <option>Selectione un estado</option>
                            <?php
                                $selected = '';
                                foreach (GADMUR__ESTADOS as $index => $estado){
                                    $selected = ( get_post_meta( get_the_ID(), 'gadmur_ordenanza_status', true ) == $index ) ? 'selected' : '';
                                    echo '<option value="'.$index.'" '.$selected.'>'.$estado.'</option>';
                                }
                            ?>
                        </select>
                        <span class="help-text"><span class="required-field">Campo Requerido.</span> Indique el estado actual de la ordenanza.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="input-placeholder-row">
            <div class="input-placeholder-col">
                <div class="input-placeholder">
                    <div class="input-label">
                        <label for="ordenanza_numero">Número de Orden</label>
                    </div>
                    <div class="input-field">
                        <input id="ordenanza_numero" 
                            type="text" 
                            name="gadmur_ordenanza_numero"
                            pattern="([0-9]{3}-[0-9]{4})"
                            placeholder="123-1234"
                            required
                            title="Dato invalido. Debe usar el siguiente formato 000-1234"
                            value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'gadmur_ordenanza_numero', true ) ); ?>">
                        <span class="help-text"><span class="required-field">Campo Requerido.</span> Indique el número
                            correlativo de la ordenanza en el siguiente formato 000-1234.</span>
                    </div>
                </div>
            </div>
            <div class="input-placeholder-col">
                <div class="input-placeholder">
                    <div class="input-label">
                        <label for="ordenanza_numero_registro_oficial">Página</label>
                    </div>
                    <div class="input-field">
                        <input id="ordenanza_numero_pagina" 
                            type="number" 
                            name="gadmur_ordenanza_numero_pagina"
                            required
                            value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'gadmur_ordenanza_numero_pagina', true ) ); ?>">
                        <span class="help-text"><span class="required-field">Campo Requerido.</span> Indique el número
                            de Registro Oficial.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="input-placeholder-row">
            <div class="input-placeholder-col input-placeholder-col-fullw">
                <div class="input-placeholder">
                    <div class="input-label">
                        <label for="ordenanza_pdf">URL Documento PDF</label>
                    </div>
                    <div class="input-field">
                        <input id="ordenanza_pdf" 
                            type="url"
                            class="gadmur_ordenanza_pdf"
                            title="Agrege el archivo PDF." 
                            name="gadmur_ordenanza_pdf"
                            accept="application/pdf"
                            width="200px"
                            value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'gadmur_ordenanza_pdf', true ) ); ?>">
                            <a id="insert-my-pdf" class="button custom-plugin-media-button">Subir PDF</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="input-placeholder-row">
            <div class="input-placeholder-col input-placeholder-col-fullw">
                <div class="input-placeholder">
                    <div class="input-label">
                        <label for="ordenanza_observaciones">Observaciones</label>
                    </div>
                    <div class="input-field">
                        <textarea name="gadmur_ordenanza_observaciones" rows="7" width="100%"><?php echo esc_attr( get_post_meta( get_the_ID(), 'gadmur_ordenanza_observaciones', true ) ); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
}

function gmOrd_save_meta_box( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
        $post_id = $parent_id;
    }
    $fields = [
        'gadmur_ordenanza_fecha_publicacion',
        'gadmur_ordenanza_status',
        'gadmur_ordenanza_numero',
        'gadmur_ordenanza_numero_pagina',
        'gadmur_ordenanza_pdf',
        'gadmur_ordenanza_observaciones',
    ];
    foreach ( $fields as $field ) {
        if ( array_key_exists( $field, $_POST ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
        }
     }
    // Make sure the file array isn't empty
    if(!empty($_FILES['gadmur_ordenanza_pdf']['name'])) {
        
        // Setup the array of supported file types. In this case, it's just PDF.
        $supported_types = array('application/pdf');
            
        // Get the file type of the upload
        $arr_file_type = wp_check_filetype(basename($_FILES['gadmur_ordenanza_pdf']['name']));
        $uploaded_type = $arr_file_type['type'];
            
        // Check if the type is supported. If not, throw an error.
        if(in_array($uploaded_type, $supported_types)) {
    
            // Use the WordPress API to upload the file
            $upload = wp_upload_bits($_FILES['gadmur_ordenanza_pdf']['name'], null, file_get_contents($_FILES['gadmur_ordenanza_pdf']['tmp_name']));
        
            if(isset($upload['error']) && $upload['error'] != 0) {
                wp_die('Hubo un error subiendo el documento. El error es: ' . $upload['error']);
            } else {
                add_post_meta($id, 'gadmur_ordenanza_pdf', $upload);
                update_post_meta($id, 'gadmur_ordenanza_pdf', $upload);     
            } // end if/else
    
        } else {
            wp_die("El archivo que intenta subir no es un PDF.");
        } // end if/else
            
    } // end if
}
add_action( 'save_post', 'gmOrd_save_meta_box' );

function gmOrd_update_edit_form() {
    echo ' enctype="multipart/form-data"';
} // end update_edit_form
add_action('post_edit_form_tag', 'gmOrd_update_edit_form');