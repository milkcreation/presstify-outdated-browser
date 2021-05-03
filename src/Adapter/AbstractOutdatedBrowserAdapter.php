<?php declare(strict_types=1);

namespace tiFy\Plugins\OutdatedBrowser\Adapter;

use tiFy\Plugins\OutdatedBrowser\Contracts\OutdatedBrowser as OutdatedBrowserContract;
use tiFy\Plugins\OutdatedBrowser\Contracts\OutdatedBrowserAdapter as OutdatedBrowserAdapterContract;
use tiFy\Plugins\OutdatedBrowser\OutdatedBrowserAwareTrait;

abstract class AbstractOutdatedBrowserAdapter implements OutdatedBrowserAdapterContract
{
    use OutdatedBrowserAwareTrait;

    /**
     * @param OutdatedBrowserContract $outdatedBrowser
     */
    public function __construct(OutdatedBrowserContract $outdatedBrowser)
    {
        $this->setOutdatedBrowser($outdatedBrowser);
    }
}