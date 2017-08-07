<?php
error_reporting(0);
function url_check($url) {
    $headers = @get_headers($url);
    return is_array($headers) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$headers[0]) : false;
};

  function get_links($url) {

        // Create a new DOM Document to hold our webpage structure
        $xml = new DOMDocument();

        // Load the url's contents into the DOM

        $xml->loadHTMLFile($url);

        // Empty array to hold all links to return
        $links = array();

        //Loop through each <a> tag in the dom and add it to the link array
        foreach ($xml->getElementsByTagName('a') as $link) {
            $url = $link->getAttribute('href');
            if (!empty($url)) {
                $links[] = $link->getAttribute('href');
            }
        }

        //Return the links
        return $links;
    }

$search = "sukasuka";
$searchs = urlencode($search);
for($i=0;$i<=1000;$i+=10){
$url = "https://www.google.com/search?q=$searchs&start=$i&ie=utf-8&oe=utf-8";
$k = get_links($url);
$l = json_encode($k);

$z = explode('url?q=',$l);
foreach($z as $o){
if(preg_match('/googleusercontent/',$o)){
	$x = explode('%25',$o);
	$a = explode(':',$x[0]);
	$urls = $a[2];
}else{
	$x = explode('&sa',$o);
	$urls = $x[0];
}
$urls = str_replace('\/','/',$urls);
$urls = urldecode($urls);
if(url_check($urls)){
print $urls;
echo"\r\n";
}else{
print $urls;
echo"\r\n";
}
}
}
?>
