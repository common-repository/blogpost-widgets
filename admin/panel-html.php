<?php
function blogpost_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    
    <div class="blogpost-admin-wrap">
        <div class="blogpost-panel-head">
            <?php
            $page_name = sanitize_text_field($_GET['page']);
            //echo $page_name;
            ?>
            <div class="side-panel-col">
                <div class="panel-logo">
                    <!-- <span><img src="<?php echo BLOGPOST_ASSETS_PATH ?>img/logo-admin-screen.png" alt="blogpost Logo"></span> -->
                    <span class="cb-logo-title"><?php esc_html_e( 'Blogpost  Addons', 'blogpost-widgets'); ?></span>
                </div>
            </div>
            <div class="side-panel-col">
                <ul class="blogpost-panel-tabs">
                    <li>
                        <a href="admin.php?page=blogpost" class="panel-tab-link<?php echo( esc_attr($page_name == 'blogpost' ? ' active': '') ) ?>">
                        <i class="icon-cubes"></i> Page Builders</a>
                    </li>
                    <li>
                        <a href="admin.php?page=cb-widgets" class="panel-tab-link<?php echo( esc_attr($page_name == 'cb-widgets' ? ' active': '') ) ?>">
                        <i class="icon-group"></i> Elements </a>
                    </li>
                    <li>
                        <a href="admin.php?page=cb-support" class="panel-tab-link<?php echo( esc_attr($page_name == 'cb-support' ? ' active': '') ) ?>">
                        <i class="icon-support"></i> Support</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="blogpost-panel-content <?php echo 'page-'.esc_attr($page_name) ?>">
            <?php
                if ( isset( $_GET['settings-updated'] ) ) {
                    // add settings saved message with the class of "updated"
                    add_settings_error( 'blogpost_messages', 'blogpost_message', __( 'Saved Settings ', 'blogpost-widgets' ), 'updated' );
                }
            
                // show error/update messages
                settings_errors( 'blogpost_messages' );
            ?>
                <form action="options.php" method="post">
                    <?php
                    if($page_name == 'blogpost') {
                        // output security fields for the registered setting "blogpost"
                        settings_fields( 'blogpost' );
                        ?>
                        <h2 class="panel-section-heading"><?php esc_html_e('Page Builders', 'blogpost-widgets') ?></h2>
                        <h3 class="panel-section-subheading"><?php esc_html_e( 'Select the Page builders you want to enable blogpost widgets on.', 'blogpost-widgets' ); ?></h3>
                        <!-- <div class="cb-builder-notice"><?php esc_html_e( 'You should enable page builder.') ?></div> -->
                        <div class="form-fields-row form-widgets-row">
                            <?php
                                // Output setting fields for page builders section
                                blogpost_settings_section_field( 'blogpost', 'blogpost_builders_elementor' );  //blogpost_settings_section_field( 'blogpost', 'blogpost_builders_wordpress' );
                                
                            ?>
                        </div>
                        
                        <?php
                    }
                    if($page_name == 'cb-widgets') {
                        // output security fields for the registered setting "blogpost"
                        settings_fields( 'cb-widgets' );
                        ?>
                        <h2 class="panel-section-heading"><?php esc_html_e('Blog Post Widgets') ?></h2>
                        <h3 class="panel-section-subheading"><?php esc_html_e( 'Select the widgets you want to enable.', 'blogpost-widgets' ); ?></h3>
                        <h3 class="widgets-section__header">Dynamic Content Elements </h3>
                        <div class="form-fields-row widgets-row">
                            <?php
                                // Output setting fields for page widgets section
                                blogpost_settings_section_field( 'cb-widgets', 'blogpost_widgets_posts_grid' );
                                blogpost_settings_section_field( 'cb-widgets', 'blogpost_widgets_posts_list' );
                                blogpost_settings_section_field( 'cb-widgets', 'blogpost_widgets_posts_carousel' );
                                blogpost_settings_section_field( 'cb-widgets', 'blogpost_widgets_posts_classic' );
                                blogpost_settings_section_field( 'cb-widgets', 'blogpost_widgets_category_tiles' );
                                blogpost_settings_section_field( 'cb-widgets', 'blogpost_widgets_posts_slider' );
                                blogpost_settings_section_field( 'cb-widgets', 'blogpost_widgets_author_box' );
                                blogpost_settings_section_field( 'cb-widgets', 'blogpost_widgets_news_ticker' );
                            ?>
                        </div>
                        
                        <?php
                    }
                    if($page_name == 'cb-support') { ?>
                        <h2 class="panel-section-heading"><?php esc_html_e('Help & Support') ?></h2>
                        <h3 class="panel-section-subheading"><?php esc_html_e( 'Feel free to reach us for help or support via any of the channel mentioned below.', 'blogpost-widgets' ); ?></h3>
                        <div class="cb-supoort-boxes-container">

                            <div class="cb-support-box">
                                <div class="cb-support-box-icon">
                                    <!-- <img src="<?php echo BLOGPOST_ASSETS_PATH ?>img/admin_icons/doc.png" alt="Documentation"> -->
                                </div>
                                <div class="cb-support-box-text">View Knowledgebase</div>
                                <div class="cb-support-box-link">
                                    <a href="#" target="_blank">Read Now</a>
                                </div>
                            </div>

                            <div class="cb-support-box">
                                <div class="cb-support-box-icon">
                                    <!-- <img src="<?php echo BLOGPOST_ASSETS_PATH ?>img/admin_icons/fb-group.png" alt="Facebook Group"> -->
                                    
                                </div>
                                <div class="cb-support-box-text">Join the Community</div>
                                <div class="cb-support-box-link">
                                    <a href="#" target="_blank">Join Group</a>
                                </div>
                            </div>

                            <div class="cb-support-box">
                                <div class="cb-support-box-icon">
                                    <!-- <img src="<?php echo BLOGPOST_ASSETS_PATH ?>img/admin_icons/forums.png" alt="Forums"> -->
                                </div>
                                <div class="cb-support-box-text">Forums</div>
                                <div class="cb-support-box-link">
                                    <a href="https://wordpress.org/support/plugin/blogpost-widgets/" target="_blank">Post Question</a>
                                </div>
                            </div>
                            <div class="cb-support-box">
                                <div class="cb-support-box-icon">
                                    <!-- <img src="<?php echo BLOGPOST_ASSETS_PATH ?>img/admin_icons/forums.png" alt="Forums"> -->
                                </div>
                                <div class="cb-support-box-text"> Show Your Love</div>
                                <div class="cb-support-box-link">
                                    <a href="https://wordpress.org/plugins/blogpost-widgets/#reviews" target="_blank">Reviews</a>
                                </div>
                            </div>

                        </div>
                    <?php } ?>
                    
                    <?php 
                    submit_button( 'Save Option' );
                    ?>
                </form>
        </div> 
    </div>
    
    <?php
}
?>