<?php
/**
 * @var tiFy\Contracts\Partial\PartialView
 */
?>
<div id="outdated" class="tiFyOutdatedBrowser">
    <div class="OutdatedBrowser-title"><?php _e('La version de votre navigateur est obsolète.', 'tify'); ?></div>

    <p class="OutdatedBrowser-text">
        <?php _e('Vous ne pourrez pas afficher de manière optimale le contenu de ce site.', 'tify'); ?>
        <a class="OutdatedBrowser-upload" href="http://outdatedbrowser.com/fr" target="_blank" rel="noreferrer">
            <?php _e('Télécharger', 'tify'); ?>
        </a>
    </p>

    <button aria-label="<?php __('Fermer', 'tify'); ?>" id="outdated--close" class="OutdatedBrowser-close">&times;</button>
</div>