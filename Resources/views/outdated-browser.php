<?php
/**
 * @var tiFy\View\ViewController $this
 */
?>

<div id="outdated" class="tiFyOutdatedBrowser">
    <h6><?php _e('La version de votre navigateur est trop ancienne', 'tify'); ?></h6>

    <p>
        <?php _e('Vous ne pourrez pas afficher de manière optimale le contenu de ce site.', 'tify'); ?>
        <a id="btnUpdateBrowser" href="http://outdatedbrowser.com/fr" target="_blank">
            <?php _e('Télécharger', 'tify'); ?>
        </a>
    </p>

    <p class="last">
        <a href="#" id="btnCloseUpdateBrowser" title="<?php _e('Fermer', 'tify'); ?>">&times;</a>
    </p>
</div>