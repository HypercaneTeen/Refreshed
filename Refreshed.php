<?php
/**
 * Refreshed skin -- a new clean, modern MediaWiki skin used on Brickimedia.
 *
 * @file
 * @ingroup Skins
 * @version 2.2
 * @link https://www.mediawiki.org/wiki/Skin:Refreshed Documentation
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

// Hide tables of content, as Refreshed creates its own
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'NoTOC',
	'version' => '0.1.0',
	'author' => '[http://swiftlytilting.com Andrew Fitzgerald]',
	'url' => 'http://www.mediawiki.org/wiki/Extension:NoTOC',
	'description' => 'Turns off TOC by default on all pages',
	//'descriptionmsg' => 'notoc-desc',
);

$wgHooks['ParserClearState'][] = 'efMWNoTOC';

function efMWNoTOC( $parser ) {
	$parser->mShowToc = false;
	return true;
}

// Skin credits that will show up on Special:Version
$wgExtensionCredits['skin'][] = array(
	'path' => __FILE__,
	'name' => 'Refreshed',
	'version' => '2.2',
	'author' => 'Brickimedia',
	'description' => 'A new clean, modern MediaWiki skin used on Brickimedia',
	'url' => 'https://www.mediawiki.org/wiki/Skin:Refreshed',
);

// The first instance must be strtolower()ed so that useskin=refreshed works and
// so that it does *not* force an initial capital (i.e. we do NOT want
// useskin=Refreshed) and the second instance is used to determine the name of
// *this* file.
$wgValidSkinNames['refreshed'] = 'Refreshed';

// Autoload the skin class, set up i18n, set up CSS & JS (via ResourceLoader)
$wgAutoloadClasses['SkinRefreshed'] = __DIR__ . '/Refreshed.skin.php';
$wgAutoloadClasses['RefreshedTemplate'] = __DIR__ . '/Refreshed.skin.php'; // needed for the hooked func below
$wgMessagesDirs['SkinRefreshed'] = __DIR__ . '/i18n';

$wgResourceModules['skins.refreshed'] = array(
	'styles' => array(
		# Styles custom to the Refreshed skin
		'skins/Refreshed/refreshed/main.css' => array( 'media' => 'screen' ),
		'skins/Refreshed/refreshed/small.css' => array( 'media' => '(max-width: 600px)' ),
		'skins/Refreshed/refreshed/medium.css' => array( 'media' => '(min-width: 601px) and (max-width: 1000px)' ),
		'skins/Refreshed/refreshed/big.css' => array( 'media' => '(min-width: 1001px)' ),
	),
	'position' => 'top'
);

$wgResourceModules['skins.refreshed.js'] = array(
	'scripts' => 'skins/Refreshed/refreshed/refreshed.js',
	'dependencies' => array( 'mediawiki.api', 'mediawiki.util' )
);

$wgHooks['OutputPageParserOutput'][] = 'RefreshedTemplate::onOutputPageParserOutput';

$wgHooks['BeforePageDisplay'][] = function( &$out, &$skin ) {
	// Add the viewport meta tag for users who are using this skin
	// The skin class check has to be present because hooks are global!
	if ( get_class( $skin ) == 'SkinRefreshed' ) {
		$out->addMeta( 'viewport', 'width=device-width' );
	}

	return true;
};

$wgRefreshedHeader = array(
	'img' => '<img src="http://meta.brickimedia.org/skins/Refreshed/refreshed/images/brickimedia.svg" width="144" alt="" />',
	'url' => 'http://meta.brickimedia.org/wiki/Main_Page',
	'dropdown' => array() // format: array( 'http://exampleurl.com' => '<img src="http://exampleimage.png" width="100" />', );
);
