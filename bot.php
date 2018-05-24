<?php 
	include "config.php";
	if(isset($_POST["tmp"])){
		$tmp = $_POST["tmp"];
		$degisken = "http://www.mersineczaciodasi.org.tr/Nobet/NobetListesi?NobetTarih=".$tmp."&get_param=";
		echo $degisken;
	}
	$text = file_get_contents($degisken);
	$bilgi = json_decode($text);
	$i = 0;
	$uzunluk = Count($bilgi);
	$sorgu = mysqli_query($baglanti,"update eczaneler set nobet_durumu = 0 ");
	while($i < $uzunluk){
		$eczane_adi = $bilgi[$i]->eczane_adi;
		$nobet_baslangic_tarihi = $bilgi[$i]->nobet_baslangic_tarihsaat;
		$nobet_bitis_tarihi = $bilgi[$i]->nobet_bitis_tarihsaat;
		if($eczane_adi != ""){
			$sorgu = mysqli_query($baglanti,'select id from eczaneler where eczane_adi like "'.$eczane_adi.'" ');
			$sonuc = mysqli_fetch_array($sorgu);
			if($sonuc > 0){
				$sorgu_2 = mysqli_query($baglanti,"update eczaneler set nobet_durumu = 1 where id = $sonuc[id]");
			}
		}
		$i++;
	}
?>
