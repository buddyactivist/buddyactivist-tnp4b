<?php
/**
 * Bridge: TNP4B for BuddyCommerce
 * Description: Adds new BuddyCommerce products and orders to group digests.
 * File name must follow the pattern: tnp4b-buddycommerce-bridge.php
 */

if ( ! function_exists( 'tnp4b_append_to_buffer' ) ) {
    return; // Core function not available
}

// Check if BuddyCommerce is active
if ( ! class_exists( 'BuddyCommerce' ) ) {
    return;
}

/**
 * Hook into product creation
 * BuddyCommerce fires 'buddycommerce_product_created' when a new product is added.
 */
add_action( 'buddycommerce_product_created', function( $product_id, $group_id ) {
    $title = get_the_title( $product_id );
    $link  = get_permalink( $product_id );
    $price = get_post_meta( $product_id, '_price', true );

    $html = '<div><strong>' . esc_html__( 'New product in group:', 'tnp4b' ) . '</strong> '
          . '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) . '</a>'
          . ( $price ? ' — ' . esc_html__( 'Price:', 'tnp4b' ) . ' ' . esc_html( $price ) : '' )
          . '</div>';

    tnp4b_append_to_buffer( $group_id, $html );
}, 10, 2);

/**
 * Hook into order creation
 * BuddyCommerce fires 'buddycommerce_order_created' when a new order is placed.
 */
add_action( 'buddycommerce_order_created', function( $order_id, $group_id ) {
    $order = wc_get_order( $order_id );
    if ( ! $order ) return;

    $items = $order->get_items();
    $summary = array();
    foreach ( $items as $item ) {
        $summary[] = $item->get_name();
    }

    $html = '<div><strong>' . esc_html__( 'New order in group:', 'tnp4b' ) . '</strong> '
          . esc_html__( 'Items:', 'tnp4b' ) . ' ' . esc_html( implode( ', ', $summary ) ) . '</div>';

    tnp4b_append_to_buffer( $group_id, $html );
}, 10, 2);
