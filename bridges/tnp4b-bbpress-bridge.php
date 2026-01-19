<?php
/**
 * Bridge: TNP4B for BBPress 
 * Description: Adds new forum topics and replies to group digests.
 * File name must follow the pattern: tnp4b-bbpress-bridge.php
 */

if ( ! function_exists( 'tnp4b_append_to_buffer' ) ) {
    return; // Core function not available
}

// Check bbPress functions
if ( ! function_exists( 'bbp_get_topic' ) || ! function_exists( 'bbp_get_reply' ) ) {
    return; // bbPress not active
}

/**
 * Hook into bbPress new topic creation
 */
add_action( 'bbp_new_topic', function( $topic_id, $forum_id, $anonymous_data, $topic_author ) {
    // Map forum to BuddyPress group ID (adjust this mapping to your setup)
    $group_id = get_post_meta( $forum_id, 'group_id', true );

    if ( $group_id ) {
        $title = get_the_title( $topic_id );
        $link  = get_permalink( $topic_id );

        $html = '<div><strong>' . esc_html__( 'New forum topic:', 'tnp4b' ) . '</strong> '
              . '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) . '</a></div>';

        tnp4b_append_to_buffer( $group_id, $html );
    }
}, 10, 4 );

/**
 * Hook into bbPress new reply creation
 */
add_action( 'bbp_new_reply', function( $reply_id, $topic_id, $forum_id, $anonymous_data, $reply_author ) {
    // Map forum to BuddyPress group ID (adjust this mapping to your setup)
    $group_id = get_post_meta( $forum_id, 'group_id', true );

    if ( $group_id ) {
        $title = get_the_title( $topic_id );
        $link  = get_permalink( $reply_id );

        $html = '<div><strong>' . esc_html__( 'New forum reply in topic:', 'tnp4b' ) . '</strong> '
              . esc_html( $title ) . ' — '
              . '<a href="' . esc_url( $link ) . '">' . esc_html__( 'View reply', 'tnp4b' ) . '</a></div>';

        tnp4b_append_to_buffer( $group_id, $html );
    }
}, 10, 5 );
