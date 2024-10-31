/**
 * post-theming-admin.js - Javascript for the Settings page.
 *
 * @package Post Theming
 * @subpackage js
 * @author GrandSlambert
 * @copyright 2009-2011
 * @access public
 * @since 0.1
 */

/* Function to change tabs on the settings pages */
function post_theming_show_tab(tab) {
     /* Close Active Tab */
     activeTab = document.getElementById('active_tab').value;
     document.getElementById('post_theming_box_' + activeTab).style.display = 'none';
     document.getElementById('post_theming_' + activeTab).removeAttribute('class','post-theming-selected');

     /* Open new Tab */
     document.getElementById('post_theming_box_' + tab).style.display = 'block';
     document.getElementById('post_theming_' + tab).setAttribute('class','post-theming-selected');
     document.getElementById('active_tab').value = tab;
}

/* Function to invoke the save feature for the settings */
function post_theming_settings_save() {
     document.getElementById('post_theming_settings').submit();
}

/* Function to verify selection to reset options */
function verify_post_theming_reset(element) {
     if (element.checked) {
          if (prompt('Are you sure you want to reset all of your options? To confirm, type the word "reset" into the box.') == 'reset' ) {
               document.getElementById('post_theming_settings').submit();
          } else {
               element.checked = false;
          }
     }
}
var selectedRow = 1;

function onChangeStyle(value, row) {
    if (value == 'content') {
        document.getElementById('row_options_length_' + row).style.display = 'none';
    } else {
        document.getElementById('row_options_length_' + row).style.display = 'block';
    }
}

function onClickRow(row) {
    /* Swap the boxes */
    document.getElementById('row_options_' + selectedRow).style.display = 'none';
    document.getElementById('row_options_' + row).style.display = 'block';

    /* Highlight the new tab */
    document.getElementById('row_tab_' + selectedRow).removeAttribute('class','post-theming-selected');
    document.getElementById('row_tab_' + row).setAttribute('class','post-theming-selected');

    /* Mark current row as selected */
    selectedRow = row;
}