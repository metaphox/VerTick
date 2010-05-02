<?php get_header(); //echo test(); ?>
	<div id="content" role="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<div class="posttitle">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<small><span class="author"><?php echo get_the_author() ?></span><br /><?php echo _tc('于') ?><br /><?php
			 	// there is a data_i18n function in wordpress but it needs you to setup locale.
			 	echo date_translate(the_date('Y|F|j', '', '', FALSE));
			?></small>
			<p class="postmetadata">
				<span class="tags"><?php the_tags(_tc('标签'), ' ', '<br />'); ?></span><span class="category"><?php the_category(' ') ?></span><span class="editpostlink"><?php edit_post_link(_tc('编辑'), '', ''); ?></span><span class="commentscounter"><?php comments_popup_link(_tc('无人置评'), _tc('1则评论'), _tc('%则评论'), _tc('评论链接'), _tc('不可评论')); ?></span>
			</p>
			</div>
			<div class="entry lp-vertical lp-width-720 lp-height-450 lp-font-size-16"><?php the_content(_tc('阅读全文').' &raquo;'); ?></div>
		</div>
	<?php endwhile; ?>
	<div class="navigation">
		<div class="alignleft"><?php next_posts_link('&laquo;'. _tc('新')) ?></div>
		<div class="alignright"><?php previous_posts_link(_tc('旧').'&raquo;') ?></div>
	</div>
	<?php else : ?>
		<h2 class="center"><?php echo _tc('无内容') ?></h2>
		<p class="center"><?php echo _tc('抱歉，您寻找的东西不在这里。') ?></p>
		<?php get_search_form(); ?>
	<?php endif; ?>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
