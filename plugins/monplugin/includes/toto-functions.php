<?php
//Enqueue styles & scripts
add_action('wp_enqueue_scripts', 'monplugin_Enqueues');

function monplugin_Enqueues() {
	wp_enqueue_style('slick-style', plugin_dir_url(__FILE__).'slick/slick.css');
	wp_enqueue_style('slick-style-01', plugin_dir_url(__FILE__).'slick/slick-theme.css');
	wp_enqueue_script('jquery');
	wp_enqueue_script('slick-js', plugin_dir_url(__FILE__).'slick/slick.js');
	wp_enqueue_script('script-js', plugin_dir_url(__FILE__).'slick/scripts.js');
}

//Test
add_action('wp_footer', 'monplugin_FooterText');

function monplugin_FooterText() {
	echo "Mon plugin Toto est activé!"; 
}

//Page admin pour config du plugin
add_action('admin_menu', 'monplugin_AdminPage');

function monplugin_AdminPage() {
	add_menu_page(
		__('Plugin Toto Page', 'monpluginlg'),
		__('Plugin Toto', 'monpluginlg'),
		'manage_options',
		'monplugin/includes/toto-acp.php'
	);
}

// Shortcodes

//[toto]
add_shortcode('slick', 'monplugin_TotoShortcode');

function monplugin_TotoShortcode() {
	return "
		<div class=\"slicksliding dots infinite arrows\">
			<div>your content</div>
			<div>your content</div>
			<div>your content</div>
		</div>
	";
}

//[titi att="value"]
add_shortcode('slick', 'monplugin_SlickShortcode');

function monplugin_SlickShortcode($atts) {
	$a = shortcode_atts(array(
		'id' => false,
		'nbimage' => false,
		'infinite' => false,
		'dots' => false,
		'arrows' => false,
		'autoplay' => false,
		'fade' => false,
		'rtl' => false,
		'slidesToShow' => false,
		'slidesToScroll' => false,
		'speed' => false
	), $atts);

	$html = "<div id=\"esgi-slick-". $a['id'] ."\" class=\"slicksliding ";
	if ($a['infinite']) {
		$html .= "infinite ";
	};
	if ($a['dots']) {
		$html .= "dots ";
	};
	if ($a['arrows']) {
		$html .= "arrows ";
	};
	if ($a['autoplay']) {
		$html .= "autoplay ";
	};
	if ($a['fade']) {
		$html .= "fade ";
	};
	if ($a['rtl']) {
		$html .= "rtl ";
	};
	if ($a['slidesToShow'] != false) {
		$html .= "slidesToShow-".$a['slidesToShow']." ";
	};
	if ($a['slidesToScroll'] != false) {
		$html .= "slidesToScroll-".$a['slidesToScroll']." ";
	};
	if ($a['speed'] != false) {
		$html .= "speed-".$a['speed']." ";
	};
	if ($a['nbimage'] != false) {
		$html .= "nbimage-".$a['nbimage']."\">";
		for ($i=1; $i <  $a['nbimage'] + 1 ; $i++) { 
			$html .=	"<div><img src=\"lien de l'image[".$i."]\" alt=\"alt de l'image[".$i."]\"></div>";
		}
		$html .= "</div>";
	}else{
		return "<p>Une erreur est survenue lors de la génération du shortcode.</p>";
	};

	return $html;
} 
