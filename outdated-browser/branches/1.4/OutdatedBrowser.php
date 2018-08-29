<?php

/**
 * @name Outdated Browser
 * @desc Extension PresstiFy de contrôle et de mise à jour de navigateur internet obsolète..
 * @author Jordy Manner <jordy@milkcreation.fr>
 * @package presstiFy
 * @namespace \tiFy\Plugins\AdminUi
 * @version 2.0.2
 */

namespace tiFy\Plugins\OutdatedBrowser;

use Illuminate\Support\Arr;
use tiFy\App\Dependency\AbstractAppDependency;

/**
 * Class OutdatedBrowser
 * @package tiFy\Plugins\OutdatedBrowser
 * @see http://outdatedbrowser.com/fr
 * @see https://github.com/burocratik/Outdated-Browser/tree/master
 *
 * Activation :
 * ----------------------------------------------------------------------------------------------------
 * Dans config/app.php ajouter \tiFy\Plugins\OutdatedBrowser\OutdatedBrowser à la liste des fournisseurs de services chargés automatiquement par l'application.
 * ex.
 * <?php
 * ...
 * use tiFy\Plugins\OutdatedBrowser\OutdatedBrowser;
 * ...
 *
 * return [
 *      ...
 *      'providers' => [
 *          ...
 *          OutdatedBrowser::class
 *          ...
 *      ]
 * ];
 *
 * Configuration :
 * ----------------------------------------------------------------------------------------------------
 * Dans le dossier de config, créer le fichier social.php
 * @see /vendor/presstify-plugins/social/Resources/config/social.php Exemple de configuration
 */
final class OutdatedBrowser extends AbstractAppDependency
{
    /**
     * Liste des attributs de configuration.
     * @var array
     */
    protected $attributes = [
        'bgColor'               => '#F25648',
        'color'                 => '#FFF',
        'lowerThan'             => 'transform',
        'languagePath'          => '',
        'wp_enqueue_scripts'    => true
    ];

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->app->appAddAction('init', [$this, 'init']);
        $this->app->appAddAction('wp_enqueue_scripts', [$this, 'wp_enqueue_scripts']);
        $this->app->appAddAction('wp_footer', [$this, 'wp_footer'], 99);
    }

    /**
     * Récupération d'un attribut de configuration.
     *
     * @param string $key Clé d'indice de l'attribut. Syntaxe à point permise.
     * @param mixed $defaults Valeur de retour par défaut.
     *
     * @return mixed
     */
    public function get($key, $defaults = null)
    {
        return Arr::get($this->attributes, $key, $defaults);
    }

    /**
     * Initialisation globale de Wordpress.
     *
     * @return void
     */
    public function init()
    {
        $this->attributes = array_merge(
            $this->attributes,
            config('outdated-browser')
        );

        $this->app->appAssets()->setDataJs(
            'outdatedBrowser',
            [
                'bgColor'      => $this->get('bgColor'),
                'color'        => $this->get('color'),
                'lowerThan'    => $this->get('lowerThan'),
                'languagePath' => $this->get('languagePath'),
            ]
        );

        \wp_register_style(
            'outdatedBrowser',
            class_info($this)->getUrl() . '/Resources/assets/css/outdatedbrowser.min.css',
            [],
            '1.1.2'
        );
        \wp_register_style(
            'tiFyOutdatedBrowser',
            class_info($this)->getUrl() . '/Resources/assets/css/styles.css',
            ['outdatedBrowser'],
            180829
        );

        \wp_register_script(
            'tiFyOutdatedBrowser',
            class_info($this)->getUrl() . '/Resources/assets/js/scripts.min.js',
            [],
            180829,
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
        if ($this->get('wp_enqueue_scripts')) :
            \wp_enqueue_style('tiFyOutdatedBrowser');
            \wp_enqueue_script('tiFyOutdatedBrowser');
        endif;
    }

    /**
     * Scripts du pied de page.
     *
     * @return void
     */
    public function wp_footer()
    {
        if (!$this->get('languagePath')) :
            echo view()
                ->setDirectory(__DIR__ . '/Resources/views')
                ->render('outdated-browser');
        endif;
    }
}
