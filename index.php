<?php
require "vendor/autoload.php";

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use \RuntimeException;

$url = "http://www.bi.go.id/id/moneter/informasi-kurs/transaksi-bi/Default.aspx";
// $url = "http://localhost/kurs/kurs.html";

$client = new Client();
$request = $client->createRequest('GET', $url);
$response = $client->send($request);

$data = [];
$crawler = new Crawler((string)$response->getBody(true));
$crawler->filter('table#ctl00_PlaceHolderMain_biWebKursTransaksiBI_GridView1 > tr')
	->each(
			function(Crawler $node, $i) use(& $data) { 
				$d = [];
				if($i > 0) {
					$node->filter('td')->each(function(Crawler $item, $j) use(&$data, &$d) {
						if($j == 0)
							$d['mata_uang'] = $item->text();
						if($j == 2)
							$d['jual'] = $item->text();
						if($j == 3)
							$d['beli'] = $item->text();
					});
					$data[] = $d;
				}
			}
		);

echo json_encode($data);
?>