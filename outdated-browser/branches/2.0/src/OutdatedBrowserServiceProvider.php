<?php declare(strict_types=1);

namespace tiFy\Plugins\OutdatedBrowser;

use tiFy\Plugins\OutdatedBrowser\Adapter\WordpressAdapter;
use tiFy\Plugins\OutdatedBrowser\Contracts\OutdatedBrowser as OutdatedBrowserContract;
use tiFy\Container\ServiceProvider;

class OutdatedBrowserServiceProvider extends ServiceProvider
{
    /**
     * Liste des noms de qualification des services fournis.
     * @internal requis. Tous les noms de qualification de services à traiter doivent être renseignés.
     * @var string[]
     */
    protected $provides = [
        'outdated-browser',
        'outdated-browser.wp-adapter',
    ];

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        events()->listen('wp.booted', function () {
            /** @var OutdatedBrowserContract $cookieLaw */
            $ob = $this->getContainer()->get('outdated-browser');

            if ($adapter = $ob->resolve('wp-adapter')) {
                $ob->setAdapter($adapter);
            }

            $ob->boot();
        });
    }

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->getContainer()->share('outdated-browser', function () {
            return new OutdatedBrowser(config('outdated-browser', []), $this->getContainer());
        });

        $this->getContainer()->share('outdated-browser.wp-adapter', function () {
            return new WordpressAdapter($this->getContainer()->get('outdated-browser'));
        });
    }
}