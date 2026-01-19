<?php
/**
 * Bridge: TNP4B for BP Group Documents
 * Description: Adds new group documents to digests.
 * File name must follow the pattern: tnp4b-bp-group-documents-bridge.php
 */

if ( ! function_exists( 'tnp4b_append_to_buffer' ) ) {
    return; // Core function not available
}

// Check if BP Group Documents is active
if ( ! class_exists( 'BP_Group_Documents' ) ) {
    return;
}

/**
 * Hook into document creation
 * BP Group Documents fires 'bp_group_documents_document_created' when a new document is added.
 */
add_action( 'bp_group_documents_document_created', function( $doc_id, $group_id ) {
    $title = get_the_title( $doc_id );
    $link  = get_permalink( $doc_id );
    $type  = get_post_mime_type( $doc_id );

    $html = '<div><strong>' . esc_html__( 'New group document:', 'tnp4b' ) . '</strong> '
          . '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) . '</a>'
          . ( $type ? ' (' . esc_html( $type ) . ')' : '' )
          . '</div>';

    tnp4b_append_to_buffer( $group_id, $html );
}, 10, 2);

/**
 * Hook into document update
 * BP Group Documents fires 'bp_group_documents_document_updated' when a document is modified.
 */
add_action( 'bp_group_documents_document_updated', function( $doc_id, $group_id ) {
    $title = get_the_title( $doc_id );
    $link  = get_permalink( $doc_id );
    $type  = get_post_mime_type( $doc_id );

    $html = '<div><strong>' . esc_html__( 'Updated group document:', 'tnp4b' ) . '</strong> '
          . '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) . '</a>'
          . ( $type ? ' (' . esc_html( $type ) . ')' : '' )
          . '</div>';

    tnp4b_append_to_buffer( $group_id, $html );
}, 10, 2);
