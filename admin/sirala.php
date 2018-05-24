<?php
include('../config.php');
if (isset($_GET['p'])){
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($_GET['p'] == 'hizmetlerimizSirala'){
		if (is_array($_POST['item'])){		
			foreach ( $_POST['item'] as $key => $value )mysql_query("UPDATE hizmetlerimiz SET siralama = '$key' WHERE id ='$value'");
			$hizmetlerimizSiralaMsg = array('islemSonuc' => true , 'hizmetlerimizSiralaIslemMsj' => 'İçeriklerin sıralama işlemi güncellendi' );
		}else{
			$hizmetlerimizSiralaMsg = array('islemSonuc' => false ,'hizmetlerimizSiralaIslemMsj' => 'İçeriklerin sıralama işleminde hata oluştu' );
		}
	}
	if (isset($hizmetlerimizSiralaMsg))echo json_encode($hizmetlerimizSiralaMsg);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($_GET['p'] == 'sayfalarSirala'){
		if (is_array($_POST['item'])){		
			foreach ( $_POST['item'] as $key => $value )mysql_query("UPDATE sayfalar SET siralama = '$key' WHERE id ='$value'");
			$sayfalarSiralaMsg = array('islemSonuc' => true , 'sayfalarSiralaIslemMsj' => 'İçeriklerin sıralama işlemi güncellendi' );
		}else{
			$sayfalarSiralaMsg = array('islemSonuc' => false ,'sayfalarSiralaIslemMsj' => 'İçeriklerin sıralama işleminde hata oluştu' );
		}
	}
	if (isset($sayfalarSiralaMsg))echo json_encode($sayfalarSiralaMsg);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


}
?>