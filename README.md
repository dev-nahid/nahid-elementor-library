# Nahid Elementor Library

A powerful, bulletproof, and dynamically loading Elementor extension framework built for scale and high performance.

## Table of Contents
1. [Folder Structure](#folder-structure)
2. [Creating a New Widget (CLI Builder)](#creating-a-new-widget-cli-builder)
3. [Adding Custom Styles & Scripts](#adding-custom-styles--scripts)
4. [Adding New Section Templates](#adding-new-section-templates)

---

## Folder Structure
The plugin is strictly organized following WordPress and Elementor best practices:
- `/assets/`: Contains separated `css/` and `js/` directories. Assets here are dynamically loaded *only* when required.
- `/bin/`: Contains the CLI widget generator script `generate-widget.php` and its base template stub.
- `/includes/`: Holds core plugin architecture classes (`class-widget-base.php`, `class-admin-menu.php`, `class-template-importer.php`).
- `/sections/`: The storage directory for raw Elementor `.json` layout templates waiting to be imported.
- `/widgets/`: Each Elementor widget gets its own dedicated folder here (e.g., `/feature-box/widget.php`). The main plugin loop automatically scans this folder.

---

## Creating a New Widget (CLI Builder)

We have built a powerful Command Line (CLI) generator that handles the boilerplate and registers the widget instantly. 

**Steps:**
1. Open your terminal and navigate to the root folder of this plugin (`/nahid-elementor-library/`).
2. Run the generator script with your desired widget name:
   ```bash
   php bin/generate-widget.php "Portfolio Grid"
   ```
3. The script will automatically:
   - Create `/widgets/portfolio-grid/widget.php`
   - Setup Elementor's zero-lag inline-editing JS template framework.
   - Inject the proper formatting and PHP class names (e.g., `Nahid_Portfolio_Grid_Widget`).
   - Create matching empty `/assets/css/nahid_portfolio_grid.css` and `/assets/js/nahid_portfolio_grid.js` files.

> **Note on Automatic Registration:** Because the plugin features a dynamic **Auto-Loader**, you *do not* need to manually `require` your newly created widget file anywhere! Just run the command, refresh your Elementor editor window, and your new widget will instantly appear under the "Nahid Library" category.

---

## Adding Custom Styles & Scripts

You do not need to manually write standard `wp_enqueue_script` or `wp_enqueue_style` hooks anymore. 

The core system uses an automated **Dynamic Asset Loader**. It will actively detect CSS or JavaScript files and will only push them to the browser if that specific widget is actively dropped onto the user's page (greatly improving page load speeds).

1. Ensure your `.css` or `.js` file name exactly matches the widget's internal registered name (the `get_name()` value, e.g., `nahid_feature_box.css`).
2. Drop them into `/assets/css/` or `/assets/js/`.
3. The parent class `Nahid_Widget_Base` will detect the file size/timestamp and securely register it to WordPress!

---

## Adding New Section Templates

This plugin ships with a native database importer to securely manage pre-designed Elementor sections.

1. Export any section or page from the Elementor Builder internally as a `.json` file.
2. Move that `.json` file directly into the `/sections/` folder of this plugin.
3. Open your typical WordPress Admin Dashboard.
4. Navigate to **Elementor** -> **Nahid Templates** on the sidebar.
5. Your file will automatically be detected and listed. Click the **"Import to Library"** button.
6. The layout is now permanently saved to your native Elementor My Templates database and categorized under the *Nahid Library* taxonomy, ready for client deployment!
