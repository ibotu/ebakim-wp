<?php

namespace eBakim\Admin\Screen;

use eBakim\App;

//include(plugin_dir_path(__FILE__) . 'src/vendor/autoload.php');
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use WP_REST_Response;
//class ScrapePatientProfile extends Screen
class ScrapePatientProfile extends Screen
{
  public function __construct( App $appContext )
    {
        $this->appContext = $appContext;
      
      return $this;
    }
    public function getRandomProxy($proxies) {
      return $proxies[array_rand($proxies)];
    }
    public function getcountries($reference)
    {
    $countries=array("US"=>"A.B.D.","AF"=>"AFGANİSTAN","DE"=>"ALMANYA","UM"=>"AMERİKA KÜÇÜK OUT. ADALARI","AS"=>"AMERİKAN SAMOA","AD"=>"ANDORRA","AO"=>"ANGOLA","AI"=>"ANGUİLLA","AQ"=>"ANTARTİKA","AG"=>"ANTİGUA-BARBUDA","AR"=>"ARJANTİN","AL"=>"ARNAVUTLUK","AW"=>"ARUBA","AU"=>"AVUSTRALYA","AT"=>"AVUSTURYA","AZ"=>"AZERBAYCAN-NAHÇ.","BS"=>"BAHAMALAR","BH"=>"BAHREYN","BD"=>"BANGLADEŞ","BB"=>"BARBADOS","TL"=>"BATI TİMOR","BE"=>"BELÇİKA","BZ"=>"BELİZE","BJ"=>"BENİN","BM"=>"BERMUDA","BY"=>"BEYAZ RUSYA","BT"=>"BHUTAN","AE"=>"BİRLEŞİK ARAP EMİRLİKLERİ","BO"=>"BOLİVYA","BA"=>"BOSNA HERSEK","BW"=>"BOTSVANA","BV"=>"BOUVET ADASI","BR"=>"BREZİLYA","BN"=>"BRUNEİ","BG"=>"BULGARİSTAN","BF"=>"BURKİNA FASO","MM"=>"BURMA (BİRMANYA)","BI"=>"BURUNDİ","CV"=>"CAPE VERDE","KY"=>"CAYMAN ADALARI","GI"=>"CEBELİTARIK","XC"=>"CEUTA","DZ"=>"CEZAYİR","DJ"=>"CİBUTİ","CC"=>"COCOS ADALARI","CK"=>"COOK ADASI","TD"=>"ÇAD","CZ"=>"ÇEK CUMHURİYETİ","CN"=>"ÇİN HALK CUMHUR.","DK"=>"DANİMARKA","DO"=>"DOMİNİK CUMHUR.","DM"=>"DOMİNİKA","EC"=>"EKVATOR","GQ"=>"EKVATOR GİNESİ","SV"=>"EL SALVADOR","ID"=>"ENDONEZYA","ER"=>"ERİTRE","AM"=>"ERMENİSTAN","EE"=>"ESTONYA","ET"=>"ETİYOPYA","FK"=>"FALKLAND ADALARI","FO"=>"FAROE ADALARI","MA"=>"FAS","FJ"=>"FİJİ","CI"=>"FİLDİŞİ SAHİLİ","PH"=>"FİLİPİNLER","PS"=>"FİLİSTİN","FI"=>"FİNLANDİYA","FR"=>"FRANSA","TF"=>"FRANSA GÜNEY BÖLGELERİ","PF"=>"FRANSIZ POLİNEZYASI","GA"=>"GABON","GM"=>"GAMBİYA","GH"=>"GANA","GN"=>"GİNE","GW"=>"GİNE-BİSSAU","GD"=>"GRENADA","GL"=>"GRÖNLAND","GU"=>"GUAM","GT"=>"GUATEMALA","GY"=>"GUYANA","ZA"=>"GÜNEY AFRİKA CUM.","GS"=>"GÜNEY GEORGİA VE GÜNEY SANDVİÇ ADALARI","KR"=>"GÜNEY KORE CUM.","GE"=>"GÜRCİSTAN","HT"=>"HAİTİ","HM"=>"HEARD ADALAI VE MC DONALD ADASI","HR"=>"HIRVATİSTAN","IN"=>"HİNDİSTAN","NL"=>"HOLLANDA","AN"=>"HOLLANDA ANTİLLERİ","HN"=>"HONDURAS","HK"=>"HONG-KONG","IQ"=>"IRAK","IO"=>"İNGİLİZ HİNT OKYANUSU TOPRAKLARI","VG"=>"İNGİLİZ VİRGİN ADALARI","GB"=>"İNGİLTERE","IR"=>"İRAN","IE"=>"İRLANDA","ES"=>"İSPANYA","IL"=>"İSRAİL","SE"=>"İSVEÇ","CH"=>"İSVİÇRE","PS"=>"FİLİSTİN","IT"=>"İTALYA","IS"=>"İZLANDA","JM"=>"JAMAİKA","JP"=>"JAPONYA","KH"=>"KAMBOÇYA","CM"=>"KAMERUN","CA"=>"KANADA","ME"=>"KARADAĞ","QA"=>"KATAR","KZ"=>"KAZAKİSTAN","KE"=>"KENYA","KG"=>"KIRGIZİSTAN","KI"=>"KİRİBATİ","CO"=>"KOLOMBİYA","KM"=>"KOMORLAR","CG"=>"KONGO","CD"=>"KONGO DEM. CUM","XK"=>"KOSOVA","CR"=>"KOSTA RİKA","CX"=>"KRİSMIS ADALARI","KW"=>"KUVEYT","KK"=>"KKTC","KP"=>"KUZEY KORE","MP"=>"KUZEY MARİANA ADALARI","CU"=>"KÜBA","LA"=>"LAOS DEMOK.HALK C","LS"=>"LESOTO","LV"=>"LETONYA","LI"=>"LIECHTENSTEIN","LR"=>"LİBERYA","LY"=>"LİBYA","LT"=>"LİTVANYA","LB"=>"LÜBNAN","LU"=>"LÜKSEMBURG","HU"=>"MACARİSTAN","MG"=>"MADAGASKAR","MO"=>"MAKAO","MK"=>"MAKEDONYA","MW"=>"MALAVİ","MV"=>"MALDİVLER","MY"=>"MALEZYA","ML"=>"MALİ","MT"=>"MALTA","MH"=>"MARSHAL ADALARI","MU"=>"MAURİTİUS","YT"=>"MAYOTTE","MX"=>"MEKSİKA","XL"=>"MELİLLA","EG"=>"MISIR","FM"=>"MİKRONEZYA","MN"=>"MOĞOLİSTAN","MD"=>"MOLDOVYA","MS"=>"MONTSERRAT","MR"=>"MORİTANYA","MZ"=>"MOZAMBİK","NA"=>"NAMİBYA","NR"=>"NAURU","NP"=>"NEPAL","NU"=>"NIUE ADASI","NE"=>"NİJER","NG"=>"NİJERYA","NI"=>"NİKARAGUA","NF"=>"NORFOLK ADASI","NO"=>"NORVEÇ","CF"=>"ORTA AFRİKA CUM","UZ"=>"ÖZBEKİSTAN","PK"=>"PAKİSTAN","PW"=>"PALAU","PA"=>"PANAMA","PG"=>"PAPUA (YENİ GİNE)","PY"=>"PARAGUAY","PE"=>"PERU","PN"=>"PİTCAİRN","PL"=>"POLONYA","PT"=>"PORTEKİZ","RO"=>"ROMANYA","RW"=>"RUANDA","RU"=>"RUSYA FEDERASYONU","WS"=>"SAMOA","SM"=>"SAN MARİNO","ST"=>"SAO TOME VE PRIN.","SN"=>"SENEGAL","SC"=>"SEYŞELLER","XS"=>"SIRBİSTAN","SL"=>"SİERRA LEONE","SG"=>"SİNGAPUR","SK"=>"SLOVAK CUMHURİYETİ","SI"=>"SLOVENYA","SB"=>"SOLOMON ADALARI","SO"=>"SOMALİ","LK"=>"SRİ LANKA","SH"=>"ST. HELENA","KN"=>"ST. KITTS VENEVİS","PM"=>"ST. PIERRE &amp; MIQUELON","LC"=>"ST.LUCİA","SD"=>"SUDAN","SR"=>"SURİNAM","SY"=>"SURİYE ARAP CUMHURİYETİ","SA"=>"SUUDİ ARABİSTAN","SZ"=>"SVAZİLAND","CL"=>"ŞİLİ","TJ"=>"TACİKİSTAN","TZ"=>"TANZANYA","TH"=>"TAYLAND","TW"=>"TAYVAN","TG"=>"TOGO","TK"=>"TOKELAU","TO"=>"TONGA","TT"=>"TRİNİDAD VE TOBAGO","TN"=>"TUNUS","TC"=>"TURKS VE CAİCAOS ADALARI","TV"=>"TUVALU","TM"=>"TÜRKMENİSTAN","TR"=>"TÜRKİYE","UG"=>"UGANDA","UA"=>"UKRAYNA","OM"=>"UMMAN","UY"=>"URUGUAY","JO"=>"ÜRDÜN","VU"=>"VANUATU","VE"=>"VENEZUELLA","VN"=>"VİETNAM SOSYALİST","WF"=>"WALLİS VE FUTUNA","YE"=>"YEMEN","NC"=>"YENİ KALEDONYA","NZ"=>"YENİ ZELANDA","GR"=>"YUNANİSTAN","ZM"=>"ZAMBİYA","ZW"=>"ZİMBABVE",);
    foreach($countries as $cnt => $cntval)
    {
    if($cnt == $reference) {
      return $cnt;
    }
    }
    }
    
   public function getcity($city)
    {
        $cities=array("0"=>"Select...", "1"=>"ADANA", "2"=>"ADIYAMAN", "3"=>"AFYONKARAHİSAR", "4"=>"AĞRI", "5"=>"AMASYA", "6"=>"ANKARA", "7"=>"ANTALYA", "8"=>"ARTVİN", "9"=>"AYDIN", "10"=>"BALIKESİR", "11"=>"BİLECİK", "12"=>"BİNGÖL", "13"=>"BİTLİS", "14"=>"BOLU", "15"=>"BURDUR", "16"=>"BURSA", "17"=>"ÇANAKKALE", "18"=>"ÇANKIRI", "19"=>"ÇORUM", "20"=>"DENİZLİ", "21"=>"DİYARBAKIR", "22"=>"EDİRNE", "23"=>"ELAZIĞ", "24"=>"ERZİNCAN", "25"=>"ERZURUM", "26"=>"ESKİŞEHİR", "27"=>"GAZİANTEP", "28"=>"GİRESUN", "29"=>"GÜMÜŞHANE", "30"=>"HAKKARİ", "31"=>"HATAY", "32"=>"ISPARTA", "33"=>"MERSİN", "34"=>"İSTANBUL", "35"=>"İZMİR", "36"=>"KARS", "37"=>"KASTAMONU", "38"=>"KAYSERİ", "39"=>"KIRKLARELİ", "40"=>"KIRŞEHİR", "41"=>"KOCAELİ", "42"=>"KONYA", "43"=>"KÜTAHYA", "44"=>"MALATYA", "45"=>"MANİSA", "46"=>"KAHRAMANMARAŞ", "47"=>"MARDİN", "48"=>"MUĞLA", "49"=>"MUŞ", "50"=>"NEVŞEHİR", "51"=>"NİĞDE", "52"=>"ORDU", "53"=>"RİZE", "54"=>"SAKARYA", "55"=>"SAMSUN", "56"=>"SİİRT", "57"=>"SİNOP", "58"=>"SİVAS", "59"=>"TEKİRDAĞ", "60"=>"TOKAT", "61"=>"TRABZON", "62"=>"TUNCELİ", "63"=>"ŞANLIURFA", "64"=>"UŞAK", "65"=>"VAN", "66"=>"YOZGAT", "67"=>"ZONGULDAK", "68"=>"AKSARAY", "69"=>"BAYBURT", "70"=>"KARAMAN", "71"=>"KIRIKKALE", "72"=>"BATMAN", "73"=>"ŞIRNAK", "74"=>"BARTIN", "75"=>"ARDAHAN", "76"=>"IĞDIR", "77"=>"YALOVA", "78"=>"KARABÜK", "79"=>"KİLİS", "80"=>"OSMANİYE", "81"=>"DÜZCE");
        foreach($cities as $cnt => $cntval)
        {
        if($cnt == $city) {
          return $cnt;
        }
        }
    }
    public function render(): WP_REST_Response
    {
      
       
        $username=$_POST['username'];
        $password=$_POST['password'];
       
      
        $proxies = [
            'http://ngqeqeos12qeqeos12-1:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-2:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-3:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-4:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-5:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-6:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-7:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-8:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-9:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-10:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-11:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-12:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-13:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-14:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-15:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-16:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-17:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-18:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-19:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-20:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            
            // ... add more proxies as needed
          ];
         
          $instance = new ScrapePatientProfile($this->appContext);
          $client = new Client(HttpClient::create([
            'timeout' => 200,
            'proxy' => $instance->getRandomProxy($proxies),
            //'proxy' => 'http://ngqeqeos12qeqeos12-1:45prwykzv01j45prwykzv01j@proxy.webshare.io:80',
            
            ])
          );
          $crawler = $client->request('GET', 'https://enabiz.gov.tr/');

          $form = $crawler->selectButton('btnGiris')->form();
          $crawler = $client->submit($form, ['TCKimlikNo' => $username, 'Sifre' => $password]);
          $crawler1=$client->request('GET', 'https://enabiz.gov.tr/Profil/Index');
          $crawler2=$client->request('GET', 'https://enabiz.gov.tr/Home/Index');

          $form = $crawler1->filter('#profil-duzenle-form')->form();

         $records = $form->getValues();
         $prersonalinfo=[];
          foreach($records as $x => $val) 
          {
            if($x=='Adi' || $x=='Soyadi' || $x=='TCKimlikNo' || $x=='TCKimlikNo' || $x=='DogumYeri' || $x=='DogumTarihi' || $x=='YasadigiSehir'
            || $x=='YasadigiUlke' || $x=='BirincilEmail' || $x=='BirincilTel' || $x=='Boy' || $x=='KanGrubu')
            {
              $prersonalinfo[$x]=$val;
            }

          }
          
          //print_r($prersonalinfo);
          /*foreach($prersonalinfo as $key =>$value)
          {
              if($key=='Adi') { echo "Firstname:".trim($value)."<br>";} if($key=='Soyadi') { echo "Lastname:".trim($value)."<br>";}  if($key=='TCKimlikNo') { echo "National Id Number:".trim($value)."<br>";} 
              if($key=='DogumTarihi') { echo "Birthday:".trim(str_replace("00:00:00","",$value))."<br>";}  if($key=='DogumYeri') { echo "BirthPlace:".trim($value)."<br>";} if($key=='YasadigiSehir') { echo "City:".trim($instance->getcity($value))."<br>";} 
              if($key=='YasadigiUlke') { echo "Country:".$instance->getcountries(trim($value))."<br>";} if($key=='BirincilEmail') { echo "Email:".trim($value)."<br>";} 
              if($key=='BirincilTel') { echo "Phone:".trim($value)."<br>";} if($key=='Boy') { echo "Height:".trim($value)."<br>";} 

          }*/
          /*$crawler1->filter('select#KanGrubu option:selected')->each(function ($node) {
            echo "Blood Type:".$node->text()."<br>";
          });*/
          $age=$crawler2->filter('.home-profile .profile .full-box.bb span.text-big')->text();
          $weight=$crawler2->filter('.home-profile .profile div:nth-child(3) div.half-box.br span.text-big')->text();
          $physcianname=$crawler2->filter('.home-profile .profile div:nth-child(5) h4.profile-desc-title')->text();
          $healthcenter=$crawler2->filter('.home-profile .profile div:nth-child(5) span.profile-desc-title')->text();
         
          $birthdate=trim(str_replace("00:00:00","",$prersonalinfo['DogumTarihi']));
          $data = array(
           "firstname"=>$prersonalinfo['Adi'],
           "lastname"=>$prersonalinfo['Soyadi'],
           "nationalidnumber"=>$prersonalinfo['TCKimlikNo'],
           "birthday"=>trim(str_replace(".","/",$birthdate)),
           "birthplace"=>trim($prersonalinfo['DogumYeri']),
           "city"=>$instance->getcity(trim($prersonalinfo['YasadigiSehir'])),
           "country"=>$instance->getcountries(trim($prersonalinfo['YasadigiUlke'])),
           "email"=>$prersonalinfo['BirincilEmail'],
           "phone"=>$prersonalinfo['BirincilTel'],
           "height"=>$prersonalinfo['Boy'],
           "bloodtype"=>$crawler1->filter('select#KanGrubu option:selected')->text(),
           'weight'=>$weight,
           'age'=>$age,
           'physcianname'=>$physcianname,
           'healthcenter'=>$healthcenter,
        );
        
        /*Add Value to session code start here*/
        //Unset Cookies first then set new cookies

        $cookie_name = 'profile_information';
        $expiration_time = time() - 3600; // Set the expiration time to the past

        setcookie($cookie_name, '', $expiration_time, '/', 'ebakim.fametechit.com');
        //set new cookies
        $cookie_name = 'profile_information';
        $cookie_data = $prersonalinfo['Adi'] ."|".$prersonalinfo['Soyadi'].'|'.trim(str_replace(".","/",$birthdate)).'|'.trim($prersonalinfo['DogumYeri']).'|'.$instance->getcity(trim($prersonalinfo['YasadigiSehir'])).'|'.
        $instance->getcountries(trim($prersonalinfo['YasadigiUlke'])).'|'.$prersonalinfo['BirincilEmail'].'|'.$prersonalinfo['BirincilTel'].'|'.$prersonalinfo['Boy'].'|'.$crawler1->filter('select#KanGrubu option:selected')->text().'|'.
        $weight.'|'.$age.'|'.$physcianname.'|'.$healthcenter;

       
        // Set the cookie
        $expiration_time = time() + 3600; // Set the expiration time (e.g., 1 hour from now)
        setcookie($cookie_name, $cookie_data, $expiration_time, '/', 'ebakim.fametechit.com');

   
        /*Add value to session code end here */
        //$records= array('Profile Information' => 'Data received: ' . $data);
        //$data = array("test" => "fine"); 
        $response = new WP_REST_Response($data);
        //echo $response;
       
        return $response;
    }
          

     
      
   /* public function patientprofileold($data)
    {
       // $username=$_POST['username'];
        //$password=$_POST['password'];


        $username='43564225540';
        $password='Welcome2023!';
        $proxies = [
            'http://ngqeqeos12qeqeos12-1:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-2:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-3:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-4:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-5:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-6:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-7:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-8:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-9:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-10:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-11:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-12:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-13:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-14:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-15:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-16:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-17:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-18:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-19:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            'http://ngqeqeos12qeqeos12-20:45prwykzv01j45prwykzv01j@p.webshare.io:80',
            
            // ... add more proxies as needed
          ];
         
        
          $client = new Client(HttpClient::create([
            'timeout' => 200,
            'proxy' => getRandomProxy($proxies),
            //'proxy' => 'http://ngqeqeos12qeqeos12-1:45prwykzv01j45prwykzv01j@proxy.webshare.io:80',
            
            ])
          );
          $data="Success";
          return array('message' => 'Data received: ' . $data);
          exit;
        $crawler = $client->request('GET', 'https://enabiz.gov.tr/');

        $form = $crawler->selectButton('btnGiris')->form();
        $crawler = $client->submit($form, ['TCKimlikNo' => $username, 'Sifre' => $password]);
        $crawler1=$client->request('GET', 'https://enabiz.gov.tr/Profil/Index');
            $data = array(
                "username" => $username,
                "password" => $password,
            );
            $form = $crawler1->filter('#profil-duzenle-form')->form();

            $records = $form->getValues();
        //$data= "working jquery code";
        //return array('message' => 'Data received: ' . $data);
        wp_send_json($records);
        exit;
    }*/

}
    
?>