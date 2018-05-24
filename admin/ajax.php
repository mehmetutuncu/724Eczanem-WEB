<?php 

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') { 
// Eğer ajax isteği yapılmışsa burayı çalıştır
	
require_once "../config.php"; // Veritabanı bağlantısı ve gerekli fonksiyonlarımızın olduğu dosyayı sayfamıza dahil ediyoruz
$kolonlar = ["icerik_id","icerik_baslik","icerik_aciklama","eklenme_tarihi"];

$arama_kelime = isset($_POST["search"]["value"]) ? $_POST["search"]["value"] : ''; // Eğer boş değilse eklentinin arama kısmından yollanan değeri alıyoruz.
$siralama =  isset($_POST["order"]) ? $_POST["order"] : ''; // Eğer boş değilse eklentinin sıralama kısmından yollanan değeri alıyoruz.
$length =  isset($_POST["length"]) ? $_POST["length"] :'' ; // Eğer boş değilse eklentinin sayfada kaç veri gösterileceği kısmından yollanan değeri alıyoruz.
$limit =  isset($_POST["start"]) ? $_POST["start"] :'' ; // Eğer boş değilse eklentinin kaçıncı veriden itibaren başlayıcağı değeri alıyoruz.
$sql = "SELECT * FROM admin ";
$toplamFiltreVeri = toplam_veri(); // Eğer filtreleme işlemi yapılmazsa filtrelenmiş veri sayısını toplam veri sayısına eşitle
if(!empty($arama_kelime))  // Eğer arama_kelime değişkeni boş değilse yani arama yapılmışsa
{
	$arama_sql = "WHERE ";
	$arama_index = 0;
	foreach ($kolonlar as $kolon) { 
	// Kolonlar dizisindeki elemanların hepsini arama işlemi şeklinde sql cümlesine ekliyoruz.
		if($arama_index == 0)
		{
			$arama_sql .= $kolon." LIKE :arama_kelime ";
		}else{
			$arama_sql .= "OR ".$kolon." LIKE :arama_kelime ";
		}
		$arama_index++;
	}
	$sql .= $arama_sql;
	$toplamFiltreVeri = arama_toplam_veri($arama_kelime,$arama_sql); // Arama yaptıktan sonra toplam kaç veri olduğunu buluyoruz.
}

if(!empty($siralama))   // Eğer siralama değişkeni boş değilse yani sıralama yapılmışsa
{
	// Sıralamadan seçilen değeri kolonlar dizimize yollayarak o değerdeki kolona göre sıralama yapıyoruz
	$sql .= "ORDER BY ".$kolonlar[$siralama['0']['column']]." ".strtoupper($siralama['0']['dir'])." ";
}else{
	// Eğer sıralama işlemi yapılmamışsa varsayılan olarak icerik_id kolonuna göre sıralama yap
	$sql .= "ORDER BY icerik_id DESC ";
}

if($length != 1)
{
	// Sayfalama işlemini yapıyoruz
	$sql .= "LIMIT ".$limit.",".$length;
}

$veriler = $db->prepare($sql); // Oluşturulan sql cümlesini gönder
if(!empty($arama_kelime))
{
	// Eğer arama işlemi yapılmışsa değişkeni programa tanıt
$veriler->bindValue(':arama_kelime', '%' . $arama_kelime . '%');
}
$veriler->execute(); // Çalıştır

$data = [];
foreach ($veriler->fetchAll(PDO::FETCH_OBJ) as $veri) {
	// Tüm sonuçları veri değişkenine aktar
	$veriDizi = []; // Herbir veriyi bu değişkende depolayacağız.
	foreach ($kolonlar as $kolon) {
		// Veri değişkeni içerisinden dinamik olarak kolon değişkeni içerisindeki kolonu getir
		$veriDizi[] = $veri->$kolon;
	}
	$veriDizi[] = "<button>Sil</button><button>Düzenle</button>";  // Ekstra olarak Sil düzenle butonları ekliyoruz
	$data[] = $veriDizi; // Her seferinde oluşan dizimizi data değişkenine depoluyoruz	
}

$output = array(
			"draw"    => intval($_POST["draw"]),
			"recordsTotal"  => toplam_veri(), // Toplam tablodaki veri sayımızı ekle
			"recordsFiltered" => $toplamFiltreVeri, // Toplam filtrelenmiş veri sayısını ekle
			"data"    => $data // Verileri depoladığımız değişkeni ekle
			);
		echo json_encode($output);  // Json çıktısı ver

}else{
	// Eğer ajax isteği yapılmamışsa burayı çalıştır
	die("Erişim engellendi");
}

?>