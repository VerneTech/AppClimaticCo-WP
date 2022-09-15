<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.climaticco.com/
 * @since             1.0.0
 * @package           climatic_co_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       ClimaticCo
 * Plugin URI:        https://www.climaticco.com/ayuda/wp-plugin-config/
 * Description:       La solución para la sostenibilidad de tu eCommerce: ClimaticCo hace que tus envíos sean neutros en carbono. Sencillamente.
 * Version:           1.0.0
 * Update URI:        https://appv2.climaticco.com/wordpress-plugin/info.json
 * Author:            ClimaticCo
 * Author URI:        https://www.climaticco.com/
 * License:           GPL-2.0+
 * License URI:       https://www.climaticco.com/
 * Text Domain:       climatic-co-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require 'plugin-update-checker-4.11/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/ClimaticCo/wordpress-plugin',
	__FILE__,
	'climatic-co'
);


$myUpdateChecker->setBranch('main');

function api_callback($url, $apikey = '') {
	
	$curl = curl_init();
    $options = get_option('wppb_demo_authentication_options');
	if( isset( $options['apikey'] ) && $apikey == '' ) {
		$apikey = $options['apikey'];
	}
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_HTTPHEADER => array(
			'X-AUTH-TOKEN: '.$apikey
		),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	$response_return = json_decode($response,true);
	return $response_return;
		
} // end general_options_callback


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-climatic-co-plugin-activator.php
 */
function activate_climatic_co_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-climatic-co-plugin-activator.php';
	ClimaticCo_Plugin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-climatic-co-plugin-deactivator.php
 */
 
// plugin uninstallation
register_uninstall_hook( __FILE__, 'my_fn_uninstall' ); 
function my_fn_uninstall() {
	delete_option( 'wppb_demo_display_options' );
	delete_option( 'wppb_demo_authentication_options' );
}    
register_activation_hook( __FILE__, 'activate_climatic_co_plugin' );
//register_uninstall_hook( __FILE__, 'deactivate_climatic_co_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-climatic-co-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
 
function run_climatic_co_plugin() {  

	$plugin = new ClimaticCo_Plugin();
	$plugin->run();

}
	
run_climatic_co_plugin();

/*
function admin_style() {
     echo '<style>
        #adminmenu #toplevel_page_climatic-co-options div.wp-menu-image:before {background-image: url(https://wp-climatic.ghrixlabs.com/wp-content/plugins/climatic-co/admin/image/logo.png); background-size: contain; background-repeat: no-repeat;   background-position-y: 3px; background-position-x: 0px; content: "";}
      </style>';
}
add_action('admin_enqueue_scripts', 'admin_style');
*/

/*add_action( 'woocommerce_after_single_product', 'wp_kama_woocommerce_after_single_product_summary_action' );
function wp_kama_woocommerce_after_single_product_summary_action(){
	$options = get_option( 'wppb_demo_display_options' );
	$stump_position = 'left';
	if(isset($options['stump_position'])){
		if($options['stump_position'] != ''){
			$stump_position = $options['stump_position'];	
		}
	}
	if(!isset($options['synchronization_off'])){
		if($options['synchronization_off'] != 1){
			echo '<div style="clear:both;"></div>
			<div class="stumpwrap '.$stump_position.'">
				<div class="tooltip">
					<img src="https://wp-climatic.ghrixlabs.com/wp-content/uploads/2022/05/button.jpg"> 
					<span class="tooltiptext tooltip-left">'.$options['product_tooltip'].'</span>
				</div>
			</div> <div style="clear:both;"></div>';
		}
	}
}

add_action( 'woocommerce_after_cart', 'wp_kama_woocommerce_after_cart_contents', 10, 0);
function wp_kama_woocommerce_after_cart_contents(){
	$options = get_option( 'wppb_demo_display_options' );
	$stump_position = 'left';
	if(isset($options['stump_position'])){
		if($options['stump_position'] != ''){
			$stump_position = $options['stump_position'];	
		}
	}
	if(!isset($options['synchronization_off'])){
		if($options['synchronization_off'] != 1){
			echo '<div style="clear:both;"></div>
			<div class="stumpwrap '.$stump_position.'">
				<div class="tooltip">
					<img src="https://wp-climatic.ghrixlabs.com/wp-content/uploads/2022/05/button.jpg"> 
					<span class="tooltiptext tooltip-left">'.$options['cart_tooltip'].'</span>
				</div>
			</div> <div style="clear:both;"></div>';
		}
	}
}




add_action( 'woocommerce_after_checkout_form', 'wp_kama_woocommerce_review_order_after_submit', 10, 0);
function wp_kama_woocommerce_review_order_after_submit(){
	$options = get_option( 'wppb_demo_display_options' );
	$stump_position = 'left';
	if(isset($options['stump_position'])){
		if($options['stump_position'] != ''){
			$stump_position = $options['stump_position'];	
		}
	}
	if(!isset($options['synchronization_off'])){
		if($options['synchronization_off'] != 1){
			echo '<div style="clear:both;"></div>
			<div class="stumpwrap '.$stump_position.'">
				<div class="tooltip">
					<img src="https://wp-climatic.ghrixlabs.com/wp-content/uploads/2022/05/button.jpg"> 
					<span class="tooltiptext tooltip-left">'.$options['checkout_tooltip'].'</span>
				</div>
			</div> <div style="clear:both;"></div>';
		}
	}
}*/

function detect_lang(){
	
	$indexIso639_1 = 0;
    $indexIso639_2t = 1;
    $indexIso639_2b = 2;
    $indexIso639_3 = 3;
    $indexEnglishName = 4;
    $indexNativeName = 5;
	
	$languages = array(
        array('ab', 'abk', 'abk', 'abk', 'Abkhaz', 'аҧсуа бызшәа, аҧсшәа'),
        array('aa', 'aar', 'aar', 'aar', 'Afar', 'Afaraf'),
        array('af', 'afr', 'afr', 'afr', 'Afrikaans', 'Afrikaans'),
        array('ak', 'aka', 'aka', 'aka', 'Akan', 'Akan'),
        array('sq', 'sqi', 'alb', 'sqi', 'Albanian', 'Shqip'),
        array('am', 'amh', 'amh', 'amh', 'Amharic', 'አማርኛ'),
        array('ar', 'ara', 'ara', 'ara', 'Arabic', 'العربية'),
        array('an', 'arg', 'arg', 'arg', 'Aragonese', 'aragonés'),
        array('hy', 'hye', 'arm', 'hye', 'Armenian', 'Հայերեն'),
        array('as', 'asm', 'asm', 'asm', 'Assamese', 'অসমীয়া'),
        array('av', 'ava', 'ava', 'ava', 'Avaric', 'авар мацӀ, магӀарул мацӀ'),
        array('ae', 'ave', 'ave', 'ave', 'Avestan', 'avesta'),
        array('ay', 'aym', 'aym', 'aym', 'Aymara', 'aymar aru'),
        array('az', 'aze', 'aze', 'aze', 'Azerbaijani', 'azərbaycan dili'),
        array('bm', 'bam', 'bam', 'bam', 'Bambara', 'bamanankan'),
        array('ba', 'bak', 'bak', 'bak', 'Bashkir', 'башҡорт теле'),
        array('eu', 'eus', 'baq', 'eus', 'Basque', 'euskara, euskera'),
        array('be', 'bel', 'bel', 'bel', 'Belarusian', 'беларуская мова'),
        array('bn', 'ben', 'ben', 'ben', 'Bengali, Bangla', 'বাংলা'),
        array('bh', 'bih', 'bih', '', 'Bihari', 'भोजपुरी'),
        array('bi', 'bis', 'bis', 'bis', 'Bislama', 'Bislama'),
        array('bs', 'bos', 'bos', 'bos', 'Bosnian', 'bosanski jezik'),
        array('br', 'bre', 'bre', 'bre', 'Breton', 'brezhoneg'),
        array('bg', 'bul', 'bul', 'bul', 'Bulgarian', 'български език'),
        array('my', 'mya', 'bur', 'mya', 'Burmese', 'ဗမာစာ'),
        array('ca', 'cat', 'cat', 'cat', 'Catalan', 'català'),
        array('ch', 'cha', 'cha', 'cha', 'Chamorro', 'Chamoru'),
        array('ce', 'che', 'che', 'che', 'Chechen', 'нохчийн мотт'),
        array('ny', 'nya', 'nya', 'nya', 'Chichewa, Chewa, Nyanja', 'chiCheŵa, chinyanja'),
        array('zh', 'zho', 'chi', 'zho', 'Chinese', '中文 (Zhōngwén), 汉语, 漢語'),
        array('cv', 'chv', 'chv', 'chv', 'Chuvash', 'чӑваш чӗлхи'),
        array('kw', 'cor', 'cor', 'cor', 'Cornish', 'Kernewek'),
        array('co', 'cos', 'cos', 'cos', 'Corsican', 'corsu, lingua corsa'),
        array('cr', 'cre', 'cre', 'cre', 'Cree', 'ᓀᐦᐃᔭᐍᐏᐣ'),
        array('hr', 'hrv', 'hrv', 'hrv', 'Croatian', 'hrvatski jezik'),
        array('cs', 'ces', 'cze', 'ces', 'Czech', 'čeština, český jazyk'),
        array('da', 'dan', 'dan', 'dan', 'Danish', 'dansk'),
        array('dv', 'div', 'div', 'div', 'Divehi, Dhivehi, Maldivian', 'ދިވެހި'),
        array('nl', 'nld', 'dut', 'nld', 'Dutch', 'Nederlands, Vlaams'),
        array('dz', 'dzo', 'dzo', 'dzo', 'Dzongkha', 'རྫོང་ཁ'),
        array('en', 'eng', 'eng', 'eng', 'English', 'English'),
        array('eo', 'epo', 'epo', 'epo', 'Esperanto', 'Esperanto'),
        array('et', 'est', 'est', 'est', 'Estonian', 'eesti, eesti keel'),
        array('ee', 'ewe', 'ewe', 'ewe', 'Ewe', 'Eʋegbe'),
        array('fo', 'fao', 'fao', 'fao', 'Faroese', 'føroyskt'),
        array('fj', 'fij', 'fij', 'fij', 'Fijian', 'vosa Vakaviti'),
        array('fi', 'fin', 'fin', 'fin', 'Finnish', 'suomi, suomen kieli'),
        array('fr', 'fra', 'fre', 'fra', 'French', 'français, langue française'),
        array('ff', 'ful', 'ful', 'ful', 'Fula, Fulah, Pulaar, Pular', 'Fulfulde, Pulaar, Pular'),
        array('gl', 'glg', 'glg', 'glg', 'Galician', 'galego'),
        array('ka', 'kat', 'geo', 'kat', 'Georgian', 'ქართული'),
        array('de', 'deu', 'ger', 'deu', 'German', 'Deutsch'),
        array('el', 'ell', 'gre', 'ell', 'Greek (modern)', 'ελληνικά'),
        array('gn', 'grn', 'grn', 'grn', 'Guaraní', 'Avañe\'ẽ'),
        array('gu', 'guj', 'guj', 'guj', 'Gujarati', 'ગુજરાતી'),
        array('ht', 'hat', 'hat', 'hat', 'Haitian, Haitian Creole', 'Kreyòl ayisyen'),
        array('ha', 'hau', 'hau', 'hau', 'Hausa', '(Hausa) هَوُسَ'),
        array('he', 'heb', 'heb', 'heb', 'Hebrew (modern)', 'עברית'),
        array('hz', 'her', 'her', 'her', 'Herero', 'Otjiherero'),
        array('hi', 'hin', 'hin', 'hin', 'Hindi', 'हिन्दी, हिंदी'),
        array('ho', 'hmo', 'hmo', 'hmo', 'Hiri Motu', 'Hiri Motu'),
        array('hu', 'hun', 'hun', 'hun', 'Hungarian', 'magyar'),
        array('ia', 'ina', 'ina', 'ina', 'Interlingua', 'Interlingua'),
        array('id', 'ind', 'ind', 'ind', 'Indonesian', 'Bahasa Indonesia'),
        array('ie', 'ile', 'ile', 'ile', 'Interlingue', 'Originally called Occidental; then Interlingue after WWII'),
        array('ga', 'gle', 'gle', 'gle', 'Irish', 'Gaeilge'),
        array('ig', 'ibo', 'ibo', 'ibo', 'Igbo', 'Asụsụ Igbo'),
        array('ik', 'ipk', 'ipk', 'ipk', 'Inupiaq', 'Iñupiaq, Iñupiatun'),
        array('io', 'ido', 'ido', 'ido', 'Ido', 'Ido'),
        array('is', 'isl', 'ice', 'isl', 'Icelandic', 'Íslenska'),
        array('it', 'ita', 'ita', 'ita', 'Italian', 'italiano'),
        array('iu', 'iku', 'iku', 'iku', 'Inuktitut', 'ᐃᓄᒃᑎᑐᑦ'),
        array('ja', 'jpn', 'jpn', 'jpn', 'Japanese', '日本語 (にほんご)'),
        array('jv', 'jav', 'jav', 'jav', 'Javanese', 'basa Jawa'),
        array('kl', 'kal', 'kal', 'kal', 'Kalaallisut, Greenlandic', 'kalaallisut, kalaallit oqaasii'),
        array('kn', 'kan', 'kan', 'kan', 'Kannada', 'ಕನ್ನಡ'),
        array('kr', 'kau', 'kau', 'kau', 'Kanuri', 'Kanuri'),
        array('ks', 'kas', 'kas', 'kas', 'Kashmiri', 'कश्मीरी, كشميري‎'),
        array('kk', 'kaz', 'kaz', 'kaz', 'Kazakh', 'қазақ тілі'),
        array('km', 'khm', 'khm', 'khm', 'Khmer', 'ខ្មែរ, ខេមរភាសា, ភាសាខ្មែរ'),
        array('ki', 'kik', 'kik', 'kik', 'Kikuyu, Gikuyu', 'Gĩkũyũ'),
        array('rw', 'kin', 'kin', 'kin', 'Kinyarwanda', 'Ikinyarwanda'),
        array('ky', 'kir', 'kir', 'kir', 'Kyrgyz', 'Кыргызча, Кыргыз тили'),
        array('kv', 'kom', 'kom', 'kom', 'Komi', 'коми кыв'),
        array('kg', 'kon', 'kon', 'kon', 'Kongo', 'Kikongo'),
        array('ko', 'kor', 'kor', 'kor', 'Korean', '한국어, 조선어'),
        array('ku', 'kur', 'kur', 'kur', 'Kurdish', 'Kurdî, كوردی‎'),
        array('kj', 'kua', 'kua', 'kua', 'Kwanyama, Kuanyama', 'Kuanyama'),
        array('la', 'lat', 'lat', 'lat', 'Latin', 'latine, lingua latina'),
        array('', '', '', 'lld', 'Ladin', 'ladin, lingua ladina'),
        array('lb', 'ltz', 'ltz', 'ltz', 'Luxembourgish, Letzeburgesch', 'Lëtzebuergesch'),
        array('lg', 'lug', 'lug', 'lug', 'Ganda', 'Luganda'),
        array('li', 'lim', 'lim', 'lim', 'Limburgish, Limburgan, Limburger', 'Limburgs'),
        array('ln', 'lin', 'lin', 'lin', 'Lingala', 'Lingála'),
        array('lo', 'lao', 'lao', 'lao', 'Lao', 'ພາສາລາວ'),
        array('lt', 'lit', 'lit', 'lit', 'Lithuanian', 'lietuvių kalba'),
        array('lu', 'lub', 'lub', 'lub', 'Luba-Katanga', 'Tshiluba'),
        array('lv', 'lav', 'lav', 'lav', 'Latvian', 'latviešu valoda'),
        array('gv', 'glv', 'glv', 'glv', 'Manx', 'Gaelg, Gailck'),
        array('mk', 'mkd', 'mac', 'mkd', 'Macedonian', 'македонски јазик'),
        array('mg', 'mlg', 'mlg', 'mlg', 'Malagasy', 'fiteny malagasy'),
        array('ms', 'msa', 'may', 'msa', 'Malay', 'bahasa Melayu, بهاس ملايو‎'),
        array('ml', 'mal', 'mal', 'mal', 'Malayalam', 'മലയാളം'),
        array('mt', 'mlt', 'mlt', 'mlt', 'Maltese', 'Malti'),
        array('mi', 'mri', 'mao', 'mri', 'Māori', 'te reo Māori'),
        array('mr', 'mar', 'mar', 'mar', 'Marathi (Marāṭhī)', 'मराठी'),
        array('mh', 'mah', 'mah', 'mah', 'Marshallese', 'Kajin M̧ajeļ'),
        array('mn', 'mon', 'mon', 'mon', 'Mongolian', 'монгол'),
        array('na', 'nau', 'nau', 'nau', 'Nauru', 'Ekakairũ Naoero'),
        array('nv', 'nav', 'nav', 'nav', 'Navajo, Navaho', 'Diné bizaad'),
        array('nd', 'nde', 'nde', 'nde', 'Northern Ndebele', 'isiNdebele'),
        array('ne', 'nep', 'nep', 'nep', 'Nepali', 'नेपाली'),
        array('ng', 'ndo', 'ndo', 'ndo', 'Ndonga', 'Owambo'),
        array('nb', 'nob', 'nob', 'nob', 'Norwegian Bokmål', 'Norsk bokmål'),
        array('nn', 'nno', 'nno', 'nno', 'Norwegian Nynorsk', 'Norsk nynorsk'),
        array('no', 'nor', 'nor', 'nor', 'Norwegian', 'Norsk'),
        array('ii', 'iii', 'iii', 'iii', 'Nuosu', 'ꆈꌠ꒿ Nuosuhxop'),
        array('nr', 'nbl', 'nbl', 'nbl', 'Southern Ndebele', 'isiNdebele'),
        array('oc', 'oci', 'oci', 'oci', 'Occitan', 'occitan, lenga d\'òc'),
        array('oj', 'oji', 'oji', 'oji', 'Ojibwe, Ojibwa', 'ᐊᓂᔑᓈᐯᒧᐎᓐ'),
        array('cu', 'chu', 'chu', 'chu', 'Old Church Slavonic, Church Slavonic, Old Bulgarian', 'ѩзыкъ словѣньскъ'),
        array('om', 'orm', 'orm', 'orm', 'Oromo', 'Afaan Oromoo'),
        array('or', 'ori', 'ori', 'ori', 'Oriya', 'ଓଡ଼ିଆ'),
        array('os', 'oss', 'oss', 'oss', 'Ossetian, Ossetic', 'ирон æвзаг'),
        array('pa', 'pan', 'pan', 'pan', 'Panjabi, Punjabi', 'ਪੰਜਾਬੀ, پنجابی‎'),
        array('pi', 'pli', 'pli', 'pli', 'Pāli', 'पाऴि'),
        array('fa', 'fas', 'per', 'fas', 'Persian (Farsi)', 'فارسی'),
        array('pl', 'pol', 'pol', 'pol', 'Polish', 'język polski, polszczyzna'),
        array('ps', 'pus', 'pus', 'pus', 'Pashto, Pushto', 'پښتو'),
        array('pt', 'por', 'por', 'por', 'Portuguese', 'português'),
        array('qu', 'que', 'que', 'que', 'Quechua', 'Runa Simi, Kichwa'),
        array('rm', 'roh', 'roh', 'roh', 'Romansh', 'rumantsch grischun'),
        array('rn', 'run', 'run', 'run', 'Kirundi', 'Ikirundi'),
        array('ro', 'ron', 'rum', 'ron', 'Romanian', 'limba română'),
        array('ru', 'rus', 'rus', 'rus', 'Russian', 'Русский'),
        array('sa', 'san', 'san', 'san', 'Sanskrit (Saṁskṛta)', 'संस्कृतम्'),
        array('sc', 'srd', 'srd', 'srd', 'Sardinian', 'sardu'),
        array('sd', 'snd', 'snd', 'snd', 'Sindhi', 'सिन्धी, سنڌي، سندھی‎'),
        array('se', 'sme', 'sme', 'sme', 'Northern Sami', 'Davvisámegiella'),
        array('sm', 'smo', 'smo', 'smo', 'Samoan', 'gagana fa\'a Samoa'),
        array('sg', 'sag', 'sag', 'sag', 'Sango', 'yângâ tî sängö'),
        array('sr', 'srp', 'srp', 'srp', 'Serbian', 'српски језик'),
        array('gd', 'gla', 'gla', 'gla', 'Scottish Gaelic, Gaelic', 'Gàidhlig'),
        array('sn', 'sna', 'sna', 'sna', 'Shona', 'chiShona'),
        array('si', 'sin', 'sin', 'sin', 'Sinhala, Sinhalese', 'සිංහල'),
        array('sk', 'slk', 'slo', 'slk', 'Slovak', 'slovenčina, slovenský jazyk'),
        array('sl', 'slv', 'slv', 'slv', 'Slovene', 'slovenski jezik, slovenščina'),
        array('so', 'som', 'som', 'som', 'Somali', 'Soomaaliga, af Soomaali'),
        array('st', 'sot', 'sot', 'sot', 'Southern Sotho', 'Sesotho'),
        array('es', 'spa', 'spa', 'spa', 'Spanish', 'español'),
        array('su', 'sun', 'sun', 'sun', 'Sundanese', 'Basa Sunda'),
        array('sw', 'swa', 'swa', 'swa', 'Swahili', 'Kiswahili'),
        array('ss', 'ssw', 'ssw', 'ssw', 'Swati', 'SiSwati'),
        array('sv', 'swe', 'swe', 'swe', 'Swedish', 'svenska'),
        array('ta', 'tam', 'tam', 'tam', 'Tamil', 'தமிழ்'),
        array('te', 'tel', 'tel', 'tel', 'Telugu', 'తెలుగు'),
        array('tg', 'tgk', 'tgk', 'tgk', 'Tajik', 'тоҷикӣ, toçikī, تاجیکی‎'),
        array('th', 'tha', 'tha', 'tha', 'Thai', 'ไทย'),
        array('ti', 'tir', 'tir', 'tir', 'Tigrinya', 'ትግርኛ'),
        array('bo', 'bod', 'tib', 'bod', 'Tibetan Standard, Tibetan, Central', 'བོད་ཡིག'),
        array('tk', 'tuk', 'tuk', 'tuk', 'Turkmen', 'Türkmen, Түркмен'),
        array('tl', 'tgl', 'tgl', 'tgl', 'Tagalog', 'Wikang Tagalog, ᜏᜒᜃᜅ᜔ ᜆᜄᜎᜓᜄ᜔'),
        array('tn', 'tsn', 'tsn', 'tsn', 'Tswana', 'Setswana'),
        array('to', 'ton', 'ton', 'ton', 'Tonga (Tonga Islands)', 'faka Tonga'),
        array('tr', 'tur', 'tur', 'tur', 'Turkish', 'Türkçe'),
        array('ts', 'tso', 'tso', 'tso', 'Tsonga', 'Xitsonga'),
        array('tt', 'tat', 'tat', 'tat', 'Tatar', 'татар теле, tatar tele'),
        array('tw', 'twi', 'twi', 'twi', 'Twi', 'Twi'),
        array('ty', 'tah', 'tah', 'tah', 'Tahitian', 'Reo Tahiti'),
        array('ug', 'uig', 'uig', 'uig', 'Uyghur', 'ئۇيغۇرچە‎, Uyghurche'),
        array('uk', 'ukr', 'ukr', 'ukr', 'Ukrainian', 'українська мова'),
        array('ur', 'urd', 'urd', 'urd', 'Urdu', 'اردو'),
        array('uz', 'uzb', 'uzb', 'uzb', 'Uzbek', 'Oʻzbek, Ўзбек, أۇزبېك‎'),
        array('ve', 'ven', 'ven', 'ven', 'Venda', 'Tshivenḓa'),
        array('vi', 'vie', 'vie', 'vie', 'Vietnamese', 'Việt Nam'),
        array('vo', 'vol', 'vol', 'vol', 'Volapük', 'Volapük'),
        array('wa', 'wln', 'wln', 'wln', 'Walloon', 'walon'),
        array('cy', 'cym', 'wel', 'cym', 'Welsh', 'Cymraeg'),
        array('wo', 'wol', 'wol', 'wol', 'Wolof', 'Wollof'),
        array('fy', 'fry', 'fry', 'fry', 'Western Frisian', 'Frysk'),
        array('xh', 'xho', 'xho', 'xho', 'Xhosa', 'isiXhosa'),
        array('yi', 'yid', 'yid', 'yid', 'Yiddish', 'ייִדיש'),
        array('yo', 'yor', 'yor', 'yor', 'Yoruba', 'Yorùbá'),
        array('za', 'zha', 'zha', 'zha', 'Zhuang, Chuang', 'Saɯ cueŋƅ, Saw cuengh'),
        array('zu', 'zul', 'zul', 'zul', 'Zulu', 'isiZulu'),
    );
	$b_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	$lang_code = strtolower(trim($b_lang));
	$lang_return = 'spa';
	foreach ($languages as $lang) {
		if ($lang[$indexIso639_1] === $lang_code) {
			$lang_return = $lang[$indexIso639_2t];
		}
	}
    //$lang_return = 'spa';
    return $lang_return;
	
}

add_action( 'init', 'createsession' );
function createsession() {
	
	$session = array();
	
	if(!isset($_SESSION['msgs'])){
		$lang = detect_lang();
		$page = 'product';
		$all_options1 = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);
		
		if (count($all_options1) == 0) {
			$lang = 'spa';
			$all_options1 = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);
		}

		if(!empty($all_options1)){
			foreach($all_options1 as $all_option){				
				$session['product'][$all_option['MessageId']] = array('content' => $all_option['translations'][0]['content'], 'tooltip' => $all_option['translations'][0]['tooltip']);
			}
		}
		
		
		$page = 'cart';
		$lang = detect_lang();
		$all_options2 = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);

		if (count($all_options2) == 0) {
			$lang = 'spa';
			$all_options2 = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);
		}

		if(!empty($all_options2)){
			foreach($all_options2 as $all_option){				
				$session['cart'][$all_option['MessageId']] = array('content' => $all_option['translations'][0]['content'], 'tooltip' => $all_option['translations'][0]['tooltip']);
			}
		}
		
		$page = 'check-out';
		$lang = detect_lang();
		$all_options3 = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);

		if (count($all_options3) == 0) {
			$lang = 'spa';
			$all_options3 = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);
		}

		if(!empty($all_options3)){
			foreach($all_options3 as $all_option){				
				$session['check-out'][$all_option['MessageId']] = array('content' => $all_option['translations'][0]['content'], 'tooltip' => $all_option['translations'][0]['tooltip']);
			}
		}
		
		$page = 'thank-you';
		$lang = detect_lang();
		$all_options4 = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);

		if (count($all_options4) == 0) {
			$lang = 'spa';
			$all_options4 = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);
		}

		if(!empty($all_options4)){
			foreach($all_options4 as $all_option){			
				if (!empty($all_option) && isset($all_option['translations'])) {
					$session['thank-you'][$all_option['MessageId']] = array('content' => $all_option['translations'][0]['content'], 'tooltip' => $all_option['translations'][0]['tooltip']);
				}
			}
		}
		$session['thank-you']['link'] = $all_options4['thankyou-link'];
		
		$_SESSION['msgs'] = $session;
	}
	//print_r($_SESSION['msgs']);
	
}

function themeslug_enqueue_style() {
	
    wp_enqueue_style( 'msg-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), '1.0.1', 'all' );
    wp_enqueue_style( 'msg-action', plugin_dir_url( __FILE__ ) . 'admin/css/frontend-box.css', array(), '1.0.1', 'all' );
	wp_enqueue_script( 'msg-action', plugin_dir_url( __FILE__ ) . 'admin/js/my-admin.js', array( 'jquery' ),'1.0.1', false );
	
}
 
add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_style' );


add_action( 'wp_footer', 'wp_kama_woocommerce_review_order_after_submit1' );

//add_action( 'woocommerce_thankyou', 'wp_kama_woocommerce_review_order_after_submit1', 10, 0);
function wp_kama_woocommerce_review_order_after_submit1(){
	$options = get_option( 'wppb_demo_display_options' );
	$authentication = get_option('wppb_demo_authentication_options');

	if (isset($authentication['apikey'])) {
		$stump_position = 'left';
	if(isset($options['stump_position'])){
		if($options['stump_position'] != ''){
			$stump_position = $options['stump_position'];	
		}
	}
	//if(!isset($options['synchronization_off'])){
		//if($options['synchronization_off'] != 1){
		$plugin_dir = str_replace(WP_PLUGIN_DIR . '/', '', __DIR__);
		if (isset($options['black_background'])) {
			# code...
			echo '<div style="clear:both;"></div>
			<div id="crossitem_added" class="stumpwrap '.$stump_position.'">
				<div class="tooltip">
					<img src="/wp-content/plugins/' . $plugin_dir . '/public/img/climaticco-stamp-dark.png"> 
					<!--<span id="crossitem">&times;</span>-->
				</div>
			</div> <div style="clear:both;"></div>';
		}else{
			echo '<div style="clear:both;"></div>
			<div id="crossitem_added" class="stumpwrap '.$stump_position.'">
				<div class="tooltip">
					<img src="/wp-content/plugins/' . $plugin_dir . '/public/img/climaticco-stamp.png"> 
					<!--<span id="crossitem">&times;</span>-->
				</div>
			</div> <div style="clear:both;"></div>';
		}
			
		//}
	//}
	}
	
}


$options = get_option( 'wppb_demo_display_options' );
$hook = 'woocommerce_after_add_to_cart_button';
if(isset($options['prod_under_h1'])){
	if($options['prod_under_h1'] == 1){		
		$hook = 'woocommerce_single_product_summary';
	}
}

add_action( $hook, 'custom_action_after_single_product_title', 6 );
function custom_action_after_single_product_title() { 
    global $product; 
    //wp_enqueue_style( 'msg-action', plugin_dir_url( __FILE__ ) . 'admin/css/frontend-box.css', array(), '1.0.1', 'all' );
	$options = get_option( 'wppb_demo_display_options' );
	$authentication = get_option('wppb_demo_authentication_options');

	if (isset($authentication['apikey'])) {
			
			if(isset($options['prod_fontsize'])){
				if($options['prod_fontsize'] != ''){
					$options['prod_fontsize'] = $options['prod_fontsize'];	
				}else{
					$options['prod_fontsize'] = '1';
				}
			}else{
				$options['prod_fontsize'] = '1';
			}
			$plugin_dir = str_replace(WP_PLUGIN_DIR . '/', '', __DIR__);
			$background_color = $options['product_color'];
			$black_background = '/wp-content/plugins/' . $plugin_dir . '/public/img/climaticco-light.png';
			if(isset($options['black_background'])){
				if($options['black_background'] == 1){
					$black_background = '/wp-content/plugins/' . $plugin_dir . '/public/img/climaticco-dark.png';	
				}
			}
			
			$session = $_SESSION['msgs'];
			$tooltip = '';
			if(isset($_SESSION['msgs']['product'][$options['product_message']])){				
				$tooltip = $session['product'][$options['product_message']]['tooltip'];
			}else{
				if(!empty($session['product'])){
					foreach($session['product'] as $ss){								
						$tooltip = $ss['tooltip'];
						break;
					}
				}
			}
			$msg = '';
			if(isset($_SESSION['msgs']['product'][$options['product_message']])){	
				$msg = $session['product'][$options['product_message']]['content'];
			}else{
				if(!empty($session['product'])){
					foreach($session['product'] as $ss){								
						$msg = $ss['content'];
						break;
					}
				}
			}
			
			
			$allmsg = '<div class="alertbox alertbox-'.$options['prod_alignment'].'" style="background-color:'.$background_color.';font-size:'.$options['prod_fontsize'].'em;"> 
			'.'<span class="tooltip"><img src="'.$black_background.'"></span> <span class="message-content">'.$msg.'<span class="closebtn tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i> <span class="tooltiptext tooltip-left">'.$tooltip.'</span></span></span>'.'
		</div>';
			
			
			echo $allmsg;
	}

	
}


$hook = 'woocommerce_after_cart_totals';
//echo $options['cart_under_h1'].'----------------';
if(isset($options['cart_under_h1'])){
	if($options['cart_under_h1'] == 1){		
		$hook = 'woocommerce_before_cart';
	}
}


add_action( $hook, 'woocommerce_output_all_notices1', 10 ); 

function woocommerce_output_all_notices1() {
    //wp_enqueue_style( 'msg-action', plugin_dir_url( __FILE__ ) . 'admin/css/frontend-box.css', array(), '1.0.1', 'all' );
	$options = get_option( 'wppb_demo_display_options' );

	$authentication = get_option('wppb_demo_authentication_options');

	if (isset($authentication['apikey'])) {
		if(isset($options['cart_fontsize'])){
			if($options['cart_fontsize'] != ''){
				$options['cart_fontsize'] = $options['prod_fontsize'];	
			}else{
				$options['cart_fontsize'] = '1';
			}
		}else{
			$options['cart_fontsize'] = '1';
		}
		$plugin_dir = str_replace(WP_PLUGIN_DIR . '/', '', __DIR__);
		$background_color = $options['product_color'];
		$black_background = '/wp-content/plugins/' . $plugin_dir . '/public/img/climaticco-light.png';
		if(isset($options['black_background'])){
			if($options['black_background'] == 1){
				$black_background = '/wp-content/plugins/' . $plugin_dir . '/public/img/climaticco-dark.png';	
			}
		}
		
		$session = $_SESSION['msgs'];
		$tooltip = '';
		if(isset($_SESSION['msgs']['cart'][$options['cart_message']])){				
			$tooltip = $session['cart'][$options['cart_message']]['tooltip'];
		}else{
			if(!empty($session['cart'])){
				foreach($session['cart'] as $ss){								
					$tooltip = $ss['tooltip'];
					break;
				}
			}
		}
		$msg = '';
		if(isset($_SESSION['msgs']['cart'][$options['cart_message']])){	
			$msg = $session['cart'][$options['cart_message']]['content'];
		}else{
			if(!empty($session['cart'])){
				foreach($session['cart'] as $ss){								
					$msg = $ss['content'];
					break;
				}
			}
		}
		//$allmsg = '<span class="tooltip"><img src="'.$black_background.'"></span> <span class="message-content">'.$msg.'</span>';
		
		echo '<div class="alertbox alertbox-'.$options['cart_alignment'].'" style="background-color:'.$background_color.';text-align: '.$options['cart_alignment'].';font-size:'.$options['cart_fontsize'].'em;">
			'.'<span class="tooltip"><img src="'.$black_background.'"></span> <span class="message-content">'.$msg.'<span class="closebtn tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i> <span class="tooltiptext tooltip-left">'.$tooltip.'</span></span></span>'.'
			 
		</div>';
	}
}



$hook = 'woocommerce_review_order_after_submit';
if(isset($options['checkout_under_h1'])){
	if($options['checkout_under_h1'] == 1){		
		$hook = 'woocommerce_before_checkout_form';
	}
}

add_action( $hook, 'woocommerce_before_checkout_form_before', 10 ); 

function woocommerce_before_checkout_form_before() { 
	
	$options = get_option( 'wppb_demo_display_options' );
	$authentication = get_option('wppb_demo_authentication_options');

	if (isset($authentication['apikey'])) {
		if(isset($options['checkout_fontsize'])){
			if($options['checkout_fontsize'] != ''){
				$options['checkout_fontsize'] = $options['prod_fontsize'];	
			}else{
				$options['checkout_fontsize'] = '1';
			}
		}else{
			$options['checkout_fontsize'] = '1';
		}
		$plugin_dir = str_replace(WP_PLUGIN_DIR . '/', '', __DIR__);
		$background_color = $options['product_color'];
		$black_background = '/wp-content/plugins/' . $plugin_dir . '/public/img/climaticco-light.png';
		if(isset($options['black_background'])){
			if($options['black_background'] == 1){
				$black_background = '/wp-content/plugins/' . $plugin_dir . '/public/img/climaticco-dark.png';
			}
		}
		
		
		$session = $_SESSION['msgs'];
		$tooltip = '';
		if(isset($_SESSION['msgs']['check-out'][$options['checkout_message']])){				
			$tooltip = $session['check-out'][$options['checkout_message']]['tooltip'];
		}else{
			if(!empty($session['check-out'])){
				foreach($session['check-out'] as $ss){								
					$tooltip = $ss['tooltip'];
					break;
				}
			}
		}
		$msg = '';
		if(isset($_SESSION['msgs']['check-out'][$options['checkout_message']])){	
			$msg = $session['check-out'][$options['checkout_message']]['content'];
		}else{
			if(!empty($session['check-out'])){
				foreach($session['check-out'] as $ss){								
					$msg = $ss['content'];
					break;
				}
			}
		}
		
		//$allmsg = '<span class="tooltip"><img src="'.$black_background.'"></span> <span class="message-content">'.$msg.'</span>';
		
		echo '<div class="alertbox alertbox-'.$options['checkout_alignment'].'" style="clear: both; background-color:'.$background_color.';text-align: '.$options['checkout_alignment'].';font-size:'.$options['checkout_fontsize'].'em;">
			'.'<span class="tooltip"><img src="'.$black_background.'"></span> <span class="message-content">'.$msg.'<span class="closebtn tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i> <span class="tooltiptext tooltip-left">'.$tooltip.'</span></span> </span>'.'
		</div>';
	}
}


add_filter('woocommerce_thankyou_order_received_text', 'woo_change_order_received_text', 10, 2 );
function woo_change_order_received_text( $str, $order ) {

	$options = get_option( 'wppb_demo_display_options' );
	$authentication = get_option('wppb_demo_authentication_options');

	if (isset($authentication['apikey'])) {
		$plugin_dir = str_replace(WP_PLUGIN_DIR . '/', '', __DIR__);
			$background_color = $options['product_color'];
			$black_background = '/wp-content/plugins/' . $plugin_dir . '/public/img/climaticco-light.png';
			if(isset($options['black_background'])){
				if($options['black_background'] == 1){
					$black_background = '/wp-content/plugins/' . $plugin_dir . '/public/img/climaticco-dark.png';
				}
			}
			
			
			
			$session = $_SESSION['msgs'];
			$tooltip = '';
			if(isset($_SESSION['msgs']['thank-you'][$options['thankyou_message']])){				
				$tooltip = $session['thank-you'][$options['thankyou_message']]['tooltip'];
			}else{
				if(!empty($session['thank-you'])){
					foreach($session['thank-you'] as $ss){								
						$tooltip = $ss['tooltip'];
						break;
					}
				}
			}
			$msg = '';
			if(isset($_SESSION['msgs']['thank-you'][$options['thankyou_message']])){	
				$msg = $session['thank-you'][$options['thankyou_message']]['content'];
				$link = $session['thank-you']['link'];
			}else{
				if(!empty($session['thank-you'])){
					foreach($session['thank-you'] as $ss){								
						$msg = $ss['content'];
						break;
					}
				}
			}
			
			
			//$allmsg = '<span class="tooltip"><img src="'.$black_background.'"></span> <span class="message-content" style="margin-top: 2px;">'.$msg.' <a href="'.$link.'" target="_blank" style="display: inline-flex;align-items: flex-start;padding: 0; margin-top: -4;">Más información</a></span>';
			
			$new_str = '<div class="alertbox alertbox-'.$options['thankyou_alignment'].'" style="background-color:'.$background_color.';text-align: '.$options['thankyou_alignment'].';font-size:'.$options['thankyou_fontsize'].'em;">
			'.' <span class="message-content" style="margin-top: 2px;"><span class="tooltip" style="margin-right: 5px;"><img src="'.$black_background.'"></span>'.$msg.' <a href="'.$link.'" target="_blank" style="display: inline-flex;align-items: flex-start;padding: 0; margin-top: -4;">Más información</a><span class="closebtn tooltip" style="margin-top: 4px;"><i class="fa fa-info-circle" aria-hidden="true"></i> <span style="background-color:'.$background_color.';" class="tooltiptext tooltip-left">'.$tooltip.'</span></span> </span>'.'
			</div>';
	}

    return $new_str;
}

/*add_action('init', 'my_init_new');
function my_init_new(){
			$order_id  = 117; 

			$order1 = new WC_Order( $order_id );
			
			$total_weight = 0;

			foreach( $order1->get_items() as $item_id => $product_item ){
				$quantity = $product_item->get_quantity(); // get quantity
				$product = $product_item->get_product(); // get the WC_Product object
				$product_weight = $product->get_weight(); // get the product weight
				// Add the line item weight to the total weight calculation
				$total_weight += floatval( $product_weight * $quantity );
			}
			
			$first_name = $order1->get_shipping_first_name();
			$last_name = $order1->get_shipping_last_name();
			$_address_1 = $order1->get_shipping_address_1();
			$_city = $order1->get_shipping_city();
			$_state = $order1->get_shipping_state();
			$_postcode = $order1->get_shipping_postcode();
			$_country = $order1->get_shipping_country();
			
			
			$store_address     = get_option( 'woocommerce_store_address' );
			$store_address_2   = get_option( 'woocommerce_store_address_2' );
			$store_city        = get_option( 'woocommerce_store_city' );
			$store_postcode    = get_option( 'woocommerce_store_postcode' );
			$weight_unit = get_option('woocommerce_weight_unit');

			// The country/state
			$store_raw_country = get_option( 'woocommerce_default_country' );

			// Split the country/state
			$split_country = explode( ":", $store_raw_country );

			// Country and state separated:
			$store_country = $split_country[0];
			$store_state   = $split_country[1];
			
			
			$data = array(
				'date' => date('d/m/Y',strtotime($order1->get_date_created())),
				'destinationAddress' => $_address_1,
				'destinationMunicipality' => $_city,
				'destinationPostalCode' => $store_postcode,
				'destinationProvince' => $_state,
				'destinationCountry' => $_country,
				'originAddress' => $store_address,
				'originMunicipality' => $store_city,
				'originPostalCode' => $store_postcode,
				'originProvince' => $store_state,
				'originCountry' => $split_country,
				'numOrder' => $order_id,
				'weight' => $total_weight,
				'weightUnit' => strtoupper($weight_unit)
			);
			$_url = http_build_query($data);
			$url = 'https://appv2.climaticco.com/api/v1/ecommerce/order/new?'.$_url;
			
			$to = "shankha4030@gmail.com"; 
			$subject = "My subject 1";
			echo $txt = json_encode($data). ' | ==== | '.$url;
			$headers = "From: info@ghrixlabs.com" . "\r\n";

			mail($to,$subject,$txt,$headers); 
			
			update_post_meta( $order_id, 'order_api_send_data', $txt );
			
			$curl = curl_init();
			
			$options = get_option('wppb_demo_authentication_options');
			$apikey = '';
			if( isset( $options['apikey'] ) ) {
				$apikey = $options['apikey'];
			}
			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => json_encode($data),
				CURLOPT_HTTPHEADER => array(
					'X-AUTH-TOKEN: '.$apikey
				),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$response_return = json_decode($response,true);
			//echo 'data===='.get_post_meta( 133, 'order_api_send_data', true );
}*/

 
add_action( 'woocommerce_order_status_completed', 'mysite_woocommerce_order_status_completed', 10, 1 );
function mysite_woocommerce_order_status_completed( $order_id ) { 
    //$options = get_option( 'wppb_demo_display_options' );
	//if(!isset($options['synchronization_off'])){
		//if($options['synchronization_off'] != 1){
			$order = new WC_Order( $order_id );
			
			$total_weight = 0;

			foreach( $order->get_items() as $item_id => $product_item ){
				$quantity = $product_item->get_quantity(); // get quantity
				$product = $product_item->get_product(); // get the WC_Product object
				$product_weight = $product->get_weight(); // get the product weight
				// Add the line item weight to the total weight calculation
				if (is_numeric($product_weight)) {
					$total_weight += floatval( $product_weight * $quantity );
				}
				
			}
			
			$first_name = $order->get_shipping_first_name();
			$last_name = $order->get_shipping_last_name();
			$_address_1 = $order->get_shipping_address_1();
			$_city = $order->get_shipping_city();
			$_state = 'Madrid';
			$_postcode = $order->get_shipping_postcode();
			$_country = $order->get_shipping_country();
			
			
			$store_address     = get_option( 'woocommerce_store_address' );
			$store_address_2   = get_option( 'woocommerce_store_address_2' );
			$store_city        = get_option( 'woocommerce_store_city' );
			$store_postcode    = get_option( 'woocommerce_store_postcode' );
			$weight_unit = get_option('woocommerce_weight_unit');

			// The country/state
			$store_raw_country = get_option( 'woocommerce_default_country' );

			// Split the country/state
			$split_country = explode( ":", $store_raw_country );

			// Country and state separated:
			$store_country = $split_country[0];
			//$store_state   = $split_country[1];
			$store_state   = 'Murcia';
			
			$data = array(
				'date' => date('d/m/Y',strtotime($order->get_date_created())),
				'destinationAddress' => $_address_1,
				'destinationMunicipality' => $_city,
				'destinationPostalCode' => $store_postcode,
				'destinationProvince' => $_state,
				'destinationCountry' => $_country,
				'originAddress' => $store_address,
				'originMunicipality' => $store_city,
				'originPostalCode' => $store_postcode,
				'originProvince' => $store_state,
				'originCountry' => $split_country[0],
				'numOrder' => $order_id,
				'weight' => $total_weight,
				'weightUnit' => strtoupper($weight_unit)
			);
			$_url = http_build_query($data);
			$url = 'https://appv2.climaticco.com/api/v1/ecommerce/order/new?'.$_url;
			
			$to = "lopezbonaque@gmail.com"; 
			$subject = "My subject 1";
			echo $txt = print_r($data,true). ' | ==== | '.$url;
			$headers = "From: soporte@sevensystem.es" . "\r\n";

			mail($to,$subject,$txt,$headers); 

			if (!function_exists('write_log')) {

				function write_log($log) {
					if (true === WP_DEBUG) {
						if (is_array($log) || is_object($log)) {
							error_log(print_r($log, true));
						} else {
							error_log($log);
						}
					}
				}
			
			}
			
			write_log($order_id.': '.$txt);
			
			update_post_meta( $order_id, 'order_api_send_data', $txt );
			
			$curl = curl_init();
			
			$options = get_option('wppb_demo_authentication_options');
			$apikey = '';
			if( isset( $options['apikey'] ) ) {
				$apikey = $options['apikey'];
			}
			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => json_encode($data),
				CURLOPT_HTTPHEADER => array(
					'X-AUTH-TOKEN: '.$apikey
				),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$response_return = json_decode($response,true);
		//}
	//}
	
}
/*
function wpauth_updated($option_name, $old_value, $value){
	if ($option_name == 'wppb_demo_authentication_options' && $old_value != $value) {
		$product_message = $this->default_social_options();
		update_option('wppb_demo_social_options', $product_message);
		$cart_message = $this->default_cart_options();
		update_option('wppb_demo_cart_options', $cart_message);
		$checkout_message = $this->default_checkout_options();
		update_option('wppb_demo_checkout_options', $checkout_message);
		$thankyou_message = $this->default_thankyou_options();
		update_option('wppb_demo_thankyou_options', $thankyou_message);
	}
}
add_action('updated_option', 'wpauth_updated', 10, 3);
*/

add_filter( 'cron_schedules', 'isa_add_every_one_hour' );
function isa_add_every_one_hour( $schedules ) {
    $schedules['every_one_hour'] = array(
            'interval'  => 3600,
            'display'   => __( 'Every one hour', 'textdomain' )
    );
    return $schedules;
}

add_filter( 'plugin_row_meta', 'climaticco_plugin_meta_links', 10, 2 );

function climaticco_plugin_meta_links( $links, $file ) {
	
    if ( strpos( $file, basename(__FILE__) ) ) {
        $links[2] = '<a href="https://www.climaticco.com/ayuda/wp-plugin-config/" target="_blank" title="Documentación">Ver detalles</a>';
		//var_dump($links);
	}
    return $links;
}

// Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'isa_add_every_one_hour' ) ) {
    wp_schedule_event( time(), 'every_one_hour', 'isa_add_every_one_hour' );
}

// Hook into that action that'll fire every three minutes
add_action( 'isa_add_every_one_hour', 'every_one_hour_event_func' );
function every_one_hour_event_func() {

	$lang = detect_lang();
	$page = 'product';
	$all_options1 = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);
	
	if(!empty($all_options1)){
		foreach($all_options1 as $all_option){				
			$session['product'][$all_option['MessageId']] = array('content' => $all_option['translations'][0]['content'], 'tooltip' => $all_option['translations'][0]['tooltip']);
		}
	}
	
	
	$page = 'cart';
	$all_options2 = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);
	if(!empty($all_options2)){
		foreach($all_options2 as $all_option){				
			$session['cart'][$all_option['MessageId']] = array('content' => $all_option['translations'][0]['content'], 'tooltip' => $all_option['translations'][0]['tooltip']);
		}
	}
	
	$page = 'check-out';
	$all_options3 = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);
	if(!empty($all_options3)){
		foreach($all_options3 as $all_option){				
			$session['check-out'][$all_option['MessageId']] = array('content' => $all_option['translations'][0]['content'], 'tooltip' => $all_option['translations'][0]['tooltip']);
		}
	}
	
	$page = 'thank-you';
	$all_options4 = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);
	if(!empty($all_options4)){
		foreach($all_options4 as $all_option){				
			$session['thank-you'][$all_option['MessageId']] = array('content' => $all_option['translations'][0]['content'], 'tooltip' => $all_option['translations'][0]['tooltip']);
		}
	}
	
	$_SESSION['msgs'] = $session;
	
}
