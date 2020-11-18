# Outdated Browser PresstiFy Plugin

[![Latest Version](https://img.shields.io/badge/release-2.0.19-blue?style=for-the-badge)](https://svn.tigreblanc.fr/presstify-plugins/outdated-browser/tags/2.0.19)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](LICENSE.md)

**Outdated Browser** provide a good solution to notify users when their web browser is out of date.

## Installation

```bash
composer require presstify-plugins/outdated-browser
```

## Setup

### Declaration

```php
// config/app.php
return [
      //...
      'providers' => [
          //...
          \tiFy\Plugins\OutdatedBrowser\OutdatedBrowserServiceProvider::class,
          //...
      ];
      // ...
];
```

### Configuration

```php
// config/theme-suite.php
// @see /vendor/presstify-plugins/outdated-browser/config/outdated-browser.php
return [
      //...

      // ...
];
```