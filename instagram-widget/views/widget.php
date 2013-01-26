<div class="instagram-wp-widget">
<?php


function get_images($instance)
{
	$api = 'https://api.instagram.com/v1/users/'.$instance['userID'].'/media/recent?client_id='.$instance['clientID'].'&amp;access_token='.$instance['accessToken'];

	$images = array();
	$gotimages =false;

	$file = dirname(dirname(__FILE__)) . '/plugin.php';
	$plugin_path = plugin_dir_path($file);
	$cache = $plugin_path.'cache/instagram-cache.txt';



	if((file_exists($cache) &&  filemtime($cache) > time() - 60*60) && filesize($cache) > 1){
		$images = unserialize(file_get_contents($cache));

		$gotimages =true;
	}
	else  {

		$response = file_get_contents($api);

		$images = array();

		foreach(json_decode($response)->data as $item){

			$title = '';

			if($item->caption){
				$title = mb_substr($item->caption->text,0,70,"utf8");
			}

			$likes = $item->likes->count;

			$src = $item->images->low_resolution->url;

			$filter = $item->filter;
			
			$link = $item->link;

			$images[] = array(
				"title" => htmlspecialchars($title),
				"src" => htmlspecialchars($src),
				"filter" => htmlspecialchars($filter),
				"likes" => htmlspecialchars($likes),
				"link" => htmlspecialchars($link)
			);
		}

		array_pop($images);



		file_put_contents($cache, serialize($images));

		$gotimages =true;
	}

	$totalPages = count($images);

	$instaItems =array();

	return $images;

}
$i=0;
$endLimit = ( $instance['limit'] !='') ? $instance['limit']: 10;
$endLimit = $endLimit -1;

foreach(get_images($instance) as $i=>$image){
?>
	<a href="<?php echo $image['link']?>" target="_blank" class="instagram-wp-thumb" title="<?php echo $image['title']; ?><?php if ($image['likes'] >=1){ echo ' '.$image['likes']. ' Likes'; } ?>">
	  <img src="<?php echo $image['src']?>" alt="<?php echo $image['title']; ?>" >
	</a>
<?php
	if(++$i > $endLimit) break;
}

?>
</div>