<?php
if ( preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']) ) {
     die('You are not allowed to call this page directly.');
}
/**
 * row.php - View for the row tab in the settings screen.
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
          <?php _e('Row Layout', 'post-theming'); ?>
     </h3>

     <ul id="post_theming_tabs">
          <?php for ( $ctr = 1; $ctr <= $this->options['rows']; ++$ctr ) : ?>
               <li id="row_tab_<?php echo $ctr; ?>" <?php echo ($ctr == 1) ? 'class="post-theming-selected"' : ''; ?>><a href="javascript:onClickRow(<?php echo $ctr; ?>);"><?php printf(__('Row %1$s', 'post-theming'), $ctr); ?></a></li>
          <?php endfor; ?>
          </ul>
     <?php for ( $ctr = 1; $ctr <= $this->options['rows']; ++$ctr ) : ?>
                    <div class="table" id="row_options_<?php echo $ctr; ?>" style="display: <?php echo ($ctr == 1) ? 'block' : 'none'; ?>">

          <?php
                    if ( !isset($this->options['row-settings'][$ctr]) ) {
                         $this->options['row-settings'][$ctr] = $this->options['row-settings'][$ctr - 1];
                    }
          ?>
                    <table class="form-table">
                         <tr align="top">
                              <th scope="row"><label for="row_options_columns_<?php echo $ctr; ?>"><?php _e('Columns', 'post-theming'); ?></label></th>
                              <td>
                                   <select name="<?php echo $this->optionsName; ?>[row-settings][<?php echo $ctr; ?>][columns]" id="row_options_columns_<?php echo $ctr; ?>">
                              <?php for ( $rctr = 1; $rctr <= $this->options['columns']; ++$rctr ) : ?>
                                   <option value="<?php echo $rctr; ?>" <?php selected($this->options['row-settings'][$ctr]['columns'], $rctr); ?>><?php echo $rctr; ?></option>
<?php endfor; ?>
                              </select>
                         </td>
                    </tr>
                    <tr align="top">
                         <th scope="row"><label for="row_options_style_<?php echo $ctr; ?>"><?php _e('Content Style', 'post-theming'); ?></label></th>
                         <td>
                              <select name="<?php echo $this->optionsName; ?>[row-settings][<?php echo $ctr; ?>][style]" id="row_options_style_<?php echo $ctr; ?>" onchange="onChangeStyle(this.value, <?php echo $ctr; ?>);">
                                   <option value="content" <?php selected($this->options['row-settings'][$ctr]['style'], 'content'); ?>><?php _e('Full Content', 'post-theming'); ?></option>
                                   <option value="excerpt" <?php selected($this->options['row-settings'][$ctr]['style'], 'excerpt'); ?>><?php _e('Excerpt', 'post-theming'); ?></option>
                              </select>
                         </td>
                    </tr>
                    <tr align="top">
                         <th scope="row"><label for="row_options_length_<?php echo $ctr; ?>"><?php _e('Excerpt Length', 'post-theming'); ?></label></th>
                         <td>
                              <input class="post-theming-number" style="display: <?php echo ($this->options['row-settings'][$ctr]['style'] == 'content') ? 'none' : 'block'; ?>" type="text" name="<?php echo $this->optionsName; ?>[row-settings][<?php echo $ctr; ?>][length]" id="row_options_length_<?php echo $ctr; ?>" value="<?php echo isset($this->options['row-settings'][$ctr]['length']) ? $this->options['row-settings'][$ctr]['length'] : 50; ?>" />
                         </td>
                    </tr>
                    <tr align="top">
                         <th scope="row"><label for="row_options_width_<?php echo $ctr; ?>"><?php _e('Column Width', 'post-theming'); ?></label></th>
                         <td>
                              <input class="post-theming-number" type="text" name="<?php echo $this->optionsName; ?>[row-settings][<?php echo $ctr; ?>][width]" id="row_options_width_<?php echo $ctr; ?>" value="<?php echo isset($this->options['row-settings'][$ctr]['width']) ? $this->options['row-settings'][$ctr]['width'] : 200; ?>" />
                         </td>
                    </tr>

                    <tr align="top">
                         <th scope="row"><label for="row_options_height_<?php echo $ctr; ?>"><?php _e('Column Height', 'post-theming'); ?></label></th>
                         <td>
                              <label><?php printf(__('Fixed %1$s at ', 'post-theming'),
                                           '<input type="checkbox" name="' . $this->optionsName . '[row-settings][' . $ctr . '][fixed-height]" id="row_options_fixed_height_' . $ctr . '" ' . checked(isset($this->options['row-settings'][$ctr]['fixed-height']), 1, false) . ' />'); ?></label>
                              <input class="post-theming-number" type="text" name="<?php echo $this->optionsName; ?>[row-settings][<?php echo $ctr; ?>][height]" id="row_options_height_<?php echo $ctr; ?>" value="<?php echo isset($this->options['row-settings'][$ctr]['height']) ? $this->options['row-settings'][$ctr]['height'] : 150; ?>" />
                         </td>
                    </tr>
                    <tr align="top">
                         <td colspan="2" class="post-theming-title"><?php _e('Thumbnail Settings', 'post-theming'); ?></td>
                                   </tr>
<?php if ( function_exists('has_post_thumbnail') ) : ?>
                                        <tr align="top">
                                             <th scope="row"><label for="row_options_thumb_width_<?php echo $ctr; ?>"><?php _e('Thumbnail Width', 'post-theming'); ?></label></th>
                                             <td>
                                                  <input class="post-theming-number" type="text" name="<?php echo $this->optionsName; ?>[row-settings][<?php echo $ctr; ?>][thumb-width]" id="row_options_thumb-width_<?php echo $ctr; ?>" value="<?php echo isset($this->options['row-settings'][$ctr]['thumb-width']) ? $this->options['row-settings'][$ctr]['thumb-width'] : 50; ?>" />
                                             </td>
                                        </tr>
                                        <tr align="top">
                                             <th scope="row"><label for="row_options_thumb_height_<?php echo $ctr; ?>"><?php _e('Thumbnail Height', 'post-theming'); ?></label></th>
                                             <td>
                                                  <input class="post-theming-number" type="text" name="<?php echo $this->optionsName; ?>[row-settings][<?php echo $ctr; ?>][thumb-height]" id="row_options_thumb_height_<?php echo $ctr; ?>" value="<?php echo isset($this->options['row-settings'][$ctr]['thumb-height']) ? $this->options['row-settings'][$ctr]['thumb-height'] : 50; ?>" />
                                             </td>
                                        </tr>
                                        <tr align="top">
                                             <th scope="row"><label for="row_options_align_<?php echo $ctr; ?>"><?php _e('Thumbnail Alignment', 'post-theming'); ?></label></th>
                                   <td>
                         <?php
                                        if ( !isset($this->options['row-settings'][$ctr]['align']) ) {
                                             $this->options['row-settings'][$ctr]['align'] = 'left';
                                        }
                         ?>

                                        <select name="<?php echo $this->optionsName; ?>[row-settings][<?php echo $ctr; ?>][align]" id="row_options_align_<?php echo $ctr; ?>">
                                             <option value="left" <?php selected($this->options['row-settings'][$ctr]['align'], 'left'); ?>><?php _e('Left', 'post-theming'); ?></option>
                                             <option value="middle" <?php selected($this->options['row-settings'][$ctr]['align'], 'middle'); ?>><?php _e('Middle', 'post-theming'); ?></option>
                                             <option value="right" <?php selected($this->options['row-settings'][$ctr]['align'], 'right'); ?>><?php _e('Right', 'post-theming'); ?></option>
                                        </select>
                                   </td>
                              </tr>
                              <tr align="top">
                                   <th scope="row"><label for="row_options_placement_<?php echo $ctr; ?>"><?php _e('Thumbnail Placement', 'post-theming'); ?></label></th>
                                   <td>
<?php
                                        if ( !isset($this->options['row-settings'][$ctr]['placement']) ) {
                                             $this->options['row-settings'][$ctr]['placement'] = 'above';
                                        }
?>

                                        <select name="<?php echo $this->optionsName; ?>[row-settings][<?php echo $ctr; ?>][placement]" id="row_options_placement_<?php echo $ctr; ?>">
                                                       <option value="above" <?php selected($this->options['row-settings'][$ctr]['placement'], 'above'); ?>><?php _e('Above', 'post-theming'); ?></option>
                                                       <option value="below" <?php selected($this->options['row-settings'][$ctr]['placement'], 'below'); ?>><?php _e('Below', 'post-theming'); ?></option>
                                                  </select>
                                             </td>
                                        </tr>
<?php else : ?>
                                             <tr align="top">
                                                  <td colspan="2"><?php _e('Your theme does not currently support featured images, also known as post thumbnails. To use this feature, you must use a theme that supports post thumbnails, or click the option above to force support for post thumbnails.', 'post-theming'); ?></td>
                                                       </tr>
<?php endif; ?>

                                                  </table>
                                             </div>
<?php endfor; ?>

</div>