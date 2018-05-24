<?php 
include "config.php";
header('Content-Type: application/json');

if(isset($_GET["ilce_id"])){
	$ilce_no = $_GET["ilce_id"];
	$sorgu = mysqli_query($baglanti,"select e.id, e.nobet_durumu, e.eczane_adi,e.adres,e.tel,e.lat,e.lng, i.ilce_no, i.isim, c.il_no, c.isim as ilisim from 
											eczaneler e, ilceler i, iller c
											where i.ilce_no = e.ilce_id and c.il_no = i.il_no and ilce_id = $ilce_no and onay = 1");
	$dizi = array();
	while($sonuc = mysqli_fetch_array($sorgu)){
			$dizi[] = parseEczane($sonuc);
	}
	echo json_encode($dizi);
		
}

if( isset($_GET["lat"]) && isset($_GET["lng"]) ){
	$lat = $_GET["lat"];
	$lng = $_GET["lng"];
	
	$minLat = $lat - 0.5;
	$maxLat = $lat + 0.5;
	
	$minLng = $lng - 0.5;
	$maxLng = $lng + 0.5;
	
	$sorgu = mysqli_query($baglanti,"select e.id, e.nobet_durumu, e.eczane_adi,e.adres, e.tel,e.lat,e.lng, i.ilce_no, i.isim, c.il_no, c.isim as ilisim from 
											eczaneler e, ilceler i, iller c
											where i.ilce_no = e.ilce_id and c.il_no = i.il_no and 
											e.lat >= $minLat and e.lat <= $maxLat and
											e.lng >= $minLng and e.lng <= $maxLng and
											onay = 1 ORDER BY (Abs(e.lng - $lng)+Abs(e.lat - $lat)) LIMIT 50"
											);
	$dizi = array();
	while($sonuc = mysqli_fetch_array($sorgu)){
			$dizi[] = parseEczane($sonuc);
	}
	echo json_encode($dizi);
		
}

if( isset($_GET["keyword"])){
	$keyword = $_GET["keyword"];
	
	$sorgu = mysqli_query($baglanti,"select e.id, e.nobet_durumu, e.eczane_adi,e.adres, e.tel,e.lat,e.lng, i.ilce_no, i.isim, c.il_no, c.isim as ilisim from 
											eczaneler e, ilceler i, iller c
											where i.ilce_no = e.ilce_id and c.il_no = i.il_no and 
											(e.adres LIKE '%$keyword%' or
											e.eczane_adi LIKE '%$keyword%' or
											i.isim LIKE '%$keyword%' or
											c.isim LIKE '%$keyword%'
											) and
											onay = 1 LIMIT 50"
											);
	$dizi = array();
	while($sonuc = mysqli_fetch_array($sorgu)){
			$dizi[] = parseEczane($sonuc);
	}
	echo json_encode($dizi);
		
}
	
function parseEczane($sonuc) {
	$eczane = array();
	$eczane["id"] = $sonuc["id"];
	$eczane["title"] = $sonuc["eczane_adi"];
	$eczane["phone"] = $sonuc["tel"];
			
	$addres = array();
	$address["text"] = $sonuc["adres"];
	$address["lat"] = floatval($sonuc["lat"]);
	$address["lon"] = floatval($sonuc["lng"]);
			
	$eczane["address"] = $address;
			
	$il = array();
	$il["id"] = intval($sonuc["il_no"]);
	$il["name"] = $sonuc["ilisim"];
			
	$eczane["province"] = $il;
			
	$ilce = array();
	$ilce["id"] = intval($sonuc["ilce_no"]);
	$ilce["name"] = $sonuc["isim"];
			
	$eczane["district"] = $ilce;
			
	$eczane["sentry"] = "false";
	if($sonuc["nobet_durumu"] > 0) {
		$eczane["sentry"] = "true";
	}
	
	return $eczane;
}
?>