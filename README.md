phileDebugbar
=============

[![CI](https://github.com/Schlaefer/phileDebugbar/actions/workflows/CI.yml/badge.svg)](https://github.com/Schlaefer/phileDebugbar/actions/workflows/CI.yml)

Adds a [PHP Debug Bar](http://phpdebugbar.com/) to [Phile](https://github.com/PhileCMS/Phile) for development.


### 1. Installation

```
composer require siezi/phile-debugbar
```

### 2. Activation

```
$config['plugins']['siezi\\phileDebugbar'] = ['active' => true];
```

### 3. Usage ###

After the plugin is activated the debug-bar is shown automatically.

Inspect items in the Messages pane with the global function `debug($item);`.
