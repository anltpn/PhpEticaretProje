<div class="container">
	<div class="row">
		<?php
			if(isset($_GET["id"]))
			{
				$sorguUrun = mysqli_query($baglanti, "select * from urun u
							inner join kategori k on u.KategoriId=k.KategoriId
							where k.KategoriId=". $_GET["id"] . " or k.UstKategoriId=". $_GET["id"]);
			}
			else
			{
				$sorguUrun = mysqli_query($baglanti, "select * from urun u
							inner join kategori k on u.KategoriId=k.KategoriId");
			}
			
			while ($diziUrun = mysqli_fetch_array($sorguUrun)) { ?>
				<!-- Card -->
				
				<div class="col-md-3 col-sm-1 ">
					<div class="card" style="width: 16rem;">
					<div class="image-test">
					  <img  src="images/urunler/<?= $diziUrun["UrunResim"] ?>" class="card-img-top" alt="...">
					</div>
					
					  <div class="card-body">
						<h5 class="card-title cardOrta cardBlue"><?= $diziUrun["KategoriAdi"] ?> - <?= $diziUrun["UrunAdi"] ?></h5>
						<p class="card-text cardOrta"><?= $diziUrun["UrunAciklama"] ?></p>
						<p class="card-text cardOrta cardRed"><?= $diziUrun["UrunSatisFiyati"] ?> TL</p>
						<a href="#" class="btn btn-primary btn-block">
							<svg class="bi bi-bookmark-plus" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							  <path fill-rule="evenodd" d="M4.5 2a.5.5 0 00-.5.5v11.066l4-2.667 4 2.667V8.5a.5.5 0 011 0v6.934l-5-3.333-5 3.333V2.5A1.5 1.5 0 014.5 1h4a.5.5 0 010 1h-4zm9-1a.5.5 0 01.5.5v2a.5.5 0 01-.5.5h-2a.5.5 0 010-1H13V1.5a.5.5 0 01.5-.5z" clip-rule="evenodd"/>
							  <path fill-rule="evenodd" d="M13 3.5a.5.5 0 01.5-.5h2a.5.5 0 010 1H14v1.5a.5.5 0 01-1 0v-2z" clip-rule="evenodd"/>
							</svg>
							Sepete Ekle
						</a>
					  </div>
					</div>
				</div>
				<!-- Card Son -->
		<?php } ?>
	</div>
</div>