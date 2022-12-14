<script>
    // Display confirmation box when trying to delete an object
    function showConfirm(id) {
        // build the confirmation box
        var c = confirm("are you sure to delete this item?");

        // if true, delete item and refresh
        if (c)
            window.location = "CoffeeOverview.php?delete=" + id;

    }
</script>


<?php

require("Model/CoffeeModel.php");

//Contains non-database related function for the Coffee page
class CoffeeController
{
    function CreateOverviewTable()
    {
        $result = "
                <table class='overViewTable'>
                <tr>
                <td></td>
                <td></td>
                <td><b>Id</b></td>
                <td><b>Name</b></td>
                <td><b>Type</b></td>
                <td><b>Price</b></td>
                <td><b>Roast</b></td>
                <td><b>Country</b></td>

                </tr>";


        $coffeeArray = $this->GetCoffeeByType('%');

        foreach ($coffeeArray as $key => $value) {
            $result = $result .
                "<tr>
                     <td><a href='CoffeeAdd.php?update=$value->id'>Update</a></td>
                     <td><a href='#' onclick='showConfirm($value->id)'>Delete</a></td>
                     <td>$value->id</td>
                     <td>$value->name</td>
                     <td>$value->type</td>
                     <td>$value->price</td>
                     <td>$value->roast</td>
                     <td>$value->country</td>
                     </tr>";
        }

        $result = $result . "</table>";
        return $result;
    }

    function CreateCoffeeDropdownList()
    {
        $coffeeModel = new CoffeeModel();
        $result = "<form action= '' method = 'POST' width = '150px'>
        <h4>Please select a type: </h4>
        <select name = 'types' >
        <option value = '%' >All</option>
        " . $this->CreateOptionValues($coffeeModel->GetCoffeeTypes()) .
            "</select>
        <input type = 'submit' value = 'Search' />
         </form>";

        return $result;
    }

    function CreateOptionValues(array $valueArray)
    {
        $result = "";

        foreach ($valueArray as $value) {
            $result = $result . "<option value = '$value'>$value</option>";
        }

        return $result;
    }

    function CreateCoffeeTables($types)
    {
        $coffeeModel = new CoffeeModel();
        $coffeeArray = $coffeeModel->GetCoffeeByType($types);
        $result = "";

        // Generate a coffeeTable for each coffeeEntity in an array
        foreach ($coffeeArray as $key => $coffee) {

            $result = $result .
                "<table class = 'coffeeTable'>
                 <tr>
                 <th rowspan='6' width = '150px'><img runat = 'server' src = './images/Coffee/$coffee->image' /></th>
                 <th width = '75px'>Name: </th>
                 <th>$coffee->name</th>
                 <td></td>
                 </tr>

                 <tr>
                 <th>Type: </th>
                 <td>$coffee->type</td>
                 </tr>

                 <tr>
                 <th>Price: </th>
                 <td>$coffee->price</td>
                 </tr>

                 <tr>
                 <th>Roast: </th>
                 <td>$coffee->roast</td>
                 </tr>

                 <tr>
                 <th>Origin: </th>
                 <td>$coffee->country</td>
                 </tr>

                 <tr>
                 <td colspan ='2'>$coffee->review</td>

                 </tr>
                 
                 </table>";
        }
        return $result;
    }

    //Returns list of files in a folder
    function GetImages()
    {

        //Select folder to scan
        $handle = opendir("./images/Coffee/");

        // Read all files and store names in an array
        $images = array();
        while ($image = readdir($handle)) {
            if (strlen($image) > 2) {
                $images[] = $image;
            }
        }


        closedir($handle);

        // Create <select><option> Values and return result
        $result = $this->CreateOptionValues($images);

        return $result;
    }

    //<editor-fold desc="Set Methods">

    function InsertCoffee()
    {
        $name = $_POST["txtName"];
        $type = $_POST["ddlType"];
        $price = $_POST["txtPrice"];
        $roast = $_POST["txtRoast"];
        $country = $_POST["txtCountry"];
        $image = $_POST["ddlImage"];
        $review = $_POST["txtReview"];

        $coffee = new CoffeeEntity(-1, $name, $type, $price, $roast, $country, $image, $review);
        $coffeeModel = new CoffeeModel();
        $coffeeModel->InsertCoffee($coffee);
    }

    function UpdateCoffee($id)
    {
        $name = $_POST["txtName"];
        $type = $_POST["ddlType"];
        $price = $_POST["txtPrice"];
        $roast = $_POST["txtRoast"];
        $country = $_POST["txtCountry"];
        $image = $_POST["ddlImage"];
        $review = $_POST["txtReview"];

        $coffee = new CoffeeEntity($id, $name, $type, $price, $roast, $country, $image, $review);

        $coffeeModel = new CoffeeModel();
        $coffeeModel->UpdateCoffee($id, $coffee);

        header("Location: Coffee.php");
    }

    function DeleteCoffee($id)
    {
        $coffeeModel = new CoffeeModel();
        $coffeeModel->DeleteCoffee($id);

        header("Location: Coffee.php");
    }
    //</editor-fold>

    //<editor-fold desc="Get Methods">
    function GetCoffeeById($id)
    {
        $coffeeModel = new CoffeeModel();
        return $coffeeModel->GetCoffeeById($id);
    }

    function GetCoffeeByType($type)
    {
        $coffeeModel = new CoffeeModel();
        return $coffeeModel->GetCoffeeByType($type);
    }

    function GetCoffeeTypes()
    {
        $coffeeModel = new CoffeeModel();
        return $coffeeModel->GetCoffeeTypes();
    }
    //</editor-fold>

    // Get Methods
}
