<?php
if ( preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']) ) {
     die('You are not allowed to call this page directly.');
}
/**
 * footer.php - Footer for all plugin management pages.
 *
 * @package Post Theming
 * @subpackage includes
 * @author GrandSlambert
 * @copyright 2009-2011
 * @access public
 * @since 0.3
 */
?>

<div class="postbox" style="clear: both; width:49%; float:left">
     <h3 class="handl" style="margin:0; padding:3px;cursor:default;"><?php _e('Credits', 'post-theming'); ?></h3>
     <div style="padding:8px;">
          <p>
               <?php
               /* translators: This is displayed in the credits. Parameters are plugin name, link to plugin page, link to support page. */
               printf(__('Thank you for trying the %1$s plugin - I hope you find it useful. For the latest updates on this plugin, vist the %2$s. If you have problems with this plugin, please use our %3$s or take a look at the %4$s', 'post-theming'),
                       $this->pluginName,
                       '<a href="http://plugins.grandslambert.com/plugins/post-theming.html" target="_blank">' . __('official site', 'post-theming') . '</a>',
                       '<a href="http://support.grandslambert.com/forum/post-theming" target="_blank">' . __('Support Forum', 'post-theming') . '</a>',
                       '<a href="http://docs.grandslambert.com/wiki/Post_Theming" target="_blank">' . __('Documentation Page', 'post-theming') . '</a>'
               ); ?>
          </p>
          <p>
               <?php
               /* translators: Displayed under the credits. Parameters are the copyright dates, link to author, link to license. */
               printf(__('This plugin is &copy; %1$s by %2$s and is released under the %3$s', 'post-theming'),
                       '2009-' . date("Y"),
                       '<a href="http://grandslambert.com" target="_blank">GrandSlambert, Inc.</a>',
                       '<a href="http://www.gnu.org/licenses/gpl.html" target="_blank">' . __('GNU General Public License', 'post-theming') . '</a>'
               );
               ?>
          </p>        </div>
</div>
<div class="postbox" style="width:49%; float:right">
     <h3 class="handl" style="margin:0; padding:3px;cursor:default;"><?php _e('Donate', 'post-theming'); ?></h3>
     <div style="padding:8px">
          <p>
               <?php
               /* translators: This is the text in the donate box. Parameter is replaced with link to the plugins page of the authors site. */
               printf(__('If you find this plugin useful, please consider supporting this and our other great %1$s.', 'post-theming'), '<a href="http://wordpress.grandslambert.com/plugins.html" target="_blank">' . __('plugins', 'post-theming') . '</a>');
               ?>
               <a href="http://plugins.grandslambert.com/post-theming-donate" target="_blank"><?php _e('Donate a few bucks!', 'post-theming'); ?></a>
          </p>
          <p style="text-align: center;"><a target="_blank" href="http://plugins.grandslambert.com/post-theming-donate"><img width="122" height="47" alt="paypal_btn_donateCC_LG" src="http://grandslambert.com/paypal.gif" title="paypal_btn_donateCC_LG" class="aligncenter size-full wp-image-174"/></a></p>
     </div>
</div>
