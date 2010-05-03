<?php
if ( function_exists('register_sidebar') )
	register_sidebar(array(
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget' => '</li>',
			'before_title' => '',
			'after_title' => '',
		));
add_action('admin_menu', 'vertick_add_admin');
$themename = "VerTick";
$shortname = "vertick";

$options = array (
	array( "name" => "Punctuations",
		"desc" => "Traditional chinese punctuations keeps generally everything in centre, while simplified has several right aligned.",
		"id" => $shortname."_punc",
		"type" => "select",
		"std" => "traditional",
		"options" => array(
			"traditional",
			"simplified"
		)),

	array( "name" => "Font Stack",
		"desc" => "Select the font stack you want to use. Song is the safest choice, Hei should be okay as well. The other two looks very crappy on windows.",
		"id" => $shortname."_fontstack",
		"type" => "select",
		"std" => "Song",
		"options" => array(
			"Song",
			"Hei",
			"FangSong",
			"Kai"
		)),
	array(  "name" => "Use traditional Chinese?",
		"desc" => "Check this option if you think simplified chinese is shit.",
		"id" => $shortname."_tc",
		"type" => "checkbox",
		"std" => "false")

);

function vertick_add_admin()
{
	global $themename, $shortname, $options;
	if ( isset($_GET['page']) and $_GET['page'] == basename(__FILE__) and isset($_REQUEST['action']) and 'save' == $_REQUEST['action'] ) {
		foreach ($options as $value) {
			if (isset($_REQUEST[ $value['id'] ])) update_option( $value['id'], $_REQUEST[ $value['id'] ] );
		}
		foreach ($options as $value) {
			if ( isset( $_REQUEST[ $value['id'] ] ) ) {
				update_option( $value['id'], $_REQUEST[ $value['id'] ]  );
			} else {
				delete_option( $value['id'] );
			}
		}
		header("Location: themes.php?page=functions.php&saved=true");
		die;
	}
	add_theme_page($themename." Options", "".$themename." Options", 'edit_themes', basename(__FILE__), 'vertick_admin');
}

function vertick_admin()
{
	global $themename, $shortname, $options;
	if ( isset($_REQUEST['saved']) ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
?>
<div class="wrap">
<h2><?php echo $themename; ?> settings</h2>
<div>
<form method="post">
<?php
	foreach ($options as $value) {
		switch ( $value['type'] ) {
		case 'select': ?>
		<h3><?php echo $value['name']; ?></h3>
		<select style="width:240px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
		<?php foreach ($value['options'] as $option) { ?>
				<option<?php if ( get_option( $value['id'] ) == $option) {
					echo ' selected="selected"';
				} elseif ($option == $value['std']) {
					echo ' selected="selected"';
				}?>><?php echo $option; ?></option>
		<?php } ?></select>
		<br /><p><?php echo $value['desc']; ?></p>
		<?php break;

		case "checkbox":?>
		<h3><?php echo $value['name']; ?></h3>
		<?php if (get_option($value['id'])) {
				$checked = 'checked="checked"';
			}else { $checked = ""; } ?>
			<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
		    <label for="<?php echo $value['id']; ?>"><?php echo $value['desc']; ?></label>
		<?php break;
		}
	}
?>
<p class="submit">
	<input name="save" type="submit" value="Save changes" />
	<input type="hidden" name="action" value="save" />
</p>
</form>
</div>
<?php
}

function mytheme_comment($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>">
      <div class="comment-author vcard">
      <?php echo get_avatar($comment, $size='48'); ?>
	  <div class="comment-meta">
	  		<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php
	echo date_translate(get_comment_date('Y|F|j'))
	?></a><?php
	edit_comment_link(_tc('编辑'), '  ', '')
	?></div><?php
	printf('<span class="commentor">%s</span>', get_comment_author_link())
	?></div>

	  <div class="commenttext lp-vertical lp-width-550 lp-height-350 lp-font-size-14"><?php
	if ($comment->comment_approved == '0') :
		?><strong><?php echo _tc('（此评论等待作者许可）') ?></strong><br /><br /><?php
		endif;
	comment_text()
	?></div>
      <div class="reply">
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>
     </div>
<?php
}

// $datestring should be pipe delimited, in the order of y m d, e.g.:
// due to the restriction of the_date() --http://codex.wordpress.org/Template_Tags/the_date
// a global $ is used for holding the date of previous date translation
$vertick_prev_datetranslation = "某年某月某日";
function date_translate($datestring)
{
	global $vertick_prev_datetranslation;
	if(!$datestring) return $vertick_prev_datetranslation;
	$monthdict = array(
		'0' => "",
		'january' => '一月', 'february' => '二月', 'march' => '三月', 'april' => '四月', 'may' => '五月',
		'june' => '六月', 'july' => '七月', 'august' => '八月', 'september' => '九月', 'october' => '十月',
		'november' => '十一月', 'december' => '十二月', 
	);

	$daydict = array(
		'',
		'一日', '二日', '三日', '四日', '五日', '六日', '七日', '八日', '九日', '十日', '十一日', '十二日',
		'十三日', '十四日', '十五日', '十六日', '十七日', '十八日', '十九日', '廿日', '廿一日', '廿二日',
		'廿三日', '廿四日', '廿五日', '廿六日',  '廿七日', '廿八日', '廿九日', '卅日', '卅一日'
		);

	$yeardict = array(
		'〇', '一', '二', '三', '四', '五', '六', '七', '八', '九'
	);

	$date = explode('|', $datestring);

	$year = $date[0] == 0 ? "" : str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $yeardict, $date[0]).'年';
	$chdate = $year . $monthdict[strtolower($date[1])].$daydict[$date[2]];
	$vertick_prev_datetranslation = $chdate;
	return $chdate;
}

function ch_num_l1k($num)
{
	if ($num > 9999) return _tc('上万');
	$num = sprintf("%04u", $num); //unsigned int stuffed with 0 leftside
	$cnnumber = array('〇', '一', '二', '三', '四', '五', '六', '七', '八', '九');
	$cnunit = array('千', '百', '十', '');
	$seennil = false; $seensth = false;
	$r = array();
	for ($i=0;$i<4;$i++) {
		$n = substr($num, $i, 1);
		if ($n=='0') {
			if ($seensth and !$seennil) { //put 0 if there werent any
				$r[] = $cnnumber[0];
				$seennil=true;
			}
		}else {
			$r[] = $cnnumber[$n];
			$r[] = $cnunit[$i];
			$seensth = true;
		}
	}
	while (end($r) == $cnnumber[0]) {
		array_pop($r);
	}
	return implode($r) ? implode($r) : $cnnumber[0];
}

$chinesehant = array(
	'上万' => '上萬',
	'标签' => '標籤',
	'分类' => '分類',
	'于' => '於',
	'无人置评' => '無人置評',
	'编辑' => '編輯',
	'1则评论' => '1則評論',
	'%则评论' => '%則評論',
	'评论链接' => '評論鏈接',
	'不可评论' => '不可評論',
	'旧' => '舊',
	'无内容' => '無內容',
	'抱歉，您寻找的东西不在这里。' => '抱歉，您尋找的東西不在這裡。',
	'阅读全文' => '閱讀全文',
	'则' => '則',
	'页面' => '分頁',
	'存档' => '存檔',
	'标签存档' => '標籤存檔',
	'作者存档' => '作者存檔',
	'抱歉，这个分类尚无任何文章' => '抱歉，這個分類尚無任何文章',
	'抱歉，这一日期范围内尚无任何文章' => '抱歉，這一日期範圍內尚無任何文章',
	'抱歉，%s尚未发布任何文章' => '抱歉，%s尚未發布任何文章',
	'抱歉，未找到任何文章' => '抱歉，未找到任何文章',
	'评论功能已关闭' => '評論功能已關閉',
	'评论' => '評論',
	'给%s留言' => '給%s留言',
	'您必须' => '您必須',
	'登入' => '登入',
	'后方可留言' => '後方可評論',
	'网站' => '網站',
	'电子邮件地址' => '電子郵件地址',
	'姓名' => '姓名',
	'必填' => '必填',
	'提交' => '提交'				
);

function _tc($sc){
	global $chinesehant;
	if(!get_option('vertick_tc') or !isset($chinesehant[$sc])) return $sc;
	return $chinesehant[$sc];
}
?>
