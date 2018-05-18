<?php

/**
 * @name Outdated Browser
 * @desc Extension PresstiFy de contrôle et de mise à jour de navigateur internet obsolète..
 * @author Jordy Manner <jordy@milkcreation.fr>
 * @package presstiFy
 * @namespace \tiFy\Plugins\AdminUi
 * @version 2.0.0
 */

namespace tiFy\Plugins\OutdatedBrowser;

use tiFy\Apps\AppController;

/**
 * @see http://outdatedbrowser.com/fr
 * @see https://github.com/burocratik/Outdated-Browser/tree/master
 *
 * Lower Than (<):
 * "IE11","borderImage"
 * "IE10", "transform" (Default property)
 * "IE9", "boxShadow"
 * "IE8", "borderSpacing"
 */

final class OutdatedBrowser extends AppController
{
    /**
     * Initialisation du controleur.
     *
     * @return void
     */
    public function appBoot()
    {
        $this->appAddAction('init');
        $this->appAddAction('wp_enqueue_scripts');
        $this->appAddAction('wp_footer', null, 99);
    }

    /**
     * Initialisation globale de Wordpress.
     *
     * @return void
     */
    public function init()
    {
        \wp_register_style(
            'tiFyPluginOutdatedBrowser',
            '//cdn.rawgit.com/burocratik/outdated-browser/develop/outdatedbrowser/outdatedbrowser.min.css',
            [],
            '1.1.2'
        );
        \wp_register_script(
            'tiFyPluginOutdatedBrowser',
            '//cdn.rawgit.com/burocratik/outdated-browser/develop/outdatedbrowser/outdatedbrowser.min.js',
            ['jquery'],
            '1.1.2',
            true
        );
    }

    /**
     * Mise en file des scripts de l'interface utilisateurs.
     *
     * @return void
     */
    public function wp_enqueue_scripts()
    {
        if ($this->appConfig('wp_enqueue_scripts', true)) :
            \wp_enqueue_style('tiFyPluginOutdatedBrowser');
            \wp_enqueue_script('tiFyPluginOutdatedBrowser');
        endif;
    }

    /**
     * Scripts du pied de page.
     *
     * @return void
     */
    public function wp_footer()
    {
        $output = "";
        $output .= "\t<div id=\"outdated\" style=\"z-index:9999999;\">\n";
        $output .= "\t\t<h6>" . __('La version de votre navigateur est trop ancienne', 'tify') . "</h6>\n";
        $output .= "\t\t<p>" . __('Pour afficher de manière satisfaisante le contenu de ce site',
                'tify') . "<a id=\"btnUpdateBrowser\" href=\"http://outdatedbrowser.com/fr\" target=\"_blank\">" . __('Télécharger Google Chrome',
                'tify') . "</a></p>\n";
        $output .= "\t\t<p class=\"last\"><a href=\"#\" id=\"btnCloseUpdateBrowser\" title=\"" . __('Fermer',
                'tify') . "\">&times;</a></p>\n";
        $output .= "\t</div>";
        $output .= "\t<script type=\"text/javascript\">/* <![CDATA[ */jQuery(document).ready(function($){outdatedBrowser({bgColor:'" . $this->appConfig('bgColor', '#F25648') . "',color:'" . $this->appConfig('color', '#FFF') . "',lowerThan: '" . $this->appConfig('lowerThan', 'transform') . "',languagePath: '" . $this->appConfig('languagePath', '') . "'});});/* ]]> */</script>";

        echo $output;
    }
}
