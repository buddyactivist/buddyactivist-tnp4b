<?php
/**
 * Bridge: TNP4B for BP User To-Do List
 * Description: Adds new to-do items created in groups to digests.
 * File name must follow the pattern: tnp4b-bp-user-todo-bridge.php
 */

if ( ! function_exists( 'tnp4b_append_to_buffer' ) ) {
    return; // Core function not available
}

// Check if BP User To-Do List is active
if ( ! class_exists( 'BP_User_To_Do_List' ) ) {
    return;
}

/**
 * Hook into to-do item creation
 * BP User To-Do List fires 'bp_user_todo_item_created' when a new item is added.
 */
add_action( 'bp_user_todo_item_created', function( $item_id, $group_id ) {
    $title = get_the_title( $item_id );
    $link  = get_permalink( $item_id );
    $status = get_post_meta( $item_id, 'bp_user_todo_status', true );

    $html = '<div><strong>' . esc_html__( 'New to-do item:', 'tnp4b' ) . '</strong> '
          . '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) . '</a>'
          . ( $status ? ' — ' . esc_html__( 'Status:', 'tnp4b' ) . ' ' . esc_html( $status ) : '' )
          . '</div>';

    tnp4b_append_to_buffer( $group_id, $html );
}, 10, 2);
