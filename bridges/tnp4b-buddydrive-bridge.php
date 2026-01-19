<?php
/**
 * Bridge: TNP4B for BuddyDrive
 * Description: Adds new BuddyDrive files shared in groups to digests.
 * File name must follow the pattern: tnp4b-buddydrive-bridge.php
 */

if ( ! function_exists( 'tnp4b_append_to_buffer' ) ) {
    return; // Core function not available
}

// Check if BuddyDrive is active
if ( ! class_exists( 'BuddyDrive' ) ) {
    return;
}

/**
 * Hook into BuddyDrive file creation
 * BuddyDrive fires 'buddydrive_item_created' when a new file is added.
 */
add_action( 'buddydrive_item_created', function( $item_id, $group_id ) {
    $title = get_the_title( $item_id );
    $link  = get_permalink( $item_id );
    $type  = get_post_mime_type( $item_id );

    $html = '<div><strong>' . esc_html__( 'New BuddyDrive file:', 'tnp4b' ) . '</strong> '
          . '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) . '</a>'
          . ( $type ? ' (' . esc_html( $type ) . ')' : '' )
          . '</div>';

    tnp4b_append_to_buffer( $group_id, $html );
}, 10, 2);
