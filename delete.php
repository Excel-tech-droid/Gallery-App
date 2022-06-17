<?php
include 'functions.php';

$msg = '';

// Check that poll ID exists
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            $id = mysqli_real_escape_string($con, $_GET['id']);

            $sql = "DELETE FROM images WHERE id = $id";

            if (mysqli_query($con, $sql)) {
                // success
                $msg = 'You have deleted the image';
            echo header('Location: index.php');
                
            } else {
                // user clicked the No button
                echo header('Location: index.php');
            }
        }
        }
if (isset($_GET['id'])) {

    $id = mysqli_real_escape_string($con, $_GET['id']);
    // make sql
    $sql = "SELECT * FROM images WHERE id = $id";
    // get the query result 
    $result = mysqli_query($con, $sql);

    // fetch in array format
    $image = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
    mysqli_close($con);
} else {
    die('No ID specified');
}
        

?>

<?php include 'header.php'; ?>

<div class="content delete">
    <h2>Delete Image #<?=$image['id']?></h2>
    <?php if ($msg): ?>
        <p><?=$msg?></p>
        <?php else: ?>
        <p>Are you sure you want to delete <?=$image['title']?></p>
        <div class="yesno">
            <a href="delete.php?id=<?=$image['id']?>&confirm=yes">Yes</a>
            <a href="delete.php?id=<?=$image['id']?>&confirm=no">No</a>
        </div>
        <?php endif; ?>
</div>


<?php include 'footer.php'; ?>
