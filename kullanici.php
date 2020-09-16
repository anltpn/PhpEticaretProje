<?php ob_start(); ?>
<?php
	if(isset($_GET["islem"])){
		if($_GET["islem"]=="Guncelle"){
			$KullaniciAdi = $_GET["id"];
			
			$sorguKayitSec = mysqli_query($baglanti, "select * from kullanici where 
											KullaniciAdi='$KullaniciAdi'");
			$diziKayitSec = mysqli_fetch_array($sorguKayitSec);		
		}
	}

?>

<form class="ust15bosluk" action="" method="POST">
	<div class="form-group">
		<input name="KullaniciAdi" type="text" placeholder="Kullanıcı Adı yazınız" class="form-control" 
			value="<?php if(isset($diziKayitSec)) echo $diziKayitSec["KullaniciAdi"]; ?>" >
	</div>
	<div class="form-group">
		<input name="Sifre" type="password" placeholder="Şifre yazınız" class="form-control"
			value="<?php if(isset($diziKayitSec)) echo $diziKayitSec["Sifre"]; ?>" >
	</div>
	<div class="form-group">
		<input name="Sifre2" type="password" placeholder="Şifreyi yeniden yazınız" class="form-control"
			value="<?php if(isset($diziKayitSec)) echo $diziKayitSec["Sifre"]; ?>">
	</div>
	<div class="form-group">
		<input name="AdSoyad" type="text" placeholder="Ad Soyad yazınız" class="form-control"
			value="<?php if(isset($diziKayitSec)) echo $diziKayitSec["AdSoyad"]; ?>">
	</div>
	<div class="form-group">
		<select class="form-control" name="YetkiId">
			<?php
			$sorguYetki = mysqli_query($baglanti, "select * from Yetki");
			while ($diziYetki = mysqli_fetch_array($sorguYetki)) { ?>
				<option 
					<?php
						if(isset($diziKayitSec)){
							if($diziYetki["YetkiID"] == $diziKayitSec["Yetki"])
								echo " selected ";
						}
					?>

				value="<?= $diziYetki["YetkiID"] ?>"><?= $diziYetki["YetkiAdi"] ?></option>
			<?php } ?>
		</select>
	</div>
	<button name="btnKullaniciEkle" type="submit" class="btn btn-primary">Kullanıcı Ekle</button>
	
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
		
	name="btnKullaniciGuncelle" type="submit" class="btn btn-primary">Kullanıcı Güncelle</button>
</form>

<?php

	if(isset($_POST["btnKullaniciGuncelle"])) {
		$KullaniciAdi = $_POST["KullaniciAdi"];
		$Sifre = $_POST["Sifre"];
		$Sifre2 = $_POST["Sifre2"];
		$AdSoyad = $_POST["AdSoyad"];
		$YetkiId = $_POST["YetkiId"];

		if($Sifre == $Sifre2) {
			
			$sorguKullaniciEkle = "update kullanici
						set Sifre='$Sifre', AdSoyad='$AdSoyad', Yetki=$YetkiId
						where KullaniciAdi='$KullaniciAdi'";
						
			if( mysqli_query($baglanti, $sorguKullaniciEkle) )
				echo '<div style="color:green;">Güncelleme başarılı</div>';
			else
				echo '<div style="color:red;">Hata oluştu</div>';
			
		}
		else {
			echo '<div style="color:red;">Şifreler uyuşmuyor</div>';
		}
		
	}

	if(isset($_GET["islem"])) {
		if($_GET["islem"]=="Sil") {
			$KullaniciAdi = $_GET["id"];
			
			$sorguKullaniciSil = "delete from kullanici where KullaniciAdi='$KullaniciAdi'";
			
			if( mysqli_query($baglanti, $sorguKullaniciSil) ) {
				echo '<div style="color:green;">Silme başarılı</div>';
				header("Refresh:0.25 index.php?s=kullanici");
			}
			else
				echo '<div style="color:red;">Hata oluştu</div>';
			
		}
	}

	if(isset($_POST["btnKullaniciEkle"])) {
		$KullaniciAdi = $_POST["KullaniciAdi"];
		$Sifre = $_POST["Sifre"];
		$Sifre2 = $_POST["Sifre2"];
		$AdSoyad = $_POST["AdSoyad"];
		$YetkiId = $_POST["YetkiId"];

		if($Sifre == $Sifre2) {
			
			$sorguKullaniciEkle = "insert into kullanici
								(KullaniciAdi, Sifre, AdSoyad, Yetki)
						values ('$KullaniciAdi', '$Sifre', '$AdSoyad', $YetkiId)";
						
			if( mysqli_query($baglanti, $sorguKullaniciEkle) )
				echo '<div style="color:green;">Kayıt başarılı</div>';
			else
				echo '<div style="color:red;">Hata oluştu</div>';
			
		}
		else {
			echo '<div style="color:red;">Şifreler uyuşmuyor</div>';
		}
		
	}
?>

<table class="table ust15bosluk">
  <thead class="thead-light">
    <tr>
      <th>#</th>
      <th>Kullanıcı Adı</th>
      <th>Şifre</th>
      <th>Ad Soyad</th>
	  <th>Yetki ID</th>
	  <th>Yetki Adı</th>
    </tr>
  </thead>
  <tbody>
  
  <?php
	$sorguKullanici = mysqli_query($baglanti, "select k.*, y.YetkiAdi 
							from kullanici k
							inner join Yetki y on k.Yetki=y.YetkiId
							order by k.Yetki");
									
	while($diziKullanici = mysqli_fetch_array($sorguKullanici)) { ?>
	
		<tr>
		  <td>
		  <a href="?s=kullanici&islem=Sil&id=<?= $diziKullanici["KullaniciAdi"] ?>">Sil</a>
		  |
		  <a href="?s=kullanici&islem=Guncelle&id=<?= $diziKullanici["KullaniciAdi"] ?>">Güncelle</a>
		  </td>
		  <td><?= $diziKullanici["KullaniciAdi"] ?></td>
		  <td><?= $diziKullanici["Sifre"] ?></td>
		  <td><?= $diziKullanici["AdSoyad"] ?></td>
		  <td><?= $diziKullanici["Yetki"] ?></td>
		  <td><?= $diziKullanici["YetkiAdi"] ?></td>
		</tr>
		
	<?php } ?>
	
  </tbody>
</table>