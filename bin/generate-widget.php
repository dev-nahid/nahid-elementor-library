<?php
/**
 * Nahid Elementor Library - Widget Generator CLI
 * 
 * Usage: php bin/generate-widget.php "Your Widget Title"
 */

if ( php_sapi_name() !== 'cli' ) {
    die( "This script must be run from the command line.\n" );
}

if ( $argc < 2 ) {
    die( "Usage: php bin/generate-widget.php \"Widget Title\"\nExample: php bin/generate-widget.php \"Testimonial Carousel\"\n" );
}

$widget_title = trim( $argv[1] );

if ( empty( $widget_title ) ) {
    die( "Error: Widget title cannot be empty.\n" );
}

// Sluggify function
function sluggify( $text ) {
    $text = preg_replace( '~[^\pL\d]+~u', '-', $text );
    $text = iconv( 'utf-8', 'us-ascii//TRANSLIT', $text );
    $text = preg_replace( '~[^-\w]+~', '', $text );
    $text = trim( $text, '-' );
    $text = preg_replace( '~-+~', '-', $text );
    return strtolower( $text );
}

$widget_slug = sluggify( $widget_title ); // 'testimonial-carousel'
$widget_name = 'nahid_' . str_replace( '-', '_', $widget_slug ); // 'nahid_testimonial_carousel'
$class_name = 'Nahid_' . str_replace( ' ', '_', ucwords( str_replace( '-', ' ', $widget_slug ) ) ) . '_Widget'; // 'Nahid_Testimonial_Carousel_Widget'

$plugin_dir = dirname( __DIR__ ); // We are inside bin/
$widgets_dir = $plugin_dir . '/widgets/' . $widget_slug;
$assets_css_dir = $plugin_dir . '/assets/css';
$assets_js_dir = $plugin_dir . '/assets/js';

// Setup directories
if ( ! is_dir( $widgets_dir ) ) {
    mkdir( $widgets_dir, 0755, true );
}
if ( ! is_dir( $assets_css_dir ) ) {
    mkdir( $assets_css_dir, 0755, true );
}
if ( ! is_dir( $assets_js_dir ) ) {
    mkdir( $assets_js_dir, 0755, true );
}

// 1. Scaffold Widget PHP
$stub_file = __DIR__ . '/template/widget.stub';

if ( file_exists( $stub_file ) ) {
    $stub_content = file_get_contents( $stub_file );
    $stub_content = str_replace(
        [ '{{CLASS_NAME}}', '{{WIDGET_NAME}}', '{{WIDGET_TITLE}}', '{{WIDGET_SLUG}}' ],
        [ $class_name, $widget_name, $widget_title, $widget_slug ],
        $stub_content
    );

    file_put_contents( $widgets_dir . '/widget.php', $stub_content );
    echo "✓ Created: /widgets/{$widget_slug}/widget.php\n";
} else {
    echo "⚠ Warning: Stub template not found at {$stub_file}.\n";
}

// 2. Scaffold CSS Asset
$css_file = $assets_css_dir . '/' . $widget_name . '.css';
$css_content = "/* \n * {$widget_title} Stylesheet\n * Dynamically loaded for the {$widget_name} Elementor widget.\n */\n\n.nahid-{$widget_slug} {\n    display: block;\n}\n";
file_put_contents( $css_file, $css_content );
echo "✓ Created: /assets/css/{$widget_name}.css\n";

// 3. Scaffold JS Asset
$js_file = $assets_js_dir . '/' . $widget_name . '.js';
$js_content = "( function( $ ) {\n\t'use strict';\n\n\tvar WidgetHandler = function( \$scope, $ ) {\n\t\tvar \$element = \$scope.find( '.nahid-{$widget_slug}' );\n\n\t\tif ( ! \$element.length ) {\n\t\t\treturn;\n\t\t}\n\n\t\t// console.log( '{$widget_title} JS ready!' );\n\t};\n\n\t$( window ).on( 'elementor/frontend/init', function() {\n\t\telementorFrontend.hooks.addAction( 'frontend/element_ready/{$widget_name}.default', WidgetHandler );\n\t} );\n\n} )( jQuery );\n";
file_put_contents( $js_file, $js_content );
echo "✓ Created: /assets/js/{$widget_name}.js\n";

echo "\n🎉 Success! The standalone widget '{$widget_title}' was generated and automatically registered to Elementor.\n";
