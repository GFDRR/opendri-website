<?php
/**
 * GMW main Tools page
 * 
 * @since 2.5
 * @Author Eyal Fitoussi
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

// include files in tools page only
if ( empty( $_GET['page'] ) || $_GET['page'] != 'gmw-tools' ) {
    return;
}

include( 'tabs/reset-gmw.php' );
include( 'tabs/system-info.php' );

/**
 * GMW Tools page
 * 
 * @since 2.5
 * 
 */
class GMW_Tools {

    public function __construct() {}

    /**
     * Display Tools page
     * 
     * @return [type] [description]
     */
    public function output() {

        $active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'system_info';
        ?>
        <div id="gmw-tools-page" class="wrap gmw-admin-page">
            <h2 class="gmw-wrap-top-h2">   
                <i class="gmw-icon-wrench"></i>
                <?php _e( 'Tools', 'geo-my-wp' ); ?>
                <?php gmw_admin_helpful_buttons(); ?>
            </h2>
            <div class="clear"></div>
            <h2 class="nav-tab-wrapper">
                <?php
                foreach( $this->get_tabs() as $tab_id => $tab_name ) {

                    $tab_url = admin_url( 'admin.php?page=gmw-tools&tab='.$tab_id );
                                
                    $active = $active_tab == $tab_id ? ' nav-tab-active' : '';
                    
                    echo '<a href="' . esc_url( $tab_url ) . '" title="' . esc_attr( $tab_name ) . '" class="nav-tab' . $active . '">' . esc_attr( $tab_name ) . '</a>';
                }
                ?>
            </h2>
            <div class="content metabox-holder">
                <div id="gmw-<?php echo $active_tab; ?>-tab-content" class="gmw-tools-tab-content">
                    <?php do_action( 'gmw_tools_'.$active_tab.'_tab' ); ?>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Retrieve tools tabs
     *
     * @since       2.5
     * @return      array
     * 
     */
    public function get_tabs() {
        
        $tabs                = array();
        $tabs['system_info'] = __( 'System Info', 'geo-my-wp' );
        $tabs['reset_gmw']   = __( 'Uninstall GEO my WP', 'geo-my-wp' );
        
        return apply_filters( 'gmw_tools_tabs', $tabs );
    }
}