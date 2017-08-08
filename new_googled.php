<?php
include"simple_html_dom.php";
/**

	Reference://
(-) http://php.net/manual/en/domdocument.loadhtml.php
(-) http://www.indoxploit.or.id/2016/06/google-dorker-new.html

Tinggal kembangin lagi biar gak kena captcha

CHKID

**/

//error_reporting(0);
function url_check($url) {
    $headers = @get_headers($url);
    return is_array($headers) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$headers[0]) : false;
};

function save($file,$data){
        $fp = @fopen($file, "a") or die("cant open file");
        fwrite($fp, $data);
        fclose($fp);
}

function paging($numb){
	$c = strlen($numb);
	$a = $c-1;
	$l = substr($numb,0,$a);
	return $l;
}

  function get_links($url,$ua) {
	
	$option = array(
            'http' => array(
                'method' => 'GET',
                'header' => $ua,
            )
    );
    $context = stream_context_create($option);
    $simple_html_dom = new simple_html_dom();
    $simple_html_dom -> load_file($url, false, $context);
    return $simple_html_dom;
    }
    
$r = md5(rand(1000,9999));
if(!$argv[1]){
	$search = "asuwsa";	// Tulis manual disini jika tidak menggunakan argv
}else{
	$search = $argv[1];
}
$searchs = urlencode($search);
for($i=0;$i<=1000;$i+=10){
	if(!$i==0){
		$page = paging($i);
	}else{
		$page = 1;
	}
	echo"Page: $page\r\n";
	
	$ua = "User-Agent: Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)";

	$url = "http://localhost/lnxindo/lnx/z.php?search=$searchs&i=$i";
	/*$option = array(
            'http' => array(
                'method' => 'GET',
                'header' => $ua,
            )
    );
    $context = stream_context_create($option);
    $simple_html_dom = new simple_html_dom();
    $simple_html_dom -> load_file($url, false, $context);
    */
    $k = file_get_contents($url);
	
	$log = save($r.".log",$k);

	$z = explode('<h3 class="r"><a href="/url?q=',$k);
	foreach($z as $o){
			$a = explode('&amp',$o);
			$urls = $a[0];
		$urls = str_replace('\/','/',$urls);
		$urls = urldecode($urls);
		if(url_check($urls)){
			print $urls;
			save("/home/log/valid-urls.txt",$urls."\r\n");
			echo"\r\n";
		}else{
			save("/home/log/unknown-urls.txt",$urls."\r\n");
			#print $urls;
			#echo"\r\n";
		}
	}

}
?>
