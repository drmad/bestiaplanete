<?php
$this->title = 'IcaPlanet';

foreach ($posts as $post):
    $blog = $post->blog->load();
    $usuario = $blog->usuario->load();
?>
    <article>
        <div class="hackergotchi">
            <img src="<?=$usuario->getModel()->obtenerUrlHackergotchi()?>" />
        </div>
        <div class="contenido">
            <h1>
                <span class="nombre-usuario"><?=$usuario->getModel()->obtenerNombreParaMostrar()?></span>
                <span class="nombre-blog"><a href="<?=$blog->url?>"><?=$blog->nombre?></a></span> ·
                <span class="fecha-publicación"><?=$post->fecha_publicación?></span>
            </h1>
            <div class="cuerpo">
                <?=$post->cuerpo?>
            </div>

            <?php if($post->url_imagen):?>
            <div class="imagen">
                <img src="<?=$post->url_imagen?>" />
            </div>
            <?php endif?>

            <div class="enlaces">
                <a href="<?=$post->permalink?>" target="_blank">
                    Sigue leyendo
                    <?php if ($post->título): ?>
                        <strong><?=$post->título?></strong>
                    <?php endif?>
                    en el blog &raquo;
                </a>
            </div>
        </div>
    </article>
<?php endforeach?>