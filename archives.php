<?php get_header(); ?>

<div id="content">

<?php get_search_form(); ?>

<h2><?php echo _tc("每月存档") ?></h2>
	<ul>
		<?php wp_get_archives('type=monthly'); ?>
	</ul>

<h2><?php echo _tc("分主题存档") ?></h2>
	<ul>
		 <?php wp_list_categories(); ?>
	</ul>

</div>

<?php get_footer(); ?>
