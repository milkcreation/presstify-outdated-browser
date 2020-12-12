<?php declare(strict_types=1);

namespace tiFy\Plugins\OutdatedBrowser\Contracts;

use tiFy\Contracts\Partial\PartialDriver as PartialDriverContract;

/**
 * @mixin \tiFy\Plugins\OutdatedBrowser\OutdatedBrowserAwareTrait
 */
interface OutdatedBrowserPartial extends PartialDriverContract
{

}