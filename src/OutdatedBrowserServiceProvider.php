<?php declare(strict_types=1);

namespace tiFy\Plugins\OutdatedBrowser;

use tiFy\Contracts\Partial\Partial as PartialManagerContract;
use tiFy\Plugins\OutdatedBrowser\Adapter\OutdatedBrowserWordpressAdapter;
use tiFy\Plugins\OutdatedBrowser\Contracts\OutdatedBrowser as OutdatedBrowserContract;
use tiFy\Plugins\OutdatedBrowser\Contracts\OutdatedBrowserPartial as OutdatedBrowserPartialContract;
use tiFy\Plugins\OutdatedBrowser\Contracts\OutdatedBrowserWordpressAdapter as OBrowserWpAdapterContract;
use tiFy\Plugins\OutdatedBrowser\Partial\OutdatedBrowserPartial;
use tiFy\Container\ServiceProvider;

class OutdatedBrowserServiceProvider extends ServiceProvider
{
    /**
     * Liste des noms de qualification des services fournis.
     * @internal requis. Tous les noms de qualification de services à traiter doivent être renseignés.
     * @var string[]
     */
    protected $provides = [
        OutdatedBrowserContract::class,
        OutdatedBrowserPartialContract::class,
        OBrowserWpAdapterContract::class,
    ];

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        events()->on('wp.booted', function () {
            /** @var OutdatedBrowserContract $obrowser */
            $obrowser = $this->getContainer()->get(OutdatedBrowserContract::class);

            if ($obrowser->containerHas(OBrowserWpAdapterContract::class)) {
                $obrowser->setAdapter($obrowser->containerGet(OBrowserWpAdapterContract::class));
            }

            $obrowser->boot();
        });
    }

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->getContainer()->share(OutdatedBrowserContract::class, function (): OutdatedBrowserContract {
            return new OutdatedBrowser(config('outdated-browser', []), $this->getContainer());
        });

        $this->registerAdapters();
        $this->registerPartials();
    }

    /**
     * Déclaration des adapteurs.
     *
     * @return void
     */
    public function registerAdapters(): void
    {
        $this->getContainer()->share(OBrowserWpAdapterContract::class, function (): OBrowserWpAdapterContract {
            return new OutdatedBrowserWordpressAdapter($this->getContainer()->get(OutdatedBrowserContract::class));
        });
    }

    /**
     * Déclaration des pilote de portion d'affichage.
     *
     * @return void
     */
    public function registerPartials(): void
    {
        $this->getContainer()->add(OutdatedBrowserPartialContract::class, function (): OutdatedBrowserPartialContract {
            return new OutdatedBrowserPartial(
                $this->getContainer()->get(OutdatedBrowserContract::class),
                $this->getContainer()->get(PartialManagerContract::class)
            );
        });
    }
}