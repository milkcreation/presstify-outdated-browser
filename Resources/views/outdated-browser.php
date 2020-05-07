<?php
/**
 * @var tiFy\Contracts\View\PlatesFactory $this
 */
?>
<div id="outdated" class="tiFyOutdatedBrowser">
    <div class="OutdatedBrowser-title"><?php _e('La version de votre navigateur est trop ancienne', 'tify'); ?></div>

    <p class="OutdatedBrowser-text">
        <?php _e('Vous ne pourrez pas afficher de manière optimale le contenu de ce site.', 'tify'); ?>
        <a class="OutdatedBrowser-upload" href="http://outdatedbrowser.com/fr" target="_blank">
            <?php _e('Télécharger', 'tify'); ?>
        </a>
    </p>

    <a href="#" class="OutdatedBrowser-close" title="<?php _e('Fermer', 'tify'); ?>">&times;</a>
</div>