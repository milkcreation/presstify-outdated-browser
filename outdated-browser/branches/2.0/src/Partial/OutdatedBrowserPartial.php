<?php declare(strict_types=1);

namespace tiFy\Plugins\OutdatedBrowser\Partial;

use tiFy\Partial\PartialDriver;
use tiFy\Plugins\OutdatedBrowser\OutdatedBrowserAwareTrait;

class OutdatedBrowserPartial extends PartialDriver
{
    use OutdatedBrowserAwareTrait;

    /**
     * @inheritDoc
     */
    public function defaults(): array
    {
        return [
            'bgColor'               => '#F25648',
            'color'                 => '#FFF',
            'lowerThan'             => 'borderImage'
        ];
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        /*add_action('init', function () {
            $this->attributes = array_merge($this->attributes, config('outdated-browser', []));

            Asset::setDataJs('outdatedBrowser', [
                'bgColor'      => $this->get('bgColor'),
                'color'        => $this->get('color'),
                'lowerThan'    => $this->get('lowerThan'),
                'languagePath' => $this->get('languagePath'),
            ], true);
        });*/

        return parent::render();
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->ob()->resources('views/partial/outdated-browser');
    }
}