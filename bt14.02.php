<?php
/*
Plugin Name: Quick Chat Button
Description: Hiển thị nút chat nhanh với Messenger và Zalo trên website.
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit; // Ngăn truy cập trực tiếp
}

// Đăng ký shortcode
add_shortcode('quick_chat', 'qcb_display_chat_button');

// Hàm hiển thị nút chat nhanh
function qcb_display_chat_button() {
    $enable_messenger = get_option('qcb_enable_messenger', '1');
    $enable_zalo = get_option('qcb_enable_zalo', '1');
    $messenger_link = esc_url(get_option('qcb_messenger_link', '#'));
    $zalo_phone = esc_attr(get_option('qcb_zalo_phone', '')); 
    $messenger_label = esc_html(get_option('qcb_messenger_label', 'Chat với Messenger'));
    $zalo_label = esc_html(get_option('qcb_zalo_label', 'Chat với Zalo'));
    $messenger_color = esc_attr(get_option('qcb_messenger_color', '#0084FF'));
    $zalo_color = esc_attr(get_option('qcb_zalo_color', '#0068FF'));

    $html = '<div class="quick-chat-buttons">';
    
    if ($enable_messenger) {
        $html .= '<a href="' . $messenger_link . '" target="_blank" class="quick-chat-link" style="background-color: ' . $messenger_color . ';" title="' . $messenger_label . '"><i class="fab fa-facebook-messenger"></i></a>';
    }
    
    if ($enable_zalo) {
        $html .= '<a href="https://zalo.me/' . $zalo_phone . '" target="_blank" class="quick-chat-link" style="background-color: ' . $zalo_color . ';" title="' . $zalo_label . '"><i class="fas fa-comment-alt"></i></a>';
    }

    $html .= '</div>';

    return $html;
}

// Đăng ký Font Awesome
add_action('wp_enqueue_scripts', 'qcb_enqueue_font_awesome');
function qcb_enqueue_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
}

// Thêm menu cài đặt vào WordPress Admin
add_action('admin_menu', 'qcb_add_settings_menu');
function qcb_add_settings_menu() {
    add_menu_page(
        'Quick Chat Settings',
        'Quick Chat',
        'manage_options',
        'quick-chat-settings',
        'qcb_settings_page',
        'dashicons-format-chat',
        100
    );
}

// Hàm hiển thị trang cài đặt
function qcb_settings_page() {
    ?>
    <div class="wrap">
        <h1>Cài đặt Nút Chat Nhanh</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('qcb_settings_group');
            do_settings_sections('quick-chat-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Đăng ký cài đặt
add_action('admin_init', 'qcb_register_settings');
function qcb_register_settings() {
    register_setting('qcb_settings_group', 'qcb_enable_messenger');
    register_setting('qcb_settings_group', 'qcb_enable_zalo');
    register_setting('qcb_settings_group', 'qcb_messenger_link');
    register_setting('qcb_settings_group', 'qcb_zalo_phone');
    register_setting('qcb_settings_group', 'qcb_messenger_label');
    register_setting('qcb_settings_group', 'qcb_zalo_label');
    register_setting('qcb_settings_group', 'qcb_messenger_color');
    register_setting('qcb_settings_group', 'qcb_zalo_color');

    add_settings_section('qcb_settings_section', 'Cấu hình Nút Chat', 'qcb_settings_section_callback', 'quick-chat-settings');
    add_settings_field('qcb_enable_messenger', 'Bật Messenger', 'qcb_enable_messenger_callback', 'quick-chat-settings', 'qcb_settings_section');
    add_settings_field('qcb_enable_zalo', 'Bật Zalo', 'qcb_enable_zalo_callback', 'quick-chat-settings', 'qcb_settings_section');
    add_settings_field('qcb_messenger_link', 'Liên kết Messenger', 'qcb_messenger_link_callback', 'quick-chat-settings', 'qcb_settings_section');
    add_settings_field('qcb_zalo_phone', 'Số điện thoại Zalo', 'qcb_zalo_phone_callback', 'quick-chat-settings', 'qcb_settings_section');
    add_settings_field('qcb_messenger_label', 'Nội dung Messenger', 'qcb_messenger_label_callback', 'quick-chat-settings', 'qcb_settings_section');
    add_settings_field('qcb_zalo_label', 'Nội dung Zalo', 'qcb_zalo_label_callback', 'quick-chat-settings', 'qcb_settings_section');
    add_settings_field('qcb_messenger_color', 'Màu Messenger', 'qcb_messenger_color_callback', 'quick-chat-settings', 'qcb_settings_section');
    add_settings_field('qcb_zalo_color', 'Màu Zalo', 'qcb_zalo_color_callback', 'quick-chat-settings', 'qcb_settings_section');
}

function qcb_settings_section_callback() {
    echo '<p>Cấu hình các tùy chọn cho nút chat nhanh.</p>';
}
function qcb_enable_messenger_callback() {
    echo '<input type="checkbox" name="qcb_enable_messenger" value="1" ' . checked(1, get_option('qcb_enable_messenger', 1), false) . '>';
}
function qcb_enable_zalo_callback() {
    echo '<input type="checkbox" name="qcb_enable_zalo" value="1" ' . checked(1, get_option('qcb_enable_zalo', 1), false) . '>';
}
function qcb_messenger_link_callback() {
    echo '<input type="text" name="qcb_messenger_link" value="' . esc_attr(get_option('qcb_messenger_link', '#')) . '" class="regular-text">';
}
function qcb_zalo_phone_callback() {
    echo '<input type="text" name="qcb_zalo_phone" value="' . esc_attr(get_option('qcb_zalo_phone', '')) . '" class="regular-text">';
}
function qcb_messenger_label_callback() {
    echo '<input type="text" name="qcb_messenger_label" value="' . esc_attr(get_option('qcb_messenger_label', 'Chat với Messenger')) . '" class="regular-text">';
}
function qcb_zalo_label_callback() {
    echo '<input type="text" name="qcb_zalo_label" value="' . esc_attr(get_option('qcb_zalo_label', 'Chat với Zalo')) . '" class="regular-text">';
}
function qcb_messenger_color_callback() {
    echo '<input type="color" name="qcb_messenger_color" value="' . esc_attr(get_option('qcb_messenger_color', '#0084FF')) . '">';
}
function qcb_zalo_color_callback() {
    echo '<input type="color" name="qcb_zalo_color" value="' . esc_attr(get_option('qcb_zalo_color', '#0068FF')) . '">';
}
