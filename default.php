<?php 
		include './layouts/header.php';
?>

<div style="display: flex; justify-content: center;">

<?php 
    if(isset($_SESSION['role'])) {
		include './layouts/menu.php';
	}
?>

<div style="display: block; width: 100%;">
	
	<div class="container mt-4" style="width: max-content; margin-left: auto; margin-right: auto;">
	<!-- Page content -->
     
	<!-- End Page content -->
	</div>
	<?php 
		include './layouts/footer.php';
	?>
</div>