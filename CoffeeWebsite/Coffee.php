<?php

require 'Controller/CoffeeController.php';
$coffeController = new CoffeeController();

if (isset($_POST['types'])) {
    // Fil page with coffees of the selected type
    $coffeeTables = $coffeController->CreateCoffeeTables($_POST['types']);
} else {
    // Page is loaded for the first time, no type selected -> Fetch all types
    $coffeeTables = $coffeController->CreateCoffeeTables('%');
}

// Output page data
$title = 'Coffee overview';
$content = $coffeController->CreateCoffeeDropdownList() . $coffeeTables;

include 'Template.php';
