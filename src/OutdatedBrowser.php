<?php declare(strict_types=1);

namespace tiFy\Plugins\OutdatedBrowser;

use Exception;
use Psr\Container\ContainerInterface as Container;
use tiFy\Contracts\Filesystem\LocalFilesystem;
use tiFy\Plugins\OutdatedBrowser\Contracts\OutdatedBrowser as OutdatedBrowserContract;
use tiFy\Plugins\OutdatedBrowser\Contracts\OutdatedBrowserAdapter;
use tiFy\Plugins\OutdatedBrowser\Partial\OutdatedBrowserPartial;
use tiFy\Support\ParamsBag;
use tiFy\Support\Proxy\Partial;
use tiFy\Support\Proxy\Storage;

class OutdatedBrowser implements OutdatedBrowserContract
{
    /**
     * Instance de la classe.
     * @var static|null
     */
    private static $instance;

    /**
     * Indicateur d'initialisation.
     * @var bool
     */
    private $booted = false;

    /**
     * Liste des services par défaut fournis par conteneur d'injection de dépendances.
     * @var array
     */
    private $defaultProviders = [];

    /**
     * Instance du gestionnaire des ressources
     * @var LocalFilesystem|null
     */
    private $resources;

    /**
     * Instance de l'adapteur associé.
     * @var OutdatedBrowserAdapter
     */
    protected $adapter;

    /**
     * Instance du gestionnaire de configuration.
     * @var ParamsBag
     */
    protected $config;

    /**
     * Instance du conteneur d'injection de dépendances.
     * @var Container|null
     */
    protected $container;

    /**
     * @param array $config
     * @param Container|null $container
     *
     * @return void
     */
    public function __construct(array $config = [], Container $container = null)
    {
        $this->setConfig($config);

        if (!is_null($container)) {
            $this->setContainer($container);
        }

        if (!self::$instance instanceof static) {
            self::$instance = $this;
        }
    }

    /**
     * @inheritDoc
     */
    public static function instance(): OutdatedBrowserContract
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }

        throw new Exception('Unavailable OutdatedBrowser instance');
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return Partial::get('outdated-browser', ['lowerThan' => $this->config('lowerThan', 'borderImage')])->render();
    }

    /**
     * @inheritDoc
     */
    public function boot(): OutdatedBrowserContract
    {
        if (!$this->booted) {
            Partial::register('outdated-browser', (new OutdatedBrowserPartial())->setOutdatedBrowser($this));

            $this->booted = true;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function config($key = null, $default = null)
    {
        if (!isset($this->config) || is_null($this->config)) {
            $this->config = new ParamsBag();
        }

        if (is_string($key)) {
            return $this->config->get($key, $default);
        } elseif (is_array($key)) {
            return $this->config->set($key);
        } else {
            return $this->config;
        }
    }

    /**
     * @inheritDoc
     */
    public function getContainer(): ?Container
    {
        return $this->container;
    }

    /**
     * @inheritDoc
     */
    public function getProvider(string $name)
    {
        return $this->config("providers.{$name}", $this->defaultProviders[$name] ?? null);
    }

    /**
     * @inheritDoc
     */
    public function resolve(string $alias)
    {
        return ($container = $this->getContainer()) ? $container->get("outdated-browser.{$alias}") : null;
    }

    /**
     * @inheritDoc
     */
    public function resolvable(string $alias): bool
    {
        return ($container = $this->getContainer()) && $container->has("outdated-browser.{$alias}");
    }

    /**
     * @inheritDoc
     */
    public function resources(?string $path = null)
    {
        if (!isset($this->resources) ||is_null($this->resources)) {
            $this->resources = Storage::local(dirname(__DIR__));
        }

        return is_null($path) ? $this->resources : $this->resources->path($path);
    }

    /**
     * @inheritDoc
     */
    public function setAdapter(OutdatedBrowserAdapter $adapter): OutdatedBrowserContract
    {
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setConfig(array $attrs): OutdatedBrowserContract
    {
        $this->config($attrs);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setContainer(Container $container): OutdatedBrowserContract
    {
        $this->container = $container;

        return $this;
    }
}
