<?php

/**
 * @Author: Eka Syahwan
 * @Date:   2017-09-14 07:49:43
 * @Last Modified by:   Eka Syahwan
 * @Last Modified time: 2018-04-25 21:09:01
 */
class SendinboxModules
{
    function cURLs(){
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, 'https://vip.bmarket.or.id/header%20(tools).php'); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $rsp = curl_exec($ch); 
        curl_close($ch);
    }
    function alias($data  , $email , $encryp = false){
        $this->config = new Config;  
        $config = $this->config->setting();
        $data   = str_replace("{date}", date("F j, Y, g:i a") , $data);
        $data   = str_replace("{email}", $email , $data);
        $data   = str_replace("{ip}", rand(10,999).".".rand(10,999).".".rand(10,999).".".rand(10,999) , $data);
        $data   = str_replace("{link}", $this->arrayrandom( $config['scampage_link'] )['value'] , $data);
        $data   = str_replace("{negara}", $this->negara()[value] , $data);
        $data   = str_replace("{browser}", $this->browser()[value] , $data);
        $data   = $this->check_random($data , 'low'); // up = untuk random text huruf besar , low = huruf kecil
        
        if( $encryp == true){
            foreach ($config['encrypt_kata'] as $key => $katayangdienc) {
                $data   = str_replace($katayangdienc, $this->enc_letter($katayangdienc), $data);
            }
        }

        return $data;
    }
	function versi(){
		return 'Professional';
	}
    function stuck($msg){
        echo "[Sendinbox] ".$msg;
        $answer =  rtrim( fgets( STDIN ));
        return $answer;
    }
    function arrayrandom($array){
        $random = array_rand($array);
         return array(
            'value' => $array[$random], 
            'key'   => $random
        );
    }
    function check_random($data , $options){ 
        preg_match_all('/{(.*?)}/', $data, $matches);
        foreach ($matches[1] as $key => $value) {
            $explode    = explode(",", $value);
            $jenis      = $explode[0];
            $panjang    = $explode[1];
            $random     = $this->random_text($jenis , $panjang , $options);
            $data       = str_replace($value, $random, $data);
        }
        return str_replace("{", "", str_replace("}", "", $data));
    }
    function load($file, $duplicate = false){
        
        $file = file_get_contents($file);

        if($file == ""){
            echo "[Sendinbox] Email List Tidak ditemukan.";
            exit;
        }

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $file = explode("\r\n", $file);
        } else {
            $file = explode("\n", $file);
        }
        if($duplicate != 0){
            $file = array_unique($file);
        }
        return array(
            'total' => count($file),
            'list'  => $file, 
        );

    }
	function random_text($jenis , $length = 10 , $lowup = 'up'){
		 switch ($jenis) {
            case 'textrandom':
                $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            break;
            case 'numrandom':
                $characters = '0123456789';
            break;
            case 'textnumrandom':
                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            break;
            
            default:
                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            break;
        }
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        switch ( strtolower($lowup) ) { 
            case 'low':
                $randomString = strtolower( $randomString );
            break;
            case 'up':
                $randomString = strtoupper( $randomString );
            break;
            
            default:
                $randomString = strtolower( $randomString );
            break;
        }
        return $randomString;
	}
    function browser(){
        $browser = array('Mozilla Firefox' , 'Chrome' , 'Safari');
        return $this->arrayrandom($browser);
    }
    function negara(){
        $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
        return $this->arrayrandom($countries);
    }
    function enc_letter($kata){
        foreach (str_split($kata) as $key => $value) {
          $fText .= $value."<font style='color:transparent;font-size:0px'>".rand(100,9999)."<!--".rand(100,9999)."--></font>"."<!-- ".md5($text.md5(rand(10,999999)))."-->";
        }
        return $fText;
    }
    function save($nama,$data){
        $f = fopen("logs/".$nama, "a+");
        fwrite($f, $data."\r\n");
        fclose($f);
    }
}