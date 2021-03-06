<?php

Disciple_Tools_Metrics_Personal::instance();
class Disciple_Tools_Metrics_Personal extends Disciple_Tools_Metrics_Hooks_Base
{
    public $permissions = [ 'access_contacts' ];

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        if ( !$this->has_permission() ){
            return;
        }
        $url_path = dt_get_url_path();

        if ( 'metrics' === substr( $url_path, '0', 7 ) ) {

            add_filter( 'dt_metrics_menu', [ $this, 'add_overview_menu' ], 20 );

            if ( 'metrics' === $url_path ) {
                add_action( 'wp_enqueue_scripts', [ $this, 'scripts' ], 99 );
            }
        }
    }

    public function add_overview_menu( $content ) {
        $content .= '
            <li><a href="'. site_url( '/metrics/' ) .'" >' .  esc_html__( 'Personal', 'disciple_tools' ) . '</a></li>
            ';
        return $content;
    }

    public function scripts() {
        wp_enqueue_script( 'dt_metrics_personal_script', get_stylesheet_directory_uri() . '/dt-metrics/metrics-personal.js', [
            'jquery',
            'jquery-ui-core',
            'amcharts-core',
            'amcharts-charts'
        ], filemtime( get_theme_file_path() . '/dt-metrics/metrics-personal.js' ), true );

        wp_localize_script(
            'dt_metrics_personal_script', 'dtMetricsPersonal', [
                'root' => esc_url_raw( rest_url() ),
                'theme_uri' => get_stylesheet_directory_uri(),
                'nonce' => wp_create_nonce( 'wp_rest' ),
                'current_user_login' => wp_get_current_user()->user_login,
                'current_user_id' => get_current_user_id(),
                'map_key' => dt_get_option( 'map_key' ),
                'data' => $this->overview(),
            ]
        );
    }

    public function overview() {
        $data = [
            'translations' => [
                'title' => __( 'My Overview', 'disciple_tools' ),
                'title_waiting_on_accept' => __( 'Waiting on Accept', 'disciple_tools' ),
                'title_waiting_on_update' => __( 'Waiting on Update', 'disciple_tools' ),
                'title_contacts' => __( 'Contacts', 'disciple_tools' ),
                'title_groups' => __( 'Groups', 'disciple_tools' ),
                'title_total_groups' => __( 'Total Groups', 'disciple_tools' ),
                'title_needs_training' => __( 'Needs Training', 'disciple_tools' ),
                'title_fully_practicing' => __( 'Fully Practicing', 'disciple_tools' ),
                'title_group_types' => __( 'Group Types', 'disciple_tools' ),
                'title_generations' => __( 'Group and Church Generations', 'disciple_tools' ),
                'title_teams' => __( 'Lead Teams', 'disciple_tools' ),
                'label_active_contacts'  => __( 'Active Contacts', 'disciple_tools' ),
                'total_groups'    => __( 'Total Groups', 'disciple_tools' ),
                'updates_needed'  => __( 'Updates Needed', 'disciple_tools' ),
                'attempts_needed' => __( 'Attempts Needed', 'disciple_tools' ),
                'label_groups_by_type' => strtolower( __( 'groups by type', 'disciple_tools' ) ),
                'label_number_of_contacts' => __( 'number of contacts', 'disciple_tools' ),
                'label_my_follow_up_progress' => __( 'Follow-up of my active contacts', 'disciple_tools' ),
                'label_group_needing_training' => __( 'Active Group Health Metrics', 'disciple_tools' ),
                'label_stats_as_of' => strtolower( __( 'stats as of', 'disciple_tools' ) ),
                'label_pre_group' => __( 'Pre-Group', 'disciple_tools' ),
                'label_group' => __( 'Group', 'disciple_tools' ),
                'label_church' => __( 'Church', 'disciple_tools' ),
                'label_generation' => __( 'Generation', 'disciple_tools' ),
            ],
            'hero_stats'        => self::chart_my_hero_stats(),
            'contacts_progress' => self::chart_contacts_progress(),
            'group_types'       => self::chart_group_types(),
            'group_health'      => self::chart_group_health(),
            'group_generations' => self::chart_group_generations(),
        ];

        return apply_filters( 'dt_my_metrics', $data );
    }
}
