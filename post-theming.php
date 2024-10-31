<?php

/*
  Plugin Name: Post Theming
  Plugin URI: http://plugins.grandslambert.com/plugins/post-theming.html
  Description: Control how the posts display on your home page.
  Version: 0.3
  Author: grandslambert
  Author URI: http://wordpress.grandslambert.com/

 * *************************************************************************

  Copyright (C) 2009-2011 GrandSlambert

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General License for more details.

  You should have received a copy of the GNU General License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.

 * *************************************************************************

 */

class postTheming {
     /* Plugin settings */

     var $menuName = 'post-theming';
     var $pluginName = 'Post Theming';
     var $version = '0.3';
     var $optionsName = 'post-theming-options';
     var $postCount = 1;
     var $columnCount = 0;
     var $displayRow = 1;
     var $currentRow = 1;
     var $postRow = 1;
     var $make_link = false;

     function postTheming() {
          /* Load Langague Files */
          $langDir = dirname(plugin_basename(__FILE__)) . '/lang';
          load_plugin_textdomain('post-theming', false, $langDir);

          $this->pluginName = __('Post Theming', 'post-theming');
          $this->pluginPath = WP_PLUGIN_DIR . '/' . plugin_basename(dirname(__FILE__));
          $this->pluginURL = WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__));
          $this->load_settings();

          /* Wordpress Hooks */
          add_action('admin_menu', array(&$this, 'admin_menu'));
          add_action('wp_loaded', array(&$this, 'wp_init'));
          add_action('wp_print_styles', array(&$this, 'add_header'), 100);
          add_action('admin_init', array(&$this, 'admin_init'));
          add_filter('plugin_action_links', array(&$this, 'plugin_action_links'), 10, 2);
          add_action('update_option_' . $this->optionsName, array(&$this, 'update_option'), 10);

          /* Modify the posts */
          add_filter('post_class', array(&$this, 'post_class'), 100);
          add_action('save_post', array(&$this, 'save_post'));
          add_filter('the_content', array(&$this, 'the_content'));
          add_filter('the_excerpt', array(&$this, 'the_content'));
          add_filter('the_title', array(&$this, 'the_title'));
          add_action('loop_end', array(&$this, 'loop_end'));

          /* Add post thumbnails */
          if ( !function_exists('has_post_thumbnail') and $this->options['add-thumbnails'] ) {
               add_action('after_setup_theme', array(&$this, 'after_setup_theme'));
          }
     }

     /**
      * Load the settings for the plugin.
      */
     function load_settings() {
          $posts_per_page = get_option('posts_per_page');

          $defaults = array(
               'posts-per-page' => $posts_per_page,
               'post-types' => array('post', 'page'),
               'if_is_front' => true,
               'if_is_archive' => false,
               'if_is_category' => false,
               'if_is_tag' => false,
               'if_is_search' => false,
               'if_is_date' => false,
               'if_is_single' => false,
               'if_is_page' => false,
               'rows' => 3,
               'columns' => 3,
               'paged-row' => 3,
               'gutter' => 5,
               'show-borders' => false,
               'use-thumbnails' => false,
               'add-thumbnails' => false,
               'custom-css' => '',
               'row-settings' => array(
                    '1' => array('columns' => 1, 'style' => 'excerpt', 'length' => 100, 'width' => 640, 'thumb-width' => 300, 'thumb-height' => 300, 'align' => 'left', 'placement' => 'above'),
                    '2' => array('columns' => 2, 'style' => 'excerpt', 'length' => 50, 'width' => 314, 'thumb-width' => 150, 'thumb-height' => 150, 'align' => 'left', 'placement' => 'above'),
                    '3' => array('columns' => 3, 'style' => 'excerpt', 'length' => 25, 'width' => 206, 'thumb-width' => 50, 'thumb-height' => 50, 'align' => 'left', 'placement' => 'above'),
               ),
          );

          $this->options = wp_parse_args(get_option($this->optionsName), $defaults);

          if ( function_exists('add_image_size') ) {
               for ( $ctr = 1; $ctr <= $this->options['rows']; ++$ctr ) {
                    if ( isset($this->options['row-settings'][$ctr]['thumb-width']) and isset($this->options['row-settings'][$ctr]['thumb-height']) ) {
                         $this->thumbSizes[$ctr] = 'post-theming-row-' . $ctr;
                         add_image_size('post-theming-row-' . $ctr, $this->options['row-settings'][$ctr]['thumb-width'], $this->options['row-settings'][$ctr]['thumb-height'], true);
                    } else {
                         $this->thumbSizes[$ctr] = 'medium';
                    }
               }
          }
     }

     /**
      * Add the Post Theming meta box.
      *
      * @global <object> $post
      */
     function meta_box() {
          global $post;
          require_once($this->pluginPath . '/includes/meta-box.php');
     }

     /**
      * Save the post theming options.
      */
     function save_post($post_id) {
          global $post;

          $fields = array('post_theming_title', 'post_theming_content', 'post_theming_link');

          if ( isset($_POST['post_theming_noncename']) and wp_verify_nonce($_POST['post_theming_noncename'], 'post_theming_content') ) {
               foreach ( $fields as $key ) {
                    $metaKey = '_' . $key;
                    if ( isset($_POST[$key]) ) {
                         $value = $_POST[$key];

                         if ( get_post_meta($post_id, $metaKey) == "" ) {
                              add_post_meta($post_id, $metaKey, $value, true);
                         } elseif ( $value != get_post_meta($post_id, '_' . $key, true) ) {
                              update_post_meta($post_id, $metaKey, $value);
                         } elseif ( $value == "" ) {
                              delete_post_meta($post_id, $metaKey, get_post_meta($post_id, $metaKey, true));
                         }
                    } else {
                         delete_post_meta($post_id, $metaKey, get_post_meta($post_id, $metaKey, true));
                    }
               }
          }
     }

     /**
      * Add a post class
      */
     function post_class($output) {
          global $post, $paged;

          /* Verify that the current post type and page is to be themed */
          if ( !in_array($post->post_type, $this->options['post-types'])
                  or (is_front_page() and !$this->options['if_is_front'])
                  or (is_archive() and !$this->options['if_is_archive'])
                  or (is_search() and !$this->options['if_is_search'])
                  or (is_category() and !$this->options['if_is_category'])
                  or (is_tag() and !$this->options['if_is_tag'])
                  or (is_date() and !$this->options['if_is_date'])
                  or (is_single() and !$this->options['if_is_single'])
                  or (is_page() and !$this->options['if_is_page']) ) {
               remove_filter('post_class', array(&$this, 'post_class'), 100);
               remove_action('save_post', array(&$this, 'save_post'));
               remove_filter('the_content', array(&$this, 'the_content'));
               remove_filter('the_excerpt', array(&$this, 'the_content'));
               remove_filter('the_title', array(&$this, 'the_title'));
               remove_action('loop_end', array(&$this, 'loop_end'));
               return $output;
          }

          if ( $paged > 1 ) {
               $this->postRow = $this->options['paged-row'];
               $this->displayRow = $this->options['paged-row'];
          }

          if ( $this->options['show-borders'] ) {
               array_push($output, 'post-theming-border');
          }

          array_push($output, 'post-theming-' . $this->postCount);
          array_push($output, 'post-theming-column-' . $this->displayRow);

          if ( $this->columnCount == 0 ) {
               array_push($output, 'post-theming-first-column');
          }
          ++$this->postCount;
          ++$this->columnCount;
          $this->postRow = $this->displayRow;

          if ( $this->columnCount >= $this->options['row-settings'][$this->displayRow]['columns'] ) {
               if ( $this->displayRow < $this->options['rows'] ) {
                    ++$this->displayRow;
               }
               $this->columnCount = 0;
               array_push($output, 'post-theming-last-column');
          }
          return $output;
     }

     /**
      * Filter the title
      */
     function the_title($title) {
          global $post;

          if ( is_object($post) and !is_single() and $customTitle = get_post_meta($post->ID, '_post_theming_title', true) and in_the_loop() ) {
               return $customTitle;
          } else {
               return $title;
          }
     }

     /**
      * Filter the content
      */
     function the_content($content) {
          global $post;

          /* Verify the plugin affects the current page */
          if ( (is_front_page() and !$this->options['if_is_front'])
                  or (is_archive() and !$this->options['if_is_archive'])
                  or (is_search() and !$this->options['if_is_search'])
                  or (is_category() and !$this->options['if_is_category'])
                  or (is_tag() and !$this->options['if_is_tag'])
                  or (is_date() and !$this->options['if_is_date'])
                  or (is_single() and !$this->options['if_is_single'])
                  or (is_page() and !$this->options['if_is_page'])
          ) {
               remove_filter('the_content', array(&$this, 'the_content'));
               remove_filter('the_excerpt', array(&$this, 'the_content'));
               remove_filter('the_title', array(&$this, 'the_title'));
               return $content;
          }

          if ( $customContent = get_post_meta($post->ID, '_post_theming_content', true) ) {
               if ( true == get_post_meta($post->ID, '_post_theming_link', true) ) {
                    $content = '<a href="' . post_permalink($post->ID) . '">' . $customContent . '</a>';
               } else {
                    $content = $customContent;
               }
          } else {
               switch ($this->options['row-settings'][$this->postRow]['style']) {
                    case 'excerpt':
                         $content = $this->trim_excerpt($content);
                         break;
               }
          }

          /* Add image if supported */
          if ( $this->options['use-thumbnails'] and isset($this->options['row-settings'][$this->postRow]['thumb-width']) and function_exists('has_post_thumbnail') and has_post_thumbnail($post->ID) ) {
               $attrs = array();

               switch ($this->options['row-settings'][$this->postRow]['align']) {
                    case 'left':
                         $attrs['class'] = 'alignleft post-theming-left';
                         break;
                    case 'right':
                         $attrs['class'] = 'alignright post-theming-right';
                         break;
                    default:
                         unset($attrs['class']);
               }

               $image = '<a href="' . post_permalink($post->ID) . '">' . get_the_post_thumbnail($post->ID, $this->thumbSizes[$this->postRow], $attrs) . '</a>';
          } else {
               $image = '';
          }

          $cleared = '<div class="post-theming-cleared"> </div>';
          switch ($this->options['row-settings'][$this->postRow]['placement']) {
               case 'above':
                    return $image . $content . $cleared;
                    break;
               case 'below':
                    return $content . $image . $cleared;
                    break;
               default:
                    return $image . $content . $cleared;
          }
     }

     /**
      * Add a div to clear the floats at the end of the loop.
      */
     function loop_end() {
          echo '<div class="post-theming-cleared"> </div>';
     }

     /**
      * Add support for post thumbnails if not already supported.
      */
     function after_setup_theme() {
          add_theme_support('post-thumbnails');
     }

     /**
      * Custom excerpt function.
      *
      * @global <object> $post
      * @param <string> $text    Text to trim.
      * @param <int> $length     Number of words for excerpt.
      * @return <string>         The excerpt.
      */
     function trim_excerpt($text, $length = NULL) {
          global $post;

          if ( !$length ) {
               $length = $this->options['row-settings'][$this->postRow]['length'];
          }

          $text = strip_tags($text, 'p');
          $text = str_replace(']]>', ']]&gt;', $text);
          $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
          $words = explode(' ', $text, $length + 1);
          if ( count($words) > $length ) {
               array_pop($words);
               array_push($words, '[...]');
               $text = implode(' ', $words);
          }

          return $text;
     }

     /**
      * WP Init Action
      */
     function wp_init() {
          wp_register_style('postThemingCSS', $this->pluginURL . '/css/post-theming-site.css');
     }

     /**
      * Add items to the header of the web site.
      */
     function add_header() {
          wp_enqueue_style('postThemingCSS');

          echo "<!-- Added by Post Theming Plugin -->\n";
          echo '<style type="text/css" media="screen">' . "\n";

          foreach ( $this->options['row-settings'] as $key => $settings ) {
               echo '.post-theming-column-' . $key . ' { width: ' . $settings['width'] . 'px; float: left; padding-right: ' . $this->options['gutter'] . 'px; }' . "\n";
          }

          if ( $this->options['custom-css'] ) {
               echo $this->options['custom-css'] . "\n";
          }

          echo "</style>";
     }

     /**
      * Admin Init Actino
      */
     function admin_init() {
          register_setting($this->optionsName, $this->optionsName);
          wp_register_style('postThemingAdminCSS', $this->pluginURL . '/css/post-theming-admin.css');
          wp_register_script('postThemingAdminJS', $this->pluginURL . '/js/post-theming-admin.js');

          foreach ($this->options['post-types'] as $post_type) {
               add_meta_box('post_theming', __('Post Theming', 'post-theming'), array(&$this, 'meta_box'), $post_type, 'side', 'high');
          }
     }

     /**
      * Add the admin page for the settings panel.
      *
      * @global string $wp_version
      */
     function admin_menu() {
          global $wp_version;

          $page = add_submenu_page('edit.php', $this->pluginName, $this->pluginName, 'activate_plugins', $this->menuName, array(&$this, 'settings'));
          add_action('admin_print_styles-' . $page, array(&$this, 'admin_styles'));
          add_action('admin_print_scripts-' . $page, array(&$this, 'admin_scripts'));
     }

     /**
      * Queue the admin CSS.
      */
     function admin_styles() {
          wp_enqueue_style('postThemingAdminCSS');
     }

     /**
      * Queue the admin Javascript.
      */
     function admin_scripts() {
          wp_enqueue_script('postThemingAdminJS');
     }

     /**
      * Add a configuration link to the plugins list.
      *
      * @staticvar object $this_plugin
      * @param array $links
      * @param array $file
      * @return array
      */
     function plugin_action_links($links, $file) {
          static $this_plugin;

          if ( !$this_plugin ) {
               $this_plugin = plugin_basename(__FILE__);
          }

          if ( $file == $this_plugin ) {
               $settings_link = '<a href="' . admin_url('edit.php?page=post-theming') . '">' . __('Settings') . '</a>';
               array_unshift($links, $settings_link);
          }

          return $links;
     }

     /**
      * Settings management panel.
      */
     function settings() {
          include($this->pluginPath . '/includes/settings.php');
     }

     /**
      * Check on update option to see if we need to reset the options.
      * @param <array> $input
      * @return <boolean>
      */
     function update_option($input) {
          if ( $_REQUEST['confirm-reset-options'] ) {
               delete_option($this->optionsName);
               wp_redirect(admin_url('edit.php?page=' . $this->menuName . '&tab=' . $_POST['active_tab'] . '&reset=true'));
               exit();
          } else {
               wp_redirect(admin_url('edit.php?page=' . $this->menuName . '&tab=' . $_POST['active_tab'] . '&updated=true'));
               exit();
          }
     }

     /**
      * Display the list of contributors.
      * @return boolean
      */
     function contributor_list() {
          $this->showFields = array('NAME', 'LOCATION', 'COUNTRY');
          print '<ul>';

          $xml_parser = xml_parser_create();
          xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, true);
          xml_set_element_handler($xml_parser, array($this, "start_element"), array($this, "end_element"));
          xml_set_character_data_handler($xml_parser, array($this, "character_data"));

          if ( !(@$fp = fopen('http://grandslambert.com/xml/post-theming/contributors.xml', "r")) ) {
               print 'There was an error getting the list. Try again later.';
               return;
          }

          while ($data = fread($fp, 4096)) {
               if ( !xml_parse($xml_parser, $data, feof($fp)) ) {
                    die(sprintf("XML error: %s at line %d",
                                    xml_error_string(xml_get_error_code($xml_parser)),
                                    xml_get_current_line_number($xml_parser)));
               }
          }

          xml_parser_free($xml_parser);
          print '</ul>';
     }

     /**
      * XML Start Element Procedure.
      */
     function start_element($parser, $name, $attrs) {
          if ( $name == 'NAME' ) {
               print '<li class="rp-contributor">';
          } elseif ( $name == 'ITEM' ) {
               print '<br><span class="rp_contributor_notes">Contributed: ';
          }

          if ( $name == 'URL' ) {
               $this->make_link = true;
          }
     }

     /**
      * XML End Element Procedure.
      */
     function end_element($parser, $name) {
          if ( $name == 'ITEM' ) {
               print '</li>';
          } elseif ( $name == 'ITEM' ) {
               print '</span>';
          } elseif ( in_array($name, $this->showFields) ) {
               print ', ';
          }

          $this->make_link = false;
     }

     /**
      * XML Character Data Procedure.
      */
     function character_data($parser, $data) {
          if ( $this->make_link ) {
               print '<a href="http://' . $data . '" target="_blank">' . $data . '</a>';
               $this->make_link = false;
          } else {
               print $data;
          }
     }

}

/* Instantiate the Widget */
$POSTTHEMINGOBJ = new postTheming;
