<?php get_header(); ?>
<div class="container">
    <div class="row">
        <div class="col col-sm-12">
            <h1><?php echo get_the_title(); ?></h1>
        </div>
    </div>
    <div class="row ordenanza-box">
        <div class="col col-md-8">
            <p class="ordenanza-archive-observaciones"><?php echo get_post_meta(get_the_ID(), 'gadmur_ordenanza_observaciones', true); ?></p>
        </div>
        <div class="col col-md-4 ordenanza-feature-box">
            <ul class="ordenanza-feature-list">
                <li><strong>Estado:</strong> <?php echo get_post_meta(get_the_ID(), 'gadmur_ordenanza_status', true); ?></li>
                <li><strong>Número de orden:</strong> <?php echo get_post_meta(get_the_ID(), 'gadmur_ordenanza_numero', true); ?></li>
                <li><strong>Página?</strong> <?php echo get_post_meta(get_the_ID(), 'gadmur_ordenanza_numero_pagina', true); ?></li>
                <li><strong>Documento publicado el</strong> <?php echo get_post_meta(get_the_ID(), 'gadmur_ordenanza_fecha_publicacion', true); ?></li>
            </ul>
            <p class="no-margin-bottom text-right"><a class="btn btn-info ordenanza-download-pdf" href="<?php echo get_post_meta(get_the_ID(), 'gadmur_ordenanza_pdf', true); ?>" target="_blank">Descarga el PDF</a></p>
        </div>
    </div>
</div>
<?php get_footer(); ?>