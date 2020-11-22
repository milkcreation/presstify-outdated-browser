<?php

/**
 * @name Outdated Browser
 * @desc Avertisseur de Navigateur déprécié
 * @author Jordy Manner <jordy@milkcreation.fr>
 * @package presstify-plugins/outdated-browser
 * @namespace \tiFy\Plugins\OutdatedBrowser
 * @version 1.4.2
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

class OutdatedBrowser extends \tiFy\App\Plugin
{
    /**
     * CONSTRUCTEUR
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
     * EVENEMENTS
     */
    /**
     * Initialisation globale
     *
     * @return void
     */
    final public function init()
    {
        // Déclaration des scripts
        \wp_register_style(
            'outdated-browser',
            '//cdn.rawgit.com/burocratik/outdated-browser/develop/outdatedbrowser/outdatedbrowser.min.css',
            [],
            '1.1.2'
        );
        \wp_register_script(
            'outdated-browser',
            '//cdn.rawgit.com/burocratik/outdated-browser/develop/outdatedbrowser/outdatedbrowser.min.js',
            [],
            '1.1.2',
            true
        );
    }

    /**
     * Mise en file des scripts de l'interface utilisateurs
     *
     * @return void
     */
    /** == Mise en file des scripts == **/
    final public function wp_enqueue_scripts()
    {
        \wp_enqueue_style('outdated-browser');
        \wp_enqueue_script('outdated-browser');
    }

    /**
     * Scripts du pied de page
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
        $output .= "\tif (window.jQuery) {\n";
        $output .= "\t\tjQuery( document ).ready( function($) {\n";
        $output .= "\t\t\toutdatedBrowser({\n";
        $output .= "\t\t\t\tbgColor: '" . self::tFyAppConfig('bgColor') . "',\n";
        $output .= "\t\t\t\tcolor: '" . self::tFyAppConfig('color') . "',\n";
        $output .= "\t\t\t\tlowerThan: '" . self::tFyAppConfig('lowerThan') . "',\n";
        $output .= "\t\t\t\tlanguagePath: '" . self::tFyAppConfig('languagePath') . "'\n";
        $output .= "\t\t\t});\n";
        $output .= "\t\t});\n";
        $output .= "\t}\n";
        $output .= "\t/* ]]> */</script>\n";

        echo $output;
    }
}