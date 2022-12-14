<?php
$title = "Upload new image";


$content = '<form action="" method="POST" enctype="multipart/form-data">
<h4>Upload an image for your coffee: </h4>
<input type="file" name="file" id="file" /><br />
<input type="submit" name="submit" value="submit" />
</form> ';

// Check if filetype is a valid format
if (isset($_POST["submit"])) {
    $fileType = $_FILES["file"]["type"];

    if (($fileType == "image/gif") ||
        ($fileType == "image/jpeg") ||
        ($fileType == "image/jpg") ||
        ($fileType == "image/png")
    ) {

        // Check if file exists
        if (file_exists("./images/Coffee/" .  $_FILES["file"]["name"])) {
            echo "File already exists";
        } else {
            move_uploaded_file($_FILES["file"]["tmp_name"], "images/Coffee/" .  $_FILES["file"]["name"]);
            echo "Uploaded in " . "images/Coffee/" .  $_FILES["file"]["name"];
        }
    }
}


include './Template.php';
