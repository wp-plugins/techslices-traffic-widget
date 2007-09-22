<?php
/*
Plugin Name: Techslices Widget
Plugin URI: http://www.techslices.com/traffic-widget/
Description: Adds a sidebar widget to display Traffic Number. You need a 10 character <a href="http://www.techslices.com/traffic-widget/">Widget Code</a> to use it.
Author: Techslices.com
Version: 1.0
Author URI: http://www.techslices.com
*/

// This gets called at the plugins_loaded action
function widget_tstw_init() {
	
	// Check for the required API functions
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;

	// This saves options and prints the widget's config form.
	function widget_tstw_control() {
		$options = $newoptions = get_option('widget_tstw');
		if ( $_POST['tstw-submit'] ) {
			$newoptions['title'] = strip_tags(stripslashes($_POST['tstw-title']));
			$newoptions['code'] = strip_tags(stripslashes($_POST['tstw-code']));
			$newoptions['new'] = strip_tags(stripslashes($_POST['tstw-new']));
		}
		if ( $options != $newoptions ) 
		{
			$options = $newoptions;
			update_option('widget_tstw', $options);
		}
	?>
				<div style="text-align:right">
				<label for="tstw-title" style="line-height:40px;display:block;">Widget title: <input type="text" id="tstw-title" name="tstw-title" value="<?php echo htmlspecialchars($options['title']); ?>" /></label>
				<label for="tstw-code" style="line-height:40px;display:block;">Widget Code: <input type="text" id="tstw-code" name="tstw-code" value="<?php echo htmlspecialchars($options['code']); ?>" /></label>
				<label for="tstw-new">Open in a new browser <input class="checkbox" type="checkbox" value="1" <?php echo $new = $options['new'] ? 'checked="checked"' : ''; ?> id="tstw-new" name="tstw-new" /></label>
				<input type="hidden" name="tstw-submit" id="tstw-submit" value="1" />
				</div>
	<?php
	}

	// This prints the widget
	function widget_tstw($args) {
		extract($args);
		$options = get_option('widget_tstw');
		$title = empty($options['title']) ? 'Traffic Widget' : $options['title'];
		$code = empty($options['code']) ? '' : $options['code'];
		$target = ($options['new'] == '1') ? 'target="new"' : '';
	
		echo $before_widget;
		echo $before_title . $title . $after_title;
		if (strlen($code)==10)
			echo "<center><a href=\"http://www.techslices.com/site/" . $code . "\">".'<img src="http://www.techslices.com/widget/'.$code.'.gif" title="Site Readers" width="76" height="30" border="0" />'."</a></center>";
		else
			echo "<center><a href=\"http://www.techslices.com/traffic-widget/\">Get Your 10 Character Widget Code First</a></center>";
		echo $after_widget;
	}

	// Tell Dynamic Sidebar about our new widget and its control
	register_sidebar_widget(array('Techslices', 'widgets'), 'widget_tstw');
	register_widget_control(array('Techslices', 'widgets'), 'widget_tstw_control');
	
}

// Delay plugin execution to ensure Dynamic Sidebar has a chance to load first
add_action('plugins_loaded', 'widget_tstw_init');

?>
