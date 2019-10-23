<?php
set_include_path(get_include_path() . PATH_SEPARATOR . getcwd() . '/phpseclib');

include('Crypt/RSA.php');

class TPLinkCameraControler
{
	// Request vars
    var $m_curl;
	var $m_username;
	var $m_password;
	var $m_base_url;
	var $cookieFile;
	var $DEBUG;

    function __construct($username, $password, $base_url)
	{
		$this->m_username = $username;
		$this->m_password = $password;
		$this->m_base_url = $base_url;

		$this->m_curl = curl_init();
		$this->cookieFile = tempnam ("tmp", "CURLCOOKIE");
		curl_setopt($this->m_curl, CURLOPT_HEADER, false);
		curl_setopt($this->m_curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->m_curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));

		$this->DEBUG = false;

    }

    function __destruct()
	{
       if($this->m_curl)
	   {
			curl_close($this->m_curl);
			$this->m_curl = NULL;
	   }
    }

    function printLog($log)
    {
    	if($this->DEBUG)
    	{
    		echo $log;
    	}
    }

 	function tp_encrypt($password)
	{
	    $a = 'RDpbLfCPsJZ7fiv';
	    $c = 'yLwVl0zKqws7LgKPRQ84Mdt708T1qQ3Ha7xv3H7NyU84p21BriUWBU43odz3iP4rBL3cD02KZciXTysVXiV8ngg6vL48rPJyAUw0HurW20xqxv9aYb4M9wK1Ae0wlro510qXeU07kV57fQMc8L6aLgMLwygtc0F10a0Dg70TOoouyFhdysuRMO51yY5ZlOZZLEal1h0t9YQW0Ko7oBwmCAHoic4HYbUyVeU3sfQ1xtXcPcf1aT303wAQhv66qzW';
	    $b = $password;
	    $e = '';
	    $f = 0;
	    $g = 0;
	    $h = 0;
	    $k = 0;
	    $l = 187;
	    $n = 187;
	    $g = strlen($a);
	    $h = strlen($b);
	    $k = strlen($c);
	    
	    if($g > $h)
	    {
	        $f = $g;
	    }
	    else
	    {
	        $f = $h;
	    }

	    for($p = 0 ; $p < $f ; $p++)
	    {    
	        $n = $l = 187;

	        if($p >= $g)
	        {
	            $n = ord($b[$p]);
	        }
	        else
	        {
	            if($p >= $h)
	            {
	                $l = ord($a[$p]);
	            }
	            else
	            {
	                $l = ord($a[$p]);
	                $n = ord($b[$p]);
	            }
	        }

	        $e .= $c[($l ^ $n) % $k];
	    }

	    return $e;
	}

	function rsa_encrypt($string, $key)
	{
		
	  $rsa = new Crypt_RSA();
	  $rsa->loadKey("-----BEGIN PUBLIC KEY-----\n" . urldecode($key) . "\n-----END PUBLIC KEY-----"); 
	  $rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
	  $crypttext = $rsa->encrypt($string);

	  return(base64_encode($crypttext));
	}

	function post_data($data, $stok="")
	{
	    $url = $this->m_base_url . (strlen($stok) > 0 ? ("/stok=" . $stok . "/ds") : "");
	    $this->printLog("post: " . $url . " data: " . $data . "\n");

	    curl_setopt($this->m_curl, CURLOPT_URL, $url);
		curl_setopt($this->m_curl, CURLOPT_POST, true);
		curl_setopt($this->m_curl, CURLOPT_POSTFIELDS, $data);
		$respond = curl_exec($url = $this->m_curl);

		$this->printLog('respond: ' . $respond . "\n");

	    return json_decode($respond, true);
	}

	function get_stok()
	{
	    #get key nonce
	    $tp_password = '';
	    $this->printLog("\n\n-get rsa and nonce" . "\n");
	    $j = $this->post_data('{"method": "do", "login": {}}');
	    $key = $j['data']['key'];
	    $nonce = $j['data']['nonce'];
	    $this->printLog("rsa: " . $key . "\n");
	    $this->printLog("nonce: " . $nonce . "\n");

	    # encrypt tp
	    $this->printLog("\n\n--encrypt password by tp" . "\n");
	    $tp_password = $this->tp_encrypt($this->m_password) . ":" . $nonce;;
	    $this->printLog("tp_password: " . $tp_password . "\n");

	    # rsa password
	    $this->printLog("\n\n--encrypt password by rsa" . "\n");
	    $rsa_password = $this->rsa_encrypt($tp_password, $key);
	    $this->printLog("rsa_password: " . $rsa_password . "\n");

	    # login
	    $d['method'] = "do";
	    $d['login']['username'] = $this->m_username;
	    $d['login']['encrypt_type'] = "2";
	    $d['login']['password'] = $rsa_password;

	    $this->printLog("\n\n--login" . "\n");
	    $j = $this->post_data(json_encode($d));
	    $stok = $j["stok"];
	 
	    return $stok;
	}

	function doRequest($data)
	{

		$stok = $this->get_stok();

		if(strlen($stok) > 0)
		{
    		$this->post_data($data, $stok);
		}

	}

 
}

?>
