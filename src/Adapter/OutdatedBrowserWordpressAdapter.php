<?php declare(strict_types=1);

namespace tiFy\Plugins\OutdatedBrowser\Adapter;

use tiFy\Plugins\OutdatedBrowser\Contracts\OutdatedBrowser as OutdatedBrowserContract;
use tiFy\Plugins\OutdatedBrowser\Contracts\OutdatedBrowserWordpressAdapter as OBrowserWpAdapterContract;

class OutdatedBrowserWordpressAdapter extends AbstractOutdatedBrowserAdapter implements OBrowserWpAdapterContract
{
    /**
     * @param OutdatedBrowserContract $outdatedBrowser
     */
    public function __construct(OutdatedBrowserContract $outdatedBrowser)
    {
        parent::__construct($outdatedBrowser);

        if ($this->ob()->config('wordpress.autoload', true) === true) {
            add_action('wp_footer', function () {
                echo $this->ob();
            }, 999999);
        }
    }
}