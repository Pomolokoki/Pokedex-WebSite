<?php session_start() ?>
<?php session_destroy() ?>
<?php
$new_url = 'pokedex.php';
echo "<script>window.location.replace('$new_url');</script>";
?>