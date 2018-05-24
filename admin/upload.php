<?php
	include ('../config.php');
	if($_GET["olay"]=="update"){
		error_reporting(0);
		$id=$_GET["id"];
		$baslik=$_GET["baslik"];
		
		$eski_resim = mysqli_fetch_array(mysqli_query($baglanti,"select resim from slider where id = $id"))["resim"];

		$dizin="../img/Slider";
		$file_type = $_FILES['file']['type'];
		  $allowed = array("image/jpeg", "image/gif", "image/png");
		require_once ('class.upload.php');
		$resim = $_FILES['file'];
		$yukle = new upload($resim);
		if($resim["name"]!="" || in_array($file_type, $allowed)){
			if ($yukle->uploaded){
			  
				$yukle->image_resize          = true;
				$yukle->image_ratio_fill      = true;
				$yukle->image_x               = 1024;
				$yukle->image_y               = 365;
			  
			  $yukle->file_new_name_body = strtolower($baslik);
			  $yukle->process($dizin);
			  if($yukle->processed){ 
				unlink("$dizin/$eski_resim");
				$update=mysqli_query($baglanti,"update slider set baslik='$baslik',resim='$yukle->file_dst_name' where id='$id'"); 
				if($update){
				  echo '1';
				}else{
				  echo "2"; 
				}
			  }else{
				echo $yukle->error()."=3"; 
			  }
			}
		  }else{
			  $update=mysqli_query($baglanti,"update slider set baslik='$baslik' where id='$id'"); 
				if($update){
				  echo '1';
				}else{
				  echo "2"; 
				}
		  }
	  }
	  else if($_GET["olay"]=="yeni_slider"){
		  error_reporting(0);
		  $file_type = $_FILES['file']['type'];
		  $allowed = array("image/jpeg", "image/gif", "image/png");
		  $baslik=$_GET["baslik"];
		  $dizin="../img/Slider";
		  $sira=mysqli_num_rows(mysqli_query($baglanti,"select * from slider"));
		  require_once ('class.upload.php');
		$resim = $_FILES['file'];
		$yukle = new upload($resim);
		if($resim["name"]!="" || in_array($file_type, $allowed)){
			if ($yukle->uploaded){
			  if($kırp==1){
				$yukle->image_resize          = true;
				$yukle->image_ratio_fill      = true;
			    $yukle->image_x               = 1024;
				$yukle->image_y               = 365;
				}
				           
			  
			  $yukle->file_new_name_body = strtolower($baslik);
			  $yukle->process($dizin);
			  if($yukle->processed){ 
				
				$insert=mysqli_query($baglanti,"insert into slider(resim,baslik,siralama) values('$yukle->file_dst_name','$baslik','$sira')"); 
				if($insert){
				  echo '1';
				  
				}else{
				  echo "2"; 
				}
			  }else{
				echo $yukle->error()."=3"; 
			  }
			}
		  }else{
			  echo "Resmi jpeg/img/png formatında seçiniz.";
		  }
	  }
	  else if($_GET["olay"]=="ayarlar"){
		    $title = $_GET['title'];
			$footer = $_GET['footer'];
			$email = $_GET['email'];
			$facebook = $_GET['facebook'];
			$twitter = $_GET['twitter'];
			$id = $_GET['id'];
			error_reporting(0);
			$file_type = $_FILES['file']['type'];
			$allowed = array("image/jpeg", "image/gif", "image/png");
			
			$dizin="../img/";
			$eski_resim = mysqli_fetch_array(mysqli_query($baglanti,"select logo from ayarlar where id = $id"))["logo"];  
			require_once ('class.upload.php');
			$resim = $_FILES['file'];
			$yukle = new upload($resim);
			if($resim["name"]!="" || in_array($file_type, $allowed)){
				if ($yukle->uploaded){
					unlink("$dizin/$eski_resim");
					$yukle->image_resize          = true;
					$yukle->image_ratio_fill      = true;
					$yukle->image_x               = 512;
					$yukle->image_y               = 512;
				  $yukle->file_new_name_body = strtolower("logo");
				  $yukle->process($dizin);
				  if($yukle->processed){ 
					
					$update=mysqli_query($baglanti,"update ayarlar set title = '$title' ,footer = '$footer' ,email = '$email',facebook = '$facebook',twitter = '$twitter',logo = '$yukle->file_dst_name' where id = '$id'"); 
					if($update){
					  echo "1";
					  
					}else{
					  echo "2"; 
					}
				  }else{
					echo $yukle->error()."=3"; 
				  }
				}
			}
			  else{
				   $update=mysqli_query($baglanti,"update ayarlar set title = '$title' ,footer = '$footer' ,email = '$email',facebook = '$facebook',twitter = '$twitter' where id = '$id'"); 
				if($update){
				  echo "1";
				}else{
				  echo "2"; 
				}
			  }
			}
	  
 ?>