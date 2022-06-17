<?php
include 'functions.php';
$sql = 'SELECT * FROM images ORDER BY uploaded_date DESC';
// make query and get result

$result = mysqli_query($con, $sql);
// fetch the resulting rows as an array
$images = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free result from memory
mysqli_free_result($result);

// close connection
mysqli_close($con);


?>
<?php include 'header.php'; ?>

<div class="home">
    <div class="container-fluid">
        <h2>Gallery</h2>
    </div>
</div>
<div class=" container content">
    <p>Welcome to the gallery page, you can veiw your images below</p>

    <a class="btn btn-success mb-5" href="upload.php" class="upload-image">Upload Image</a>
    <div class="container">
        <div class="row">

            <?php foreach ($images as $image) : ?>

                <?php if (file_exists($image['path'])) : ?>
                    <section class=" images col-xs-6 col-sm-4 col-md-3">
                        <a href="#">
                            <img class="icon" src="<?=$image['path'] ?>" alt="<?=$image['description'] ?>" data-id="<?= $image['id'] ?>" data-title="<?=$image['title'] ?>" width="200" height="200">
                           
                        </a>
                    </section>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="image-popup"></div>

<script>
    //Container we'll use to show and image
    let image_popup = document.querySelector('.image-popup');
    //Loop each image so that we can have the on click event
    document.querySelectorAll('.images a').forEach(img_link => {
        img_link.onclick = e => {
            e.preventDefault();
            let img_meta = img_link.querySelector('img');
            let img = new Image();
            img.onload = () => {
                //Create pop out image
                image_popup.innerHTML = `
                <div class="con">
                <h3>${img_meta.dataset.title}</h3>
                <p>${img_meta.alt}</p>
                <img src="${img.src}" width="${img.width}" height="${img.height}">
                <a href="delete.php?id=${img_meta.dataset.id}" class="trash" title="Delete Image"><i class="fas fa-trash fa-xs"></i></a>
                </div>
                `;
                image_popup.style.display = 'inline-flex';
                
            };
            img.src = img_meta.src;
        };
        
    });
    // Hide the image popup container if user clicks outside the image
    image_popup.onclick = e => {
        if (e.target.className == 'image-popup') {
            image_popup.style.display = "none";
        }
    };
</script>

<?php include 'footer.php'; ?>