<?php declare(strict_types=1);

namespace tiFy\Plugins\OutdatedBrowser;

use RuntimeException;
use Psr\Container\ContainerInterface as Container;
use tiFy\Contracts\Filesystem\LocalFilesystem;
use tiFy\Contracts\Partial\Partial as PartialManagerContract;
use tiFy\Partial\Partial as PartialManager;
use tiFy\Plugins\OutdatedBrowser\Contracts\OutdatedBrowser as OutdatedBrowserContract;
use tiFy\Plugins\OutdatedBrowser\Contracts\OutdatedBrowserAdapter;
use tiFy\Plugins\OutdatedBrowser\Contracts\OutdatedBrowserPartial as OutdatedBrowserPartialContract;
use tiFy\Plugins\OutdatedBrowser\Partial\OutdatedBrowserPartial;
use tiFy\Support\Concerns\BootableTrait;
use tiFy\Support\Concerns\ContainerAwareTrait;
use tiFy\Support\ParamsBag;
use tiFy\Support\Proxy\Storage;

class OutdatedBrowser implements OutdatedBrowserContract
{
    use BootableTrait, ContainerAwareTrait;

    /**
     * Instance de la classe.
     * @var static|null
     */
    private static $instance;

    /**
     * Liste des services par défaut fournis par conteneur d'injection de dépendances.
     * @var array
     */
    private $defaultProviders = [];

    /**
     * Instance du gestionnaire de portion d'affichage.
     * @var PartialManagerContract
     */
    private $partialManager;

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

        $this->partialManager = $this->containerHas(PartialManagerContract::class)
            ? $this->containerGet(PartialManagerContract::class) : new PartialManager();

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
        throw new RuntimeException(sprintf('Unavailable %s instance', __CLASS__));
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->partialManager->get('outdated-browser', ['lowerThan' => $this->config('lowerThan', 'borderImage')])->render();
    }

    /**
     * @inheritDoc
     */
    public function boot(): OutdatedBrowserContract
    {
        if (!$this->isBooted()) {
            $this->partialManager->register(
                'outdated-browser',
                $this->containerHas(OutdatedBrowserPartialContract::class)
                    ? $this->containerGet(OutdatedBrowserPartialContract::class)
                    : (new OutdatedBrowserPartial($this, $this->partialManager))
            );

            $this->setBooted();
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
    public function getProvider(string $name)
    {
        return $this->config("providers.{$name}", $this->defaultProviders[$name] ?? null);
    }

    /**
     * @inheritDoc
     */
    public function resources(?string $path = null)
    {
        if (!isset($this->resources) ||is_null($this->resources)) {
            $this->resources = Storage::local(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'resources');
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
}
