
//add keyword meta to header of single page
function add_meta_tags() {
  echo '<meta name="keywords" content="'.getkeyword(get_the_title()).'">';
}
add_action('wp_head', 'add_meta_tags');



//Get google suggestions
function getkeyword($keyword) 
{
    $keywords = array();
    $data = get_data('http://suggestqueries.google.com/complete/search?output=firefox&client=firefox&hl=en-US&q='.urlencode($keyword));
   
    if (($data = json_decode($data, true)) !== null) {
        $keywords = $data[1];
    }
    
    $string = '';
    $i = 1;
    foreach ($keywords as $k) 
    {
        $string .= $k . ', ';
        if ($i++ == 10) break;
    }
    return $string;
}

//curl for get data from google
function get_data($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
