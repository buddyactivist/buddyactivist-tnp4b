<?php
/**
 * Bridge: TNP4B for Events Manager
 * Description: Adds new and updated Events Manager events to group digests.
 * File name must follow the pattern: tnp4b-events-manager-bridge.php
 */

if ( ! function_exists( 'tnp4b_append_to_buffer' ) ) {
    return; // Core function not available
}

// Check if Events Manager is active
if ( ! class_exists( 'EM_Events' ) ) {
    return;
}

/**
 * Hook into event creation
 * Events Manager fires 'em_event_save' when an event is saved.
 * We check if it's a new event.
 */
add_action( 'em_event_save', function( $event ) {
    if ( empty( $event->post_id ) ) return;

    // Detect if it's a new event
    if ( $event->just_added ) {
        $title = $event->event_name;
        $link  = get_permalink( $event->post_id );
        $date  = $event->event_start_date;
        $time  = $event->event_start_time;

        // Map to group_id if relevant (adjust mapping logic)
        $group_id = get_post_meta( $event->post_id, 'group_id', true );

        if ( $group_id ) {
            $html = '<div><strong>' . esc_html__( 'New event:', 'tnp4b' ) . '</strong> '
                  . '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) . '</a>'
                  . ( $date ? ' — ' . esc_html( $date ) : '' )
                  . ( $time ? ' ' . esc_html( $time ) : '' )
                  . '</div>';

            tnp4b_append_to_buffer( $group_id, $html );
        }
    }
}, 10, 1);

/**
 * Hook into event update
 */
add_action( 'em_event_save', function( $event ) {
    if ( empty( $event->post_id ) ) return;

    // Detect if it's an update (not just added)
    if ( ! $event->just_added ) {
        $title = $event->event_name;
        $link  = get_permalink( $event->post_id );
        $date  = $event->event_start_date;
        $time  = $event->event_start_time;

        $group_id = get_post_meta( $event->post_id, 'group_id', true );

        if ( $group_id ) {
            $html = '<div><strong>' . esc_html__( 'Updated event:', 'tnp4b' ) . '</strong> '
                  . '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) . '</a>'
                  . ( $date ? ' — ' . esc_html( $date ) : '' )
                  . ( $time ? ' ' . esc_html( $time ) : '' )
                  . '</div>';

            tnp4b_append_to_buffer( $group_id, $html );
        }
    }
}, 20, 1);
