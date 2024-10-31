<?php
if ( preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']) ) {
     die('You are not allowed to call this page directly.');
}
/**
 * meta-box.php - Adds a meta box to the editting screens for the custom fields.
 *
 * @package Post Theming
 * @subpackage includes
 * @author GrandSlambert
 * @copyright 2009-2011
 * @access public
 * @since 0.1
 */
?>

<input type="hidden" name="post_theming_noncename" id="post_theming_noncename" value="<?php echo wp_create_nonce('post_theming_content'); ?>" />

<p><?php _e('You can change the content on the home page for this post with the fields below. Leave them blank to use the post title and content from the post.', 'post-theming'); ?></p>
<p>
     <label for="post_theming_title"><?php _e('Alternate Title', 'post-theming'); ?></label><br />
     <input class="widefat" type="text" name="post_theming_title" id="post_theming_title" value="<?php echo get_post_meta($post->ID, '_post_theming_title', true); ?>" />
</p>

<p>
     <label for="post_theming_content"><?php _e('Alternate Content', 'post-theming'); ?></label><br />
     <textarea class="widefat" name="post_theming_content" id="post_theming_content"><?php echo get_post_meta($post->ID, '_post_theming_content', true); ?></textarea>
     <label><input type="checkbox" name="post_theming_link" id="post_theming_link" value="1" <?php checked(get_post_meta($post->ID, '_post_theming_link', true), 1); ?> /> <?php _e('Link this content to the post?', 'post-theming'); ?></label>
</p>