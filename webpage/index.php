<?php
	# Sätt titeln på sidan
	$title = "Uppdrag 5 | SQL";

	# Inkludera spl_autoloader_register samt header
	include 'core/init.php';
	include 'incl/header.php';

	# Skapa en instans av klassen CSQLFilemenu
	$menu = new CSQLFileMenu();
?>

<header>
	<h1>SQL - lexikon</h1>
</header>

<div id="navlist">
	<?php $menu->getNavigation(); ?>
</div>

<section>
<?php
	$menu->getContent();
?>
</section>

<?php include 'incl/footer.php'; ?>