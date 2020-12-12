<?php declare(strict_types=1);

namespace tiFy\Plugins\OutdatedBrowser\Partial;

use tiFy\Contracts\Partial\Partial as PartialManager;
use tiFy\Partial\PartialDriver;
use tiFy\Plugins\OutdatedBrowser\Contracts\OutdatedBrowser;
use tiFy\Plugins\OutdatedBrowser\Contracts\OutdatedBrowserPartial as OutdatedBrowserPartialContract;
use tiFy\Plugins\OutdatedBrowser\OutdatedBrowserAwareTrait;

class OutdatedBrowserPartial extends PartialDriver implements OutdatedBrowserPartialContract
{
    use OutdatedBrowserAwareTrait;

    /**
     * @param OutdatedBrowser $outdatedBrowser
     * @param PartialManager $partialManager
     */
    public function __construct(OutdatedBrowser $outdatedBrowser, PartialManager $partialManager)
    {
        $this->setOutdatedBrowser($outdatedBrowser);

        parent::__construct($partialManager);
    }

    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return array_merge(parent::defaultParams(), [
            'bgColor'               => '#F25648',
            'color'                 => '#FFF',
            'lowerThan'             => 'borderImage'
        ]);
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