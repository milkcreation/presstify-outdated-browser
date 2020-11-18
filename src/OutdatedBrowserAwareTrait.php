<?php declare(strict_types=1);

namespace tiFy\Plugins\OutdatedBrowser;

use Exception;
use tiFy\Plugins\OutdatedBrowser\Contracts\OutdatedBrowser as OutdatedBrowserContact;

trait OutdatedBrowserAwareTrait
{
    /**
     * Instance du gestionnaire.
     * @var OutdatedBrowserContact|null
     */
    private $ob;

    /**
     * Récupération de l'instance du gestionnaire.
     *
     * @return OutdatedBrowserContact|null
     */
    public function ob(): ?OutdatedBrowserContact
    {
        if (is_null($this->ob)) {
            try {
                $this->ob = OutdatedBrowser::instance();
            } catch (Exception $e) {
                $this->ob;
            }
        }

        return $this->ob;
    }

    /**
     * Définition de l'instance du gestionnaire.
     *
     * @param OutdatedBrowserContact $ob
     *
     * @return static
     */
    public function setOutdatedBrowser(OutdatedBrowserContact $ob): self
    {
        $this->ob = $ob;

        return $this;
    }
}