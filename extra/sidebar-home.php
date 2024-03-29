<!--#sidebar:start-->
		<?php
			$feed_user = get_option('ci_feed_user');
			$feed_uri = "";
			$feed_service = get_option('ci_feed_service');
			$feed_email_uri = "";
			$feed_email_boolean = get_option('ci_feed_email');
			$feed_email_text = "";
			$feed_text = "";
			$feed_count_text = (get_option('ci_feed_enable') === 'yes' ? get_option('ci_feed_count') : '');
			
			if(!$feed_user or $feed_user == '') :
				$feed_uri = get_bloginfo('rss2_url');
			else :
				if($feed_service !== "google") :
					$feed_uri = 'http://feeds2.feedburner.com/' . $feed_user;
				else :
					$feed_uri = 'http://feedproxy.google.com/' . $feed_user;
				endif;
			endif;
			
			$feed_text = 'feed';
			
			if($feed_email_boolean == "yes") :
				$feed_email_uri = 'http://feedburner.google.com/fb/a/mailverify?uri='.$feed_user.'&amp;loc=en_US';
				$feed_text .= ' or e-mail';
			endif;
		?>
		<div id="sidebar" class="bigbox">
			<h3 class="closed"><?php echo ($feed_count_text != "" ? $feed_count_text." via " : ""); ?>Feed</h3>
			<p>
				<a href="#" id="feeds-a">You can get update via <?php echo $feed_text; ?></a>.
			</p>
			
			<script type="text/javascript">
			<!--
			jQuery(function($) {
				$("a#feeds-a").bind("click", function() {
					new Js.widget.dialog({
						element: "feeder",
						title: "Subscribe with Us Today",
						width: 560,
						content: '<p>Become a subscriber today via <a href="<?php echo $feed_uri; ?>">feed</a> <?php echo ($feed_email_boolean == "yes" ? " or  <a href=\"" . $feed_email_uri ."\">e-mail</a>" : ""); ?>.</p>',
						overlay: true

					});
				});
			});
			-->
			</script>
			
			<div class="box-separator"></div>
            <div class="col">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-left')) : ?>

			<?php endif; ?>
            </div>
            <div class="col2">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-right')) : ?>

			<?php endif; ?>
            </div>
        </div>
<!--#sidebar:end-->
		<div class="clear-right"></div>
