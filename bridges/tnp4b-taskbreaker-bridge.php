<?php
/**
 * Bridge: TNP4B for TaskBreaker Project Management
 * Description: Adds new projects and tasks from TaskBreaker to group digests.
 * File name must follow the pattern: tnp4b-taskbreaker-bridge.php
 */

if ( ! function_exists( 'tnp4b_append_to_buffer' ) ) {
    return; // Core function not available
}

// Check if TaskBreaker is active
if ( ! class_exists( 'TaskBreaker' ) ) {
    return;
}

/**
 * Hook into project creation
 * TaskBreaker fires 'taskbreaker_project_created' when a new project is added.
 */
add_action( 'taskbreaker_project_created', function( $project_id, $group_id ) {
    $title = get_the_title( $project_id );
    $link  = get_permalink( $project_id );

    $html = '<div><strong>' . esc_html__( 'New project:', 'tnp4b' ) . '</strong> '
          . '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) . '</a></div>';

    tnp4b_append_to_buffer( $group_id, $html );
}, 10, 2);

/**
 * Hook into task creation
 * TaskBreaker fires 'taskbreaker_task_created' when a new task is added.
 */
add_action( 'taskbreaker_task_created', function( $task_id, $project_id, $group_id ) {
    $title = get_the_title( $task_id );
    $link  = get_permalink( $task_id );
    $status = get_post_meta( $task_id, 'taskbreaker_task_status', true );

    $html = '<div><strong>' . esc_html__( 'New task in project:', 'tnp4b' ) . '</strong> '
          . esc_html( get_the_title( $project_id ) ) . ' — '
          . '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) . '</a>'
          . ( $status ? ' (' . esc_html( $status ) . ')' : '' )
          . '</div>';

    tnp4b_append_to_buffer( $group_id, $html );
}, 10, 3);
