<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Nahid_Template_Importer {

	public static function get_sections_dir() {
		return plugin_dir_path( dirname( __FILE__ ) ) . 'sections/';
	}

	public static function get_available_templates() {
		$dir = self::get_sections_dir();
		$templates = [];

		if ( is_dir( $dir ) ) {
			$files = glob( $dir . '*.json' );
			if ( $files ) {
				foreach ( $files as $file ) {
					$templates[] = [
						'id'       => basename( $file, '.json' ),
						'filename' => basename( $file ),
						'path'     => $file,
						'title'    => ucwords( str_replace( '-', ' ', basename( $file, '.json' ) ) ),
					];
				}
			}
		}

		return $templates;
	}

	public static function import( $filename ) {
		$file_path = self::get_sections_dir() . sanitize_file_name( $filename );

		if ( ! file_exists( $file_path ) ) {
			return new \WP_Error( 'file_not_found', 'Template file not found.' );
		}

		$file_content = file_get_contents( $file_path );
		$template_data = json_decode( $file_content, true );

		if ( empty( $template_data ) || empty( $template_data['content'] ) ) {
			return new \WP_Error( 'invalid_json', 'Invalid or corrupt Elementor JSON file.' );
		}

		$template_type = isset( $template_data['type'] ) ? $template_data['type'] : 'section';
		$template_title = isset( $template_data['title'] ) && ! empty( $template_data['title'] ) ? $template_data['title'] : ucwords( str_replace( '-', ' ', basename( $filename, '.json' ) ) );

		// Check if it already exists to prevent duplicates
		$existing = get_posts( [
			'post_type' => 'elementor_library',
			'title'     => $template_title,
			'posts_per_page' => 1,
			'post_status' => 'publish'
		] );

		if ( ! empty( $existing ) ) {
			return new \WP_Error( 'already_imported', 'Template is already imported.' );
		}

		$post_data = [
			'post_type'    => 'elementor_library',
			'post_title'   => sanitize_text_field( $template_title ),
			'post_status'  => 'publish',
		];

		$post_id = wp_insert_post( $post_data );

		if ( is_wp_error( $post_id ) ) {
			return $post_id;
		}

		// Inject the native Elementor meta data securely
		update_post_meta( $post_id, '_elementor_data', wp_slash( wp_json_encode( $template_data['content'] ) ) );
		update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );
		update_post_meta( $post_id, '_elementor_template_type', sanitize_text_field( $template_type ) );
		
		if ( isset( $template_data['page_settings'] ) ) {
			update_post_meta( $post_id, '_elementor_page_settings', $template_data['page_settings'] );
		}

		// Assign it to "Nahid Library" category (if elementor taxonomy exists)
		if ( taxonomy_exists( 'elementor_library_category' ) ) {
			wp_set_object_terms( $post_id, 'Nahid Library', 'elementor_library_category', true );
		}

		return $post_id;
	}
}
