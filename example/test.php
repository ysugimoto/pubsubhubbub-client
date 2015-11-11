<?php

require_once(__DIR__ . "/../vendor/autoload.php");

$publisher = Pubsubhubbub\Publisher::make();
$ret       = $publisher->publish("https://github.com/ysugimoto/pubsubhubbub-client");

if ( $ret ) {
    echo "URI: https://github.com/ysugimoto/pubsubhubbub-client has sent" . PHP_EOL;
} else {
    echo "Send error." . PHP_EOL;
}
