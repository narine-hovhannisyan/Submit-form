<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<script src ="script.js"></script>

<form action="index.php" method="post" enctype="multipart/form-data">
    <div class="card">
        <h2>Contact Us</h2>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="firstname" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name ="lastname" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label >Select image:</label>
                    <!--             <input class="button button2" type="file" name="fileToUpload" id="fileToUpload" required="required">-->
                    <!--             Select Image File to Upload:-->
                    <input type="file" name="file" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label>Description</label>
                    <textarea name ="description" required></textarea>
                </div>
            </div>

            <div class="col">
                <input type="submit" name="submit" value="Submit">
            </div>
        </div>
    </div>
</form>

</body>
</html>


<?php
$servername = "localhost";
$username = "root";
$password = "01234567";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $description = $_POST['description'];
    $imagepath = $_POST['imagepath'];


// File upload path
$targetDir = "./image/";
$fileName = time() . "--". basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

$statusMsg = '';

if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
    // Allow certain file formats

    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $sql = "INSERT INTO MyGuests (firstname, lastname, email, description,imagepath  ) VALUES ('$firstname', '$lastname', '$email', '$description','$targetFilePath)')";
            if ($conn->query($sql) === TRUE) {
                //echo "New record created successfully";
                echo "<br/>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            if($sql){
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
            }else{
                $statusMsg = "File upload failed, please try again.";
            }
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}else{
    $statusMsg = 'Please select a file to upload.';

}

//echo $statusMsg;

$conn->close();
?>