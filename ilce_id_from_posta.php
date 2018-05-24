<?php 
include "config.php";

if(isset($_GET["posta_kodu"])){
		$posta_kodu = $_GET["posta_kodu"];
		$sorgu = mysqli_query($baglanti,"select ilce_id from eczaneler where adres LIKE '%$posta_kodu%' ");
		$arr = array('id' => -1, 'name' => 'zone');
		while($sonuc = mysqli_fetch_array($sorgu)){
			$arr['id'] = $sonuc['ilce_id']; 
			
		}
		echo json_encode($arr);
		
	}
?>