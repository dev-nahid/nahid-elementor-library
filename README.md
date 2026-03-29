# Nahid Elementor Library

Welcome to your custom Elementor plugin! This is a simple, lightweight tool that helps you build your own custom Elementor widgets without writing repetitive setup code.

## Where Everything Lives
- `/assets/css/`: Put your custom CSS design files here. 
- `/assets/js/`: Put your custom JavaScript files here.
- `/includes/`: The core engine that makes the plugin work (you don't need to change anything here).
- `/widgets/`: The most important folder. This is where you will build and store your custom widgets.

---

## 1. How to Make a New Widget (Step-by-Step)

You don't need to write complicated WordPress registration code. The plugin automatically scans the `/widgets/` folder and loads your widgets for you!

**Follow these exact steps to create a widget:**
1. Go into the `/widgets/` folder.
2. Create a new folder for your widget (for example: `/my-cool-button/`).
3. Inside that folder, create a file and name it `widget.php`.
4. Open `widget.php` and paste in your Elementor widget code. **Important:** Make sure your class extends `\Nahid_Widget_Base` so the plugin recognizes it.

### Example Starter Code for `widget.php`:
```php
<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Security check

class Nahid_My_Cool_Button_Widget extends \Nahid_Widget_Base {

	// 1. Give your widget an internal computer name (no spaces)
	public function get_name() {
		return 'nahid_my_cool_button'; 
	}

	// 2. Give your widget a human name (this shows up in the Elementor Sidebar)
	public function get_title() {
		return 'My Cool Button';
	}

	// 3. Setup your sidebar controls here
	protected function register_controls() { 
		// Elementor controls go here...
	}

	// 4. Print your webpage HTML here
	protected function render() { 
		echo '<div class="nahid-cool-button">Hello Elementor!</div>'; 
	}
}
```
*That's it! Save the file, refresh your Elementor editor, and your new widget will instantly appear in the left sidebar menu under the "Nahid Library" category.*

---

## 2. How to Add CSS (Styling) or JS (Scripts)

Normally in WordPress, you have to write long complicated codes (`wp_enqueue_script`) to load your CSS and JS files. 

This plugin has a **Magic File Loader** built in. It will automatically load your specific CSS and JS files, but *only* if your widget is actually dragged onto the page (this makes your website run super fast!).

**How to use the Magic Loader:**
You just have to name your file exactly the same as the internal `get_name()` value of your widget.

**Example for the widget above:**
If your `get_name()` is `'nahid_my_cool_button'`, then:
1. **For CSS**: Create your stylesheet at exactly `/assets/css/nahid_my_cool_button.css`
2. **For JavaScript**: Create your script at exactly `/assets/js/nahid_my_cool_button.js`

The plugin will automatically see those files sitting there and load them for you. You don't have to touch a single line of extra code!
