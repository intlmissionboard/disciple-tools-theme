<?php
declare(strict_types=1);

if ( ! current_user_can( 'access_clusters' ) ) {
    wp_safe_redirect( '/settings' );
}

( function() {

//    if ( !Disciple_Tools_Clusters::can_view( 'clusters', get_the_ID() )){
//        get_template_part( "403" );
//        die();
//    }

//    Disciple_Tools_Notifications::process_new_notifications( get_the_ID() ); // removes new notifications for this post
//    $following = Disciple_Tools_Posts::get_users_following_post( "clusters", get_the_ID() );
//    $cluster = Disciple_Tools_Clusters::get_cluster( get_the_ID(), true, true );
    $cluster = [];
    $cluster_fields = Disciple_Tools_Clusters_Post_Type::instance()->get_custom_fields_settings();
    $current_user_id = get_current_user_id();
    get_header();

    ?>

    <?php
    dt_print_details_bar(
        false,
        false,
        false
    ); ?>

<div id="errors"> </div>

<div id="content">
    <span id="cluster-id" style="display: none"><?php echo get_the_ID()?></span>
    <span id="post-id" style="display: none"><?php echo get_the_ID()?></span>
    <span id="post-type" style="display: none">cluster</span>

    <div id="inner-content" class="grid-x grid-margin-x grid-margin-y">

        <main id="main" class="large-7 medium-12 small-12 cell" role="main" style="padding:0">
            <div class="cell grid-y grid-margin-y" style="display: block">
                
                <!-- Requires update block -->
                <section class="cell small-12 update-needed-notification"
                         style="display: <?php echo esc_html( ( isset( $cluster['requires_update'] ) && $cluster['requires_update'] === true ) ? "block" : "none" ) ?> ">
                    <div class="bordered-box detail-notification-box" style="background-color:#F43636">
                        <h4><img src="<?php echo esc_html( get_template_directory_uri() . '/dt-assets/images/alert-circle-exc.svg' ) ?>"/><?php esc_html_e( 'This cluster needs an update', 'disciple_tools' ) ?>.</h4>
                        <p><?php esc_html_e( 'Please provide an update by posting a comment.', 'disciple_tools' )?>.</p>
                    </div>
                </section>
                <!--
                    DETAILS SECTION
                -->
                <section id="contact-details" class="cell small-12 grid-margin-y">
                    <div class="cell">
                        <section class="bordered-box">
                            <div style="display: flex;">
                                <div class="item-details-header" style="flex-grow:1">
                                    <i class="fi-rss large" style="padding-bottom: 1.2rem"></i>
                                    <span class="title"><?php the_title_attribute(); ?></span>
                                </div>
                                <div>
                                    <button class="" id="open-edit">
                                        <i class="fi-pencil"></i>
                                        <span><?php esc_html_e( 'Edit', 'disciple_tools' )?></span>
                                    </button>
                                </div>
                            </div>
                            <div class="grid-x grid-margin-x" style="margin-top: 20px">
                            </div>

                            <hr />

                            <div class="display-fields grid-x grid-margin-x">
                                <div class="xlarge-6 large-6 medium-6 small-12 cell">
                                    <div class="section-subheader cell">
                                        <img src="<?php echo esc_url( get_template_directory_uri() ) . '/dt-assets/images/location.svg' ?>">
                                        <?php esc_html_e( 'Locations', 'disciple_tools' ) ?>
                                    </div>
                                    <div class="locations">
                                        <var id="locations-result-container" class="result-container"></var>
                                        <div id="locations_t" name="form-locations" class="scrollable-typeahead typeahead-margin-when-active">
                                            <div class="typeahead__container">
                                                <div class="typeahead__field">
                                                    <span class="typeahead__query">
                                                        <input class="js-typeahead-locations"
                                                               name="locations[query]" placeholder="<?php esc_html_e( "Search Locations", 'disciple_tools' ) ?>"
                                                               autocomplete="off">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="xlarge-6 large-6 medium-6 small-12 cell">
                                    <div class="section-subheader cell">
                                        <img src="<?php echo esc_url( get_template_directory_uri() ) . '/dt-assets/images/location.svg' ?>">
                                        <?php esc_html_e( 'Leaders', 'disciple_tools' ) ?>
                                    </div>
                                    <div class="leaders">
                                        <var id="leaders-result-container" class="result-container"></var>
                                        <div id="leaders_t" name="form-leaders" class="scrollable-typeahead typeahead-margin-when-active">
                                            <div class="typeahead__container">
                                                <div class="typeahead__field">
                                                    <span class="typeahead__query">
                                                        <input class="js-typeahead-leaders"
                                                               name="leaders[query]" placeholder="<?php esc_html_e( "Search Leaders", 'disciple_tools' ) ?>"
                                                               autocomplete="off">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="xlarge-6 large-6 medium-6 small-12 cell">
                                    <div class="section-subheader cell">
                                        <img src="<?php echo esc_url( get_template_directory_uri() ) . '/dt-assets/images/location.svg' ?>">
                                        <?php esc_html_e( 'Parents Clusters', 'disciple_tools' ) ?>
                                    </div>
                                    <div class="parents">
                                        <var id="parents-result-container" class="result-container"></var>
                                        <div id="parents_t" name="form-parents" class="scrollable-typeahead typeahead-margin-when-active">
                                            <div class="typeahead__container">
                                                <div class="typeahead__field">
                                                    <span class="typeahead__query">
                                                        <input class="js-typeahead-parents"
                                                               name="parents[query]" placeholder="<?php esc_html_e( "Search Parents", 'disciple_tools' ) ?>"
                                                               autocomplete="off">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="xlarge-6 large-6 medium-6 small-12 cell">
                                    <div class="section-subheader cell">
                                        <img src="<?php echo esc_url( get_template_directory_uri() ) . '/dt-assets/images/location.svg' ?>">
                                        <?php esc_html_e( 'Child Clusters', 'disciple_tools' ) ?>
                                    </div>
                                    <div class="children">
                                        <var id="children-result-container" class="result-container"></var>
                                        <div id="children_t" name="form-children" class="scrollable-typeahead typeahead-margin-when-active">
                                            <div class="typeahead__container">
                                                <div class="typeahead__field">
                                                    <span class="typeahead__query">
                                                        <input class="js-typeahead-children"
                                                               name="children[query]" placeholder="<?php esc_html_e( "Search Children", 'disciple_tools' ) ?>"
                                                               autocomplete="off">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </section>
                    </div>
                </section>
                <div class="cell small-12">
                    <div class="grid-x grid-margin-x grid-margin-y grid">
                        <section class="xlarge-6 large-12 medium-6 cell grid-item">
                            <div class="bordered-box">
                            <div class="section-header"><?php esc_html_e( 'Groups', 'disciple_tools' )?></div>
                                <div class="section-subheader cell">
                                    <?php esc_html_e( 'Groups', 'disciple_tools' ) ?>
                                </div>
                                <div class="groups">
                                    <var id="groups-result-container" class="result-container"></var>
                                    <div id="groups_t" name="form-groups" class="scrollable-typeahead typeahead-margin-when-active">
                                        <div class="typeahead__container">
                                            <div class="typeahead__field">
                                                <span class="typeahead__query">
                                                    <input class="js-typeahead-groups"
                                                           name="groups[query]" placeholder="<?php esc_html_e( "Search Groups", 'disciple_tools' ) ?>"
                                                           autocomplete="off">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-subheader cell">
                                    Count
                                </div>
                                <input id="member_count"
                                       class="number-input" type="number" min="0"
                                       placeholder="100"
                                       value="<?php echo esc_html( $cluster["member_count"] ?? "" ) ?>">

                                <div class="section-subheader cell">
                                    Stats:
                                </div>
                                <p>2019: 24</p>
                                <p>2018: 7</p>
                                <p>2017: 3</p>
                            </div>
                        </section>
                        
                        
                        <section class="xlarge-6 large-12 medium-6 cell grid-item">
                            <div class="bordered-box">
                            <div class="section-header"><?php esc_html_e( 'Contacts', 'disciple_tools' )?></div>
                                <div class="section-subheader cell">
                                    <?php esc_html_e( 'Contacts', 'disciple_tools' ) ?>
                                </div>
                                <div class="contacts">
                                    <var id="contacts-result-container" class="result-container"></var>
                                    <div id="contacts_t" name="form-contacts" class="scrollable-typeahead typeahead-margin-when-active">
                                        <div class="typeahead__container">
                                            <div class="typeahead__field">
                                                <span class="typeahead__query">
                                                    <input class="js-typeahead-contacts"
                                                           name="contacts[query]" placeholder="<?php esc_html_e( "Search Contacts", 'disciple_tools' ) ?>"
                                                           autocomplete="off">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-subheader cell">
                                    Count
                                </div>
                                <input id="member_count"
                                       class="number-input" type="number" min="0"
                                       placeholder="100"
                                       value="<?php echo esc_html( $cluster["member_count"] ?? "" ) ?>">

                                <div class="section-subheader cell">
                                    Baptisms:
                                </div>
                                <input id="member_count"
                                       class="number-input" type="number" min="0"
                                       placeholder="100"
                                       value="<?php echo esc_html( $cluster["member_count"] ?? "" ) ?>">


                                <div class="section-subheader cell">
                                    Stats:
                                </div>
                                <p>2019: 120</p>
                                <p>2018: 35</p>
                                <p>2017: 10</p>
                            </div>
                        </section>


                        <?php
                        //get sections added by plugins
                        $sections = apply_filters( 'dt_details_additional_section_ids', [], "clusters" );
                        //get custom sections
                        $custom_tiles = dt_get_option( "dt_custom_tiles" );
                        foreach ( $custom_tiles["clusters"] ?? [] as $tile_key => $tile_options ){
                            if ( !in_array( $tile_key, $sections ) ){
                                $sections[] = $tile_key;
                            }
                            //remove section if hidden
                            if ( isset( $tile_options["hidden"] ) && $tile_options["hidden"] == true ){
                                if ( ( $index = array_search( $tile_key, $sections ) ) !== false) {
                                    unset( $sections[ $index ] );
                                }
                            }
                        }
                        foreach ( $sections as $section ){
                            ?>
                            <section id="<?php echo esc_html( $section ) ?>" class="xlarge-6 large-12 medium-6 cell grid-item">
                                <div class="bordered-box">
                                    <?php
                                    // let the plugin add section content
                                    do_action( "dt_details_additional_section", $section );
                                    //setup tile label if see by customizations
                                    if ( isset( $custom_tiles["clusters"][$section]["label"] ) ){ ?>
                                        <label class="section-header">
                                            <?php echo esc_html( $custom_tiles["clusters"][$section]["label"] )?>
                                        </label>
                                    <?php }
                                    //setup the order of the tile fields
                                    $order = $custom_tiles["clusters"][$section]["order"] ?? [];
                                    foreach ( $cluster_fields as $key => $option ){
                                        if ( isset( $option["tile"] ) && $option["tile"] === $section ){
                                            if ( !in_array( $key, $order )){
                                                $order[] = $key;
                                            }
                                        }
                                    }
                                    foreach ( $order as $field_key ) {
                                        if ( !isset( $cluster_fields[$field_key] ) ){
                                            continue;
                                        }
                                        $field = $cluster_fields[$field_key];
                                        if ( isset( $field["tile"] ) && $field["tile"] === $section ){ ?>
                                            <div class="section-subheader">
                                                <?php echo esc_html( $field["name"] )?>
                                            </div>
                                            <?php
                                            /**
                                             * Key Select
                                             */
                                            if ( $field["type"] === "key_select" ) : ?>
                                                <select class="select-field" id="<?php echo esc_html( $field_key ); ?>">
                                                    <?php foreach ($field["default"] as $option_key => $option_value):
                                                        $selected = isset( $cluster[$field_key]["key"] ) && $cluster[$field_key]["key"] === $option_key; ?>
                                                        <option value="<?php echo esc_html( $option_key )?>" <?php echo esc_html( $selected ? "selected" : "" )?>>
                                                            <?php echo esc_html( $option_value["label"] ) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            <?php elseif ( $field["type"] === "multi_select" ) : ?>
                                                <div class="small button-cluster" style="display: inline-block">
                                                    <?php foreach ( $cluster_fields[$field_key]["default"] as $option_key => $option_value ): ?>
                                                        <?php
                                                        $class = ( in_array( $option_key, $cluster[$field_key] ?? [] ) ) ?
                                                            "selected-select-button" : "empty-select-button"; ?>
                                                        <button id="<?php echo esc_html( $option_key ) ?>" data-field-key="<?php echo esc_html( $field_key ) ?>"
                                                                class="dt_multi_select <?php echo esc_html( $class ) ?> select-button button ">
                                                            <?php echo esc_html( $cluster_fields[$field_key]["default"][$option_key]["label"] ) ?>
                                                        </button>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php elseif ( $field["type"] === "text" ) :?>
                                                <input id="<?php echo esc_html( $field_key ) ?>" type="text"
                                                       class="text-input"
                                                       value="<?php echo esc_html( $cluster[$field_key] ?? "" ) ?>"/>
                                            <?php elseif ( $field["type"] === "date" ) :?>
                                                <input type="text" class="date-picker dt_date_picker"
                                                       id="<?php echo esc_html( $field_key ) ?>"
                                                       value="<?php echo esc_html( $cluster[$field_key]["formatted"] ?? '' )?>">
                                            <?php endif;
                                        }
                                    }
                                    ?>
                                </div>
                            </section>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </main> <!-- end #main -->

        <aside class="auto cell grid-x">
            <section class="bordered-box comment-activity-section cell"
                     id="comment-activity-section">
                <?php get_template_part( 'dt-assets/parts/loop', 'activity-comment' ); ?>
            </section>
        </aside>

    </div> <!-- end #inner-content -->

</div> <!-- end #content -->


<!--    Modals-->
<!--    --><?php //get_template_part( 'dt-assets/parts/modals/modal', 'share' ); ?>
<!--    --><?php //get_template_part( 'dt-assets/parts/modals/modal', 'new-cluster' ); ?>
<!--    --><?php //get_template_part( 'dt-assets/parts/modals/modal', 'new-contact' ); ?>




    <?php
} )();

get_footer();
