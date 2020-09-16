<?php
	if(isset($_GET["islem"])){
		if($_GET["islem"]=="Guncelle"){
			$UrunKodu = $_GET["id"];
			
			$sorguKayitSec = mysqli_query($baglanti, "select * from urun where UrunKodu='$UrunKodu'");
			$diziKayitSec = mysqli_fetch_array($sorguKayitSec);		
		}
	}

?>

<form class="ust15bosluk" action="" method="POST" enctype="multipart/form-data">
	<div class="form-group">
		<input name="UrunKodu" type="text" placeholder="Ürün Kodu yazınız" class="form-control" 
		value="<?php if(isset($diziKayitSec)) echo $diziKayitSec["UrunKodu"];
					else if(isset($_POST["UrunKodu"])) echo $_POST["UrunKodu"]; ?>" >
	</div>

	<div class="form-group">
		<input name="UrunAdi" type="text" placeholder="Ürün Adı yazınız" class="form-control" 
		value="<?php if(isset($diziKayitSec)) echo $diziKayitSec["UrunAdi"];
					else if(isset($_POST["UrunAdi"])) echo $_POST["UrunAdi"]; ?>" >
	</div>
	
	<div class="form-group">
		<input name="UrunSatisFiyati" type="text" placeholder="Satış Fiyatı yazınız" class="form-control" 
		value="<?php if(isset($diziKayitSec)) echo $diziKayitSec["UrunSatisFiyati"];
					else if(isset($_POST["UrunSatisFiyati"])) echo $_POST["UrunSatisFiyati"]; ?>" >
	</div>
	
	<div class="form-group">
		<textarea name="UrunAciklama" placeholder="Ürün açıklaması yazınız" class="form-control" rows="3"><?php if(isset($diziKayitSec)) echo $diziKayitSec["UrunAciklama"]; else if(isset($_POST["UrunAciklama"])) echo $_POST["UrunAciklama"]; ?></textarea>
	</div>
	
	<div class="form-group">
		<select class="form-control" name="AnaKategoriId" onchange="this.form.submit()">
			<option value="-1">Seçiniz...</option>
			<?php
			$sogruKategoriListe = mysqli_query($baglanti, "select * from kategori
														where UstKategoriId=0");
			while($diziKategoriListe = mysqli_fetch_array($sogruKategoriListe)) { ?>
				
				<option
					<?php
						if(isset($_POST["AnaKategoriId"])){
							if($_POST["AnaKategoriId"] == $diziKategoriListe["KategoriId"])
							{
								echo "selected";
							}
						}
					?>
				value="<?= $diziKategoriListe["KategoriId"] ?>"><?= $diziKategoriListe["KategoriAdi"] ?></option>
			
			<?php } ?>
		</select>
	</div>
	
	<div class="form-group">
		<select class="form-control" name="KategoriId">
			<?php
			$sogruKategoriListe = mysqli_query($baglanti, "select * from kategori
														where UstKategoriId=" . $_POST["AnaKategoriId"]);
			while($diziKategoriListe = mysqli_fetch_array($sogruKategoriListe)) { ?>
				
				<option value="<?= $diziKategoriListe["KategoriId"] ?>"><?= $diziKategoriListe["KategoriAdi"] ?></option>
			
			<?php } ?>
		</select>
	</div>
	
	<div class="form-group">
		<input type="file" class="form-control-file" name="UrunResim" accept="image/*">
	</div>
	
	<div class="form-group">
		<input name="StokDurumu" type="text" placeholder="Stok Miktarı yazınız" class="form-control" 
		value="<?php if(isset($diziKayitSec)) echo $diziKayitSec["StokDurumu"];
					else if(isset($_POST["StokDurumu"])) echo $_POST["StokDurumu"]; ?>" >
	</div>
	
	<button name="btnUrunEkle" type="submit" class="btn btn-primary">Ürün Ekle</button>
	
	<button
		<?php
			if(isset($_GET["islem"])) {
				if($_GET["islem"]=="Guncelle")
					echo "visible";
				else
					echo "hidden";
			}
			else
				echo "hidden";
		?>
		
	name="btnUrunGuncelle" type="submit" class="btn btn-primary">Urun Güncelle</button>
</form>

<?php

if(isset($_POST["btnUrunGuncelle"])) {
	$tur = $_FILES["UrunResim"]["type"];
	if($tur == "image/jpeg" || $tur == "image/jpg" || $tur == "image/png") {
		
		$dizin = "images/urunler/";
		$uzanti = explode('.', $_FILES["UrunResim"]["name"]);
		$yuklenecekDosya = $dizin . $_POST["UrunKodu"] . '.' . $uzanti[1];
		
		if( move_uploaded_file( $_FILES["UrunResim"]["tmp_name"], $yuklenecekDosya) ) {
			//insert start
			$UrunKodu = $_POST["UrunKodu"];
			$UrunAdi = $_POST["UrunAdi"];
			$UrunSatisFiyati = $_POST["UrunSatisFiyati"];
			$UrunAciklama = $_POST["UrunAciklama"];
			$KategoriId = $_POST["KategoriId"];
			$UrunResim = $_POST["UrunKodu"] . '.' . $uzanti[1];
			$StokDurumu = $_POST["StokDurumu"];
			
			$sorguUrunGuncelle = "update urun 
			set UrunAdi='$UrunAdi', UrunSatisFiyati=$UrunSatisFiyati, UrunAciklama='$UrunAciklama',
				KategoriId=$KategoriId, UrunResim='$UrunResim', StokDurumu='$StokDurumu'
				where UrunKodu='$UrunKodu'";

	
			if( mysqli_query($baglanti, $sorguUrunGuncelle) ) {
				echo '<div style="color:green;">Guncelleme başarılı</div>';
			}
			else {
				echo '<div style="color:red;">Hata oluştu</div>';
			}
			//insert end
		}
		else
		{
			echo '<div style="color:red;">Resim yükleme başarısız olduğu için kayıt eklenmedi!!</div>';
		}
		
	}
	else
	{
		echo '<div style="color:red;">JPEG veya PNG türünden dosya seçmelisiniz!!</div>';
	}
}


if(isset($_GET["islem"])) {
	if($_GET["islem"]=="Sil") {
		$UrunKodu = $_GET["id"];
		
		$sorguResimBilgi = mysqli_query($baglanti, "select * from urun where UrunKodu='$UrunKodu'");
		$diziResimBilgi = mysqli_fetch_array($sorguResimBilgi);
		$dosya = "images/urunler/" . $diziResimBilgi["UrunResim"];
		
		$sorguUrunSil = "delete from urun where UrunKodu='$UrunKodu'";
		
		if( mysqli_query($baglanti, $sorguUrunSil) ) {
			
			unlink($dosya);
			echo '<div style="color:green;">Silme başarılı</div>';
			
		}
		else
			echo '<div style="color:red;">Hata oluştu</div>';
		
	}
}

if(isset($_POST["btnUrunEkle"])) {
	$tur = $_FILES["UrunResim"]["type"];
	if($tur == "image/jpeg" || $tur == "image/jpg" || $tur == "image/png") {
		
		$dizin = "images/urunler/";
		
		$uzanti = explode('.', $_FILES["UrunResim"]["name"]);
		
		$yuklenecekDosya = $dizin . $_POST["UrunKodu"] . '.' . $uzanti[1];
		
		if( move_uploaded_file( $_FILES["UrunResim"]["tmp_name"], $yuklenecekDosya) ) {
			//insert start
			$UrunKodu = $_POST["UrunKodu"];
			$UrunAdi = $_POST["UrunAdi"];
			$UrunSatisFiyati = $_POST["UrunSatisFiyati"];
			$UrunAciklama = $_POST["UrunAciklama"];
			$KategoriId = $_POST["KategoriId"];
			$UrunResim = $_POST["UrunKodu"] . '.' . $uzanti[1];
			$StokDurumu = $_POST["StokDurumu"];
			
			$sorguUrunEkle = "insert into urun 
			(UrunKodu, UrunAdi, UrunSatisFiyati, UrunAciklama, KategoriId, UrunResim, StokDurumu)
	values ('$UrunKodu', '$UrunAdi', $UrunSatisFiyati, '$UrunAciklama', $KategoriId, '$UrunResim', $StokDurumu)";
	
			if( mysqli_query($baglanti, $sorguUrunEkle) ) {
				echo '<div style="color:green;">Kayıt başarılı</div>';
			}
			else {
				echo '<div style="color:red;">Hata oluştu</div>';
			}
			//insert end
		}
		else
		{
			echo '<div style="color:red;">Resim yükleme başarısız olduğu için kayıt eklenmedi!!</div>';
		}
		
	}
	else
	{
		echo '<div style="color:red;">JPEG veya PNG türünden dosya seçmelisiniz!!</div>';
	}
}


?>

<table class="table ust15bosluk">
	<thead class="thead-light">
		<tr>
			<th>#</th>
			<th>Ürün Kodu</th>
			<th>Ürün Adı</th>
			<th>Satış Fiyati</th>
			<th>Açıklama</th>
			<th>Kategori</th>
			<th>Resim</th>
			<th>Stok</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$sorguUrun = mysqli_query($baglanti, "select * from urun u
							inner join kategori k on u.KategoriId=k.KategoriId");
							
			while ($diziUrun = mysqli_fetch_array($sorguUrun)) { ?>
				<tr>
					<td>
					<a href="?s=urun&islem=Sil&id=<?= $diziUrun["UrunKodu"] ?>">Sil</a>
					|
					<a href="?s=urun&islem=Guncelle&id=<?= $diziUrun["UrunKodu"] ?>">Güncelle</a>
					</td>
					<td><?= $diziUrun["UrunKodu"] ?></td>
					<td><?= $diziUrun["UrunAdi"] ?></td>
					<td><?= $diziUrun["UrunSatisFiyati"] ?> TL</td>
					<td><?= $diziUrun["UrunAciklama"] ?></td>
					<td><?= $diziUrun["KategoriAdi"] ?></td>
					<td>
						<img src="images/urunler/<?= $diziUrun["UrunResim"] ?>" width="100px" />
					</td>
					<td><?= $diziUrun["StokDurumu"] ?></td>
				</tr>
		<?php } ?>
	</tbody>
</table>