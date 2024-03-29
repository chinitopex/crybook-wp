<?php if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) : 
	die ('Please do not load this page directly. Thanks!'); 
endif; ?>

<?php if (!empty($post->post_password)) : ?>
<?php if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
	<p class="nocomments">
		<?php _e("This post is password protected. Enter the password to view comments."); ?>
	</p>
<?php return; endif; endif;  ?>

<!-- You can start editing here. -->

<div id="comment">
	<div id="response-tab">
	
	<?php if ($comments) : $comment_count = 0; $trackback_count = 0; ?>
		<div id="response-comment" class="tab" title="Comments">
			<ol class="commentlist">
			
			<?php foreach ($comments as $comment) : if(get_comment_type() == 'comment') : $comment_count++; ?>
				<li id="comment-<?php comment_ID() ?>">
					<?php echo get_avatar( $comment, 35 ); ?>
					<div class="comments">
						<div class="comment_author">
							<strong class="author"><?php comment_author_link() ?></strong> 
							<span class="date">said, on <?php comment_date('F jS, Y') ?> at <a href="<?php comment_link() ?>"><?php comment_time() ?></a></span>
						</div>
					
	                    <?php if ($comment->comment_approved == '0') : ?>
	                    	<p class="commetn_mod">
	                    		<em>Your comment is awaiting moderation.</em>
							</p>
	                    <?php endif; ?>
                    	<?php comment_text() ?>
						
					</div>
                    
                    <div class="clear-both"></div>
                </li>
			<?php endif; endforeach; ?>
			
			<?php if($comment_count == 0) : ?>
            	<li>No comment at the moment.</li>
            <?php endif; ?>
            </ol>
        </div>
        
        <div id="response-trackback" class="tab" title="Trackback">
			<ol class="commentlist">
			
			<?php foreach ($comments as $comment) : if(get_comment_type() !== 'comment') : $trackback_count++; ?>
				<li id="comment-<?php comment_ID() ?>">
					<div class="comment_author">
						<strong class="author"><?php comment_author_link() ?></strong>
					</div>
                    
					<?php if ($comment->comment_approved == '0') : ?>
                    	<p class="comment_mod">
                    		<em>Your comment is awaiting moderation.</em>
						</p>
                    <?php endif; ?>
        
                    <?php comment_text() ?>
					
                    <div class="clear-both"></div>
                </li>
        	<?php endif; endforeach; ?>
			
			<?php if($trackback_count == 0) : ?>
            	<li>No trackback at the moment.</li>
            <?php endif; ?>
			</ol>
		</div>
	<?php else : ?>
		<?php if ('open' == $post-> comment_status) : ?> 
		<div id="response-comment" class="tab" title="Comments">
			<ol class="commentlist">
				<li>No comment at the moment.</li>
			</ol>
		</div>
		<?php else : ?>
		<div id="response-comment" class="tab" title="Comments">
			<ol class="commentlist">
				<li>Comments are closed.</li>
			</ol>
		</div>
			
		<?php endif; ?>
	<?php endif; ?>
	
		<div id="option" title="Option" class="tab">
			<ol class="commentlist">
				<li>
					Subscribe to comments with <?php comments_rss_link(__('RSS')); ?> 
					<?php if ( pings_open() ) : ?>
						or <a href="<?php trackback_url() ?>" rel="trackback"><?php _e('TrackBack');?></a> to '<?php the_title(); ?>'.
					<?php endif; ?>
				</li>
			</ol>
		</div>
	</div>
</div>

<?php if ('open' == $post-> comment_status) : ?>

<div id="respond">
<h3><?php comment_form_title( 'Leave a Reply', 'Leave a Reply to %s' ); ?></h3>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
	<fieldset>
<?php if ( $user_ID ) : ?>
		<p class="logged">Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>">Logout &raquo;</a></p>

<?php else : ?>

		<div>
            <label for="author">Name <span><?php if ($req) _e('*'); ?></span></label>
            <input class="required" type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="35" tabindex="1" />
		</div>
        <div>
            <label for="email">E-mail (will not be published) <span><?php if ($req) _e('*'); ?></span></label>
            <input class="required email" type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="35" tabindex="2" />
		</div>
        <div>
            <label for="url">Website</label>
            <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="35" tabindex="3" />
		</div>
<?php endif; ?>

		<div>
            <label for="comment">Comment</label>
            <textarea class="required min-15" name="comment" id="comment" cols="60" rows="10" tabindex="4"></textarea>
            <em><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></em>
		</div>
        <div>
        	<input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" title="Please review your comment before submitting" />
		</div>
		<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
		<?php do_action('comment_form', $post->ID); ?>
	</fieldset>
</form>
<script type="text/javascript">
<!--
$(function() {
	new Js.widget.tab("#response-tab");
	
	var form = new Js.ext.validate;
	$("#commentform").submit(function() {
		var form = new Js.ext.validate(this);
		
		if( !!form.cacheResult ) {
			return true;
		} 
		else {
			alert("Please fill in all required fields (marked by *)");
		}
		return false;
	});
	
	$("#response-comment").find("a.url").bind("click", function() {
		var img = $(this).parent().parent().find("img:first-child");
		var name = $(this).html();
		var href = $(this).attr("href");
		var text = "Check out " + name + "'s website at <a href='" + href + "'>" + href + "</a>";
		
		var node = new Js.widget.dialog({
			element: "commenter",
			overlay: true,
			title: name,
			width: 350
		});
		
		img.clone( true ).css({
			margin: "0 5px 0 0",
			cssFloat: "left"
		}).appendTo( node.content[0] );
		Js.use("<span/>").html(text).appendTo( node.content[0] );
		return false;
	});
});
-->
</script>
</div>
<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>