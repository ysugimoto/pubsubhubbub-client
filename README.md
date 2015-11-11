# pubsubhubbub-client
Pubsubhubbub client for PHP

## Requirements

- Composer
- PHP 5.4+
- cURL

## Installation

```
$ composer require ysugimoto/pubsubhubbub-client
```

## Usage

```
<?php

$publisher = Pubsubhubbub\Publisher::make();
$publisher->publish("your destination url");
```

And see `example/test.php`.

## Author

Yoshiaki Sugimoto

## License

MIT License

## Thanks

This library inspired from https://github.com/joshfraser/pubsubhubbub-php. That is wonderfule, but don't support composer. So that, we create this library thanks.
