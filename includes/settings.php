<?php
if ( preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']) ) {
     die('You are not allowed to call this page directly.');
}
/**
 * settings.php - View for the Settings page.
 *
 * @package Post Theming
 * @subpackage includes
 * @author GrandSlambert
 * @copyright 2009-2011
 * @access public
 * @since 0.3
 */
/* Flush the rewrite rules */
global $wp_rewrite, $wp_query;
$wp_rewrite->flush_rules();

if ( isset($_REQUEST['tab']) ) {
     $selectedTab = $_REQUEST['tab'];
} else {
     $selectedTab = 'display';
}

$tabs = array(
     'display' => __('Display Settings', 'post-theming'),
     'row' => __('Row Layout', 'post-theming'),
     'administration' => __('Administration', 'post-theming'),
);
?>

<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;" class="overDiv"></div>
<div class="wrap">
     <form method="post" action="options.php" id="post_theming_settings">
          <input type="hidden" id="home_page_url" value ="<?php echo site_url(); ?>" />
          <div class="icon32" id="icon-post-theming"><br/></div>
          <h2><?php echo $this->pluginName; ?> &raquo; <?php _e('Settings', 'post-theming'); ?> </h2>
          <?php if ( isset($_REQUEST['reset']) ) : ?>
               <div id="settings-error-post-theming_upated" class="updated settings-error">
                    <p><strong><?php _e('Post Theming settings have been reset to defaults.', 'post-theming'); ?></strong></p>
               </div>
          <?php elseif ( isset($_REQUEST['updated']) ) : ?>
                    <div id="settings-error-index-press_upated" class="updated settings-error">
                         <p><strong><?php _e('Post Theming Settings Saved.', 'index-press'); ?></strong></p>
                    </div>
          <?php endif; ?>
          <?php settings_fields($this->optionsName); ?>
                    <input type="hidden" name="<?php echo $this->optionsName; ?>[random-value]" value="<?php echo rand(1000, 100000); ?>" />
                    <input type="hidden" name="active_tab" id="active_tab" value="<?php echo $selectedTab; ?>" />
                    <ul id="post_theming_tabs">
               <?php foreach ( $tabs as $tab => $name ) : ?>
                         <li id="post_theming_<?php echo $tab; ?>" class="post-theming<?php echo ($selectedTab == $tab) ? '-selected' : ''; ?>">
                              <a href="#top" onclick="post_theming_show_tab('<?php echo $tab; ?>')"><?php echo $name; ?></a>
                         </li>
               <?php endforeach; ?>
                         <li id="post_theming_save" class="post-theming save-tab">
                              <a href="#top" onclick="post_theming_settings_save()"><?php _e('Save Settings', 'post-theming'); ?></a>
                         </li>
                    </ul>

                    <div style="width:49%; float:left">
               <?php foreach ( $tabs as $tab => $name ) : ?>
                              <div id="post_theming_box_<?php echo $tab; ?>" style="display: <?php echo ($selectedTab == $tab) ? 'block' : 'none'; ?>">
                    <?php require_once('settings/' . $tab . '.php'); ?>
                         </div>
               <?php endforeach; ?>
                         </div>

                         <div  style="width:49%; float:right">
               <?php require_once($this->pluginPath . '/includes/sidebar.php'); ?>
                         </div>


                    </form>
     <?php require_once($this->pluginPath . '/includes/footer.php'); ?>

</div>
