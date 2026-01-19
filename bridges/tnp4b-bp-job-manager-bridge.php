<?php
/**
 * Bridge: TNP4B for BP Job Manager
 * Description: Adds new job listings created in groups to digests.
 * File name must follow the pattern: tnp4b-bp-job-manager-bridge.php
 */

if ( ! function_exists( 'tnp4b_append_to_buffer' ) ) {
    return; // Core function not available
}

// Check if BP Job Manager is active
if ( ! class_exists( 'BP_Job_Manager' ) ) {
    return;
}

/**
 * Hook into job creation
 * BP Job Manager fires 'bp_job_manager_job_created' when a new job is posted.
 */
add_action( 'bp_job_manager_job_created', function( $job_id, $group_id ) {
    $title  = get_the_title( $job_id );
    $link   = get_permalink( $job_id );
    $status = get_post_meta( $job_id, 'bp_job_manager_status', true );
    $company = get_post_meta( $job_id, 'bp_job_manager_company', true );

    $html = '<div><strong>' . esc_html__( 'New job listing:', 'tnp4b' ) . '</strong> '
          . '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) . '</a>'
          . ( $company ? ' — ' . esc_html( $company ) : '' )
          . ( $status ? ' (' . esc_html( $status ) . ')' : '' )
          . '</div>';

    tnp4b_append_to_buffer( $group_id, $html );
}, 10, 2);
