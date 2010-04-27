<?php

// $datestring should be pipe delimited
function date_translate($datestring){
	$monthdict = array(
		'january' => '一月', 'february' => '二月', 'march' => '三月', 'april' => '四月', 'may' => '五月',
		'june'	=> '六月', 'july'	=> '七月', 'august'	=> '八月', 'september' => '九月', 'october' => '十月',
		'november'	=> '十一月', 'december' => '十二月'
	);
	
	$daydict = array(
		'0',
		'一日', '二日', '三日', '四日', '五日', '六日', '七日', '八日', '九日', '十日', '十一日', '十二日',
		'十三日', '十四日', '十五日', '十六日', '十七日', '十八日', '十九日', '廿日', '廿一日', '廿二日',
		'廿三日', '廿四日', '廿五日', '廿六日', 	'廿七日', '廿八日', '廿九日', '卅日', '卅一日'
	);
	
	$yeardict = array(
		'〇', '一', '二', '三', '四', '五', '六', '七', '八', '九'
	);
	
	$date = explode('|', $datestring);
	
	return str_replace(array('0', '1', '2','3','4','5','6','7','8','9'),
		$yeardict, $date[0]).'年'.$monthdict[strtolower($date[1])].$daydict[$date[2]];
}

function ch_num_l1k($num) {
	if($num > 9999) return '上万';
	$num = sprintf("%04u", $num); //unsigned int stuffed with 0 leftside
	$cnnumber = array('〇', '一', '二', '三', '四', '五', '六', '七', '八', '九');
 	$cnunit = array('千', '百', '十', '');
	$seennil = false; $seensth = false;
	$r = array();
	for($i=0;$i<4;$i++){
		$n = substr($num, $i, 1);
		if($n=='0'){
			if($seensth and !$seennil){ //put 0 if there werent any
				$r[] = $cnnumber[0];
				$seennil=true;				
			}
		}else{
			$r[] = $cnnumber[$n];
			$r[] = $cnunit[$i];
			$seensth = true;
		}
	}
	while(end($r) == $cnnumber[0]){
		array_pop($r);
	}
	return implode($r) ? implode($r) : $cnnumber[0];
}

if ( function_exists('register_sidebar') )
    register_sidebar();
?>
