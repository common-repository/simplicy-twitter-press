<?php
/*
 Plugin Name: Simplicy Twitter Press
  Plugin URI: http://www.naxialis.com/simplicy-twitter-press
  Description: Se Widget permet d'affich&eacute; vos derniers twitts ainsi que le bouton me suivre avec la photo de ceux qui vous suive.
  Version: 1.1
  Author: Naxialis
  Author URI: http://naxialis.com
  
  Copyright (C) 2011-2011, naxialis
  All rights reserved.
 */

 
 

add_action( 'widgets_init', 'twitter_lister_widget' );

function twitter_lister_widget() {
	register_widget( 'twitter_widget' );
}

wp_enqueue_script('jquery-1-6', '/wp-content/plugins/simplicy-twitter-press/js/jquery-1-6.js');
wp_enqueue_style('SP-twitter-press', '/wp-content/plugins/simplicy-twitter-press/css/SP-twitter-press.css');
wp_enqueue_script('fan_tweet', '/wp-content/plugins/simplicy-twitter-press/js/fan_tweet.js');
wp_enqueue_script('jquery_tweet', '/wp-content/plugins/simplicy-twitter-press/js/jquery_tweet.js');


class twitter_widget extends WP_Widget {

	function twitter_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'twitter_class', 'description' => __('L&acute;essentiel de Twitter.', 'twitter_class') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'twitter-lister-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'twitter-lister-widget', __('Simplicy Twitter Press', 'twitter_class'), $widget_ops, $control_ops );
	}
	
	


	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$user = $instance['user'];
		$count = $instance['count'];
		$number_user = $instance['number_user'];
		$number_user_max = $instance['number_user_max'];
		$img_user_follow = $instance['img_user_follow'];
		$div_user_follow = $instance['div_user_follow'];
		$avatar_size = $instance['avatar_size'];
		$twitt_user = isset( $instance['twitt_user'] ) ? $instance['twitt_user'] : false;
		$twitt_user_follow = isset( $instance['twitt_user_follow'] ) ? $instance['twitt_user_follow'] : false;
		?>
<?php echo' <script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>'; ?> 
 
<script>
 $(document).ready(function(){
        $(".tweet").tweet({
          join_text: "auto",
          username: "<?php echo $user; ?>",
          avatar_size: <?php echo $avatar_size; ?>,
          count: <?php echo $count; ?>,
          auto_join_text_url: "<strong>Nous avons post&eacute; :</strong> ",
          loading_text: "loading tweets..."
		  
        });
      });
</script>

<script type="text/javascript">
   $(function(){
      $('#friends').twitterFriends({
         debug:1,
		 users:<?php echo $number_user; ?>,
		 users_max:<?php echo $number_user_max; ?>,
		 user_image:<?php echo $img_user_follow; ?>,
         username:'<?php echo $user; ?>'
      });
   });
</script>
<?php

		echo $before_widget;
	
		if ( $title )
			echo $before_title . $title . $after_title;
			

echo '<div class="twitt-lister">';

if ( $twitt_user )
			echo ( '<div class="tweet"> ' . __('', 'twitter_class') . '</div>');
?>

 </div>

<div class="twitt-follow">
<dt><a href="http://twitter.com/<?php echo $user; ?>" class="twitter-follow-button" data-show-screen-name="false" data-lang="fr">Suivre</a></dt>
</div>

<?php 
if ( $twitt_user_follow )
			echo ( '<div style="height:'.$div_user_follow.'px;" id="friends"> ' . __('', 'twitter_class') . '</div>');
			
		
		
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['user'] = strip_tags( $new_instance['user'] );
		$instance['count'] = strip_tags( $new_instance['count'] );
		$instance['number_user'] = strip_tags( $new_instance['number_user'] );
		$instance['number_user_max'] = strip_tags( $new_instance['number_user_max'] );
		$instance['img_user_follow'] = strip_tags( $new_instance['img_user_follow'] );
		$instance['div_user_follow'] = strip_tags( $new_instance['div_user_follow'] );

		
		$instance['avatar_size'] = $new_instance['avatar_size'];
		$instance['twitt_user'] = $new_instance['twitt_user'];
		$instance['twitt_user_follow'] = $new_instance['twitt_user_follow'];
		
		

		return $instance;
	}

	
	function form( $instance ) {

		/* Set up some default widget settings. */
		
		
		 ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label style="line-height:22px;" for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Titre:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Nom utilisateur: Text Input -->
		<p>
			<label style="line-height:22px;" for="<?php echo $this->get_field_id( 'user' ); ?>"><?php _e('Nom d&acute;utilisateur: @', 'twitter_class'); ?></label>
			<input id="<?php echo $this->get_field_id( 'user' ); ?>" name="<?php echo $this->get_field_name( 'user' ); ?>" value="<?php echo $instance['user']; ?>" style="width:100%;" />
		</p>

		<!-- avatar size: Select Box -->
		<p>
			<label style="line-height:22px;" for="<?php echo $this->get_field_id( 'avatar_size' ); ?>"><?php _e('Taille de votre image d&acute;utilisateur:', 'twitter_class'); ?></label><i style="float:right; line-height:22px;">px</i> 
			<input id="<?php echo $this->get_field_id( 'avatar_size' ); ?>" name="<?php echo $this->get_field_name( 'avatar_size' ); ?>" value="<?php echo $instance['avatar_size']; ?>" style="width:20%; float:right;" />
		</p>
        

		<!-- Afficher les twetts Checkbox -->
        <p>
			<label style="line-height:22px;" for="<?php echo $this->get_field_id('twitt_user'); ?>"><?php _e('Affich&eacute; mes tweets ?'); ?></label>
            <input type="checkbox" class="checkbox" <?php checked( $instance['twitt_user'], 'on' ); ?> id="<?php echo $this->get_field_id('twitt_user'); ?>" name="<?php echo $this->get_field_name('twitt_user'); ?>" />
		</p>
        
         <!-- nombre de twitt: Text Input -->
		<p>
			<label style="line-height:22px;" for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Nombre de twitte a affich&eacute;:', 'twitter_class'); ?></label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" style="width:20%;float:right; margin-right:15px;" />
		</p>
        
        <!-- Afficher les utilisateur Checkbox -->
        <p>
			<label style="line-height:22px;" for="<?php echo $this->get_field_id('twitt_user_follow'); ?>"><?php _e('Affich&eacute; les utilisateurs qui vous suive ?'); ?></label>
            <input type="checkbox" class="checkbox" <?php checked( $instance['twitt_user_follow'], 'on' ); ?> id="<?php echo $this->get_field_id('twitt_user_follow'); ?>" name="<?php echo $this->get_field_name('twitt_user_follow'); ?>" />
		</p>
        
        <!-- nombre de suiveur: Text Input -->
		<p>
			<label style="line-height:22px;" for="<?php echo $this->get_field_id( 'number_user' ); ?>"><?php _e('Nombre utilisateurs a affich&eacute; :', 'twitter_class'); ?></label>
			<input id="<?php echo $this->get_field_id( 'number_user' ); ?>" name="<?php echo $this->get_field_name( 'number_user' ); ?>" value="<?php echo $instance['number_user']; ?>" style="width:20%;float:right; margin-right:15px;" />
		</p>
        
        <!-- nombre de suiveur totale : Text Input -->
		<p>
			<label style="line-height:22px;" for="<?php echo $this->get_field_id( 'number_user_max' ); ?>"><?php _e('Nombre utilisateurs a affich&eacute; max :', 'twitter_class'); ?></label>
			<input id="<?php echo $this->get_field_id( 'number_user_max' ); ?>" name="<?php echo $this->get_field_name( 'number_user_max' ); ?>" value="<?php echo $instance['number_user_max']; ?>" style="width:20%;float:right; margin-right:15px;" />

		</p>
        <!-- taille image suiveur  : Text Input -->
		<p>
			<label style="line-height:22px;" for="<?php echo $this->get_field_id( 'img_user_follow' ); ?>"><?php _e('Taille des images des utilisateurs :', 'twitter_class'); ?></label><i style="float:right; line-height:22px;">px</i>
			<input id="<?php echo $this->get_field_id( 'img_user_follow' ); ?>" name="<?php echo $this->get_field_name( 'img_user_follow' ); ?>" value="<?php echo $instance['img_user_follow']; ?>" style="width:20%; float:right;" />
		</p>
        
         <!-- hauteur du bloc  : Text Input -->
		<p>
			<label style="line-height:22px;" for="<?php echo $this->get_field_id( 'div_user_follow' ); ?>"><?php _e('Hauteur du widget des utilisateurs :', 'twitter_class'); ?></label><i style="float:right; line-height:22px;">px</i>
			<input id="<?php echo $this->get_field_id( 'div_user_follow' ); ?>" name="<?php echo $this->get_field_name( 'div_user_follow' ); ?>" value="<?php echo $instance['div_user_follow']; ?>" style="width:20%; float:right;" />
		</p>
        

	<?php
	}
}

?>