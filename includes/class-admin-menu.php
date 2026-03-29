<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Nahid_Admin_Menu {

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'register_menu' ] );
		add_action( 'admin_post_nahid_import_template', [ $this, 'handle_import' ] );
	}

	public function register_menu() {
		add_submenu_page(
			'elementor', // parent slug
			esc_html__( 'Nahid Templates', 'nahid-elementor-library' ), // page title
			esc_html__( 'Nahid Templates', 'nahid-elementor-library' ), // menu title
			'manage_options', // capability
			'nahid-elementor-templates', // menu slug
			[ $this, 'render_page' ] // callback
		);
	}

	public function render_page() {
		$templates = Nahid_Template_Importer::get_available_templates();
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Nahid Elementor Templates', 'nahid-elementor-library' ); ?></h1>
			<p><?php esc_html_e( 'Import pre-designed layout sections directly into your Elementor library below:', 'nahid-elementor-library' ); ?></p>
			
			<?php if ( isset( $_GET['import'] ) ) : ?>
				<?php if ( $_GET['import'] === 'success' ) : ?>
					<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Template imported successfully! Check your Elementor Saved Templates.', 'nahid-elementor-library' ); ?></p></div>
				<?php elseif ( isset( $_GET['error'] ) ) : ?>
					<div class="notice notice-error is-dismissible"><p><?php echo esc_html( urldecode( $_GET['error'] ) ); ?></p></div>
				<?php endif; ?>
			<?php endif; ?>

			<table class="wp-list-table widefat fixed striped">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Template Name', 'nahid-elementor-library' ); ?></th>
						<th><?php esc_html_e( 'File', 'nahid-elementor-library' ); ?></th>
						<th><?php esc_html_e( 'Action', 'nahid-elementor-library' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php if ( empty( $templates ) ) : ?>
						<tr>
							<td colspan="3"><?php esc_html_e( 'No templates found in the /sections/ directory.', 'nahid-elementor-library' ); ?></td>
						</tr>
					<?php else : ?>
						<?php foreach ( $templates as $temp ) : ?>
							<tr>
								<td><strong><?php echo esc_html( $temp['title'] ); ?></strong></td>
								<td><code><?php echo esc_html( $temp['filename'] ); ?></code></td>
								<td>
									<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
										<?php wp_nonce_field( 'nahid_import_nonce', 'security' ); ?>
										<input type="hidden" name="action" value="nahid_import_template">
										<input type="hidden" name="file" value="<?php echo esc_attr( $temp['filename'] ); ?>">
										<button type="submit" class="button button-primary">
											<?php esc_html_e( 'Import to Library', 'nahid-elementor-library' ); ?>
										</button>
									</form>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
		<?php
	}

	public function handle_import() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'Unauthorized' );
		}

		if ( ! isset( $_POST['security'] ) || ! wp_verify_nonce( $_POST['security'], 'nahid_import_nonce' ) ) {
			wp_die( 'Security check failed' );
		}

		$file = isset( $_POST['file'] ) ? sanitize_file_name( $_POST['file'] ) : '';

		if ( empty( $file ) ) {
			wp_redirect( admin_url( 'admin.php?page=nahid-elementor-templates&import=failed&error=' . urlencode( 'No file specified.' ) ) );
			exit;
		}

		$result = Nahid_Template_Importer::import( $file );

		if ( is_wp_error( $result ) ) {
			wp_redirect( admin_url( 'admin.php?page=nahid-elementor-templates&import=failed&error=' . urlencode( $result->get_error_message() ) ) );
			exit;
		}

		wp_redirect( admin_url( 'admin.php?page=nahid-elementor-templates&import=success' ) );
		exit;
	}
}

new Nahid_Admin_Menu();
