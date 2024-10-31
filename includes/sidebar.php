<?php
if ( preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']) ) {
     die('You are not allowed to call this page directly.');
}
/**
 * sidebar.php - View for the Settings sidebar.
 *
 * @package Post Theming
 * @subpackage includes
 * @author GrandSlambert
 * @copyright 2009-2011
 * @access public
 * @since 0.3
 */
?>
<div class="postbox" >
     <h3 class="handl" style="margin:0; padding:3px;cursor:default;"><?php _e('Plugin Information', 'post-theming'); ?></h3>
     <div style="padding:5px;">
          <p><?php _e('This page allows you to change the layout of the rows of posts as well as which pages and post types will be themed.', 'post-theming'); ?></p>
          <p><?php _e('You are using', 'post-theming'); ?> <strong> <a href="http://plugins.grandslambert.com/plugins/post-theming.html" target="_blank"><?php print $this->pluginName; ?> <?php print $this->version; ?></a></strong> by <a href="http://grandslambert.com" target="_blank">GrandSlambert</a>.</p>
     </div>
</div>
<div class="postbox">
     <h3 class="handl" style="margin:0; padding:3px;cursor:default;"><?php _e('Usage', 'post-theming'); ?></h3>
     <div style="padding:5px;">
          <ul>
               <li><?php _e('The Display Settings tab allows you to indicate which pages will be themed and the features to be used.', 'post-theming'); ?></li>
               <li><?php _e('The Row Layout tab allows you to set up how each row will display. If you change the number of rows on the Display Settings tab, you need to save the settings to adjust the new rows.', 'post-theming'); ?></li>
               <li><?php _e('The Administration tab allows you to reset the plugin to default settings.', 'post-theming'); ?></li>
               <li>
                    <?php printf(__('You can find more help on how to use this plugin on the %1$s.', 'recipe-press'),
                            '<a href="http://docs.grandslambert.com/wiki/Post_Theming" target="_blank">' . __('Documentation Page', 'recipe-press') . '</a>'
                    ); ?>
               </li>
          </ul>
     </div>
</div>
<div class="postbox">
     <h3 class="handl" style="margin:0; padding:3px;cursor:default;">
<?php _e('Recent Contributors', 'post-theming'); ?>
     </h3>
     <div style="padding:5px;">
          <p><?php _e('GrandSlambert would like to thank these wonderful contributors to this plugin!', 'post-theming'); ?></p>
<?php $this->contributor_list(); ?>
     </div>
</div>