<?php
/**
 * Add the top level menu page.
 */
function blogpost_options_page() {
    add_menu_page(
        'blogpost Widgets',
        'BlogPost',
        'manage_options',
        'blogpost',
        'blogpost_options_page_html',
        'dashicons-welcome-widgets-menus',
        20
    );
}
add_action( 'admin_menu', 'blogpost_options_page' );

/**
 * Add sub-menu page.
 */
function blogpost_options_page_builders() {
    add_submenu_page(
        'blogpost',
        'blogpost Builders',
        'Builders',
        'manage_options',
        'blogpost',
        'blogpost_options_page_html' );
}
add_action('admin_menu', 'blogpost_options_page_builders');
function blogpost_options_page_widgets() {
    add_submenu_page(
        'blogpost',
        'blogpost Widgets',
        'Widgets',
        'manage_options',
        'cb-widgets',
        'blogpost_options_page_html' );
}
add_action('admin_menu', 'blogpost_options_page_widgets');



function blogpost_options_page_support() {
    add_submenu_page(
        'blogpost',
        'blogpost Support',
        'Support',
        'manage_options',
        'cb-support',
        'blogpost_options_page_html' );
}
add_action('admin_menu', 'blogpost_options_page_support');