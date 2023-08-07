<?php foreach ($posts as $post):
    $blog = $post->blog->load();
    $usuario = $blog->usuario->load();
?>
    <article>
        <div class="hackergotchi">
            <img src="<?=$usuario->getModel()->obtenerUrlHackergotchi()?>" />
        </div>
        <div class="cuerpo">
            <h1>
                <span class="nombre-usuario"><?=$usuario->getModel()->obtenerNombreParaMostrar()?></span>
                <span class="nombre-blog"><a href="<?=$blog->url?>"><?=$blog->nombre?></a></span> ·
                <span class="fecha-publicación"><?=$post->fecha_publicación?></span>
            </h1>
            <div>
                <?=$post->cuerpo?>
            </div>

            <?php if($post->url_imagen):?>
            <div class="imagen">
                <img src="<?=$post->url_imagen?>" />
            </div>
            <?php endif?>

            <div class="links">
                <a href="<?=$post->permalink?>" target="_blank">Leer más</a>
            </div>
        </div>
    </article>
<?php endforeach?>