<?php
/**
 * Bridge: TNP4B for BuddyMeet
 * Description: Adds new BuddyMeet conferences scheduled in groups to digests.
 * File name must follow the pattern: tnp4b-buddymeet-bridge.php
 */

if ( ! function_exists( 'tnp4b_append_to_buffer' ) ) {
    return; // Core function not available
}

// Check if BuddyMeet is active
if ( ! class_exists( 'BuddyMeet' ) ) {
    return;
}

/**
 * Hook into BuddyMeet conference creation
 * BuddyMeet fires 'buddymeet_conference_created' when a new conference is scheduled.
 */
add_action( 'buddymeet_conference_created', function( $conference_id, $group_id ) {
    $title = get_the_title( $conference_id );
    $link  = get_permalink( $conference_id );
    $date  = get_post_meta( $conference_id, 'buddymeet_date', true );
    $time  = get_post_meta( $conference_id, 'buddymeet_time', true );

    $html = '<div><strong>' . esc_html__( 'New BuddyMeet conference:', 'tnp4b' ) . '</strong> '
          . '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) . '</a>'
          . ( $date ? ' — ' . esc_html( $date ) : '' )
          . ( $time ? ' ' . esc_html( $time ) : '' )
          . '</div>';

    tnp4b_append_to_buffer( $group_id, $html );
}, 10, 2);
