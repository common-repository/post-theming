<?php
if ( preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']) ) {
     die('You are not allowed to call this page directly.');
}
/**
 * display.php - View for the display tab on the settings page.
 *
 * @package Post Theming
 * @subpackage includes/settings
 * @author GrandSlambert
 * @copyright 2009-2011
 * @access public
 * @since 0.3
 */
?>

<div class="postbox">
     <h3 class="handl" style="margin:0;padding:3px;cursor:default;">
          <?php _e('Display Settings', 'post-theming'); ?>
     </h3>
     <div class="table">
          <table class="form-table">
               <tr align="top">
                    <th scope="row"><label><?php _e('Posts Per Page', 'post-theming'); ?></label></th>
                    <td>
                         <strong><?php echo $this->options['posts-per-page']; ?></strong>
                         <?php
                         printf(__('Set this on the %1$s page.', 'post-theming'),
                                 '<a href="' . admin_url('options-reading.php') . '">' . __('Reading Options', 'post-theming') . '</a>'
                         );
                         ?>
                    </td>
               </tr>
               <tr align="top">
                    <th scope="row"><?php _e('Post Types to Theme', 'post-theming'); ?></th>
                    <td>
                         <?php
                         if ( function_exists('get_post_types') ) {
                              $types = get_post_types(array('public' => true));
                         } else {
                              $types = array('post', 'page');
                         }
                         ?>

                         <?php foreach ( $types as $type ) : ?>
                              <label class="index-press-post-type"><input type="checkbox" name="<?php echo $this->optionsName; ?>[post-types][]" value="<?php echo $type; ?>" <?php checked(in_array($type, $this->options['post-types']), 1); ?> /> <?php echo ucfirst($type); ?></label>
                         <?php endforeach; ?>
                         </td>
                    </tr>
                    <tr align="top">
                         <th scope="row"><label for="options_pages"><?php _e('Use on these pages', 'post-theming'); ?></label></th>
                         <td>
                              <table class="form-table">
                                   <tr align="top">
                                        <td><label><input type="checkbox" name="<?php echo $this->optionsName; ?>[if_is_front]" value="1" <?php checked($this->options['if_is_front'], '1'); ?> /> <?php _e('Front Page', 'post-theming'); ?></label></td>
                                        <td><label><input type="checkbox" name="<?php echo $this->optionsName; ?>[if_is_archive]" value="1" <?php checked($this->options['if_is_archive'], '1'); ?> /> <?php _e('Archive Page', 'post-theming'); ?></label></td>
                                   </tr>
                                   <tr align="top">
                                        <td><label><input type="checkbox" name="<?php echo $this->optionsName; ?>[if_is_category]" value="1" <?php checked($this->options['if_is_category'], '1'); ?> /> <?php _e('Category Page', 'post-theming'); ?></label></td>
                                        <td><label><input type="checkbox" name="<?php echo $this->optionsName; ?>[if_is_tag]" value="1" <?php checked($this->options['if_is_tag'], '1'); ?> /> <?php _e('Tag Page', 'post-theming'); ?></label></td>
                                   </tr>
                                   <tr align="top">
                                        <td><label><input type="checkbox" name="<?php echo $this->optionsName; ?>[if_is_search]" value="1" <?php checked($this->options['if_is_search'], '1'); ?> /> <?php _e('Search Page', 'post-theming'); ?></label></td>
                                        <td><label><input type="checkbox" name="<?php echo $this->optionsName; ?>[if_is_date]" value="1" <?php checked($this->options['if_is_date'], '1'); ?> /> <?php _e('Date Page', 'post-theming'); ?></label></td>
                                   </tr>
                                   <tr align="top">
                                        <td><label><input type="checkbox" name="<?php echo $this->optionsName; ?>[if_is_single]" value="1" <?php checked($this->options['if_is_single'], '1'); ?> /> <?php _e('Post Pages', 'post-theming'); ?></label></td>
                                        <td><label><input type="checkbox" name="<?php echo $this->optionsName; ?>[if_is_page]" value="1" <?php checked($this->options['if_is_page'], '1'); ?> /> <?php _e('Pages', 'post-theming'); ?></label></td>
                                   </tr>
                              </table>
                         </td>
                    </tr>
                    <tr align="top">
                         <th scope="row"><label for="options_rows"><?php _e('Number for row styles', 'post-theming'); ?></label></th>
                         <td>
                              <select name="<?php echo $this->optionsName; ?>[rows]" id="options_rows">
                              <?php for ( $ctr = 1; $ctr <= $this->options['posts-per-page']; ++$ctr ) : ?>
                                   <option value="<?php echo $ctr; ?>" <?php selected($this->options['rows'], $ctr); ?>><?php echo $ctr; ?></option>
                              <?php endfor; ?>
                              </select>
                         </td>
                    </tr>
                    <tr align="top">
                         <th scope="row"><label for="options_columns"><?php _e('Max columns on page', 'post-theming'); ?></label></th>
                         <td>
                              <select name="<?php echo $this->optionsName; ?>[columns]" id="options_columns">
                              <?php for ( $ctr = 1; $ctr <= 5; ++$ctr ) : ?>
                                        <option value="<?php echo $ctr; ?>" <?php selected($this->options['columns'], $ctr); ?>><?php echo $ctr; ?></option>
                              <?php endfor; ?>
                                   </select>
                              </td>
                         </tr>
                         <tr align="top">
                              <th scope="row"><label for="options_paged_row"><?php _e('Row layout to use for additional pages', 'post-theming'); ?></label></th>
                              <td>
                                   <select name="<?php echo $this->optionsName; ?>[paged-row]" id="options_paged_row">
                              <?php for ( $ctr = 1; $ctr <= $this->options['rows']; ++$ctr ) : ?>
                                             <option value="<?php echo $ctr; ?>" <?php selected($this->options['paged-row'], $ctr); ?>><?php echo $ctr; ?></option>
                              <?php endfor; ?>
                                        </select>
                                   </td>
                              </tr>
                              <tr align="top">
                                   <th scope="row"><label for="options_show_borders"><?php _e('Show Column Borders', 'post-theming'); ?></label></th>
                                   <td><input type="checkbox" name="<?php echo $this->optionsName; ?>[show-borders]" id="options_show_borders" <?php checked($this->options['show-borders'], 1); ?> value="1" /></td>
                              </tr>

               <?php if ( function_exists('has_post_thumbnail') ) : ?>
                                                  <tr align="top">
                                                       <th scope="row"><label for="options_use_thumbnails"><?php _e('Use Post Thumbnails', 'post-theming'); ?></label></th>
                                                       <td>
                                                            <input type="checkbox" name="<?php echo $this->optionsName; ?>[use-thumbnails]" id="options_use_thumbnails" <?php checked($this->options['use-thumbnails'], 1); ?> value="1" />
                                                            <input type="hidden" name="<?php echo $this->optionsName; ?>[add-thumbnails]" id="options_add_thumbnails" value="1" />
                                                       </td>
                                                  </tr>
               <?php else : ?>
                                                       <tr align="top">
                                                            <th scope="row"><label for="options_add_thumbnails"><?php _e('Add Post Thumbnails Support', 'post-theming'); ?></label></th>
                                                            <td><input type="checkbox" name="<?php echo $this->optionsName; ?>[add-thumbnails]" id="options_add_thumbnails" <?php checked($this->options['add-thumbnails'], 1); ?> value="1" /></td>
                                                       </tr>

               <?php endif; ?>
          </table>
     </div>
</div>