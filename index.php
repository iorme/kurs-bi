<?php
require('./phpQuery/phpQuery.php');

$html = @file_get_contents('http://www.bi.go.id/web/en/Moneter/Kurs+Bank+Indonesia/Kurs+Transaksi/');
// $html = @file_get_contents('http://localhost/rate/tes.html');

phpQuery::newDocumentHTML($html, $charset = 'utf-8'); 
$tables = pq('table[bgcolor="#cccccc"]');
$data = array();

foreach ($tables as $table){
	$i = 0;
  	foreach(pq($table)->find('tr') as $tr) {
  		if($i > 1) {
	  		$d = array();
	  		foreach (pq($tr)->find('td') as $td) {
	  			$d[] = pq($td)->text();
	  		}
	  		$data[] = array('kurs' => $d);
	  	}
  		$i++;
	}
}
phpQuery::unloadDocuments();
echo "<pre>";print_r($data);echo "</pre>";die;
?>