<?php

include_once('../vendor/autoload.php');

use \Maneuver\Omnicasa\Client;

@require 'globals.php';

$username = defined('USERNAME') ? USERNAME : '';
$password = defined('PASSWORD') ? PASSWORD : '';

$client = new Client($username, $password);

$statusses = $client->settings->getStatusList();
$substatusses = $client->settings->getSubstatusList();
$marquees = $client->settings->getMarqueeList();
$types = $client->settings->getTypesList();
$pricerange = $client->settings->getPriceRangeSales();
$pricerange = $client->settings->getPriceRangeRent();