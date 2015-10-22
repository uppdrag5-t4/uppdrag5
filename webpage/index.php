<?php
	$title = "Uppdrag 5 | SQL";

	include 'core/init.php';
	include 'incl/header.php';

?>

<header>
	<h1>SQL - lexikon</h1>
</header>

<div id="navlist">
	<a href="#">ROOT</a><span> > </span><a href="#">FILER</a><span> > </span><a href="#">SQL</a>
</div>

<section>
<?php
	$menu = new CSQLFileMenu();
	$menu->getContent();
?>
</section>

<?php include 'incl/footer.php'; ?>