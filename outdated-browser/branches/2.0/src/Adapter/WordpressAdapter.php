<?php declare(strict_types=1);

namespace tiFy\Plugins\OutdatedBrowser\Adapter;

use tiFy\Plugins\OutdatedBrowser\Contracts\OutdatedBrowser as OutdatedBrowserContract;
use tiFy\Plugins\OutdatedBrowser\Contracts\OutdatedBrowserAdapter;
use tiFy\Plugins\OutdatedBrowser\OutdatedBrowserAwareTrait;

class WordpressAdapter implements OutdatedBrowserAdapter
{
    use OutdatedBrowserAwareTrait;

    /**
     * @param OutdatedBrowserContract $outdatedBrowser
     *
     * @return void
     */
    public function __construct(OutdatedBrowserContract $outdatedBrowser)
    {
        $this->setOutdatedBrowser($outdatedBrowser);

        if ($this->ob()->config('wordpress.autoload', true) === true) {
            add_action('wp_footer', function () {
                echo $this->ob();
            }, 999999);
        }
    }
}