<?php defined('ABSPATH') || exit; ?>
<?php
include(__DIR__ . '/../templates/header.php');
if (isset($_GET['id'])) {
    global $wpdb;
    $eb_patients = $wpdb->prefix . 'eb_patients';
    $patient_id = intval($_GET['id']); // Sanitize and convert to integer

    // Retrieve patient data for the specified ID
    $patient_data = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $eb_patients WHERE id = %d", $patient_id)
    );
}


?>
<script>
$(document).ready(function() {
    $('#loginenabiz').click(function(e) {
      
        e.preventDefault(); // Prevent the form from submitting normally

        // Get the values from the form fields
        var username = $('#tckimlikno').val();
        var password = $('#Password').val();
 
        // Check if the fields are empty
        if (username === '' || password === '') {
            $('#error-message').html('<span style="color:red;font-size:16px;">Both fields are required.</span>');
        } else {
                if ( $('#accept').is(':checked') ){
                    var loader = $('#loader');
                    loader.show();
                    $.ajax({  
                url: '/wp-json/scraping/v1/endpoint',
                type: 'POST',
                data: {
                    username: username,
                    password: password
                    },   
                
           success: function (response) {
            loader.hide();
            console.log(response);
                $("#success-message span").html("<b>"+response.firstname+" "+response.lastname+"</b> has been successfully logged in and data has been received.");
                $("#success-message").show();
                // Handle the response from the API
                var birthdate=response.birthday;
                $("#firstname").val(response.firstname);
                $("#lastname").val(response.lastname);
                $("#birthdate").val(birthdate);
                $("#birthplace").val(response.birthplace);
                $('#nationality option').each(function () { 
                  if($(this).val()==response.country)
                  {
                    $(this).prop("selected", true);
                  }
                });
                $('#city option').each(function () { 
                  if($(this).val()==response.city)
                  {
                    $(this).prop("selected", true);
                  }
                });
                $("#email").val(response.email);
                $("#phone").val(response.phone);
                $("#height").val(response.height);
                $("#weight").val(response.weight);
                $("#age").val(response.age);
                $("#physicianname").val(response.physicianname);
                $("#healthcentre").val(response.healthcentre);
                $('#bloodType option').each(function () { 
                  if($(this).val()==response.bloodtype)
                  {
                    $(this).prop("selected", true);
                  }
                });
                
            },
            error: function (error) {
                loader.hide();
                $("#success-message").hide();
                $("#error-message").show();
                // Handle any errors
                $("#error-message span").html("An error occurred while logging into e-Nbiza.");
                console.error("error:"+error);
            },
      });  
            }
            else {
                alert('You must accept the privacy and terms of use!')
                return false;
            }
            
        }
    });

/*Tabs code start here */
$('#tabs-nav li:first-child').addClass('active');
$('.tab-content').hide();
$('.tab-content:first').show();

// Click function
$('#tabs-nav li').click(function(){
  $('#tabs-nav li').removeClass('active');
  $(this).addClass('active');
  $('.tab-content').hide();
  
  var activeTab = $(this).find('a').attr('href');
  $(activeTab).fadeIn();
  return false;
});


});
</script>

<style>
    input {
        width: 100%;
    }

    .flowers {
        width: 35px;
        height: 35px;
    }

    .flex-div {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }
    /* Tabs */
.tabs {
  width: 600px;

  border-radius: 5px 5px 5px 5px;
}
ul#tabs-nav {
  list-style: none;
  margin: 0;
  padding: 5px;
  overflow: auto;
}
ul#tabs-nav li {
  float: left;
  font-weight: bold;

  padding: 8px 10px;
  border-bottom: 1px solid #000;
  /*border: 1px solid #d5d5de;
  border-bottom: none;*/
  cursor: pointer;
}
ul#tabs-nav li:hover,
ul#tabs-nav li.active {
  border-bottom: 1px solid #2271b1;
}
#tabs-nav li a {
  text-decoration: none;
  color: #000;
}
.tab-content {
  padding: 10px;
 

}
.wrap select,.wrap textarea
{
    width: 100%;
    max-width: 36rem;
}
.loading-bar {
  position: relative;
  margin: 0 auto;
  height: 30px;
 
  border-radius: 50px;
}

.loading-bar span {
  display: block;
  position: relative;
  height: 100%;
  width: 100%;
  
  border-radius: 50px;
  background-image: linear-gradient(to bottom, #000, #2271b1 60%);
  box-shadow:
    inset 0 2px 9px  rgba(255,255,255,0.3),
    inset 0 -2px 6px rgba(0,0,0,0.4);
  overflow: hidden;
}

.loading-bar span:after {
  content: "";
  position: absolute;
  top: 0px; left: 0; bottom: 0; right: 0;
  background-image: linear-gradient(
    -45deg, 
    rgba(255, 255, 255, .2) 25%, 
    transparent 25%, 
    transparent 50%, 
    rgba(255, 255, 255, .2) 50%, 
    rgba(255, 255, 255, .2) 75%,
    transparent 75%, 
    transparent
  );
  z-index: 1;
  background-size: 50px 50px;
  border-top-right-radius: 8px;
  border-bottom-right-radius: 8px;
  border-top-left-radius: 20px;
  border-bottom-left-radius: 20px;
  overflow: hidden;
}

.loading-bar > span:after, .animate > span > span { 
  animation: load 1s infinite;
}

@keyframes load {
  0% {
    background-position: 0 0;
  }
  100% {
    background-position: 50px 50px;
  }
}
#success-message span
{
    border-top:2px solid #c3c4c7;
    border-right:2px solid #c3c4c7;
    border-bottom:2px solid #c3c4c7;
    border-left:6px solid #8fd14f;
    padding: 10px;
    color: #000;
    font-size: 16px;
    background-color: #fff;
}
#error-message span
{
    border-top:2px solid #c3c4c7;
    border-right:2px solid #c3c4c7;
    border-bottom:2px solid #c3c4c7;
    border-left:6px solid #F24726;
    padding: 10px;
    color: #000;
    font-size: 16px;
    background-color: #fff;
}
</style>
<div class="wrap">
<?php

if (isset($_COOKIE['profile_information'])) {
    
    //echo "fine";
 $cookievalues=explode('|',$_COOKIE['profile_information']);
 //print_r($cookievalues);
    
 
}

?>
<div class="container">
   <div  style="max-width: 600px">
      <h3>Login Form</h3>
      <div id="success-message" style="display: none;">
    <span></span>
      </div>
      <div id="error-message" style="display: none;">
    <span></span>
      </div>
      <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" enctype="multipart/form-data" name="loginform">
         <p>
            <strong style="display: table; margin-bottom: 5px">tcNumber</strong>
            <input type="text" class="form-control" id="tckimlikno" placeholder="tcNumber" name="tckimlikno" aria-describedby="tckimlikno">
         </p>
         <p>
            <input type="password" name="password" id="Password" class="form-control" placeholder="Password">
         </p>
         <p>
            <label class="checkbox-inline">
            <input type="checkbox" id="accept" value="">I accept the privacy and terms of use
            </label>
         </p>
         <div id="loader" style="display: none;">
         <div class="loading-bar animate">
            <span></span>
            </div>
        </div>

         <p>
            <input type="submit" id="loginenabiz" name="loginenabiz" class="button button-primary" value="Login with e-Nabiz">
         </p>
         <p>
            <input type="submit" name="loginedevlet" class="button button-outline-primary" value="Login with e-Devlet">
         </p>
      </form>
   </div>
</div>



    <!--<h2><?= (isset($patient_data)) ? __('Edit Patient', 'ebakim-wp') : __('Add Patient', 'ebakim-wp') ?></h2>
    <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" enctype="multipart/form-data" style="max-width: 600px">
        <input type="hidden" name="action" value="<?= ((isset($patient_data)) ? 'edit_patient' : 'add_patient') ?>" />
        <?php
        if (isset($_GET['id'])) {
        ?>
            <input type="hidden" name="id" value="<?= $_GET['id'] ?>" />
        <?php } ?>




        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Patient ID', 'ebakim-wp'); ?></strong>
            <input required type="text" class="widefat" name="patientID" value="<?php echo esc_attr($patient_data->patientID ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Patient Image', 'ebakim-wp'); ?></strong>
            <input type="file" accept="image/*" name="patientImage">
            <span class="error-message"></span>
            <?php
            // $patientImage = $patient_data->picture;
            // if ($patientImage) {
            //     $upload_dir = wp_upload_dir();
            //     $target_dir = $upload_dir['path'] . '/images/';

            //     $imagePath = $target_dir . $patientImage;
            //     if (file_exists($imagePath)) {
            //         echo '<p><strong>' . __('Current Image:', 'ebakim-wp') . '</strong></p>';
            //         echo '<img src="' . ($imagePath) . '" style="max-width: 100px;" alt="Patient Image">';
            //     }
            // }
            ?>
        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Patient Fullname', 'ebakim-wp'); ?></strong>
            <input required type="text" class="widefat" name="patientFullName" value="<?php echo esc_attr($patient_data->patientFullName ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Patient Birthdate', 'ebakim-wp'); ?></strong>
            <input type="date" name="patientBirthDate" value="<?php echo esc_attr($patient_data->patientBirthDate ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Patient T.C. Number', 'ebakim-wp'); ?></strong>
            <input type="number" name="patientTcNumber" value="<?php echo esc_attr($patient_data->patientTcNumber ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Clinic Acceptance Date', 'ebakim-wp'); ?></strong>
            <input type="date" name="clinicAcceptanceDate" value="<?php echo esc_attr($patient_data->clinicAcceptanceDate ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Clinic Placement Type', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" name="clinicPlacementType" value="<?php echo esc_attr($patient_data->clinicPlacementType ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Clinic Placement Status', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" name="clinicPlacementStatus" value="<?php echo esc_attr($patient_data->clinicPlacementStatus ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Clinic End Date', 'ebakim-wp'); ?></strong>
            <input type="date" name="clinicEndDate" value="<?php echo esc_attr($patient_data->clinicEndDate ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Clinic Life Plan Date', 'ebakim-wp'); ?></strong>
            <input type="date" name="clinicLifePlanDate" value="<?php echo esc_attr($patient_data->clinicLifePlanDate ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Clinic ESKR Date', 'ebakim-wp'); ?></strong>
            <input type="date" name="clinicEskrDate" value="<?php echo esc_attr($patient_data->clinicEskrDate ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Clinic Guardian Date', 'ebakim-wp'); ?></strong>
            <input type="date" name="clinicGuardianDate" value="<?php echo esc_attr($patient_data->clinicGuardianDate ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Clinic Allowance Status', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" name="clinicAllowanceStatus" value="<?php echo esc_attr($patient_data->clinicAllowanceStatus ?? ''); ?>">
            <span class="error-message"></span>

        </p>

        <p>
            <input type="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes', 'ebakim-wp'); ?>">
            <span class="error-message"></span>

        </p>
    </form>-->
    <div class="tabs">
  <ul id="tabs-nav">
    <li><a href="#tab1">Genel Bilgiler</a></li>
    <li><a href="#tab2">SSO Bilgiler</a></li>
    <li><a href="#tab3">Sagilk Bilgiler</a></li>
   
  </ul> <!-- END tabs-nav -->
  <form >
  <div id="tabs-content">
    <div id="tab1" class="tab-content">
    <p><label>Gender:</label> <br/>
    <p>
        <input type="radio" id="male" name="gender" value="male" required>
        <label for="male">Male</label>
        <input type="radio" id="female" name="gender" value="female" required>
        <label for="female">Female</label>   
    </p>  
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Firstname', 'ebakim-wp'); ?></strong>
        <input required type="text" class="widefat" id="firstname" name="firstname" placeholder="firstname" value="<?php if(isset($cookievalues[0])) {echo $cookievalues[0];}?>">
    </p>
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Lastname', 'ebakim-wp'); ?></strong>
        <input required type="text" class="widefat" id="lastname" name="lastname" placeholder="lastname" value="<?php if(isset($cookievalues[0])) {echo $cookievalues[1];}?>">
    </p>
    <p>
    <strong style="display: table; margin-bottom: 5px"><?php echo __('Nationality', 'ebakim-wp'); ?></strong>
    <select name="nationality" id="nationality">
        <option value="">Please Select</option>
    <?php 
    $countries=array("US"=>"A.B.D.","AF"=>"AFGANİSTAN","DE"=>"ALMANYA","UM"=>"AMERİKA KÜÇÜK OUT. ADALARI","AS"=>"AMERİKAN SAMOA","AD"=>"ANDORRA","AO"=>"ANGOLA","AI"=>"ANGUİLLA","AQ"=>"ANTARTİKA","AG"=>"ANTİGUA-BARBUDA","AR"=>"ARJANTİN","AL"=>"ARNAVUTLUK","AW"=>"ARUBA","AU"=>"AVUSTRALYA","AT"=>"AVUSTURYA","AZ"=>"AZERBAYCAN-NAHÇ.","BS"=>"BAHAMALAR","BH"=>"BAHREYN","BD"=>"BANGLADEŞ","BB"=>"BARBADOS","TL"=>"BATI TİMOR","BE"=>"BELÇİKA","BZ"=>"BELİZE","BJ"=>"BENİN","BM"=>"BERMUDA","BY"=>"BEYAZ RUSYA","BT"=>"BHUTAN","AE"=>"BİRLEŞİK ARAP EMİRLİKLERİ","BO"=>"BOLİVYA","BA"=>"BOSNA HERSEK","BW"=>"BOTSVANA","BV"=>"BOUVET ADASI","BR"=>"BREZİLYA","BN"=>"BRUNEİ","BG"=>"BULGARİSTAN","BF"=>"BURKİNA FASO","MM"=>"BURMA (BİRMANYA)","BI"=>"BURUNDİ","CV"=>"CAPE VERDE","KY"=>"CAYMAN ADALARI","GI"=>"CEBELİTARIK","XC"=>"CEUTA","DZ"=>"CEZAYİR","DJ"=>"CİBUTİ","CC"=>"COCOS ADALARI","CK"=>"COOK ADASI","TD"=>"ÇAD","CZ"=>"ÇEK CUMHURİYETİ","CN"=>"ÇİN HALK CUMHUR.","DK"=>"DANİMARKA","DO"=>"DOMİNİK CUMHUR.","DM"=>"DOMİNİKA","EC"=>"EKVATOR","GQ"=>"EKVATOR GİNESİ","SV"=>"EL SALVADOR","ID"=>"ENDONEZYA","ER"=>"ERİTRE","AM"=>"ERMENİSTAN","EE"=>"ESTONYA","ET"=>"ETİYOPYA","FK"=>"FALKLAND ADALARI","FO"=>"FAROE ADALARI","MA"=>"FAS","FJ"=>"FİJİ","CI"=>"FİLDİŞİ SAHİLİ","PH"=>"FİLİPİNLER","PS"=>"FİLİSTİN","FI"=>"FİNLANDİYA","FR"=>"FRANSA","TF"=>"FRANSA GÜNEY BÖLGELERİ","PF"=>"FRANSIZ POLİNEZYASI","GA"=>"GABON","GM"=>"GAMBİYA","GH"=>"GANA","GN"=>"GİNE","GW"=>"GİNE-BİSSAU","GD"=>"GRENADA","GL"=>"GRÖNLAND","GU"=>"GUAM","GT"=>"GUATEMALA","GY"=>"GUYANA","ZA"=>"GÜNEY AFRİKA CUM.","GS"=>"GÜNEY GEORGİA VE GÜNEY SANDVİÇ ADALARI","KR"=>"GÜNEY KORE CUM.","GE"=>"GÜRCİSTAN","HT"=>"HAİTİ","HM"=>"HEARD ADALAI VE MC DONALD ADASI","HR"=>"HIRVATİSTAN","IN"=>"HİNDİSTAN","NL"=>"HOLLANDA","AN"=>"HOLLANDA ANTİLLERİ","HN"=>"HONDURAS","HK"=>"HONG-KONG","IQ"=>"IRAK","IO"=>"İNGİLİZ HİNT OKYANUSU TOPRAKLARI","VG"=>"İNGİLİZ VİRGİN ADALARI","GB"=>"İNGİLTERE","IR"=>"İRAN","IE"=>"İRLANDA","ES"=>"İSPANYA","IL"=>"İSRAİL","SE"=>"İSVEÇ","CH"=>"İSVİÇRE","PS"=>"FİLİSTİN","IT"=>"İTALYA","IS"=>"İZLANDA","JM"=>"JAMAİKA","JP"=>"JAPONYA","KH"=>"KAMBOÇYA","CM"=>"KAMERUN","CA"=>"KANADA","ME"=>"KARADAĞ","QA"=>"KATAR","KZ"=>"KAZAKİSTAN","KE"=>"KENYA","KG"=>"KIRGIZİSTAN","KI"=>"KİRİBATİ","CO"=>"KOLOMBİYA","KM"=>"KOMORLAR","CG"=>"KONGO","CD"=>"KONGO DEM. CUM","XK"=>"KOSOVA","CR"=>"KOSTA RİKA","CX"=>"KRİSMIS ADALARI","KW"=>"KUVEYT","KK"=>"KKTC","KP"=>"KUZEY KORE","MP"=>"KUZEY MARİANA ADALARI","CU"=>"KÜBA","LA"=>"LAOS DEMOK.HALK C","LS"=>"LESOTO","LV"=>"LETONYA","LI"=>"LIECHTENSTEIN","LR"=>"LİBERYA","LY"=>"LİBYA","LT"=>"LİTVANYA","LB"=>"LÜBNAN","LU"=>"LÜKSEMBURG","HU"=>"MACARİSTAN","MG"=>"MADAGASKAR","MO"=>"MAKAO","MK"=>"MAKEDONYA","MW"=>"MALAVİ","MV"=>"MALDİVLER","MY"=>"MALEZYA","ML"=>"MALİ","MT"=>"MALTA","MH"=>"MARSHAL ADALARI","MU"=>"MAURİTİUS","YT"=>"MAYOTTE","MX"=>"MEKSİKA","XL"=>"MELİLLA","EG"=>"MISIR","FM"=>"MİKRONEZYA","MN"=>"MOĞOLİSTAN","MD"=>"MOLDOVYA","MS"=>"MONTSERRAT","MR"=>"MORİTANYA","MZ"=>"MOZAMBİK","NA"=>"NAMİBYA","NR"=>"NAURU","NP"=>"NEPAL","NU"=>"NIUE ADASI","NE"=>"NİJER","NG"=>"NİJERYA","NI"=>"NİKARAGUA","NF"=>"NORFOLK ADASI","NO"=>"NORVEÇ","CF"=>"ORTA AFRİKA CUM","UZ"=>"ÖZBEKİSTAN","PK"=>"PAKİSTAN","PW"=>"PALAU","PA"=>"PANAMA","PG"=>"PAPUA (YENİ GİNE)","PY"=>"PARAGUAY","PE"=>"PERU","PN"=>"PİTCAİRN","PL"=>"POLONYA","PT"=>"PORTEKİZ","RO"=>"ROMANYA","RW"=>"RUANDA","RU"=>"RUSYA FEDERASYONU","WS"=>"SAMOA","SM"=>"SAN MARİNO","ST"=>"SAO TOME VE PRIN.","SN"=>"SENEGAL","SC"=>"SEYŞELLER","XS"=>"SIRBİSTAN","SL"=>"SİERRA LEONE","SG"=>"SİNGAPUR","SK"=>"SLOVAK CUMHURİYETİ","SI"=>"SLOVENYA","SB"=>"SOLOMON ADALARI","SO"=>"SOMALİ","LK"=>"SRİ LANKA","SH"=>"ST. HELENA","KN"=>"ST. KITTS VENEVİS","PM"=>"ST. PIERRE &amp; MIQUELON","LC"=>"ST.LUCİA","SD"=>"SUDAN","SR"=>"SURİNAM","SY"=>"SURİYE ARAP CUMHURİYETİ","SA"=>"SUUDİ ARABİSTAN","SZ"=>"SVAZİLAND","CL"=>"ŞİLİ","TJ"=>"TACİKİSTAN","TZ"=>"TANZANYA","TH"=>"TAYLAND","TW"=>"TAYVAN","TG"=>"TOGO","TK"=>"TOKELAU","TO"=>"TONGA","TT"=>"TRİNİDAD VE TOBAGO","TN"=>"TUNUS","TC"=>"TURKS VE CAİCAOS ADALARI","TV"=>"TUVALU","TM"=>"TÜRKMENİSTAN","TR"=>"TÜRKİYE","UG"=>"UGANDA","UA"=>"UKRAYNA","OM"=>"UMMAN","UY"=>"URUGUAY","JO"=>"ÜRDÜN","VU"=>"VANUATU","VE"=>"VENEZUELLA","VN"=>"VİETNAM SOSYALİST","WF"=>"WALLİS VE FUTUNA","YE"=>"YEMEN","NC"=>"YENİ KALEDONYA","NZ"=>"YENİ ZELANDA","GR"=>"YUNANİSTAN","ZM"=>"ZAMBİYA","ZW"=>"ZİMBABVE",);
    foreach($countries as $cnt => $cntval)
    {
        ?>
<option value="<?php echo $cnt;?>" <?php if(@$cookievalues[5]==$cnt) { echo "selected"; }?>><?php echo $cntval;?></option>
        <?php 
    }
    ?>
    </select>
    </p>
     <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('FatherName', 'ebakim-wp'); ?></strong>
        <input required type="text" class="widefat" name="fathername" placeholder="fathername" value="">
    </p>
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('MotherName', 'ebakim-wp'); ?></strong>
        <input required type="text" class="widefat" name="mothername" placeholder="mothername" value="">
    </p>
    
    <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Birthdate', 'ebakim-wp'); ?></strong>
            <input type="date" name="birthDate" id="birthdate" value="<?php if(isset($cookievalues[2])) {echo $cookievalues[2];}?>" placeholder="birthDate">
    </p>
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('BirthPlace', 'ebakim-wp'); ?></strong>
        <input required type="text" class="widefat" id="birthplace" name="birthPlace" placeholder="birthPlace" value="<?php if(isset($cookievalues[3])) {echo $cookievalues[3];}?>">
    </p>
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('passportNumber', 'ebakim-wp'); ?></strong>
        <input required type="text" class="widefat" name="PassportNumber" placeholder="passportNumber" value="">
    </p>
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('YupassNumber', 'ebakim-wp'); ?></strong>
        <input required type="text" class="widefat" name="yupassNumber" placeholder="yupassNumber" value="">
    </p>
    <!--<p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Length', 'ebakim-wp'); ?></strong>
        <input required type="text" class="widefat" name="length" placeholder="length" value="">
    </p>
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Weight', 'ebakim-wp'); ?></strong>
        <input required type="text" class="widefat" name="weight" placeholder="weight" value="">
    </p>-->
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Email', 'ebakim-wp'); ?></strong>
        <input required type="email" class="widefat" name="email" id="email" placeholder="Email" value="<?php if(isset($cookievalues[6])) {echo $cookievalues[6];}?>">
    </p>
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Phone', 'ebakim-wp'); ?></strong>
        <input required type="text" class="widefat" name="phone" id="phone" placeholder="Phone" value="<?php if(isset($cookievalues[7])) {echo $cookievalues[7];}?>">
    </p>
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Phone 2', 'ebakim-wp'); ?></strong>
        <input required type="text" class="widefat" name="phone2" placeholder="Phone 2" value="">
    </p>
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Address Home', 'ebakim-wp'); ?></strong>
        <textarea id="message" name="addresshome" rows="3" cols="50" required></textarea>
    </p>
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Address Job', 'ebakim-wp'); ?></strong>
        <textarea id="message" name="addressjob" rows="3" cols="50" required></textarea>
    </p>
    <p>
    <strong style="display: table; margin-bottom: 5px"><?php echo __('Province', 'ebakim-wp'); ?></strong>
    <select name="province">
        <option value="">Please Select</option>
    </select>
    </p>
    <p>
    <strong style="display: table; margin-bottom: 5px"><?php echo __('City', 'ebakim-wp'); ?></strong>
    <select name="city" id="city">
    
        <option value="">Please Select</option>
        <?php 
        $cities=array("0"=>"Select...", "1"=>"ADANA", "2"=>"ADIYAMAN", "3"=>"AFYONKARAHİSAR", "4"=>"AĞRI", "5"=>"AMASYA", "6"=>"ANKARA", "7"=>"ANTALYA", "8"=>"ARTVİN", "9"=>"AYDIN", "10"=>"BALIKESİR", "11"=>"BİLECİK", "12"=>"BİNGÖL", "13"=>"BİTLİS", "14"=>"BOLU", "15"=>"BURDUR", "16"=>"BURSA", "17"=>"ÇANAKKALE", "18"=>"ÇANKIRI", "19"=>"ÇORUM", "20"=>"DENİZLİ", "21"=>"DİYARBAKIR", "22"=>"EDİRNE", "23"=>"ELAZIĞ", "24"=>"ERZİNCAN", "25"=>"ERZURUM", "26"=>"ESKİŞEHİR", "27"=>"GAZİANTEP", "28"=>"GİRESUN", "29"=>"GÜMÜŞHANE", "30"=>"HAKKARİ", "31"=>"HATAY", "32"=>"ISPARTA", "33"=>"MERSİN", "34"=>"İSTANBUL", "35"=>"İZMİR", "36"=>"KARS", "37"=>"KASTAMONU", "38"=>"KAYSERİ", "39"=>"KIRKLARELİ", "40"=>"KIRŞEHİR", "41"=>"KOCAELİ", "42"=>"KONYA", "43"=>"KÜTAHYA", "44"=>"MALATYA", "45"=>"MANİSA", "46"=>"KAHRAMANMARAŞ", "47"=>"MARDİN", "48"=>"MUĞLA", "49"=>"MUŞ", "50"=>"NEVŞEHİR", "51"=>"NİĞDE", "52"=>"ORDU", "53"=>"RİZE", "54"=>"SAKARYA", "55"=>"SAMSUN", "56"=>"SİİRT", "57"=>"SİNOP", "58"=>"SİVAS", "59"=>"TEKİRDAĞ", "60"=>"TOKAT", "61"=>"TRABZON", "62"=>"TUNCELİ", "63"=>"ŞANLIURFA", "64"=>"UŞAK", "65"=>"VAN", "66"=>"YOZGAT", "67"=>"ZONGULDAK", "68"=>"AKSARAY", "69"=>"BAYBURT", "70"=>"KARAMAN", "71"=>"KIRIKKALE", "72"=>"BATMAN", "73"=>"ŞIRNAK", "74"=>"BARTIN", "75"=>"ARDAHAN", "76"=>"IĞDIR", "77"=>"YALOVA", "78"=>"KARABÜK", "79"=>"KİLİS", "80"=>"OSMANİYE", "81"=>"DÜZCE");
        foreach($cities as $cnt => $cntval)
        {
            
            
        ?>
            <option value="<?php echo $cnt;?>" <?php if(@$cookievalues[4]==$cnt) { echo "selected"; }?>><?php echo $cntval;?></option>
        <?php
        }
        ?>
    </select>
    </p>
    <p>
    <strong style="display: table; margin-bottom: 5px"><?php echo __('Education', 'ebakim-wp'); ?></strong>
    <select name="province">
      
        <?php 
         $province=array("0"=>"Select...", "Okur yazar degil"=>"Okur yazar degil", "Ilkokul mezunu"=>"Ilkokul mezunu", "Orta Okul"=>"Orta Okul", "Lise"=>"Lise", "Üniversite"=>"Üniversite", "Yüksek Lisans"=>"Yüksek Lisans", "Diğer"=>"Diğer");
        foreach($province as $cnt => $cntval)
        {
     
        ?>
        <option value="<?php $cnt;?>"><?php echo $cntval;?></option>
        <?php 
        }
        ?>
    </select>
    </p>
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Occupation', 'ebakim-wp'); ?></strong>
        <input required type="text" class="widefat" name="occupation" placeholder="occupation" value="">
    </p>
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Medini Durumu', 'ebakim-wp'); ?></strong>
        <input type="checkbox" id="medinidurumu" name="medinidurumu[]" value="Evil">
        <label for="subscribe">Evil</label>
        <input type="checkbox" id="medinidurumu" name="medinidurumu[]" value="Bekar">
        <label for="subscribe">Bekar</label>
        <input type="checkbox" id="medinidurumu" name="medinidurumu[]" value="Bosamis">
        <label for="subscribe">Bosamis</label>
    </p>
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Engel Grubu', 'ebakim-wp'); ?></strong>
        <input type="checkbox" id="engelgrubu" name="engelgrubu[]" value="Zihinsel">
        <label for="engelgrubu">Zihinsel</label>
        <input type="checkbox" id="engelgrubu" name="engelgrubu[]" value="Ruhsal">
        <label for="engelgrubu">Ruhsal</label>
        <input type="checkbox" id="engelgrubu" name="engelgrubu[]" value="Bedensel">
        <label for="engelgrubu">Bedensel</label>
        <input type="checkbox" id="engelgrubu" name="engelgrubu[]" value="0-12">
        <label for="engelgrubu">0-12</label>
        <input type="checkbox" id="engelgrubu" name="engelgrubu[]" value="13-18">
        <label for="engelgrubu">13-18</label>
        <input type="checkbox" id="engelgrubu" name="engelgrubu[]" value="19+">
        <label for="engelgrubu">19+</label>
    </p>
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Patient Image', 'ebakim-wp'); ?></strong>
        <input type="file" accept="image/*" name="patientImage">
    </p>
    <p>
        <h3>Saglik Bilgileri</h3>
    </p>
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Height', 'ebakim-wp'); ?></strong>
        <input required type="text" class="widefat" name="height" id="height" placeholder="length" value="<?php if(isset($cookievalues[8])) {echo $cookievalues[8];}?>">
    </p>
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Length', 'ebakim-wp'); ?></strong>
        <input required type="text" class="widefat" name="length" placeholder="length" value="">
    </p>
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Weight', 'ebakim-wp'); ?></strong>
        <input required type="text" class="widefat" name="weight" id="weight" placeholder="weight" value="<?php if(isset($cookievalues[10])) {echo $cookievalues[10];}?>">
    </p>
    <p>
    <strong style="display: table; margin-bottom: 5px"><?php echo __('BloodType', 'ebakim-wp'); ?></strong>
    <select name="bloodType" id="bloodType">
        <?php 
         $bloodType=array("0"=>"Select...", "A Rh+"=>"A Rh+", "A Rh-"=>"A Rh-", "A Rh"=>"A Rh", "AB Rh-"=>"AB Rh-", "O Rh+"=>"O Rh+", "0 RH -"=>"0 RH -");
         foreach($bloodType as $cnt => $cntval)
         {
        ?>
        <option value="<?php echo $cnt;?>" <?php if(@$cookievalues[9]==$cnt) { echo "selected"; }?>><?php echo $cntval;?></option>
        <?php 
         }
         ?>
    </select>
    </p>
    <p>
    <strong style="display: table; margin-bottom: 5px"><?php echo __('Social Security', 'ebakim-wp'); ?></strong>
    <select name="socialsecurity">
        <option value="">Please Select</option>
        <option value="SGK">SGK</option>
        <option value="GSS">GSS</option>
        <option value="ASHIM">ASHIM</option>
        <option value="Yurtdisi">Yurtdisi</option>
        <option value="Bagkur">Bagkur</option>
        <option value="Emekli">Emekli</option>
        <option value="Yaslilik ayligi">Yaslilik ayligi</option>
        <option value="Olum ayligi">Olum ayligi</option>
        <option value="Yesil Kart">Yesil Kart</option>
        <option value="Yok">Yok</option>
        <option value="Diğer">Diğer</option>
    </select>
    </p>
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Allergy', 'ebakim-wp'); ?></strong>
        <input required type="text" class="widefat" name="allergy" placeholder="Allergy" value="">
    </p>
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Age', 'ebakim-wp'); ?></strong>
        <input required type="text" class="widefat" id="age" name="age" placeholder="Age" value="<?php if(isset($cookievalues[10])) {echo $cookievalues[11];}?>">
    </p>
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Physician name', 'ebakim-wp'); ?></strong>
        <input required type="text" class="widefat" id="physicianname" name="physicianname" placeholder="Physician name" value="<?php if(isset($cookievalues[10])) {echo $cookievalues[12];}?>">
    </p>
    <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Health centre', 'ebakim-wp'); ?></strong>
        <input required type="text" class="widefat" id="healthcentre" name="healthcentre" placeholder="Health centre" value="<?php if(isset($cookievalues[10])) {echo $cookievalues[13];}?>">
    </p>
    <p>
        <h3>Institution Information</h3>
    </p>
    <p>
    <strong style="display: table; margin-bottom: 5px"><?php echo __('Patient Group', 'ebakim-wp'); ?></strong>
    <select name="patientgroup">
        <option value="">Please Select</option>
        <option value="Erkek bedensel 1">Erkek bedensel 1</option>
        <option value="Erkek bedensel 2">Erkek bedensel 2</option>
        <option value="Kadın bedensel 3">Kadın bedensel 3</option>
        <option value="Kadın bedensel 4">Kadın bedensel 4</option>
        <option value="Erkek ruhsal 1">Erkek ruhsal 1</option>
        <option value="Erkek ruhsal 2">Erkek ruhsal 2</option>
        <option value="Kadin ruhsal 3">Kadin ruhsal 3</option>
        <option value="Kadin ruhsal 4">Kadin ruhsal 4</option>
    </select>
    </p>
    <p>
    <strong style="display: table; margin-bottom: 5px"><?php echo __('Sorumlu Meslek Elemani', 'ebakim-wp'); ?></strong>
    <select name="sorumlumeslekelemani">
        <option value="">Please Select</option>
    </select>
    </p>
    <p>
    <strong style="display: table; margin-bottom: 5px"><?php echo __('Sorumlu Saglik Personeli', 'ebakim-wp'); ?></strong>
    <select name="sorumlusaglikpersoneli">
        <option value="">Please Select</option>
    </select>
    </p>
    <p>
    <strong style="display: table; margin-bottom: 5px"><?php echo __('Sorumlu Mudur', 'ebakim-wp'); ?></strong>
    <select name="sorumlumudur">
        <option value="">Please Select</option>
    </select>
    </p>
    <p>
    <strong style="display: table; margin-bottom: 5px"><?php echo __('Degelendiren Personel', 'ebakim-wp'); ?></strong>
    <select name="degelendirenpersonel">
        <option value="">Please Select</option>
    </select>
    </p>
        <p>
            <input type="submit" id="genelbilglier" name="genelbilglier" class="button button-primary" value="Save">
         </p>
    </div><!-- Tab1 content area div end here-->
    <div id="tab2" class="tab-content">
      <h2>Dante Hicks</h2>
      <p>"My friend here's trying to convince me that any independent contractors who were working on the uncompleted Death Star were innocent victims when it was destroyed by the Rebels."</p>
    </div>
    <div id="tab3" class="tab-content">
      <h2>Randall Graves</h2>
      <p>"In light of this lurid tale, I don't even see how you can romanticize your relationship with Caitlin. She broke your heart and inadvertently drove men to deviant lifestyles."</p>
    </div>
   
  </div> <!-- END tabs-content -->
  </form>
</div> <!-- END tabs -->

</div>
<script>
    $(document).ready(function() {
        const validationRegex = {
            patientID: /^[A-Za-z0-9_-]+$/,
            patientFullName: /^[A-Za-z\s]+$/,
            patientBirthDate: /^\d{4}-\d{2}-\d{2}$/,
            patientTcNumber: /^\d+$/,
            clinicAcceptanceDate: /^\d{4}-\d{2}-\d{2}$/,
            clinicPlacementType: /^[A-Za-z\s]+$/,
            clinicPlacementStatus: /^[A-Za-z\s]+$/,
            clinicEndDate: /^\d{4}-\d{2}-\d{2}$/,
            clinicLifePlanDate: /^\d{4}-\d{2}-\d{2}$/,
            clinicEskrDate: /^\d{4}-\d{2}-\d{2}$/,
            clinicGuardianDate: /^\d{4}-\d{2}-\d{2}$/,
            clinicAllowanceStatus: /^[A-Za-z\s]+$/,
        };

        const validationMessages = {
            patientID: '<?php echo __('Invalid format for Patient ID. Use letters, numbers, underscores, and hyphens.', 'ebakim-wp'); ?>',
            patientFullName: '<?php echo __('Please enter a valid full name.', 'ebakim-wp'); ?>',
            patientBirthDate: '<?php echo __('Please enter a valid birthdate in the format YYYY-MM-DD.', 'ebakim-wp'); ?>',
            patientTcNumber: '<?php echo __('Please enter a valid T.C. number.', 'ebakim-wp'); ?>',
            clinicAcceptanceDate: '<?php echo __('Please enter a valid clinic acceptance date in the format YYYY-MM-DD.', 'ebakim-wp'); ?>',
            clinicPlacementType: '<?php echo __('Please enter a valid clinic placement type.', 'ebakim-wp'); ?>',
            clinicPlacementStatus: '<?php echo __('Please enter a valid clinic placement status.', 'ebakim-wp'); ?>',
            clinicEndDate: '<?php echo __('Please enter a valid clinic end date in the format YYYY-MM-DD.', 'ebakim-wp'); ?>',
            clinicLifePlanDate: '<?php echo __('Please enter a valid clinic life plan date in the format YYYY-MM-DD.', 'ebakim-wp'); ?>',
            clinicEskrDate: '<?php echo __('Please enter a valid clinic ESKR date in the format YYYY-MM-DD.', 'ebakim-wp'); ?>',
            clinicGuardianDate: '<?php echo __('Please enter a valid clinic guardian date in the format YYYY-MM-DD.', 'ebakim-wp'); ?>',
            clinicAllowanceStatus: '<?php echo __('Please enter a valid clinic allowance status.', 'ebakim-wp'); ?>',
        };

        $('input[name]').keyup(function() {
            const fieldName = $(this).attr('name');
            const value = $(this).val();
            const regex = validationRegex[fieldName];
            const errorMessage = value === '' ? 'Field is required' : (regex.test(value) ? '' : validationMessages[fieldName]);
            $(this).siblings('.error-message').text(errorMessage);
        });
    });
</script>

<?php include(__DIR__ . '/../templates/footer.php'); ?>