-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 05 Eyl 2020, 11:02:13
-- Sunucu sürümü: 10.1.21-MariaDB
-- PHP Sürümü: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `alkan`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategori`
--

CREATE TABLE `kategori` (
  `UstKategoriId` int(11) NOT NULL,
  `KategoriId` int(11) NOT NULL,
  `KategoriAdi` varchar(30) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kategori`
--

INSERT INTO `kategori` (`UstKategoriId`, `KategoriId`, `KategoriAdi`) VALUES
(0, 1, 'Elektronik'),
(1, 3, 'Bilgisayar'),
(1, 4, 'Yazıcılar'),
(1, 6, 'Telefon'),
(0, 7, 'Spor'),
(7, 8, 'Bisiklet'),
(7, 9, 'Tenis'),
(7, 12, 'Balıkçılık'),
(1, 13, 'Tablet');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici`
--

CREATE TABLE `kullanici` (
  `KullaniciAdi` varchar(10) COLLATE utf8_turkish_ci NOT NULL,
  `Sifre` varchar(8) COLLATE utf8_turkish_ci NOT NULL,
  `AdSoyad` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `Yetki` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kullanici`
--

INSERT INTO `kullanici` (`KullaniciAdi`, `Sifre`, `AdSoyad`, `Yetki`) VALUES
('anil', '12345', 'Anıl Can Tapan', 1),
('ogr', '12345', 'Murat Köse', 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `menu`
--

CREATE TABLE `menu` (
  `MenuId` int(11) NOT NULL,
  `MenuAdi` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `MenuAdres` varchar(35) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `menu`
--

INSERT INTO `menu` (`MenuId`, `MenuAdi`, `MenuAdres`) VALUES
(1, 'Kullanıcı Ayarları', '?s=kullanici'),
(2, 'Kategori Ayarlari', '?s=kategori'),
(3, 'Ürün Ayarları', '?s=urun'),
(6, 'Sepet', '?s=sepet'),
(7, 'Yetki', '?s=yetki'),
(8, 'Menü Ayarları', '?s=menu'),
(9, 'Menu Yetki Ayarları', '?s=menuyetki');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `menuyetki`
--

CREATE TABLE `menuyetki` (
  `MenuYetkiId` int(11) NOT NULL,
  `MenuId` int(11) NOT NULL,
  `YetkiId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `menuyetki`
--

INSERT INTO `menuyetki` (`MenuYetkiId`, `MenuId`, `YetkiId`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(8, 6, 1),
(9, 6, 2),
(10, 7, 1),
(11, 8, 1),
(12, 9, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun`
--

CREATE TABLE `urun` (
  `UrunKodu` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `UrunAdi` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `UrunSatisFiyati` int(11) NOT NULL,
  `UrunAciklama` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `KategoriId` int(11) NOT NULL,
  `UrunResim` varchar(45) COLLATE utf8_turkish_ci NOT NULL,
  `StokDurumu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `urun`
--

INSERT INTO `urun` (`UrunKodu`, `UrunAdi`, `UrunSatisFiyati`, `UrunAciklama`, `KategoriId`, `UrunResim`, `StokDurumu`) VALUES
('iphone', 'iphone', 13, 'aaa', 6, 'iphone.jpg', 44),
('Samsung', 'Telefon', 1400, 'Samsung Telefon 32 GB', 6, 'Samsung.jpg', 1300),
('Samsung Tablet', 'Tablet', 2500, 'Samsung 8 Çekirdek', 13, 'Samsung Tablet.jpg', 250),
('Samsung Tablet3', 'Vestel Telefon2', 1200, 'aa', 13, 'Samsung Tablet3.jpg', 4124),
('Samsung Tablet4', 'Vestel Telefon3', 1200, 'aa', 13, 'Samsung Tablet4.jpg', 22),
('Samsung3', 'Samsung3', 3333, 'aaaa', 3, 'Samsung3.jpg', 444),
('Samsungt', 'Samsungt', 8888, 'Samsung 64 Gb ', 6, 'Samsungt.jpg', 250);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yetki`
--

CREATE TABLE `yetki` (
  `YetkiID` int(11) NOT NULL,
  `YetkiAdi` varchar(20) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `yetki`
--

INSERT INTO `yetki` (`YetkiID`, `YetkiAdi`) VALUES
(1, 'admin'),
(2, 'kullanici');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`KategoriId`);

--
-- Tablo için indeksler `kullanici`
--
ALTER TABLE `kullanici`
  ADD PRIMARY KEY (`KullaniciAdi`);

--
-- Tablo için indeksler `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`MenuId`);

--
-- Tablo için indeksler `menuyetki`
--
ALTER TABLE `menuyetki`
  ADD PRIMARY KEY (`MenuYetkiId`);

--
-- Tablo için indeksler `urun`
--
ALTER TABLE `urun`
  ADD PRIMARY KEY (`UrunKodu`);

--
-- Tablo için indeksler `yetki`
--
ALTER TABLE `yetki`
  ADD PRIMARY KEY (`YetkiID`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `kategori`
--
ALTER TABLE `kategori`
  MODIFY `KategoriId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- Tablo için AUTO_INCREMENT değeri `menu`
--
ALTER TABLE `menu`
  MODIFY `MenuId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Tablo için AUTO_INCREMENT değeri `menuyetki`
--
ALTER TABLE `menuyetki`
  MODIFY `MenuYetkiId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Tablo için AUTO_INCREMENT değeri `yetki`
--
ALTER TABLE `yetki`
  MODIFY `YetkiID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
