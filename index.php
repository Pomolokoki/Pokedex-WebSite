<?php

if(isset($_SESSION['LOGGED_USER']) && $_SESSION['LOGGED_USER'] === true){
	header('location: Pokedex.php');
	exit;
}

?>
<!DOCTYPE html>
<html lang='fr'>

<head>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet'>
	<title>Document</title>
</head>

<?php include_once 'header.php'; ?>

<?php if (isset($errorMessage)): ?>
	<div class='alert alert-danger' role='alert'>
		<?php echo $errorMessage ?>
	<?php endif; ?>

	<body>
		<?php if (!isset($_SESSION['LOGGED_USER'])): ?>
			<?php
			include_once 'Pokedex.php';
			?>
		<?php endif; ?>

	</body>

</html>