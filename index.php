<?php 
	include "config.php";
	
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="shortcut icon" href="../img/logo.png"> 
	<title>724Eczanem.com</title>
	
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/animate.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/responsive.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:600italic,400,800,700,300' rel='stylesheet' type='text/css'>
	<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.css">
	<script src="js/modernizr.js"></script>
	
	<!-- <script language="javascript" src="http://ic.sitekodlari.com/sagtusengelleme1.js"></script> -->
	<style>
			.modal-dialog {
				width: 1000px;
			}
			
			#mymap {
				width: 100%;
				height: 400px;
				background-color: grey;
				display:none;
			}
			#mymap2 {
				width: 100%;
				height: 400px;
				background-color: grey;
				display:none;
			}
	</style>
	<script>
	var seciliEczane;
		function iletisim_mesajlar(){
			var mesaj = document.getElementById("mesaj").value;
			var isim = document.getElementById("isim").value;
			var email = document.getElementById("email").value;
			var konu = document.getElementById("konu").value;
			if(mesaj != "" && isim != "" && email != "" && konu != ""){
			$.post("admin/postlar.php",{iletisim_mesaj:mesaj,iletisim_isim:isim,iletisim_email:email,iletisim_konu:konu},
			function(result){
					if(result == "1"){
						alert("Mesajınız başarı ile iletilmiştir.");
						location.reload();
					}
					else{
						alert("Maalesef mesajınız iletilemedi.");
					}
			});
			}
			else {
				alert("* İşaretli alanların doldurulması gerekmektedir.");
			}
			
		}
		function ilNoGetir(id){
			var il_no = id;
			
			$.post("admin/postlar.php", {il_no: il_no}, 
				function(result){
					var myText = "";
					var ilceler = JSON.parse(result);
					var i = 0;
					while(i  != ilceler.length){
						myText = myText + "<option value="+ilceler[i].ilce_no+">"+ilceler[i].isim+"</option>";
						i++;
					}
					document.getElementById("cmbilce").innerHTML = myText;
					refresh();
				});
		}
			function ilNoGetir_2(id){
				
			bot_calistir();	
			var il_no = id;
			$.post("admin/postlar.php", {il_no: il_no}, 
				function(result){
					var myText = "";
					var ilceler = JSON.parse(result);
					var i = 0;
					while(i  != ilceler.length){
						myText = myText + "<option value="+ilceler[i].ilce_no+">"+ilceler[i].isim+"</option>";
						i++;
					}
					document.getElementById("cmbilce_2").innerHTML = myText;
					
					eczaneListele();
				});
				
		}
		function bot_calistir(){
			var date = new Date();
					var year = date.getFullYear();
					var month = date.getMonth()+1;
					var day = date.getDay()+14;
					var tmp = year+"-"+month+"-"+day;
					alert(tmp);
					$.post("bot.php", {tmp:tmp}, 
							function(result){
								eczaneListele();
								//alert(result);
								
					});

		}
		function isNumberKey(evt){
			var charCode = (evt.which) ? evt.which : event.keyCode
			if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;
			return true;
		}
		function eczaneListele(){
				
			
			document.getElementById("mymap2").style.display = "none";
			document.getElementById("haritaGeri").style.display = "none";
			
			var ilce_id = document.getElementById("cmbilce_2").value;
				$.post("eczaneler.php", {ilce_id: ilce_id}, 
				function(result){
					var eczaneBulundu = JSON.parse(result);
					var myText = "";
					var i = 0;
					var nobetcimi;
					while(i < eczaneBulundu.length){
						if(eczaneBulundu[i].nobet_durumu == "1"){
							nobetcimi = "Nöbetçi Ezcane";
						}
						else{
							nobetcimi = "X";
						}
						myText += "<tr style = 'cursor:pointer;' onclick = 'eczaneDetayGetir(this,"+eczaneBulundu[i].lat+","+eczaneBulundu[i].lng+")'><td>"+eczaneBulundu[i].ad+"</td><td>"+eczaneBulundu[i].adres+"</td><td>"+eczaneBulundu[i].tel+"</td><td>"+nobetcimi+"</td></tr>";
						i++;
					}
					if(myText == ""){
						myText = "<tr><td colspan = '4'><marquee>Eczane Bulunamadı.</marquee></td></tr>";
					}
			document.getElementById("eczaneAra").innerHTML = myText;
		});
	
		
		
		}
		
		function eczaneDetayGetir(e,latL,lngL){
			
			document.getElementById("eczaneAra").innerHTML = e.innerHTML;
			
			
			
			document.getElementById("mymap2").style.display = "block";
			document.getElementById("haritaGeri").style.display = "block";
			google.maps.event.trigger(map2, 'resize');
			var latLng = new google.maps.LatLng(latL,lngL);
			map2.setCenter(latLng);
			new google.maps.Marker({
            position: latLng,
            map: map2
          });
			
			
		}
	</script>
	<!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<!-- ====================================================
	header section -->
	
	<header class="top-header">
		<div class="container">
			<div class="row">
				<!-- nav starts here -->
				<div class="col-md-12">					
					<nav class="navbar navbar-default">
						<div class="container-fluid nav-bar">
						    <div class="navbar-header">
						      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						        <span class="sr-only">Toggle navigation</span>
						        <span class="icon-bar"></span>
						        <span class="icon-bar"></span>
						        <span class="icon-bar"></span>
						      </button>
						     <a href="index.php"><img src="img/logo.png" style = "margin-top:-5px;" width="50px" height = "50px" alt="" class="img-responsive logo"></a>
							 
						    </div>
							
							
							
							
							
							<div class="navbar-header" style="margin-left:10px;">
							
							
							<a href = "index.php">724Eczanem.com</a>
							</div>
						    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						      <ul class="nav navbar-nav navbar-right">
								
						        <li><a href="#home">Anasayfa</a></li>
								<li><a href="#testimonials">Sunum</a></li>
						        <li><a href="#features">Eczane Ekle</a></li>
								<li><a href="#pricing">Eczaneler</a></li>
						        <li><a href="#about">Hakkımızda</a></li>
						        <li><a href="#contact">İletişim</a></li>
						      </ul>
						    </div>
						</div>
					</nav>
				</div>
			</div>
		</div>
	</header><!-- end of header section -->

	<!-- banner section starts here -->
	<section class="banner" id="home">
		<div class="container">
			<div class="row">
				<div class="col-xs-6 wow fadeInLeft animated" style = "margin-bottom:60px;">
					<h3>Eczanelere 1 tık mesafedesiniz.</h3>
					<h1>Eczane aramak hiç bu kadar kolay olmamıştı.</h1>
					<p>Bu kısımdan kolayca eczane ekleyebilir ya da arayabilirsiniz.</p>
					
				</div>
				<div class="col-xs-6 banner-img wow fadeInRight animated">
					<img class="img-responsive" width = "350px" src="img/logo.png" alt="">
				</div>
			</div>
		</div>
	</section><!-- end of banner section -->
<!-- pricing-slide section starts here -->
	<section class="pricing-slide" id="testimonials">
		<div class="hero-carousel" data-flickity="" data-js="hero-carousel">
		<?php 
			$sorgu = mysqli_query($baglanti,"select * from slider");
			while($sonuc = mysqli_fetch_array($sorgu)){
				$sayac = 1;
				echo"<div class='hero-carousel__cell hero-carousel__cell--'".$sayac."' style = 'margin-right: 10px;width: 100%'>
				  <div class='hero-carousel__cell__content'>
			<p align = 'center' class='slogan slogan--easy'>$sonuc[baslik]</p>
					<p align = 'center'><img  src='img/Slider/$sonuc[resim]' alt=''></p>
					
				  </div>
				</div>";
				$sayac++;
			}
		?>
    
    
  </div>
	</section><!-- end of pricing-slide section -->
	<br>
	<hr>
	<!-- feature sectiona -->
	<section class="features text-center" id="features" >
		<div class="container">
			<div class="row" >
			
				<div class="form-group" style = "margin-top:120px;">
						<h4>Eczane Ekle</h4>
						<img class="img-responsive" src="img/daag.png" alt="">
						<select id="cmbil" name="Make" onchange = 'ilNoGetir(this.value)'>
						<option id = "il" value="0">İl Seçiniz</option>
						<?php 
							$sorgu = mysqli_query($baglanti,"select * from iller");
							while($sonuc = mysqli_fetch_array($sorgu)){
								echo "<option value='".$sonuc['il_no']."'>".$sonuc['isim']."</option>";
							}
						?>
						</select>
						
				  </div>
				   <div class="form-group">
						
						<select id="cmbilce" name="Make2" >
						<option id = "ilce" value="0">İlçe Seçiniz</option>
						
						
						</select>
						
				  </div>
				  <div id="mymap"></div>
				  <div class="form-group">
						<label for="eczane_adi">Eczane Adı</label>
						<input type="text" class="form-control" id="eczane_adi"  placeholder="Eczane Adı Giriniz">
						
				  </div>
				  <div class="form-group">
						<label for="adres">Adres</label>
						<input disabled type="text" class="form-control" id="adres" placeholder="Haritadan adres seçiniz.">
				  </div>
				  <div class="form-group" width = "200px;">
						<label for="telefon">Telefon</label>
						<input maxlength='11' type="text" class="form-control" id="telefon" placeholder="Telefon" onkeypress="return isNumberKey(event)">
						<small>Sadece rakam giriniz.</small>
				  </div>
				  
						<button type="submit" class="btn btn-primary" onclick="eczaneEklePost()">Kaydet</button>
			</div>
		</div>
	</section>
	<hr>
	
	<!-- end of features section -->
	<section class="price-plan text-center" id="pricing">
		<div class="container" >
			<div class="row">
				<div class="pricing-heading">
					<h4>Eczane Ara</h4>
					<img class="img-responsive" src="img/daag.png" alt="">
				</div>
				<div class="pricing-tables">
					
					<div class="form-group">
						
						<select id="cmbil_2" name="Make3" onchange = 'ilNoGetir_2(this.value)'>
						<option id = "il_2" value="0">İl Seçiniz</option>
						<?php 
							$sorgu = mysqli_query($baglanti,"select * from iller");
							while($sonuc = mysqli_fetch_array($sorgu)){
								echo "<option value='".$sonuc['il_no']."'>".$sonuc['isim']."</option>";
							}
						?>
						</select>
						
				  </div>
				   <div class="form-group">
						
						<select id="cmbilce_2" name="Make4" onchange="eczaneListele()">
						<option id = "ilce_2" value="0">İlçe Seçiniz</option>
						
						
						</select>
						
				  </div>
				  <div  class="form-group">
						
		
								<table  id="eczaneDataTable" class="table table-striped table-bordered " cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Eczane Adı</th>
										<th>Adres</th>
										<th>Telefon</th>
										<th>Nöbet Durumu</th>
										
									</tr>
								</thead>
								
								<tbody id = "eczaneAra">
								
								</tbody>
							</table>
							<div id="mymap2" style="display:none;" >HARİTA</div>
							<button onclick="eczaneListele()" id="haritaGeri" style="display:none;margin-top:10px;margin-left:47%;" type="button" class="btn btn-default" >GERİ</button>
				  </div>
					
				</div>
			</div>
		</div>
	</section>
	<hr>
	
	
			
	
	
	
	<?php
		$sorgu = mysqli_query($baglanti,"select * from hakkimizda");
		$sonuc = mysqli_fetch_array($sorgu);
	?>
	
	<section class="details" id="about">
		<div class="container">
			<div class="row">
				<div class="col-md-5 col-xs-6 col-sm-6 wow slideInUp animated">
					<img class="img-responsive details-phone" src="img/logo.png" alt="">
				</div>
				<div class="col-md-6 col-md-offset-1 col-xs-6 col-sm-6 wow slideInUp animated">
					<h4>Bizi biraz daha yakından tanıyın.</h4>
					<h2><?php echo $sonuc["slogan"];?></h2>
					<img class="img-responsive" src="img/daag.png" alt="">
					<p><?php echo $sonuc["aciklama"]; ?> </p>
					<ul>
						<li><i class="fa fa-star"></i><?php echo $sonuc["kisa_ozellik1"]; ?></li>
						<li><i class="fa fa-star"></i><?php echo $sonuc["kisa_ozellik2"]; ?></li>
						<li><i class="fa fa-star"></i><?php echo $sonuc["kisa_ozellik3"]; ?></li>
						
					</ul>
				</div>
			</div>
		</div>
	</section><!-- end of details section -->



	

	

	

	<!-- contact section -->
	
	<section class="contact text-center" id="contact">
		<div class="container">
			<div class="row" >
			<?php
			$sorgu =  mysqli_query($baglanti,"select * from iletisim");
			$sonuc = mysqli_fetch_assoc($sorgu);
	?>
				<div class="contact-heading" style = "padding:15px" >
					<h2>İletişim</h2>
					<img class="img-responsive" src="img/daag.png" alt="">
				</div>
				<div class="col-md-2 col-md-offset-1 col-xs-4 col-sm-4">
					<i class="fa fa-phone"></i>
					<p><?php echo $sonuc['telno']; ?></p>
					
				</div>
				<div class="col-md-2 col-md-offset-2 col-xs-4 col-sm-4">
					<i class="fa fa-map-marker"></i>
					<p><?php echo $sonuc['adres']; ?></p>
					
				</div>
				<div class="col-md-2 col-md-offset-2 col-xs-4 col-sm-4 clearfix">
					<i class="fa fa-envelope-o"></i>
					<p><?php echo $sonuc['email']; ?></p>
				</div>
				<div class="col-md-8 col-md-offset-2 col-xs-6 col-sm-6" style = "margin-bottom:100px;" >
					<article class="contact-form">
						
							<div class="col-md-5 col-md-offset-1 contact-form-left">
								<input class="name" id = "isim" type="text" placeholder="İSİM*">
								<input class="email" type="email" id = "email" placeholder="EMAIL*">
								<input class="subject" type="text" id = "konu" placeholder="KONU*">
							</div>
							<div class="col-md-5 contact-form-right text-right">
								<textarea style = "resize: none;"class="message" name="message" id="mesaj" cols="30" rows="10" placeholder="MESAJ*"></textarea>
								<input type="submit" onclick = "iletisim_mesajlar();" class="submit-btn" value="Mesaj Gönder">
							</div>
						
					</article>
				</div>
	
			</div>
		</div>
	</section><!-- end of contact section -->

	
	

		
	<!-- footer starts here -->
	<?php 
		$sorgu = mysqli_query($baglanti,"select * from ayarlar");
		$sonuc = mysqli_fetch_array($sorgu);
	?>
	<footer class="footer text-center" >
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="icons">
						
						<a href="<?php echo $sonuc["twitter"];?>" target = "_blank"><i class="fa fa-twitter"></i></a>
						<a href="<?php echo $sonuc["facebook"];?>" target = "_blank"><i class="fa fa-facebook"></i></a>
						
					</div>
					<p>COPYRIGHT &copy; <a href="<?php $sonuc["title"];?>"><?php echo $sonuc["title"]?></a></p>
				</div>
			</div>
		</div>
	</footer>

	<!-- script tags
	============================================================= -->
	<script src="js/jquery-2.1.1.js"></script>
	<script src="js/smoothscroll.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/custom.js"></script>
	<script src="js/wow.js"></script>
	<!--
	<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
	<script src="js/gmaps.js"></script>
	<script>
	    var map = new GMaps({
	      el: '#map',
	      lat: -12.043333,
	      lng: -77.028333
	    });
	</script>
	-->
	<script>
	var mapElm = document.getElementById('mymap');
	var mapElm2 = document.getElementById('mymap2');
	  var map;
	  var map2;
      var marker;
	var geocoder;
	var lat;
	var lng;
      function initMap() {
        var california = {lat: 37.4419, lng: -122.1419};
        map = new google.maps.Map(mapElm, {
          center: california,
          zoom: 13
        });
		map2 = new google.maps.Map(mapElm2, {
          center: california,
          zoom: 20
        });
		
		geocoder =  new google.maps.Geocoder();
		
		google.maps.event.addListener(map, 'click', function(event) {
			if(marker){
				marker.setMap(null);
			}
			marker = new google.maps.Marker({
            position: event.latLng,
            map: map
          });
			 lat = marker.position.lat();
			 lng = marker.position.lng();
			 var latlng = new google.maps.LatLng(marker.position.lat(),marker.position.lng());
			 geocoder.geocode( { 'location': latlng}, function(results, status) {
				  if (status == google.maps.GeocoderStatus.OK) {
					  
					  document.getElementById("adres").value = results[0].formatted_address;
				  } else {
					alert("Something got wrong " + status);
				  }})
			 google.maps.event.addListener(marker, 'click', function() {
             infowindow.open(map, marker);
          });
        });
		
		
		
      }
	  
	  document.getElementById('cmbilce').addEventListener('change', refresh);
	  
	  function refresh() {
		  console.log(document.getElementById('cmbil'));
		  var il_adi = document.getElementById('cmbil').selectedOptions[0].text;
		  var ilce_adi = document.getElementById('cmbilce').selectedOptions[0].text;
		  console.log("213",il_adi, ilce_adi);
		  geocoder.geocode( { 'address': il_adi + " , " + ilce_adi}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
			  var latLng = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
				map.setCenter(latLng);
          } else {
            alert("Something got wrong " + status);
          }})
		  
		  mapElm.style.display = 'block';
		  google.maps.event.trigger(map, 'resize');
	  }
	  function eczaneEklePost(){
		  var ilce_id = document.getElementById("cmbilce").value;
		  var eczane_adi = document.getElementById("eczane_adi").value;
		  var adres = document.getElementById("adres").value;
		  var telefon = document.getElementById("telefon").value;
		  if(ilce_id != null && eczane_adi != "" && adres != "" && telefon.length == 11){
			  $.post("admin/postlar.php", {ilce_id: ilce_id,eczane_adi:eczane_adi,adres:adres,telefon:telefon,lat:lat,lng:lng}, 
				function(result){
					if(result == "1"){
						alert("Eczane başarı ile kaydedildi. Yönetici onayı bekleniyor..");
						location.reload();
					}
					else{
						alert("Ezcane eklenemedi.");
					}
				});	
		  }
		  else{
			  alert("Bilgiler eksik veya hatalı. Lütfen bilgileri eksiksiz ve doğru doldurunuz.")
		  }
		  
	  }
	</script>
	<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjuKV-RahvTF4wX_0-8bQK_8VN_CzRH6g&callback=initMap">
    </script>
</body>
</html>