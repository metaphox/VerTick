<?php get_header(); //echo test(); ?>
	<div id="content" role="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<div class="posttitle">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<small><span class="author"><?php echo get_the_author() ?></span><br />于<br /><?php
			 	// there is a data_i18n function in wordpress but it needs you to setup loale.
			 	echo date_translate(date('Y|F|j'));
			?></small>
			<p class="postmetadata">
				<span class="tags"><?php the_tags('标签', ' ', '<br />'); ?></span><span class="category"><?php the_category(' ') ?></span><span class="editpostlink"><?php edit_post_link('编辑', '', ''); ?></span><span class="commentscounter"><?php comments_popup_link('无人置评', '1则评论', '%则评论', 'comments-link', '不可评论'); ?></span>
			</p>
			</div>
			<div class="entry lp-vertical lp-width-720 lp-height-450 lp-font-size-16"><?php the_content('Read the rest of this entry &raquo;'); ?></div>
		</div>
	<?php endwhile; ?>
	<div class="navigation">
		<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
		<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
	</div>
	<?php else : ?>
		<h2 class="center">无内容</h2>
		<p class="center">抱歉，您寻找的东西不在这里。</p>
		<?php get_search_form(); ?>
	<?php endif; ?>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
