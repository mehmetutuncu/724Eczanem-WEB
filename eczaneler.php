<?php 
include "config.php";

if(isset($_REQUEST["ilce_id"])){
		$ilce_no = $_REQUEST["ilce_id"];
		$sorgu = mysqli_query($baglanti,"select eczane_adi ad,adres,tel,lat,lng,nobet_durumu from eczaneler where ilce_id = $ilce_no and onay = 1");
		$dizi = array();
		while($sonuc = mysqli_fetch_array($sorgu)){
			$dizi[] = $sonuc;
			
		}
		echo json_encode($dizi);
		
	}
?>