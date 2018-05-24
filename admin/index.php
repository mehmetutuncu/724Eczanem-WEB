<!DOCTYPE html>
<html lang="tr">
<?php 
session_start();
include("../config.php"); 
$durum="";
$durum = isset($_SESSION['username']) ? $_SESSION['username'] : ""; 
if($durum =="") echo '<script language="javascript">location.href="login.php";</script>';
$sayfa="";
$sayfa=isset($_GET["sayfa"]) ? $_GET["sayfa"] : "";  
$ayarlar=mysqli_fetch_object(mysqli_query($baglanti,"select * from ayarlar")); 

?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    
    <title><?php echo $ayarlar->title;?> | Yönetim Paneli</title>
    <link rel="shortcut icon" href="../img/logo.png"> 
	
	
<link rel="stylesheet" href="../css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/animate.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/responsive.css">






    <link href="assets/css/bootstrap.css" rel="stylesheet"> 
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" /> 
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet"> 
    <script src="assets/js/chart-master/Chart.js"></script> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	 <style>
		.kapsa{width:960px;margin:0px auto;}
		.the-table {
			table-layout: fixed;
			word-wrap: break-word;
		}

	</style>
	
	 

	<script  type="text/javascript">
		function showimagepreview(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {$('#imgview').attr('src', e.target.result);}
			reader.readAsDataURL(input.files[0]);
			}
		}	
		function resim_yukleme(e){
			$('#resim').attr("src",window.URL.createObjectURL(e.target.files[0]));
		}	
		function reply_click(clicked_id){
			var id = clicked_id;
			$.post("postlar.php", {id: id}, 
				function(result){
					var obj = JSON.parse(result);
					var modal_duzenle = document.getElementById("duzenle");
					var baslik = obj.baslik;
					var resim = obj.resim;
					var id = obj.id;
					document.getElementById("baslik").value = baslik;
					document.getElementById("mevcut").src = "../img/Slider/"+resim;
					document.getElementById("resim2").value = resim;
					document.getElementById("id").value = id;
					
					
				}
			);
		}
		
		function slider_duzenle_post(){ 
			var slider_id = document.getElementById("id").value;
			var baslik = document.getElementById("baslik").value;
			var file_data = $('#slider').prop('files')[0];   
			var form_data = new FormData();                  
			form_data.append('file', file_data);
			$.ajax({
				url: 'upload.php?olay=update&id='+slider_id+"&baslik="+baslik,
				dataType: 'text',  // what to expect back from the PHP script, if anything
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
				type: 'post',
				success: function(result){
					if(result=="1"){
						alert("Kayıt Başarılı");
						location.reload();
					}else{
						alert("Hata : " + result);
					} 		
				}
			 }); 
		}
		
		function slider_sil(){
			var id = document.getElementById("slider_sil").name;
			
			$.post("postlar.php", {slider_id: id}, 
				function(result){
					if(result == "1"){
						alert("Silme İşlemi Başarılı.");
						location.reload();
					}
					else{
						alert("Silme İşlemi Başarısız. Hata Kodu :"+result);
					
					}
					
				});
		}
		function yeni_slider(){
			var baslik = document.getElementById("baslik").value;
			var file_data = $('#exampleInputFile1').prop('files')[0];   
			var form_data = new FormData();                  
			form_data.append('file', file_data);
			if(baslik != "" ){
				$.ajax({
				url: 'upload.php?olay=yeni_slider&baslik='+baslik,
				dataType: 'text',  // what to expect back from the PHP script, if anything
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
				type: 'post',
				success: function(result){
					if(result=="1"){
						alert("Kayıt Başarılı");
						
					}else{
						alert("Hata : " + result);
					} 		
				}
			 }); 
			 location.reload();
			}
			
			
		}
		function ayarlar(){
			var title = document.getElementById("title").value;
			var footer = document.getElementById("footer").value;
			var email = document.getElementById("email").value;
			var facebook = document.getElementById("facebook").value;
			var twitter = document.getElementById("twitter").value;
			var id = document.getElementById("hidden").value;
			var file_data = $('#exampleInputFile2').prop('files')[0];   
			var form_data = new FormData();                  
			form_data.append('file', file_data);
			if(title != "" && footer !="" && email !="" && facebook!="" && twitter !="" && id != 0){
				$.ajax({
				url: 'upload.php?olay=ayarlar&title='+title+'&footer='+footer+'&email='+email+'&facebook='+facebook+'&twitter='+twitter+'&id='+id,
				dataType: 'text',  // what to expect back from the PHP script, if anything
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
				type: 'post',
				success: function(result){
					if(result == "1"){
						alert("Kayıt Başarılı.");
						
						location.reload();
						location.reload();
						
						
					}else{
						alert("Hata : " + result);
					} 		
				}
			 }); 
			}
			
			
		}
		function yeni_admin(){
			var kuladi = document.getElementById("kuladi").value;
			var email = document.getElementById("email").value;
			var password = document.getElementById("password").value;
			if(kuladi != "" && email != "" && password != ""){
					$.post("postlar.php", {kuladi: kuladi,email:email,password:password}, 
				function(result){
					if(result == "1"){
						alert("Ekleme İşlemi Başarılı.");
						location.reload();
					}
					else{
						alert("Ekleme İşlemi Başarısız. Hata Kodu :"+result);
					}
				});
			}
		}
		
		function reply_click2(clicked_id){
			var id = clicked_id;
			$.post("postlar.php", {admin_id: id}, 
				function(result){
					if(result == "1"){
						alert("Silme İşlemi Başarılı");
						location.reload();
					}
					else{
						alert("Silme işlemi başarısız :"+result);
					}
				}
			);
		}
		function reply_click3(clicked_id){
			var id = clicked_id;
			$.post("postlar.php", {admin_duzenle_id: id}, 
				function(result){
					var obj = JSON.parse(result);
					var password = obj.password
					var kuladi = obj.kuladi;
					var email = obj.email;
					var id = obj.id;
					document.getElementById("email").value = email;
					document.getElementById("kuladi").value = kuladi;
					document.getElementById("password").value  = password;
					document.getElementById("hidden").value = id;
				}
			);
		}
		function reply_click4(clicked_id){
			var id = clicked_id;
			$.post("postlar.php",{mesaj_id_sil:id},
			function(result){
					if(result == "1"){
						alert("Silme İşlemi Başarılı");
						location.reload();
					}
					else{
						alert("Silme işlemi başarısız :"+result);
					}
				}
			);
		}function reply_click5(clicked_id){
			var id = clicked_id;
			$.post("postlar.php",{mesaj_id_okundu:id},
			function(result){
					if(result == "1"){
						alert("Mesaj Okundu olarak işaretlendi!");
						location.reload();
					}
					else{
						alert("İşlem başarısız :"+result);
					}
				}
			);
		}
		function reply_click6(clicked_id){
			var id = clicked_id;
			$.post("postlar.php",{eczane_sil_id:id},
			function(result){
					if(result == "1"){
						alert("Eczane onayı başarı ile reddedildi.");
						location.reload();
					}
					else{
						alert("İşlem başarısız :"+result);
					}
				}
			);
		}
		function reply_click7(clicked_id){
			var id = clicked_id;
			$.post("postlar.php",{eczane_onay_id:id},
			function(result){
					if(result == "1"){
						alert("Eczane başarı ile onaylandı.");
						location.reload();
					}
					else{
						alert("İşlem başarısız :"+result);
					}
				}
			);
		}
		function admin_duzenle(){
			var id = document.getElementById("hidden").value;
			var email = document.getElementById("email").value;
			var kuladi = document.getElementById("kuladi").value;
			var password = document.getElementById("password").value;
			$.post("postlar.php", {admin_duzenle_id2:id,email2:email,kuladi2:kuladi,password2:password}, 
				function(result){
					if(result == "1"){
						alert("Başarı ile kaydedildi.");
						location.reload();
					}
					else{
						alert("Hata alındı."+result);
					}
						
				}
			);
		}
		function iletisim_bilgileri(){
			var iletisim_id = document.getElementById("hidden").value;
			var email = document.getElementById("email").value;
			var telefon = document.getElementById("telefon").value;
			var adres = document.getElementById("adres").value;
			if (id == null){
				id = "";
			}
			if(adres != "" && email != "" && telefon.length == 13){
				$.post("postlar.php", {email2:email,telefon:telefon,adres:adres,iletisim_id:iletisim_id}, 
				function(result){
					
						if(result == "1"){
							alert("İletişim bilgileri başarı ile güncellendi");
							location.reload();
						}
						else{
							alert("Hata alındı."+result);
						}
				});
			}else{
				alert("Bilgileri eksiksiz doldurun.");
			}
			
		}
		function hakkimizda(){
			var slogan = document.getElementById("slogan").value;
			var aciklama = document.getElementById("aciklama").value;
			var kisa_ozellik1 = document.getElementById("kisa_ozellik1").value;
			var kisa_ozellik2 = document.getElementById("kisa_ozellik2").value;
			var kisa_ozellik3 = document.getElementById("kisa_ozellik3").value;
			var hidden = document.getElementById("hidden_hakkimizda").value;
			if(slogan != "" && aciklama != "" && kisa_ozellik1 != "" && kisa_ozellik2 != "" && kisa_ozellik3 != ""){
				$.post("postlar.php", {slogan:slogan,aciklama:aciklama,kisa_ozellik1:kisa_ozellik1,kisa_ozellik2:kisa_ozellik2,kisa_ozellik3:kisa_ozellik3,hidden_hakkimizda_id:hidden}, 
				function(result){
					
						if(result == "1"){
							alert("Hakkımızda bilgileri başarı ile kaydedildi");
							location.reload();
						}
						else{
							alert("Hata alındı."+result);
						}
				});
			}
			else{
				alert("Bilgileri eksiksiz doldurunuz.");
			}
		}
	</script>
	
		<script src="http://code.jquery.com/jquery.js"></script>
		<script src="assets/js/jquery-1.11.2.js" type="text/javascript"></script>
		<script type="text/javascript" src="assets/js/jquery-ui.js"></script> 
		<style type="text/css">.sortable { cursor: move; }</style>
		
</head> 
<body> 
  <section id="container" > 
      <header class="header black-bg">
	  <div class="sidebar-toggle-box"><div class="fa fa-bars tooltips" data-placement="right" data-original-title="Paneli Daralt"></div></div>
            <?php  
				$title=$ayarlar->title;
				$karakter=30;
				if(strlen($title)>=$karakter){ 
					if(preg_match('/(.*?)\s/i',substr($title,$karakter),$dizi))$title=substr($title,0,$karakter+strlen($dizi[0]))."";  
				}else{
					$title .="";
				}
			?>
            <a href="index.php" class="logo" alt="jsbkbfk"><?php echo $title;?></a> 
            <div class = "top-menu">
				<ul class ="nav pull-left top-menu">
					<li  style = " margin-left:80px;margin-top:17px;">
						<a href = "http://724eczanem.com"><font color = "red" size="1">Siteye Dön!</font></a>
					</li>
				</ul>
			</div>
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
				<li>
				<a class="logout" onclick="return confirm('Çıkmak İstediğinize Emin Misiniz?');" href="logout.php">Çıkış Yap!</a>
				</li>
				</ul>
            </div>
        </header> 
      <aside>
          <div id="sidebar"  class="nav-collapse "> 
            <ul  class="sidebar-menu" id="nav-accordion"> 
              	  <p class="centered" style = "margin-top:100px;"><a href="index.php"><img src="../img/<?php echo $ayarlar->logo;?>" class="img-circle" width="100px"></a></p>
              	  <h5 class="centered"><?php echo strtoupper($durum);?></h5>
                  <li class="sub-menu">
                      <a <?php if($sayfa =="slider_duzenle" || $sayfa == "yeni_slider") echo"class = 'active'"; ?> href="javascript:;" ><i class="fa fa-desktop"></i><span>Slider</span></a>
                      <ul class="sub">
                          <li <?php if($sayfa=="slider_duzenle"  ) echo " class='active'";?>>
						  <a  href="index.php?sayfa=slider_duzenle">Slider Düzenle</a>
						  </li>
						  
                          <li <?php if($sayfa=="yeni_slider" ) echo ' class="active"';?>>
						  <a  href="index.php?sayfa=yeni_slider">Slider Ekle</a>
						  </li> 
                      </ul>
				   </li> 
				   <li class="sub-menu">
					  <a <?php if($sayfa =="ayarlar" || $sayfa == "hakkimizda" ) echo"class = 'active'"; ?> href="javascript:;" ><i class="fa fa-cog"></i><span>Ayarlar</span></a>
					  <ul class="sub">
                          <li <?php if($sayfa=="ayarlar") echo " class='active'";?>>
						  <a  href="index.php?sayfa=ayarlar">Ayarlar</a>
						  </li>
						   <li <?php if($sayfa=="hakkimizda") echo " class='active'";?>>
						  <a  href="index.php?sayfa=hakkimizda">Hakkımızda</a>
						  </li>
                      </ul>
					</li>
					<li class="sub-menu">
					  <a <?php if($sayfa =="adminler" || $sayfa == "yeni_admin" ) echo"class = 'active'"; ?> href="javascript:;" ><i class="fa fa-user"></i><span>Admin</span></a>
					  <ul class="sub">
                          <li <?php if($sayfa=="adminler") echo " class='active'";?>>
						  <a  href="index.php?sayfa=adminler">Admin Listesi</a>
						  </li>
						  <li <?php if($sayfa=="yeni_admin") echo " class='active'";?>>
						  <a  href="index.php?sayfa=yeni_admin">Admin Ekle</a>
						  </li>
                      </ul>
					</li>
					<li class="sub-menu">
					  <a <?php if($sayfa =="iletisim" || $sayfa == "iletisim_mesajlar") echo"class = 'active'"; ?> href="javascript:;" ><i class="fa fa-paper-plane"></i><span>İletişim</span></a>
					  <ul class="sub">
                          <li <?php if($sayfa=="iletisim") echo " class='active'";?>>
						  <a  href="index.php?sayfa=iletisim">İletişim</a>
						  </li>
						  <li <?php if($sayfa=="iletisim_mesajlar") echo " class='active'";?>>
						  <a  href="index.php?sayfa=iletisim_mesajlar">Mesajlar</a>
						  </li>
						  
                      </ul>
					</li>
					<li class="sub-menu">
					  <a <?php if($sayfa =="eczane_onay") echo"class = 'active'"; ?> href="javascript:;" ><i class="fa fa-medkit"></i><span>Eczane Onay</span></a>
					  <ul class="sub">
                          <li <?php if($sayfa=="eczane_onay") echo " class='active'";?>>
						  <a  href="index.php?sayfa=eczane_onay">Eczane Onay</a>
						  </li>
						  
						  
                      </ul>
					</li>
                  
			</ul>
          </div>
      </aside>
	  <section id="main-content">
          <section class="wrapper site-min-height">
          	
          	<div class="row mt" >
          		<div class="col-md-12" >
				
					<?php 
					 if($sayfa == "slider_duzenle" or $sayfa==""){
							$slider_veri = mysqli_query($baglanti,"select * from slider ");
							while($slider = mysqli_fetch_array($slider_veri)){
								
								echo"
									<div class='col-lg-12 col-md-12	col-sm-12 mb' >
									<br>
										 
									<div class='content-panel pn'  >
										<div  id='spotify'  style='background-image:url(../img/Slider/$slider[resim]);' >
							
											<div ' class='sp-title'><h4 style='margin-top:-220px;color: rgb(255, 215, 119); background-color: black;'>$slider[baslik]</h4></div>
											
										</div>
										<p  class='followers' style='text-align:center;float:right;'>
										 
										 
										 
											<button    onclick='reply_click($slider[id])' type='button' id='post-btn' class='btn btn-info btn-lg'  data-toggle='modal'  data-target='#myModal1'>
													<a  href = '#'>Düzenle</a>
											</button>
											
													<button   id ='slider_sil' name = '$slider[id]'  onclick = 'slider_sil();' type='button' class='btn btn-info btn-lg' data-toggle='modal'  >
													<a href = '#'>Sil</a>
													</button>
										</p>
										
									</div>
								</div>";
								
									
									
									
									
									
							}
						}
						else  if($sayfa == "yeni_slider"){
							echo "<div class='form-panel'> 
							  <form class='form-horizontal style-form'  enctype='multipart/form-data'   method='post'>
								 
								 <div class='form-group'>
									  <label class='col-sm-2 col-sm-2 control-label'>Başlık :</label>
									  <div class='col-sm-6'>
									  <input required  type='text' class='form-control' id = 'baslik' name='baslik' placeholder='Başlık'></div>
								 </div>
								  
								  <div class='form-group'>
									  <label class='col-sm-2 col-sm-2 control-label'>Resim :</label>
									  <div class='col-sm-6'><input required  type='file' onChange='showimagepreview(this);' id='exampleInputFile1' class='form-control'  name='slider_resim' id='resim'></div>
								  </div>
								  <div class='form-group'>
									  <label class='col-sm-2 col-sm-2 control-label'>Yeni Resim :</label>
									  <div class='col-sm-10' ><img   class = 'aw-zoom' title='Yeni Resim' id='imgview'  src='../img/no_image.png'  width='100px' /> </div>
								  </div>  
								  <div class='form-group'>
									  <label class='col-sm-2 col-sm-2 control-label'>Kırp :</label>
									  <div class='col-sm-10'>
										<label class='checkbox-inline'><input name='kırp' id='kırp' value='1' type='radio' checked> Evet</label>
										<label class='checkbox-inline'><input name='kırp' id='kırp' value='0' type='radio' > Hayır</label>
									  </div>
								  </div>
								  
								  <div class='form-group' >
									  <label class='col-sm-2 col-sm-2 control-label'></label>
									  <button onclick = 'yeni_slider()' type='submit' class='btn btn-theme' name='gonder'>Gönder</button>								  
								  </div> 
							  </form>
						  </div>";
							
						}
						else if($sayfa == "ayarlar"){ 
						
						$select_ayarlar = mysqli_query($baglanti,"select * from ayarlar");
						$ayarlar_result = mysqli_fetch_array($select_ayarlar);
						?>
						
								  <div class="form-group">
									<button type="button" class="btn btn-email"><font size = "1"> <b>T</b></font>&nbsp;&nbsp;Title</button>
									<input type="text"  required class="form-control" id="title" value = "<?php echo$ayarlar_result[title];?>" >
									<input type ="hidden"  value="<?php echo$ayarlar_result[id]?>" id = "hidden">
								  </div>
								  <div class="form-group">
									<button type="button" class="btn btn-email"><i class="fa fa-facebook left"	></i> Footer</button>
									<input type="text" required class="form-control" id="footer" value = "<?php echo$ayarlar_result[footer];?>" >
								  </div>
								  <div class="form-group">
									<button type="button" class="btn btn-email"><i class="fa fa-envelope left"	></i> Email</button>
									<input type="email" required class="form-control" id="email" value = "<?php echo$ayarlar_result[email];?>">
								  </div>
								  <div class="form-group">
									<button type="button" class="btn btn-fb"><i class="fa fa-facebook left"s></i> Facebook</button>
									<input type="text" required class="form-control" id="facebook" value = "<?php echo$ayarlar_result[facebook];?>">
								  </div>
								   <div class="form-group">
									<button type="button" class="btn btn-tw"><i class="fa fa-twitter left"></i> Twitter</button>
									<input type="text" required class="form-control" id="twitter" value = "<?php echo$ayarlar_result[twitter];?>">
								  </div>
								    <div class="form-group">
									<button type="button" class="btn btn-tw"><font size = "1"><b>L</b> </font>  Logo</button><br>
									<img  id="logo"  src="../img/<?php echo $ayarlar_result[logo];?>"  width="200px" />
									
								  </div>
								   <div class="form-group">
									<button type="button" class="btn btn-tw"><font size = "1"><b>Y</b> </font> Yeni Logo</button><br>
									<img title="Yeni Resim" id="imgview"  src="../img/no_image.png"  width="200px" />
									<input   type="file" onChange="showimagepreview(this);" id="exampleInputFile2" class="form-control"><br>
									
								  </div>
								   <div class="form-group" style = "margin-left:50%">
										<button type = "submit"  onclick = "ayarlar()" name = "sayfa" value = "ayarlar" class="btn btn-theme">Güncelle</button>
									  
									
									
								  </div>
								
								  
						

						 <?php } else if($sayfa == "adminler"){?>
						  
						 
								<table  id="example" class="table table-striped table-bordered " cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>İsim</th>
										<th>Email</th>
										<th>İşlemler</th>
										
									</tr>
								</thead>
								
								<tbody>
								<?php 
								$sorgu = mysqli_query($baglanti,"select * from admin");
								while($sonuc = mysqli_fetch_array($sorgu)){
								echo"
									<tr>
										<td>$sonuc[kuladi]</td>
										<td>$sonuc[email]</td>
										<td><button  onclick='reply_click2($sonuc[id])' >Sil</button>
										<button onclick='reply_click3($sonuc[id])' id='post-btn'   data-toggle='modal'  data-target='#modal23'>Düzenle</button></td>
									</tr>";
								}?>
								</tbody>
							</table>
							
						 
						
						
						
						 <?php }
								 else if($sayfa == "yeni_admin"){?>
									<div style = "margin-left:33%;margin-top:10%">
									<div class="form-group row" style = "margin-left:100px">
										  <b><h1>Admin Ekleme Formu</h1></b>
										  
										</div>
										
										<div class="form-group row">
										  <label for="kuladi" class="col-sm-1 col-form-label">Kullanıcı Adı</label>
										  <div class="col-sm-10">
												<input type="email" class="form-control" id="kuladi" placeholder="Kullanıcı Adı" required>
										  </div>
										</div>
										<div class="form-group row">
										  <label for="email" class="col-sm-1 col-form-label">Email</label>
										  <div class="col-sm-10">
												<input type="email" class="form-control" id="email" placeholder="Email" required>
										  </div>
										</div>
										
										<div class="form-group row">
										  <label for="password" class="col-sm-1 col-form-label">Şifre</label>
										  <div class="col-sm-10">
												<input type="password" class="form-control" id="password" placeholder="Şifre" required>
										  </div>
										</div>
									
									
										<div class="form-group row" style = "margin-left:20%">
										  <div class="offset-sm-1 col-sm-10">
												<button type="submit" onclick = "yeni_admin();" class="btn btn-primary">Kaydet</button>
										  </div>
										</div>
									</div> 
								 
						<?php }
						else if($sayfa == "iletisim"){
							$sorgu = mysqli_query($baglanti,"select * from iletisim");
							$iletisim = mysqli_fetch_array($sorgu);
							?>
							<div style = "padding-left:10%" class="col-md-8 col-md-offset-2 col-xs-12 col-sm-12">
								<article class="contact-form">
									<h1 align = "center">İletişim Bilgileri</h1>
										<div class="col-md-5 col-md-offset-1 contact-form-left">
											<input class="name" type="text" id = "telefon" value ="<?php echo $iletisim['telno'];?>" placeholder="+90 5XX XXX XX XX" >
											<input class="email" id = "email" type="email" value ="<?php echo $iletisim['email'];?>" placeholder="mail_name@XXX.XXX">
											<input  id = "hidden" type="hidden" value ="<?php echo $iletisim['id']?>">
											
										</div>
										<div class="col-md-5 contact-form-right text-right">
											<textarea class="adress"  name="adres"  id="adres" cols="30" rows="10" placeholder="ADRES*"><?php echo htmlspecialchars($iletisim['adres']);?></textarea>
											<input type="submit" value = "Kaydet" class="submit-btn" onclick = "iletisim_bilgileri();">
										</div>
									
								</article>
							</div>
						
						
						<?php }else if($sayfa == "iletisim_mesajlar"){?>
								<div class="kap sa">
								 
								 
 
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>
		<script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>
		<script type="text/javascript" charset="utf-8">$(document).ready(function() {$('#example2').DataTable();} );</script>
	 

<table id="example2" class="display the-table" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Konu</th>
			<th>İsim</th>
			<th>Email</th>
			<th>Mesaj</th>
			
			<th>İşlemler</th>
			
		</tr>
	</thead>
	<tbody>
		<?php 
			$sorgu = mysqli_query($baglanti,"select * from iletisim_mesajlar where durum = 1");
			while($sonuc = mysqli_fetch_array($sorgu)){
			
			echo"
				<tr>
					<td>$sonuc[konu]</td>
					<td>$sonuc[isim]</td>
					<td>$sonuc[email]</td>
					<td>$sonuc[mesaj]</td>
					
					<td><button  onclick='reply_click4($sonuc[id])' ><i class='fa fa-times-circle' aria-hidden='true'></i></button><button onclick='reply_click5($sonuc[id])' id='post-btn'   ><i class='fa fa-check' aria-hidden='true'></i></button></td>
				</tr>";
			}?>
			
	</tbody>
</table>

<script type="text/javascript">$('#example2').removeClass( 'display' ).addClass('table table-striped table-bordered');</script> 					  
						</div>
						<?php }
						else if($sayfa == "hakkimizda"){
							$sorgu = mysqli_query($baglanti,"select * from hakkimizda");
							$sonuc = mysqli_fetch_array($sorgu);
						?>
						<div style = "width:100%">
								  <div class="form-group">
									<label style = "font-size:15px;" for="slogan"><b>Slogan:</b></label>
									<input type="text" class="form-control" id="slogan" value = "<?php echo $sonuc['slogan'];?>">
								  </div>
								  <div class="form-group">
									<label style = "font-size:15px;" for="aciklama"><b>Açıklama:</b></label>
									<textarea style = "resize: none;" rows = "4" type="text" class="form-control" id="aciklama" ><?php echo $sonuc['aciklama'];?></textarea>
								  </div>
								  <div class="form-group">
									<label style = "font-size:15px;" for="kisa_ozellik1"><b>Kısa Özellik-1:</b></label>
									<input type="text" class="form-control" id="kisa_ozellik1" value = "<?php echo $sonuc['kisa_ozellik1'];?>">
								  </div>
								  <div class="form-group">
									<label style = "font-size:15px;" for="kisa_ozellik2"><b>Kısa Özellik-2:</b></label>
									<input type="text" class="form-control" id="kisa_ozellik2" value = "<?php echo $sonuc['kisa_ozellik2'];?>">
								  </div>
								  <div class="form-group">
									<label style = "font-size:15px;" for="kisa_ozellik3"><b>Kısa Özellik-3:</b></label>
									<input type="text" class="form-control" id="kisa_ozellik3" value = "<?php echo $sonuc['kisa_ozellik3'];?>">
									<input type = "hidden" id = "hidden_hakkimizda" value = "<?php echo $sonuc["id"];?>">
								  </div>
								  <button type="submit" class="btn btn-default"  onclick = "hakkimizda();" >Kaydet</button>
						</div>
						<?php }if($sayfa == "eczane_onay"){?>
						<div class="kap sa">
								 
								 
 
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>
		<script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>
		<script type="text/javascript" charset="utf-8">$(document).ready(function() {$('#example3').DataTable();} );</script>
	 

<table id="example3" class="display the-table" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>İl</th>
			<th>İlçe</th>
			<th>Eczane Adı</th>
			<th>Adres</th>
			<th>Telefon</th>
			<th>Enlem</th>
			<th>Boylam</th>
			<th>İşlemler</th>
			
		</tr>
	</thead>
	<tbody>
		<?php 
			$sorgu = mysqli_query($baglanti,"select e.id id ,a.isim  il,i.isim  ilce, e.eczane_adi  eczane_adi,e.adres  adres ,e.tel  tel , e.lat  lat,e.lng   lng from eczaneler e , ilceler i , iller a where onay = 0 and   e.ilce_id = i.ilce_no and i.il_no = a.il_no");
			while($sonuc = mysqli_fetch_array($sorgu)){
			
			echo"
				<tr>
							<th>$sonuc[il]</th>
							<th>$sonuc[ilce]</th>
							<th>$sonuc[eczane_adi]</th>
							<th>$sonuc[adres]</th>
							<th>$sonuc[tel]</th>
							<th>$sonuc[lat]</th>
							<th>$sonuc[lng]</th>
					
					<td><button  onclick='reply_click6($sonuc[id])'>
					<i class='fa fa-times-circle' aria-hidden='true'></i></button>
					<button onclick='reply_click7($sonuc[id])' id='post-btn'>
					<i class='fa fa-check' aria-hidden='true'></i></button></td>
				</tr>";
			}?>
			
	</tbody>
</table>

<script type="text/javascript">$('#example3').removeClass( 'display' ).addClass('table table-striped table-bordered');</script> 					  
						</div>
						<?php }?>
					<div id='myModal1' class='modal fade' role='dialog'>
											  <div class='modal-dialog'>
												<div class='modal-content'>
												  <div class='modal-header'>
													<button type='button' class='close' data-dismiss='modal'>&times;</button>
													<h4 class='modal-title'>Slider Düzenle</h4>
												  </div>
												  <div id = "duzenle" class='modal-body'>
												  
												<div style = "margin-left:15%;">
															
															<form id = 'slider_duzenle' action='' method='post' enctype='multipart/form-data'>
															
															<div class="form-group row" style = "padding-left:10%;">
															  <label for="baslik" class="col-sm-1 col-form-label">Başlık</label>
															  <div class="col-sm-6" >
																	
																	<input type = 'hidden' id = 'id' >
																	<input type = 'hidden' id = 'resim2' >
																	<input  type="text" class="form-control" id ='baslik' type = 'text'   required>
															  </div>
															  <div class="form-group row">
															  
															  <div class="col-sm-8">
																	
																  <hr>
																	
															  </div>
															
															</div>
															<div class="form-group row">
															  <label for="abc" class="col-sm-1 col-form-label">Mevcut Resim</label>
															  <div class="col-sm-10" style = "padding-left:20%;">
																	<img class = "img-circle" id = "mevcut" src = '../img/no_image.png'  width='150' height = '150' /><br>
															  </div>
															</div>
															 <div class="form-group row">
															  
															  <div class="col-sm-8">
																	
																  <hr>
																	
															  </div>
															
															</div>
															<div class="form-group row">
															  <label for="resim" class="col-sm-1 col-form-label">Yüklenen Resim</label>
															  <div class="col-sm-10" style = "padding-left:20%;">
																	<img   id = 'resim' width='150' height = '150' src='../img/no_image.png'/>
															  </div>
															</div>
															 <div class="form-group row">
															  
															  <div class="col-sm-8">
																	
																  <hr>
																	
															  </div>
															
															</div>
															<div class="form-group row">
															  <label for="slider" class="col-sm-1 col-form-label">Slider Seçiniz</label>
															  <div class="col-sm-10">
																	<input onchange='resim_yukleme(event)' id = 'slider' type = 'file'  name = 'resim' >
															  </div>
															</div>
														 <div class="form-group row">
															  
															  <div class="col-sm-8">
																	
																  <hr>
																	
															  </div>
															
															</div>
														
															<div class="form-group row" style = "margin-left:20%">
															  <div class="offset-sm-1 col-sm-10">
																	<input onclick='slider_duzenle_post()' type = 'submit' value = 'Güncelle' name = 'button'>
															  </div>
															</div>
															</form>
												</div> 	  
																		  
															  
														  </div>
														  
														  
														  
												  </div>
												  <div class='modal-footer'>
													<button type='button' class='btn btn-default' data-dismiss='modal'>Kapat</button>
												  </div>
												</div>
											  </div>
										</div>
										<div id="modal23" class="modal fade" role="dialog">
										  <div class="modal-dialog">

											<!-- Modal content-->
											<div class="modal-content">
											  <div class="modal-header">
												<button type="button" class="close" data-dismiss="modal"></button>
												<h4 class="modal-title">Modal Header</h4>
											  </div>
											  <div class="modal-body">
												<div style = "margin-left:8%">			
											
												
												<div class="form-group row">
												  <label for="kuladi" class="col-sm-2 col-form-label">Kullanıcı Adı</label>
												  <div class="col-sm-10">
														<input type="email" class="form-control" id="kuladi" placeholder="Kullanıcı Adı" required>
												  </div>
												</div>
												<div class="form-group row">
												  <label for="email" class="col-sm-2 col-form-label">Email</label>
												  <div class="col-sm-10">
														<input type="email" class="form-control" id="email" placeholder="Email" required>
														<input type ="hidden" id = "hidden">
												  </div>
												</div>
												
												<div class="form-group row">
												  <label for="password" class="col-sm-2 col-form-label">Şifre</label>
												  <div class="col-sm-10">
														<input type="password" class="form-control" id="password" placeholder="Şifre" required>
												  </div>
												</div>
											
											
												<div class="form-group row" style = "margin-left:35%">
												  <div class="offset-sm-2 col-sm-10">
														<button type="submit" onclick = "admin_duzenle();" class="btn btn-primary">Kaydet</button>
												  </div>
												</div>
									</div>
											  </div>
											  <div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											  </div>
											</div>

										  </div>
										</div>
											
          	</div> 
		</section>
      </section>
      <footer class="site-footer"><div class="text-center"><?php echo date("Y");?> © <a href="http://bilgimedya.com.tr">Mehmet Tütüncü</a><a href="#" class="go-top"><i class="fa fa-angle-up"></i></a></div></footer>
  </section>
     <!-- <script src="assets/js/jquery.js"></script> -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sparkline.js"></script>
    <script src="assets/js/common-scripts.js"></script>
    <script src="assets/js/sparkline-chart.js"></script>  
	<script src="assets/js/form-component.js"></script>    
	<script src="assets/js/bootstrap-switch.js"></script> 
	<script> $(function(){$('select.styled').customSelect();});</script> 
	
	

  </body>
</html>