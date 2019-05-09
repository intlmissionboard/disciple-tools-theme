<div class="reveal" id="create-location-modal" data-reveal data-reset-on-close>

    <p class="lead"><?php esc_html_e( 'Create Location', 'disciple_tools' )?></p>

    <form class="js-create-group hide-after-group-create">
        <label for="title">
            <?php esc_html_e( "Name of group", "disciple_tools" ); ?>
        </label>
        <input name="title" type="text" placeholder="<?php esc_html_e( "Name", "disciple_tools" ); ?>" required aria-describedby="name-help-text">
        <p class="help-text" id="name-help-text"><?php esc_html_e( "This is required", "disciple_tools" ); ?></p>

        <div style="text-align: center">
            <button class="button loader js-create-group-button" type="submit"><?php esc_html_e( "Create Group", "disciple_tools" ); ?></button>
        </div>
    </form>

    <p class="reveal-after-group-create" style="display: none"><?php esc_html_e( "Group Created", 'disciple_tools' ) ?>: <span id="new-group-link"></span></p>


    <div class="grid-x">
        <button class="button button-cancel clear hide-after-group-create" data-close aria-label="Close reveal" type="button">
            <?php esc_html_e( 'Cancel', 'disciple_tools' )?>
        </button>
        <button class="button reveal-after-group-create button-cancel clear" data-close type="button" id="create-group-return" style="display: none">
            <?php
            if ( is_singular( "contacts" )){
                esc_html_e( 'Return to Contact', 'disciple_tools' );
            } elseif ( is_singular( "groups" )){
                esc_html_e( 'Return to Group', 'disciple_tools' );
            } else {
                esc_html_e( 'Return', 'disciple_tools' );
            }
            ?>
        </button>
        <a class="button reveal-after-group-create" id="go-to-group" style="display: none">
            <?php esc_html_e( 'Edit new Group', 'disciple_tools' )?>
        </a>
        <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
