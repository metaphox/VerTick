<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"></p>
	<?php
		return;
	}

# You can start editing here. -->

	if ( have_comments() ) : ?>
	<h3 id="comments"><span class="cnt"><?php comments_number(_tc('尚无评论'), _tc('1则评论'), _tc('%则评论') );?></span></h3>
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
	<ol class="commentlist">
	<?php wp_list_comments('type=comment&callback=mytheme_comment'); ?>
	</ol>
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
 <?php else : // this is displayed if there are no comments so far ?>
	<?php if ( comments_open() ) : ?>
		<p class="nocomments"><?php echo _tc('尚无评论') ?></p>
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php echo _tc('评论功能已关闭') ?></p>
	<?php endif; ?>
<?php endif; ?>
<?php if ( comments_open() ) : ?>
<div id="respond" class="clearfix">
<h3><?php comment_form_title(_tc('评论'), _tc('给%s留言')); ?></h3>
<div class="cancel-comment-reply">
	<small><?php cancel_comment_reply_link(); ?></small>
</div>
<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
<p><?php echo _tc('您必须'); ?><a href="<?php echo wp_login_url( get_permalink() ); ?>"><?php echo _tc('登入') ?></a><?php echo _tc("后方可留言") ?></p>
<?php else : ?>
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<?php if ( is_user_logged_in() ) : ?>
<p><?php echo _tc('以') ?><a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a><?php echo _tc('身份登入') ?>。<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php echo _tc('登出') ?>&raquo;</a></p>

<?php else : ?>

<p id="author-para"><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="12" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
<label for="author"><small><?php echo _tc('姓名') ?><span class="commenthint"><?php if ($req) echo _tc("必填"); ?></span></small></label></p>
<p id="email-para"><input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="12" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
<label for="email"><small><?php echo _tc('电子邮件地址') ?><span class="commenthint"><?php if ($req) echo _tc('必填'); ?></span></small></label></p>
<p id="url-para"><input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="12" tabindex="3" />
<label for="url"><small><?php echo _tc('网站') ?></small></label></p>

<?php endif; ?>

<p><textarea name="comment" id="comment" cols="80" rows="20" tabindex="4"></textarea></p>
<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php echo _tc('提交') ?>" /></p>
<?php comment_id_fields(); ?>
<?php do_action('comment_form', $post->ID); ?>
</form>

<?php endif; // If registration required and not logged in ?>
</div>

<?php endif; // if you delete this the sky will fall on your head ?>
