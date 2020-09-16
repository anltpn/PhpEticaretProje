	<?php ob_start(); ?>
<?php
if( isset($_GET["islem"]) ) {
	if( $_GET["islem"]=="Guncelle" ) {
		$KategoriId = $_GET["id"];
		
		$sorguKayitSec = mysqli_query($baglanti, "select * from kategori where 
										KategoriId=$KategoriId");
		$diziKayitSec = mysqli_fetch_array($sorguKayitSec);
	}
}

?>

<form class="ust15bosluk" action="" method="POST">
	<div class="form-group">
		<select class="form-control" name="UstKategoriId">
			<?php
			$sogruKategoriListe = mysqli_query($baglanti, "select
								0 as UstKategoriId, 0 as KategoriId, 
								'Ana Kategori' as KategoriAdi
								union
								select UstKategoriId, KategoriId, KategoriAdi
								from Kategori");
			while($diziKategoriListe = mysqli_fetch_array($sogruKategoriListe)) { ?>
				
				<option 
				
					<?php
						if(isset($diziKayitSec)) {
							if($diziKategoriListe["KategoriId"]==$diziKayitSec["UstKategoriId"])
								echo "selected";
						}				
					?>
				
				value="<?= $diziKategoriListe["KategoriId"] ?>"><?= $diziKategoriListe["KategoriAdi"] ?></option>
			
			<?php } ?>
		</select>
	</div>
	
	<div class="form-group">
		<input name="KategoriAdi" type="text" placeholder="Kategori Adı yazınız" class="form-control" 
			value="<?php if(isset($diziKayitSec)) echo $diziKayitSec["KategoriAdi"]; ?>" >
	</div>
	
	<!-- KategoriId otomatik sayı olduğu için, gizli olarak input eklendi -->
	<!-- 
	<div class="form-group">
		<input name="KategoriId" type="hidden" class="form-control" 
			value="<?php if(isset($diziKayitSec)) echo $diziKayitSec["KategoriId"]; ?>" >
	</div>
	-->
	<button name="btnKategoriEkle" type="submit" class="btn btn-primary">Kategori Ekle</button>
	
	<button 
		<?php
			if(isset($_GET["islem"])) {
				if($_GET["islem"]=="Guncelle")
					echo "visible";
				else
					echo "hidden";
			}
			else {
				echo "hidden";
			}
		
		?>
	name="btnKategoriGuncelle" type="submit" class="btn btn-primary">Kategori Güncelle</button>
</form>

<?php

if(isset($_POST["btnKategoriGuncelle"])) {
	
	$UstKategoriId = $_POST["UstKategoriId"];
	$KategoriAdi = $_POST["KategoriAdi"];
	$KategoriId = $_GET["id"];
	
	$sorguKategoriGuncelle = "update kategori
							set UstKategoriId=$UstKategoriId, KategoriAdi='$KategoriAdi'
							where KategoriId=$KategoriId";
				
	if( mysqli_query($baglanti, $sorguKategoriGuncelle) ) {
		echo '<div style="color:green;">Güncelleme başarılı</div>';
		header("Refresh:0.25 index.php?s=kategori");
	}
	else {
		echo '<div style="color:red;">Hata oluştu</div>';
	}

}

if(isset($_GET["islem"])) {
	if($_GET["islem"]=="Sil") {
		$KategoriId = $_GET["id"];
		
		
		$sorguKategoriSilAltKategoriKontrol = mysqli_query($baglanti,"select * from kategori 
														where UstKategoriId=$KategoriId");
			if( mysqli_num_rows($sorguKategoriSilAltKategoriKontrol) ==0 ) {
		
		$sorguKategoriSilUrunKontrol = mysqli_query($baglanti,"select * from kategori k 
										inner join urun u on k.KategoriId=u.KategoriId
										where k.KategoriId=$KategoriId or k.UstKategoriId=$KategoriId");
		
		if( mysqli_num_rows($sorguKategoriSilUrunKontrol) == 0 ) {

			
			
										
			$sorguKategoriSil = "delete from kategori 
								where KategoriId=$KategoriId or UstKategoriId=$KategoriId";
			
			if( mysqli_query($baglanti, $sorguKategoriSil) ){
				echo '<div style="color:green;">Silme başarılı</div>';
				header("Refresh:0.25 index.php?s=kategori");
			}
			else
				echo '<div style="color:red;">Hata oluştu</div>';
			
		}
		else
		{
			echo '<div style="color:red;">Silmek İstediğiniz Kategoriye Ait Ürünler Var!</div>';
		}
		}
		else
		{
			echo '<div style="color:red;">Silmek İstediğiniz Kategoriye Ait Alt Kategorileri Var!</div>';
			
		}

	}
	
}

if(isset($_POST["btnKategoriEkle"])) {
	$UstKategoriId = $_POST["UstKategoriId"];
	$KategoriAdi = $_POST["KategoriAdi"];
	
	$sorguKategoriEkle = "insert into kategori (UstKategoriId, KategoriAdi)
				values ($UstKategoriId, '$KategoriAdi')";
				
	if( mysqli_query($baglanti, $sorguKategoriEkle) ) {
		echo '<div style="color:green;">Kayıt başarılı</div>';
		header("Refresh:0.25 index.php?s=kategori");
	}
	else {
		echo '<div style="color:red;">Hata oluştu</div>';
	}
}

?>


<table class="table ust15bosluk">
  <thead class="thead-light">
    <tr>
      <th>#</th>
	  <th>Üst Kategori Adı</th>
	  <th>Kategori Id</th>
      <th>Kategori Adı</th>
    </tr>
  </thead>
  <tbody>
	<?php
		$sorguKategori = mysqli_query($baglanti, "select 
											case when k2.KategoriAdi is null then 'Ana Kategori'
											else k2.KategoriAdi 
											end as UstKategoriAdi,
											 
											k1.KategoriId, k1.KategoriAdi 
											from kategori k1
											left join kategori k2 on k1.UstKategoriId=k2.KategoriId
											order by k1.UstKategoriId, k1.KategoriId");
		
		
		while($diziKategori = mysqli_fetch_array($sorguKategori)) { ?>
	
			<tr>
			  <td>
			  <a href="?s=kategori&islem=Sil&id=<?= $diziKategori["KategoriId"] ?>">Sil</a>
			  |
			  <a href="?s=kategori&islem=Guncelle&id=<?= $diziKategori["KategoriId"] ?>">Güncelle</a>
			  </td>
			  <td><?= $diziKategori["UstKategoriAdi"] ?></td>
			  <td><?= $diziKategori["KategoriId"] ?></td>
			  <td><?= $diziKategori["KategoriAdi"] ?></td>
			</tr>
			
		<?php } ?>
  </tbody>
</table>