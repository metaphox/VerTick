<?php get_header(); ?>

	<div id="content" role="main">

	<?php if (have_posts()) : ?>

 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h2 class="pagetitle"><?php single_cat_title(); echo _tc("存档") ?></h2>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h2 class="pagetitle"><?php single_tag_title(); echo _tc("标签存档") ?></h2>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle"><?php echo date_translate(get_post_time("Y|F|j", false, null, true)); echo _tc("存档") ?></h2>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle"><?php echo date_translate(get_post_time("Y|F|0", false, null, true)); echo _tc("存档") ?></h2>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle"><?php echo date_translate(get_post_time("Y|0|0", false, null, true)); echo _tc("存档") ?></h2>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle"><?php echo _tc("作者存档") ?></h2>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="pagetitle"><?php echo _tc("存档") ?></h2>
 	  <?php } ?>


		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo;'._tc("旧")) ?></div>
			<div class="alignright"><?php previous_posts_link(_tc("新").'&raquo;') ?></div>
		</div>
		<?php while (have_posts()) : the_post(); ?>
		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<div class="posttitle">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<small><span class="author"><?php echo get_the_author() ?></span><br />于<br /><?php
			 	// there is a data_i18n function in wordpress but it needs you to setup locale.
			 	echo date_translate(the_date('Y|F|j', '', '', FALSE));
			?></small>
			<p class="postmetadata">
				<span class="tags"><?php the_tags(_tc('标签'), ' ', '<br />'); ?></span><span class="category"><?php the_category(' ') ?></span><span class="editpostlink"><?php edit_post_link(_tc('编辑'), '', ''); ?></span><span class="commentscounter"><?php comments_popup_link(_tc('无人置评'), _tc('1则评论'), _tc('%则评论'), _tc('评论链接'), _tc('不可评论')); ?></span>
			</p>
			</div>
			<div class="entry lp-vertical lp-width-720 lp-height-450 lp-font-size-16"><?php the_content('Read the rest of this entry &raquo;'); ?></div>
		</div>
	<?php endwhile; ?>
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo;'._tc("旧")) ?></div>
			<div class="alignright"><?php previous_posts_link(_tc("新").'&raquo;') ?></div>
		</div>
	<?php else :

		if ( is_category() ) { // If this is a category archive
			printf("<h2 class='center'>"._tc('抱歉，这个分类尚无任何文章')."</h2>", single_cat_title('',false));
		} else if ( is_date() ) { // If this is a date archive
			echo("<h2 class='center'>"._tc('抱歉，这一日期范围内尚无任何文章')."</h2>");
		} else if ( is_author() ) { // If this is a category archive
			$userdata = get_userdatabylogin(get_query_var('author_name'));
			printf("<h2 class='center'>"._tc('抱歉，%s尚未发布任何文章')".</h2>", $userdata->display_name);
		} else {
			echo("<h2 class='center'>"._tc('抱歉，未找到任何文章')."</h2>");
		}
		get_search_form();

	endif;
?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
