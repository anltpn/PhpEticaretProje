<?php include("header.php") ?>

<?php

if(isset($_GET["s"]))
{
	include("sayfa/".$_GET["s"].".php");
}
else
{
	include("sayfa/anasayfa.php");
}

?>

<?php include("footer.php") ?>