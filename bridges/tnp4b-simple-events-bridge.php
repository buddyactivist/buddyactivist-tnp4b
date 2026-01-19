<?php
/**
 * Bridge: TNP4B for BuddyPress Simple Events
 * Description: Adds new group events to digests.
 * File name must follow the pattern: tnp4b-simple-events-bridge.php
 */

if ( ! function_exists( 'tnp4b_append_to_buffer' ) ) {
    return; // Core function not available
}

// Check if BuddyPress Simple Events is active
if ( ! class_exists( 'BP_Simple_Events' ) ) {
    return;
}

/**
 * Hook into event creation
 * BuddyPress Simple Events fires 'bp_simple_events_event_created' when a new event is added.
 */
add_action( 'bp_simple_events_event_created', function( $event_id, $group_id ) {
    $title = get_the_title( $event_id );
    $link  = get_permalink( $event_id );
    $date  = get_post_meta( $event_id, 'bp_simple_events_date', true );

    $html = '<div><strong>' . esc_html__( 'New group event:', 'tnp4b' ) . '</strong> '
          . '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) . '</a>'
          . ( $date ? ' — ' . esc_html( $date ) : '' )
          . '</div>';

    tnp4b_append_to_buffer( $group_id, $html );
}, 10, 2);
