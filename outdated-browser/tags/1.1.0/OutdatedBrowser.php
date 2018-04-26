<?php

/*
Plugin Name: Outdated Browser
Plugin URI: https://presstify.com/plugins/outdated-browser
Description: Avertisseur de Navigateur déprécié
Version: 1.1.0
Author: Milkcreation
Author URI: http://milkcreation.fr
*/

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

namespace tiFy\Plugins\OutdatedBrowser;

use tiFy\App\Plugin;

class OutdatedBrowser extends Plugin
{
    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->appAddAction('init');
        $this->appAddAction('wp_enqueue_scripts');
        $this->appAddAction('wp_footer', null, 99);
    }

    /**
     * Initialisation globale.
     *
     * @return void
     */
    final public function init()
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
    final public function wp_enqueue_scripts()
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
    final public function wp_footer()
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
        $output .= "\t<script type=\"text/javascript\">/* <![CDATA[ */\n";
        $output .= "\t\tjQuery( document ).ready( function($) {\n";
        $output .= "\t\t\toutdatedBrowser({\n";
        $output .= "\t\t\t\tbgColor: '" . $this->appConfig('bgColor') . "',\n";
        $output .= "\t\t\t\tcolor: '" . $this->appConfig('color') . "',\n";
        $output .= "\t\t\t\tlowerThan: '" . $this->appConfig('lowerThan') . "',\n";
        $output .= "\t\t\t\tlanguagePath: '" . $this->appConfig('languagePath') . "'\n";
        $output .= "\t\t\t});\n";
        $output .= "\t\t});\n";
        $output .= "\t/* ]]> */</script>\n";

        echo $output;
    }
}
