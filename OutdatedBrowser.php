<?php

/**
 * @name Outdated Browser
 * @desc Extension PresstiFy de contrôle et de mise à jour de navigateur internet obsolète.
 * @author Jordy Manner <jordy@milkcreation.fr>
 * @package presstify-plugins/outdated-browser
 * @namespace \tiFy\Plugins\OutdatedBrowser
 * @version 2.0.3
 */

namespace tiFy\Plugins\OutdatedBrowser;

use Illuminate\Support\Arr;

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
final class OutdatedBrowser
{
    /**
     * Liste des attributs de configuration.
     * @var array
     */
    protected $attributes = [
        'bgColor'               => '#F25648',
        'color'                 => '#FFF',
        'lowerThan'             => 'borderImage',
        'languagePath'          => '',
        'wp_enqueue_scripts'    => true
    ];

    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {
        add_action(
            'init',
            function () {
                $this->attributes = array_merge(
                    $this->attributes,
                    config('outdated-browser')
                );

                assets()->setDataJs(
                    'outdatedBrowser',
                    [
                        'bgColor'      => $this->get('bgColor'),
                        'color'        => $this->get('color'),
                        'lowerThan'    => $this->get('lowerThan'),
                        'languagePath' => $this->get('languagePath'),
                    ]
                );

                $url = class_info($this)->getUrl();

                wp_register_style(
                    'outdatedBrowser',
                    $url . '/Resources/assets/css/outdatedbrowser.min.css',
                    [],
                    '1.1.2'
                );

                wp_register_style(
                    'tiFyOutdatedBrowser',
                    $url . '/Resources/assets/css/styles.css',
                    ['outdatedBrowser'],
                    180829
                );

                wp_register_script(
                    'tiFyOutdatedBrowser',
                    $url . '/Resources/assets/js/scripts.min.js',
                    [],
                    180829,
                    true
                );
            }
        );

        add_action(
            'wp_enqueue_scripts',
            function () {
                if ($this->get('wp_enqueue_scripts')) :
                    wp_enqueue_style('tiFyOutdatedBrowser');
                    wp_enqueue_script('tiFyOutdatedBrowser');
                endif;
            }
        );

        add_action(
            'wp_footer',
            function () {
                if (!$this->get('languagePath')) :
                    echo view()
                        ->setDirectory(__DIR__ . '/Resources/views')
                        ->render('outdated-browser');
                endif;
            },
            999999
        );
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
}
