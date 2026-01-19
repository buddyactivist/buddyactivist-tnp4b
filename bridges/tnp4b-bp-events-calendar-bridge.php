<?php
/**
 * Bridge: TNP4B for BP Events Calendar 
 * Description: Adds new and updated group events from BP Events Calendar to digests.
 * File name must follow the pattern: tnp4b-bp-events-calendar-bridge.php
 */

if ( ! function_exists( 'tnp4b_append_to_buffer' ) ) {
    return; // Core function not available
}

// Check if BP Events Calendar is active
if ( ! class_exists( 'BP_Events_Calendar' ) ) {
    return;
}

/**
 * Hook into event creation
 */
add_action( 'bp_events_calendar_event_created', function( $event_id, $group_id ) {
    $title = get_the_title( $event_id );
    $link  = get_permalink( $event_id );
    $date  = get_post_meta( $event_id, 'bp_events_calendar_date', true );
    $time  = get_post_meta( $event_id, 'bp_events_calendar_time', true );

    $html = '<div><strong>' . esc_html__( 'New group event:', 'tnp4b' ) . '</strong> '
          . '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) . '</a>'
          . ( $date ? ' — ' . esc_html( $date ) : '' )
          . ( $time ? ' ' . esc_html( $time ) : '' )
          . '</div>';

    tnp4b_append_to_buffer( $group_id, $html );
}, 10, 2);

/**
 * Hook into event update
 */
add_action( 'bp_events_calendar_event_updated', function( $event_id, $group_id ) {
    $title = get_the_title( $event_id );
    $link  = get_permalink( $event_id );
    $date  = get_post_meta( $event_id, 'bp_events_calendar_date', true );
    $time  = get_post_meta( $event_id, 'bp_events_calendar_time', true );

    $html = '<div><strong>' . esc_html__( 'Updated group event:', 'tnp4b' ) . '</strong> '
          . '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) . '</a>'
          . ( $date ? ' — ' . esc_html( $date ) : '' )
          . ( $time ? ' ' . esc_html( $time ) : '' )
          . '</div>';

    tnp4b_append_to_buffer( $group_id, $html );
}, 10, 2);
