<?php
include 'functions.php';
// output method
$msg = '';

// Check if user has uploaded new image 
if (isset($_FILES['image'], $_POST['title'], $_POST['description'])) {

    // The folder where the images would be stored
    $target_dir = 'images/';
    // path of the new uploaded image
    $image_path = $target_dir . basename($_FILES['image']['name']);

    // check to make sure the image is valid
    if (!empty($_FILES['image']['tmp_name']) && getimagesize($_FILES['image']['tmp_name'])) {
        
        if (file_exists($image_path)) {
            $msg = 'Image already exists, please choose another or rename that image. ';
        } elseif ($_FILES['image']['size'] > 500000) {
            $msg = 'Image file size too large please choose an image less than 500kb.';
        } else {
            $title = mysqli_real_escape_string($con, $_POST['title']);
            $description = mysqli_real_escape_string($con, $_POST['description']);
            // Everything checks out so we can move the uploaded image
            move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
            // Connect to Mysql
            $sql = "INSERT INTO images(title, description, path) VALUES( '$title', '$description','$image_path' )";

            // save to db and check
            if (mysqli_query($con, $sql)) {
                //success
                $msg = 'Image uploaded successfully!';
            } else {
                //error
                echo 'query error:' . mysqli_error($conn);
            }
        }
    } else {
        $msg = 'Please upload an image!';
    }
}

?>

<?php include 'header.php'; ?>


<div class=" container content upload">
    <h2>Upload image</h2>
    <form class="" action="upload.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label" for="image">Choose Image</label>
            <input class="form-control" type="file" name="image" accept="image/*" id="image" >
        </div>

        <div class="mb-3">
            <label class="form-label" for="title">Title</label>
            <input class="form-control" type="text" name="title" id="title" placeholder="Title">
        </div>

        <div class="mb-3">
            <label class="form-label" for="description">Description</label>
            <textarea class="form-control" name="description" id="description" cols="30" rows="5"></textarea>
            <input class="btn btn-success" type="submit" name="submit" value="Upload Image">
        </div>

    </form>
    <p class="text-danger"><?= $msg ?></p>

</div>






<?php include 'footer.php'; ?>