<?php

include_once('../vendor/autoload.php');

use \Maneuver\Omnicasa\Client;
use \Maneuver\Omnicasa\Property;

@require 'globals.php';

$username = defined('USERNAME') ? USERNAME : '';
$password = defined('PASSWORD') ? PASSWORD : '';

$client = new Client($username, $password);
$propertyGetter = new Property($client);

// Get the property with ID 8221.
$property = $propertyGetter->getProperty(8221);

// Access to all data:
var_dump($property->TypeDescription);


$fields = ['ProjectID', 'WebIDName', 'Status'];
$sortBy = ['ProjectID']; // Default is CreatedDate
$args = ['Status' => 5];

// Get a list of properties.
$properties = $propertyGetter->getPropertyList($fields, $sortBy, $args);

// The result is a 'Collection' but you can treat it as an array.
$count = count($properties);

// Or filter it by substatus.
$filtered = $properties->filterBySubStatus(1);