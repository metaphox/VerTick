<?php get_header(); ?>

	<div id="content" role="main">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="navigation clearfix">
			<div class="alignleft"><?php previous_post_link('&laquo; %link') ?></div>
			<div class="alignright"><?php next_post_link('%link &raquo;') ?></div>
		</div>

		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<div class="posttitle"><h2><?php the_title(); ?></h2>
			 	<small>
			 	<span class="author"><?php echo get_the_author() ?></span>于<br /><?php
			 		// there is a data_i18n function in wordpress but it needs you to setup loale.
			 		echo date_translate(date('Y|F|j')); 
			 		the_tags( '<p class="tags">', ', ', '</p>'); ?>			 	
				</small>
				<p class="postmetadata">
					<span class="tags"><?php the_tags('标签', ' ', '<br />'); ?></span>
			 	<span class="category"><?php the_category(' ') ?></span>
			 	<?php if(pings_open()){	?>
					<span class="commentscounter"><a href="<?php trackback_url(); ?>" rel="trackback">回应链接</a></span>
				<?php } 
					  if ( comments_open() ) { ?>
					<span class="commentscounter"><a href="#respond">评论</a></span>
				<?php } ?>
					<span class="editpostlink"><?php edit_post_link('编辑','',''); ?></span>
			 	</p>
			</div>
			<div class="entry lp-vertical lp-width-720 lp-height-450 lp-font-size-16"><?php
				//dont add space/return here
				the_content('<p class="serif">阅读全文</p>');
				wp_link_pages(array(
					'before' => '<p><strong>页面</strong> ',
					'after' => '</p>',
					'next_or_number' => 'number'
				));?>				
			</div>
		</div>
	<?php comments_template(); ?> 	
	<?php endwhile; else: ?>
		<p>无内容</p>
	<?php endif; ?>

	</div>
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>
