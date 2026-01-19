<?php
/**
 * Bridge: TNP4B for BuddyPress Group Reviews
 * Description: Adds new group reviews to digests.
 * File name must follow the pattern: tnp4b-bp-group-reviews-bridge.php
 */

if ( ! function_exists( 'tnp4b_append_to_buffer' ) ) {
    return; // Core function not available
}

// Check if BuddyPress Group Reviews is active
if ( ! class_exists( 'BP_Group_Reviews' ) ) {
    return;
}

/**
 * Hook into review creation
 * BuddyPress Group Reviews fires 'bp_group_reviews_review_created' when a new review is added.
 */
add_action( 'bp_group_reviews_review_created', function( $review_id, $group_id ) {
    $title   = get_the_title( $review_id );
    $link    = get_permalink( $review_id );
    $rating  = get_post_meta( $review_id, 'bp_group_review_rating', true );
    $author  = get_the_author_meta( 'display_name', get_post_field( 'post_author', $review_id ) );

    $html = '<div><strong>' . esc_html__( 'New group review:', 'tnp4b' ) . '</strong> '
          . '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) . '</a>'
          . ( $rating ? ' — ' . esc_html__( 'Rating:', 'tnp4b' ) . ' ' . esc_html( $rating ) . '/5' : '' )
          . ( $author ? ' — ' . esc_html__( 'By', 'tnp4b' ) . ' ' . esc_html( $author ) : '' )
          . '</div>';

    tnp4b_append_to_buffer( $group_id, $html );
}, 10, 2);

/**
 * Hook into review update
 * BuddyPress Group Reviews fires 'bp_group_reviews_review_updated' when a review is modified.
 */
add_action( 'bp_group_reviews_review_updated', function( $review_id, $group_id ) {
    $title   = get_the_title( $review_id );
    $link    = get_permalink( $review_id );
    $rating  = get_post_meta( $review_id, 'bp_group_review_rating', true );

    $html = '<div><strong>' . esc_html__( 'Updated group review:', 'tnp4b' ) . '</strong> '
          . '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) . '</a>'
          . ( $rating ? ' — ' . esc_html__( 'Rating:', 'tnp4b' ) . ' ' . esc_html( $rating ) . '/5' : '' )
          . '</div>';

    tnp4b_append_to_buffer( $group_id, $html );
}, 10, 2);
