<?php
/*
 * Plugin Name:       Admin Color
 * Description:       Change the admin color.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sudin Manandhar
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       admin-color
 * Domain Path:       /languages
 */

/**
 * Adds a submenu page under a custom post type parent.
 */
function admin_color_menu() {
    add_submenu_page(
        'options-general.php',
        __( 'Admin Color', 'textdomain' ),
        __( 'Admin Color', 'textdomain' ),
        'manage_options',
        'admin-color',
        'admin_color_callback'
    );
}
add_action( 'admin_menu', 'admin_color_menu' );

/**
 * Display callback for the submenu page.
 */
function admin_color_callback() { 
    ?>
    <div class="wrap">
        <h1><?php _e( 'Admin Color', 'textdomain' ); ?></h1>
        <form method="post" action="options.php">
            <?php settings_fields('admin-color-settings-group'); ?>
            <?php do_settings_sections('admin-color-settings-group'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="admin-color">Select Color</label></th>
                    <td>
                        <input type="color" id="admin-color" name="admin_color" value="<?php echo esc_attr(get_option('admin_color', '#ffffff')); ?>" />
                        <p class="description">Select the color for wp admin.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>

    </div>
    <?php
}

// Register the plugin settings
add_action('admin_init', 'admin_color_plugin_settings');
function admin_color_plugin_settings() {
    register_setting(
        'admin-color-settings-group',
        'admin_color',
        array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_hex_color',
            'default' => '#ffffff'
        )
    );
}

add_action( 'admin_footer', 'admin_color_footer' );
function admin_color_footer(){ ?>
    <style>
        body #wpadminbar,
        body #adminmenuwrap #adminmenu{
            background-color: <?php echo get_option('admin_color', '#ffffff'); ?>;
        }
    </style>
    <?php
}