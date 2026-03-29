# Nahid Elementor Library

A powerful, bulletproof, and dynamically loading Elementor extension framework built for scale and high performance.

## Table of Contents
1. [Folder Structure](#folder-structure)
2. [Creating a New Widget](#creating-a-new-widget)
3. [Adding Custom Styles & Scripts](#adding-custom-styles--scripts)

---

## Folder Structure
The plugin is strictly organized following WordPress and Elementor best practices:
- `/assets/`: Contains separated `css/` and `js/` directories. Assets here are dynamically loaded *only* when required.
- `/includes/`: Holds core plugin architecture classes (`class-widget-base.php`).
- `/widgets/`: Each Elementor widget gets its own dedicated folder here (e.g., `/feature-box/widget.php`). The main plugin loop automatically scans this folder.

---

## Creating a New Widget

To add a new widget:
1. Create a new folder inside `/widgets/` (e.g. `/my-widget/`).
2. Create a `widget.php` file inside that folder.
3. Ensure your class extends `\Nahid_Widget_Base`.

> **Note on Automatic Registration:** Because the plugin features a dynamic **Auto-Loader**, you *do not* need to manually `require` your newly created widget file anywhere! Just save the file, refresh your Elementor editor window, and your new widget will instantly appear under the "Nahid Library" category.

---

## Adding Custom Styles & Scripts

You do not need to manually write standard `wp_enqueue_script` or `wp_enqueue_style` hooks anymore. 

The core system uses an automated **Dynamic Asset Loader**. It will actively detect CSS or JavaScript files and will only push them to the browser if that specific widget is actively dropped onto the user's page (greatly improving page load speeds).

1. Ensure your `.css` or `.js` file name exactly matches the widget's internal registered name (the `get_name()` value, e.g., `nahid_feature_box.css`).
2. Drop them into `/assets/css/` or `/assets/js/`.
3. The parent class `Nahid_Widget_Base` will detect the file size/timestamp and securely register it to WordPress!
