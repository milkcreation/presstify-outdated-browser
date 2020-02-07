<?php declare(strict_types=1);

namespace tiFy\Plugins\OutdatedBrowser;

use Illuminate\Support\Arr;
use tiFy\Support\Proxy\Asset;
use tiFy\Support\Proxy\View;

/**
 * @desc Extension PresstiFy de contrôle et de mise à jour de navigateur internet déprécié.
 * @author Jordy Manner <jordy@milkcreation.fr>
 * @package tiFy\Plugins\OutdatedBrowser
 * @version 2.0.16
 *
 * @see http://outdatedbrowser.com/fr
 * @see https://github.com/burocratik/Outdated-Browser/tree/master
 *
 * USAGE :
 * Activation
 * ---------------------------------------------------------------------------------------------------------------------
 * Dans config/app.php ajouter \tiFy\Plugins\OutdatedBrowser\OutdatedBrowser à la liste des fournisseurs de services.
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
 * Configuration
 * ---------------------------------------------------------------------------------------------------------------------
 * Dans le dossier de config, créer le fichier outdated-browser.php
 * @see /vendor/presstify-plugins/outdated-browser/Resources/config/outdated-browser.php
 */
class OutdatedBrowser
{
    /**
     * Liste des attributs de configuration.
     * @var array
     */
    protected $attributes = [
        'bgColor'               => '#F25648',
        'color'                 => '#FFF',
        'lowerThan'             => 'borderImage',
        'languagePath'          => ''
    ];

    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {
        add_action('init', function () {
            $this->attributes = array_merge($this->attributes, config('outdated-browser', []));

            Asset::setDataJs('outdatedBrowser', [
                'bgColor'      => $this->get('bgColor'),
                'color'        => $this->get('color'),
                'lowerThan'    => $this->get('lowerThan'),
                'languagePath' => $this->get('languagePath'),
            ], true);
        });

        add_action('wp_footer', function () {
            if (!$this->get('languagePath')) {
                echo View::getPlatesEngine()->setDirectory(__DIR__ . '/Resources/views')->render('outdated-browser');
            }
        }, 999999);
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
