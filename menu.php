<?php ob_start(); ?>

<?php
	if(isset($_GET["islem"])){
		if($_GET["islem"]=="Guncelle"){
			$MenuId = $_GET["id"];
			
			$sorguKayitSec = mysqli_query($baglanti, "select * from Menu where 
											MenuId='$MenuId'");
			$diziKayitSec = mysqli_fetch_array($sorguKayitSec);		
		}
	}

?>

<form class="ust15bosluk" action="?s=menu" method="POST">
<div class="form-group">
		<input type="hidden" name="MenuId" type="text" placeholder="Menu ID yazınız" class="form-control" 
			value="<?php if(isset($diziKayitSec)) echo $diziKayitSec["MenuId"]; ?>" >
	</div>
	<div class="form-group">
		<input name="MenuAdi" type="text" placeholder="Menu Adi yazınız" class="form-control" 
			value="<?php if(isset($diziKayitSec)) echo $diziKayitSec["MenuAdi"]; ?>" >
	</div>
	<div class="form-group">
		<input name="MenuAdres" type="text" placeholder="Menu Adress yazınız" class="form-control" 
			value="<?php if(isset($diziKayitSec)) echo $diziKayitSec["MenuAdres"]; ?>" >
	</div>
	
	
	
	<button name="btnMenuEkle" type="submit" class="btn btn-primary">Menu Ekle</button>
	
	<button
		
		<?php
			if(isset($_GET["islem"])) {
				if($_GET["islem"]=="Guncelle")
					echo "visible";
			}
			else
				echo "hidden";
		?>
		
	name="btnMenuGuncelle" type="submit" class="btn btn-primary">Menu Güncelle</button>
</form>

<?php
	if(isset($_POST["btnMenuGuncelle"])) {
		$MenuId = $_POST["MenuId"];
		$MenuAdi = $_POST["MenuAdi"];
		$MenuAdres = $_POST["MenuAdres"];

			
			$sorguMenuEkle = "update Menu
						set MenuAdi='$MenuAdi', MenuAdres='$MenuAdres'
						where MenuId=$MenuId";
						
			if( mysqli_query($baglanti, $sorguMenuEkle) )
				echo '<div style="color:green;">Güncelleme başarılı</div>';
			else
				echo '<div style="color:red;">Hata oluştu</div>';
			
		
		
	}

	if(isset($_GET["islem"])) {
		if($_GET["islem"]=="Sil") {
			$MenuId = $_GET["id"];
			
			$sorguMenuSil = "delete from Menu where MenuId='$MenuId'";
			
			if( mysqli_query($baglanti, $sorguMenuSil) ) {
				echo '<div style="color:green;">Silme başarılı</div>';
			
				header("Refresh:0.25 index.php?s=menu");
			}
			else
				echo '<div style="color:red;">Hata oluştu</div>';
			
		}
	}

	if(isset($_POST["btnMenuEkle"])) {
		$MenuAdi = $_POST["MenuAdi"];
		$MenuAdres = $_POST["MenuAdres"];
				
			$sorguMenuEkle = "insert into Menu
								(MenuAdi,MenuAdres)
						values ('$MenuAdi','$MenuAdres')";
						
			if( mysqli_query($baglanti, $sorguMenuEkle) )
				echo '<div style="color:green;">Kayıt başarılı</div>';
			else
				echo '<div style="color:red;">Hata oluştu</div>';

	}
?>

<table class="table ust15bosluk">
  <thead class="thead-light">
    <tr>
      <th>#</th>
	  <th>Menu ID</th>
	  <th>Menu Adı</th>
	  <th>Menu Adress</th>
    </tr>
  </thead>
  <tbody>
  
  <?php
	$sorguMenu = mysqli_query($baglanti, "select * from Menu");
									
	while($diziMenu = mysqli_fetch_array($sorguMenu)) { ?>
	
		<tr>
		  <td>
		  <a href="?s=menu&islem=Sil&id=<?= $diziMenu["MenuId"] ?>">Sil</a>
		  |
		  <a href="?s=menu&islem=Guncelle&id=<?= $diziMenu["MenuId"] ?>">Güncelle</a>
		  </td>
		  <td><?= $diziMenu["MenuId"] ?></td>
		  <td><?= $diziMenu["MenuAdi"] ?></td>
		  <td><?= $diziMenu["MenuAdres"] ?></td>
		</tr>
		
	<?php } ?>
	
  </tbody>
</table>