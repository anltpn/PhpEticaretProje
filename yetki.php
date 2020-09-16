<?php ob_start(); ?>
<?php
	if(isset($_GET["islem"])){
		if($_GET["islem"]=="Guncelle"){
			$YetkiID = $_GET["id"];
			
			$sorguKayitSec = mysqli_query($baglanti, "select * from Yetki where 
											YetkiID='$YetkiID'");
			$diziKayitSec = mysqli_fetch_array($sorguKayitSec);		
		}
	}

?>

<form class="ust15bosluk" action="?s=yetki" method="POST">
<div class="form-group">
		<input type ="hidden" name="YetkiID" type="text" placeholder="Yetki ID yazınız" class="form-control" 
			value="<?php if(isset($diziKayitSec)) echo $diziKayitSec["YetkiID"]; ?>" >
	</div>

	<div class="form-group">
		<input name="YetkiAdi" type="text" placeholder="Yetki Adi yazınız" class="form-control" 
			value="<?php if(isset($diziKayitSec)) echo $diziKayitSec["YetkiAdi"]; ?>" >
	</div>
	
	
	<button name="btnYetkiEkle" type="submit" class="btn btn-primary">Yetki Ekle</button>
	
	<button
		
		<?php
			if(isset($_GET["islem"])) {
				if($_GET["islem"]=="Guncelle")
					echo "visible";
			}
			else
				echo "hidden";
		?>
		
	name="btnYetkiGuncelle" type="submit" class="btn btn-primary">Yetki Güncelle</button>
</form>

<?php
	if(isset($_POST["btnYetkiGuncelle"])) {
		$YetkiID = $_POST["YetkiID"];
		$YetkiAdi = $_POST["YetkiAdi"];
		
			
			$sorguYetkiEkle = "update Yetki
						set YetkiAdi='$YetkiAdi'
						where YetkiID=$YetkiID";
						
			if( mysqli_query($baglanti, $sorguYetkiEkle) )
				echo '<div style="color:green;">Güncelleme başarılı</div>';
			else
				echo '<div style="color:red;">Hata oluştu</div>';
			
		
		
	}

	if(isset($_GET["islem"])) {
		if($_GET["islem"]=="Sil") {
			$YetkiID = $_GET["id"];
			
			$sorguYetkiSil = "delete from Yetki where YetkiID='$YetkiID'";
			
			if( mysqli_query($baglanti, $sorguYetkiSil) ) {
				echo '<div style="color:green;">Silme başarılı</div>';
			
				header("Refresh:0.25 index.php?s=yetki");
			}
			else
				echo '<div style="color:red;">Hata oluştu</div>';
			
		}
	}

	if(isset($_POST["btnYetkiEkle"])) {
		$YetkiAdi = $_POST["YetkiAdi"];
				
			$sorguYetkiEkle = "insert into Yetki
								(YetkiAdi)
						values ('$YetkiAdi')";
						
			if( mysqli_query($baglanti, $sorguYetkiEkle) )
				echo '<div style="color:green;">Kayıt başarılı</div>';
			else
				echo '<div style="color:red;">Hata oluştu</div>';

	}
?>

<table class="table ust15bosluk">
  <thead class="thead-light">
    <tr>
      <th>#</th>
	  <th>Yetki ID</th>
	  <th>Yetki Adı</th>
    </tr>
  </thead>
  <tbody>
  
  <?php
	$sorguYetki = mysqli_query($baglanti, "select * from Yetki");
									
	while($diziYetki = mysqli_fetch_array($sorguYetki)) { ?>
	
		<tr>
		  <td>
		  <a href="?s=yetki&islem=Sil&id=<?= $diziYetki["YetkiID"] ?>">Sil</a>
		  |
		  <a href="?s=yetki&islem=Guncelle&id=<?= $diziYetki["YetkiID"] ?>">Güncelle</a>
		  </td>
		<td><?= $diziYetki["YetkiID"] ?></td>
		  <td><?= $diziYetki["YetkiAdi"] ?></td>
		</tr>
		
	<?php } ?>
	
  </tbody>
</table>