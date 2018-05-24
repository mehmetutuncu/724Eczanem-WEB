<?php 
	$baglanti = mysqli_connect("","","","") or die ("Baglanti hatali!");
	mysqli_query($baglanti,"SET NAMES 'UTF8'");
	mysqli_query($baglanti,"SET character_set_connection = 'UTF8'");
	mysqli_query($baglanti,"SET character_set_client = 'UTF8'");
	mysqli_query($baglanti,"SET character_set_results = 'UTF8'");
    $veri = mysqli_query($baglanti,"SELECT * FROM ayarlar");
	$ayarlar = mysqli_fetch_object($veri);
	function toplam_veri()
{
	// Tablomuz içerisindeki toplam veri sayısını buluyoruz
	global $db;
	$toplam = mysqli_query($baglanti,"SELECT count(*) FROM admin"); 
	
	return $toplam->fetchColumn(); 
}
function arama_toplam_veri($arama_kelime,$sql)
{
	// Arama yapıldığında toplam kaç tane veri olduğunu buluyoruz.
	
	$toplam = mysqli_query(baglanti,"SELECT COUNT(*) FROM admin ".$sql);
	$toplam->bindValue(':arama_kelime', '%' . $arama_kelime . '%');
	 
	return $toplam->fetchColumn(); 

}
?>