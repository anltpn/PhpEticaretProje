<!doctype html>
<html lang="tr">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css/stil.css" />
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">	

		<title>İnternet Programılığı</title>
	</head>
	<body>
		<?php
			$baglanti = mysqli_connect("localhost","root","","alkan");
			mysqli_set_charset($baglanti,"utf8");
		?>
	
		<div class="container-fluid">
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
				<a class="navbar-brand" href="index.php">Alkan</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNavDropdown">
					<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link" href="index.php?s=anasayfa">Anasayfa</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="index.php?s=hakkimizda">Hakkımızda</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="index.php?s=iletisim">İletişim</a>
						</li>
						
						<?php
							$sorgu = mysqli_query($baglanti,"select * from kategori where UstKategoriId=0");
							while($dizi = mysqli_fetch_array($sorgu)) {
								echo '<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											'.$dizi["KategoriAdi"].'
										</a>
										<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
										
										$sorgu1 = mysqli_query($baglanti, "select * from kategori where UstKategoriId=". $dizi["KategoriId"]);
										while($dizi1 = mysqli_fetch_array($sorgu1)) {
											echo '<a class="dropdown-item" href="index.php?s=anasayfa&id='.$dizi1["KategoriId"].'">'.$dizi1["KategoriAdi"].'</a>';
										}
								echo '</div>
									</li>';
							}
						?>
						
					</ul>
				</div>
			</nav>	
		</div>

		<div class="container-fluid">
			<div class="row">
				<div class="col-3">
				
						<?php
						@session_start();
						
						if(isset($_SESSION["KullaniciAdi"]))
						{
							echo '<div class="ust15bosluk">Hoşgeldiniz! ' . $_SESSION["KullaniciAdi"] . '</div>';
							echo '<form class="ust15bosluk" action="" method="POST">
									  <button name="btnCikis" type="submit" class="btn btn-primary">Çıkış Yap</button>
									</form>';
									
							echo '<div class="list-group ust15bosluk">
							  <a href="#" class="list-group-item list-group-item-action active">
								Menüler
							  </a>';
							  
							  $sorguMenu = mysqli_query($baglanti, "select * from
																	Yetki y
																	inner join MenuYetki my on y.YetkiId=my.YetkiId
																	inner join Menu m on my.MenuId=m.MenuId
																where y.YetkiId=" . $_SESSION["YetkiId"]);
							  while ($diziMenu = mysqli_fetch_array($sorguMenu)) {
							  
							  echo '<a href="' . $diziMenu["MenuAdres"] . '" class="list-group-item list-group-item-action">'.$diziMenu["MenuAdi"].'</a>';
							  
							  }
							echo '</div>';
								
						}
						else
						{
							echo '<form class="ust15bosluk" action="" method="POST">
								  <div class="form-group">
									<input name="KullaniciAdi" type="text" placeholder="Kullanıcı Adı" class="form-control" id="KullaniciAdi">
								  </div>
								  <div class="form-group">
									<input name="Sifre" type="password" placeholder="Şifre" class="form-control" id="Sifre">
								  </div>
								  <button name="btnGiris" type="submit" class="btn btn-primary">Giriş Yap</button>
								</form>';
						}
					
						if(isset($_POST["btnCikis"])) {
							session_destroy();
							header("Location: index.php");
						}
						
					
						if(isset($_POST["btnGiris"])) {
							$KullaniciAdi = $_POST["KullaniciAdi"];
							$Sifre = $_POST["Sifre"];
							
							$sorgu = mysqli_query($baglanti,"select * from Kullanici where
														KullaniciAdi='$KullaniciAdi' and
														Sifre='$Sifre'");
							if($dizi = mysqli_fetch_array($sorgu))
							{
								$_SESSION["KullaniciAdi"]=$_POST["KullaniciAdi"];
								$_SESSION["YetkiId"]=$dizi["Yetki"];
								header("Location: index.php");
							}
							else
							{
								echo "Hatalı Giriş";
							}
							
						}
					
					
					?>
				</div>
				<div class="col">
				
				
				
				
				
				
				
				
				
				
				
				
				
				