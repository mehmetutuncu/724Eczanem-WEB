<?php 
// Mehmet Y. TUTUNCU
	include "../config.php";
	//slider duzenleme modal
	if(isset($_POST["id"])){
		$sorgu = mysqli_query($baglanti,"select * from slider where id =$_POST[id]");
		$sonuc = mysqli_fetch_assoc($sorgu);
		echo json_encode($sonuc);
	}
	//slider duzenleme modal end
	//-----------------------------------
	//admin düzenleme modal
	if(isset($_POST["admin_duzenle_id"])){
		$sorgu = mysqli_query($baglanti,"select * from admin where id =$_POST[admin_duzenle_id]");
		$sonuc = mysqli_fetch_assoc($sorgu);
		echo json_encode($sonuc);
	}
	//admin düzenleme modal end
	//-----------------------------------
	//slider silme
	if(isset($_POST["slider_id"])){
		$sorgu = mysqli_query($baglanti,"select resim from slider where id =$_POST[slider_id]");
		$sonuc = mysqli_fetch_assoc($sorgu);
		if($sonuc > 0){
				$sil = mysqli_query($baglanti,"delete from slider where id = $_POST[slider_id]");
				$resim = $sonuc["resim"];
				unlink("../img/Slider/".$resim);
				echo "1";
		}
		else{
			echo "2";	
		}
	}
	//slider silme end
	//-----------------------------------
	// admin ekleme 
	if(isset($_POST["email"])){
		$kuladi = $_POST["kuladi"];
		$email = $_POST["email"];
		$password = $_POST["password"];
		$sorgu = mysqli_query($baglanti,"insert into admin(kuladi,password,email) VALUES('$kuladi','$password','$email')");
		if($sorgu>0){
			echo  "1";
		}
		else{
			echo "2";
		}
	}
	// admin ekleme end
	//-----------------------------------
	// admin silme
	if(isset($_POST["admin_id"])){
		$sorgu = mysqli_query($baglanti,"delete from admin where id = $_POST[admin_id]");
		if($sorgu > 0){
			echo "1";
		}
		else{
			echo "2";
		}
	}
	//admin silme end
	//-----------------------------------
	// admin bilgileri düzenleme 
	if(isset($_POST["admin_duzenle_id2"])){
		$id = $_POST["admin_duzenle_id2"];
		$kuladi = $_POST["kuladi2"];
		$email = $_POST["email2"];
		$pass = $_POST["password2"];
		$sorgu = mysqli_query($baglanti,"update admin set kuladi = '$kuladi',email = '$email',password='$pass' where id = '$id' ");
		if($sorgu > 0){
			echo "1";
		}
		else{
			echo "2";
		}
	}
	// admin bilgileri düzenleme  end
	//-----------------------------------
	// iletişim bilgileri update && insert
	if(isset($_POST["telefon"]) && isset($_POST["email2"]) && isset($_POST["adres"])){
		
		$id = $_POST["iletisim_id"];
		$tel = $_POST["telefon"];
		$email = $_POST["email2"];
		$adres = $_POST["adres"];
		
		if($id == ""){ // insert yapılacak
			$sorgu = mysqli_query($baglanti,"insert into iletisim(telno,adres,email) values('$tel','$adres','$email')");
			if($sorgu > 0){
					echo "1";
			}
			else{
					echo "2";
			}	
		}
		else{					  //update yapılacak
			$sorgu = mysqli_query($baglanti,"update iletisim set telno = '$tel',adres = '$adres',email = '$email' where id = '$id'");
				if($sorgu>0){
						echo "1";
				}
				else{
						echo "2";
				}
		}
	}
	// iletişim bilgileri update && insert end
	//-----------------------------------
	// İletişim mesaj post
	if(isset($_POST["iletisim_mesaj"]) && isset($_POST["iletisim_isim"]) && isset($_POST["iletisim_email"]) && isset($_POST["iletisim_konu"])){
		$mesaj = $_POST["iletisim_mesaj"];
		$isim = $_POST["iletisim_isim"];
		$email = $_POST["iletisim_email"];
		$konu = $_POST["iletisim_konu"];
		$sorgu = mysqli_query($baglanti,"insert into iletisim_mesajlar(isim,konu,mesaj,email) values ('$isim','$konu','$mesaj','$email') ");
		if($sorgu > 0){
			echo "1";
		}
		else{
			echo "2";
		}
	}
	// İletişim mesaj post end
	// İletişim mesaj sil 
		if(isset($_POST["mesaj_id_sil"])){
			
			$sorgu = mysqli_query($baglanti,"delete from iletisim_mesajlar where id = $_POST[mesaj_id_sil] ");
			if($sorgu > 0){
			echo "1";
			}
			else{
				echo "2";
			}
		}
	// İletişim mesaj sil end
	// İletişim mesajlar okundu
	if(isset($_POST["mesaj_id_okundu"])){
			
			$sorgu = mysqli_query($baglanti,"update iletisim_mesajlar set durum = 0 where id = $_POST[mesaj_id_okundu] ");
			if($sorgu > 0){
			echo "1";
			}
			else{
				echo "2";
			}
		}
	// İletişim mesajlar okundu end
	// hakkimizda post 
	if(isset($_POST["slogan"])){
		$hidden_id = $_POST["hidden_hakkimizda_id"];
		$slogan = $_POST["slogan"];
		$aciklama = $_POST["aciklama"];
		$kisa_ozellik1 = $_POST["kisa_ozellik1"];
		$kisa_ozellik2 = $_POST["kisa_ozellik2"];
		$kisa_ozellik3 = $_POST["kisa_ozellik3"];
		if(hidden_id == ""){
			$sorgu = mysqli_query($baglanti,"insert into hakkimizda(slogan,aciklama,kisa_ozellik1,kisa_ozellik2,kisa_ozellik3) values('$slogan','$aciklama','$kisa_ozellik1','$kisa_ozellik2','$kisa_ozellik3')");
			if($sorgu > 0){
				echo "1";
			}
			else{
				echo "2";
			}
		}
		else{
			$sorgu = mysqli_query($baglanti,"update hakkimizda set slogan = '$slogan', aciklama = '$aciklama',kisa_ozellik1 = '$kisa_ozellik1',kisa_ozellik2 = '$kisa_ozellik2',kisa_ozellik3 = '$kisa_ozellik3' where id = $hidden_id");
			if($sorgu > 0){
				echo "1";
			}
			else{
				echo "2";
			}
		}
		
	}
	// hakkimizda post end
	// il no ile ilçe seçtirtme
	if(isset($_POST["il_no"])){
		$il_no = $_POST["il_no"];
		$sorgu = mysqli_query($baglanti,"select ilce_no , isim from ilceler where il_no = $il_no ");
		$dizi = array();
		while($sonuc = mysqli_fetch_array($sorgu)){
			$dizi[] = $sonuc;
			
		}
		echo json_encode($dizi);
		
	}
	// il no ile ilçe seçtirtme end
	// eczane ekle post 
	if(isset($_POST["ilce_id"])){
		
		$ilce_id  = $_POST["ilce_id"];
		$eczane_adi = $_POST["eczane_adi"];
		$adres = $_POST["adres"];
		$telefon = $_POST["telefon"];
		$lat = $_POST["lat"];
		$lng = $_POST["lng"];
		$onay = 0;
		$durum = 0;
		$lat = floatval(str_replace(',', '.', $lat));
		$lng = floatval(str_replace(',', '.', $lng));
		$sorgu = mysqli_query($baglanti,"insert into eczaneler(ilce_id,eczane_adi,adres,tel,onay,lat,lng,nobet_durumu) VALUES($ilce_id,'$eczane_adi','$adres','$telefon',$onay,'$lat','$lng',$durum)");
		if($sorgu >0){
			echo "1";
		}
		else{
			echo "2";
		}
		
	}
	// eczane ekle post end
	// eczane onay post	
	if(isset($_POST["eczane_onay_id"])){
		$id = $_POST["eczane_onay_id"];
		$sorgu = mysqli_query($baglanti,"update eczaneler set onay = 1 where id = $id");
		if($sorgu > 0){
			echo "1";
		}
		else{
			echo "2";
		}
	}
	// eczane onay post end
	// eczane onay sil post
	if(isset($_POST["eczane_sil_id"])){
		$id = $_POST["eczane_sil_id"];
		$sorgu = mysqli_query($baglanti,"delete  from  eczaneler  where id = $id");
		if($sorgu > 0){
			echo "1";
		}
		else{
			echo "2";
		}
	}
	// eczane onay sil post end
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	
?>