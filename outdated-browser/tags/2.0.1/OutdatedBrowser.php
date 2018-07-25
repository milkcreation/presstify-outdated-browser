<?php

/**
 * @name Outdated Browser
 * @desc Extension PresstiFy de contrôle et de mise à jour de navigateur internet obsolète..
 * @author Jordy Manner <jordy@milkcreation.fr>
 * @package presstiFy
 * @namespace \tiFy\Plugins\AdminUi
 * @version 2.0.1
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
     * Liste des attributs de configuration.
     * @var array
     */
    protected $attributes = [
        'bgColor'      => '#F25648',
        'color'        => '#FFF',
        'lowerThan'    => 'transform',
        'languagePath' => '',
        'wp_enqueue'   => true,
    ];

    /**
     * Initialisation du controleur.
     *
     * @return void
     */
    public function appBoot()
    {
        $this->appTemplates(
            ['directory' => $this->appDirname() . '/templates']
        );

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
        $this->appSet(
            'config',
            array_merge(
                $this->attributes,
                $this->appConfig()
            )
        );
        $this->appAssets()->setDataJs(
            'outdatedBrowser',
            [
                'bgColor'      => $this->appConfig('bgColor'),
                'color'        => $this->appConfig('color'),
                'lowerThan'    => $this->appConfig('lowerThan'),
                'languagePath' => $this->appConfig('languagePath'),
            ]
        );

        \wp_register_style(
            'outdatedBrowser',
            '//cdn.rawgit.com/burocratik/outdated-browser/develop/outdatedbrowser/outdatedbrowser.min.css',
            [],
            '1.1.2'
        );
        \wp_register_style(
            'tiFyPluginOutdatedBrowser',
            $this->appUrl() . '/assets/css/styles.css',
            ['outdatedBrowser'],
            290518
        );
        \wp_register_script(
            'outdatedBrowser',
            '//cdn.rawgit.com/burocratik/outdated-browser/develop/outdatedbrowser/outdatedbrowser.min.js',
            [],
            '1.1.2',
            true
        );
        \wp_register_script(
            'tiFyPluginOutdatedBrowser',
            $this->appUrl() . '/assets/js/scripts.js',
            ['outdatedBrowser'],
            290518,
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
        if ($this->appConfig('wp_enqueue')) :
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
        if (!$this->appConfig('languagePath')) :
            echo $this->appTemplateRender('outdated-browser');
        endif;
    }
}
