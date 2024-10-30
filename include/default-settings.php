<?php
function coneblod_set_default_settings() {
    add_option('blogpost_builders_elementor', 'on');
    add_option('blogpost_widgets_posts_grid', 'on');
    add_option('blogpost_widgets_posts_list', 'on');
    add_option('blogpost_widgets_posts_carousel', 'on');
    add_option('blogpost_widgets_category_tiles', 'off');
    add_option('blogpost_widgets_posts_classic', 'off');
    add_option('blogpost_widgets_posts_slider', 'off');
    add_option('blogpost_widgets_author_box', 'off');
    add_option('blogpost_widgets_news_ticker', 'off');
}