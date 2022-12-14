<?php
require("Entities/CoffeeEntity.php");

// Contains database related code for the Coffee page.
class CoffeeModel
{

    // Get all coffee types from the database and return them in an array.
    function GetCoffeeTypes()
    {

        require 'Credentials.php';

        // Open connection and Select database.
        $link = mysqli_connect('localhost', 'root', '', 'coffeedb');
        $sql = "SELECT DISTINCT type FROM coffee";

        if (!$link) {
            die(mysqli_connect_error());
        }

        $result = mysqli_query($link, $sql) or die(mysqli_connect_error());
        $types = array();

        // Get data from database.
        while ($row = mysqli_fetch_array($result)) {
            array_push($types, $row[0]);
        }

        // Close connection and return result.
        $link->close();
        return $types;
    }

    // Get coffeeEntity objects from the database and return them in an array
    function GetCoffeeByType($type)
    {
        require 'Credentials.php';

        // Open connection and Select database.
        $link = mysqli_connect('localhost', 'root', '', 'coffeedb');
        $sql = "SELECT * FROM coffee WHERE type LIKE '$type'";
        $result = mysqli_query($link, $sql) or die(mysqli_connect_error());
        $coffeeArray = array();

        // Get data from database.
        while ($row = mysqli_fetch_array($result)) {
            $id = $row[0];
            $name = $row[1];
            $type = $row[2];
            $price = $row[3];
            $roast = $row[4];
            $country = $row[5];
            $image = $row[6];
            $review = $row[7];

            // Create coffee objects and store them in an array.
            $coffee = new CoffeeEntity($id, $name, $type, $price, $roast, $country, $image, $review);
            array_push($coffeeArray, $coffee);
        }

        // Close connection and return result

        return $coffeeArray;
    }

    function GetCoffeeById($id)
    {
        require 'Credentials.php';

        // Open connection and Select database.
        $link = mysqli_connect('localhost', 'root', '', 'coffeedb');
        $sql = "SELECT * FROM coffee WHERE id = $id";
        $result = mysqli_query($link, $sql) or die(mysqli_connect_error());

        // Get data from database.
        while ($row = mysqli_fetch_array($result)) {
            $name = $row[1];
            $type = $row[2];
            $price = $row[3];
            $roast = $row[4];
            $country = $row[5];
            $image = $row[6];
            $review = $row[7];

            // Create coffee object
            $coffee = new CoffeeEntity($id, $name, $type, $price, $roast, $country, $image, $review);
        }

        // Close connection and return result

        return $coffee;
    }

    function InsertCoffee(CoffeeEntity $coffee)
    {
        $sql =  "INSERT INTO coffee
        (name,type,price,roast,country,image,review) VALUES ('$coffee->name','$coffee->type','$coffee->price', '$coffee->roast', '$coffee->country', '$coffee->image', '$coffee->review' )";
        $this->PerformQuery($sql);
    }

    function UpdateCoffee($id, CoffeeEntity $coffee)
    {
        $sql = "UPDATE coffee SET name =\"$coffee->name\", type =\"$coffee->type\", price =$coffee->price, roast =\"$coffee->roast\",
        country =\"$coffee->country\", image =\"$coffee->image\", review =\"$coffee->review\" WHERE id = $id ";
        echo $sql;
        $this->PerformQuery($sql);
    }

    function DeleteCoffee($id)
    {
        $sql = "DELETE FROM coffee WHERE id = $id";
        $this->PerformQuery($sql);
    }

    function PerformQuery($sql)
    {

        require 'Credentials.php';
        $link = mysqli_connect('localhost', 'root', '', 'coffeedb');

        if (!$link) {
            die(mysqli_connect_error());
        }

        $result = mysqli_query($link, $sql) or die(mysqli_connect_error());
    }
}
