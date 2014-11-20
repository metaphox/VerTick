<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=utf-8" />
<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<!--[if IE]>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/fixie.css" type="text/css" media="screen" />
<![endif]-->
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<script charset="utf-8" type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.js"></script>
<script charset="utf-8" type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/nehan.js"></script>
<script charset="utf-8" type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/various.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	vertilizeArticleH2();
  	Nehan.LayoutMapper.start("div", {
    		charImgRoot:"<?php echo get_template_directory_uri() . ( get_option('vertick_punc') == 'traditional' ? '/images/traditional' : '/images/modern') ?>",
    		<?php
    		$fontStack = array(
    			//tweak here if you dislike simplified chinese fonts
    			"Song"	=> 'fontFamily: "STSong, Hiragino Mincho Pro, LiSong Pro, MS Mincho, SimSun, WenQuanYi Micro Hei Mono"',
				"Hei"	=> 'fontFamily: "Hiragino Sans GB, Hiragino Kaku Gothic Pro, LiHei Pro, Microsoft YaHei, SimHei, WenQuanYi Micro Hei Mono"',
				"FangSong" => 'fontFamily: "STFangSong, FangSong, MS Mincho, SimSun, WenQuanYi Micro Hei Mono"',
				"Kai"	=> 'fontFamily: "STKaiti, KaiTi, WenQuanYi Micro Hei Mono"'
			);
			$fs = get_option('vertick_fontstack');
			echo $fs ? $fontStack[$fs] : $fontStack['Song'];
    		?>
  	});
	<?php $cmtelmt = is_singular() ? '#comments span.cnt' : '.commentscounter a'; ?> 
	$('<?php echo $cmtelmt ?>').each(function(){
		var ze = $(this).text().indexOf('<?php echo _tc('则') ?>');
		if(ze>0){
			$(this).text(ch_num_l1k($(this).text().substring(0, ze))+
				$(this).text().substring(ze, $(this).text().length));
		}
	});	
});
</script>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page">

<div id="header" role="banner">
	<div id="headerimg">
		<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
		<div class="description lp-vertical lp-width-80 lp-height-210 lp-font-size-20"><?php bloginfo('description'); ?></div>
	</div>
</div>
