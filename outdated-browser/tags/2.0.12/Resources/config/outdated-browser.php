<?php

/**
 * Exemple de configuration.
 * @see https://github.com/burocratik/Outdated-Browser/tree/master
 */

return [
    /**
     * Couleur de fond du message.
     */
    'bgColor'               => '#F25648',

    /**
     * Couleur du texte du message.
     */
    'color'                 => '#FFFFFF',

    /**
     * Limite de prise en charge des navigateurs.
     * {@internal
     *      Lower Than (<):
     *      "IE11","borderImage"
     *      "IE10", "transform" (Default property)
     *      "IE9", "boxShadow"
     *      "IE8", "borderSpacing"
     * }
     */
    'lowerThan'             => 'borderImage',

    /**
     * Chemin absolue vers le gabarit d'affichage personnalisé.
     * ex. your_path/outdatedbrowser/lang/en.html
     */
    'languagePath'          => '',

    /**
     * Mise en file automatique des scripts.
     * {@internal Ajouter "import 'presstify-plugins/outdated-browser/Resources/assets/index';" à votre feuille de style global}
     */
    'wp_enqueue_scripts'    => true
];