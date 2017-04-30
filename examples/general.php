<?php

include_once('../vendor/autoload.php');

use \Maneuver\Omnicasa\Client;

@require 'globals.php';

$username = defined('USERNAME') ? USERNAME : '';
$password = defined('PASSWORD') ? PASSWORD : '';

$client = new Client($username, $password);

$sites = $client->general->getSiteList();
$cities = $client->general->getCityList();
$offices = $client->general->getOfficeList();
$countries = $client->general->getCountryList();