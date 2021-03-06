<?php
# This file was automatically generated by the MediaWiki 1.22.14
# installer. If you make manual changes, please keep track in case you
# need to recreate them later.
#
# See includes/DefaultSettings.php for all configurable settings
# and their default values, but don't forget to make changes in _this_
# file, not there.
#
# Further documentation for configuration settings may be found at:
# http://www.mediawiki.org/wiki/Manual:Configuration_settings

# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

## Uncomment this to disable output compression
# $wgDisableOutputCompression = true;

$wgLanguageCode = 'he';
$wgSitename = 'כל-זכות';
$wgMetaNamespace = $wgSitename;
#$wgLogo =


$wgAllowSlowParserFunctions = true; # Allow slow parser functions; Enables the magic words {{PAGESINNAMESPACE}} 
$wgArticleCountMethod = 'any';	/* Count any article as such, even if it isn't categorized or has a wikilink */
$wgWrFormPath = '/forms'; 		# WikiRights specific: points to the relative location of external forms on the server (CR, contact, mail) 
$wgUseCombinedLoginLink = false;

$wgDefaultRobotPolicy 				= 'noindex,nofollow';

## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.
## For more information on customizing the URLs
## (like /w/index.php/Page_title to /wiki/Page_title) please see:
## http://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath = "";
$wgScriptExtension = ".php";

## The protocol and server name to use in fully-qualified URLs
#$wgServer = getenv('SERVER_NAME_AND_PROTOCOL');

## The relative URL path to the skins directory
$wgStylePath = "$wgScriptPath/skins";

## The relative URL path to the logo.  Make sure you change this from the default,
## or else you'll overwrite your logo when you upgrade!
$wgLogo             = "/logo.png";

## UPO means: this is also a user preference option

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO

#$wgEmergencyContact = "apache@YO.com";
#$wgPasswordSender = "apache@YO.com";

$wgEnotifUserTalk = false; # UPO
$wgEnotifWatchlist = false; # UPO
$wgEmailAuthentication = true;

## Database settings
$_wgDBConnectionString = getenv('DATABASE_URL');
if (preg_match('%(.*?)://([^:]+):([^@]+)@([^:]+):(\d+)/(.*)%', $_wgDBConnectionString, $regs, PREG_OFFSET_CAPTURE)) {
$wgDBtype = $regs[1][0];
$wgDBuser = $regs[2][0];
$wgDBpassword = $regs[3][0];
$wgDBserver = $regs[4][0];
$wgDBport = $regs[5][0];
$wgDBname = $regs[6][0];
} else {
die("Failed to parse DB connection string");
}

# MySQL specific settings
$wgDBprefix = "";

# MySQL table options to use during installation or update
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";

# Experimental charset support for MySQL 5.0.
$wgDBmysql5 = false;

## Shared memory settings
$wgMainCacheType = CACHE_NONE;
$wgMemCachedServers = array();

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads = false;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";

# InstantCommons allows wiki to use images from http://commons.wikimedia.org
$wgUseInstantCommons = false;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale
$wgShellLocale = "en_US.utf8";

## If you want to use image uploads under safe mode,
## create the directories images/archive, images/thumb and
## images/temp, and make them all writable. Then uncomment
## this, if it's not already uncommented:
#$wgHashedUploadDirectory = false;

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publically accessible from the web.
#$wgCacheDirectory = "$IP/cache";

$wgSecretKey = "c8dbd8c1b04d7ef3787c469be6699c0eb60b60bebdbd2d468d2a7f2225f9e25d";

# Site upgrade key. Must be set to a string (default provided) to turn on the
# web installer while LocalSettings.php is in place
$wgUpgradeKey = "b2a0f6d071f5b369";

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl = "";
$wgRightsText = "";
$wgRightsIcon = "";

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";



# End of automatically generated settings.
# Add more configuration options below.


###############
## :EDITING: ##
$wgRestrictDisplayTitle = false; #DS 22/2/2010 Allw changing the page title to anything using {{DISPLAYTITLE:foobar}} - used for categorizing pages. Might be unwise... we need a standard.
$wgWikiEditorFeatures['toolbar']['global'] = true; # Enable for all
$wgWikiEditorFeatures['toolbar']['user'] = false; # And do not allow to disable
	$wgDefaultUserOptions['usebetatoolbar'] = true; # Otherwise the checkbox is unchecked for users, even though the feature is on
$wgWikiEditorFeatures['dialogs']['global'] = true; # Enable for all
$wgWikiEditorFeatures['dialogs']['user'] = true; # And allow to disable
	$wgDefaultUserOptions['usebetatoolbar-cgd'] = true; # Otherwise the checkbox is unchecked for users, even though the feature is on
$wgWikiEditorFeatures['preview']['global'] = true; # Enable for all
$wgWikiEditorFeatures['preview']['user'] = true; # And allow to disable
	$wgDefaultUserOptions['wikieditor-preview'] = true; # Otherwise the checkbox is unchecked for users, even though the feature is on
$wgWikiEditorFeatures['publish']['global'] = false; # Disable for all
$wgWikiEditorFeatures['publish']['user'] = false; # And do not allow to enable
$wgWikiEditorFeatures['toc']['global'] = false; # Disable for all
$wgWikiEditorFeatures['toc']['user'] = false; # And do not allow to enable
$wgDefaultUserOptions['showtoolbar'] = true; 	# Show edit toolbar (requires javascript)
$wgDefaultUserOptions['minordefault'] = false; 	# Do *not* mark edits as minor by default
$wgHiddenPrefs[] = 'minordefault';		# Do not allow to change the above setting
$wgHiddenPrefs[] = 'uselivepreview';		# Do not show "quick preview" in preferences (not the tab, but another button, which is deprecated)
#$wgDefaultUserOptions['forceeditsummary'] = true;	# Consider enabling later on

###############
## :DISPLAY: ##
$wgDefaultSkin = 'helena';	// Note: for MW1.24 this should be capitalized!
$wgSkipSkins = array( 'cologneblue', 'modern', 'monobook', 'vector', 'wrvector' ); //...actually the only one we allow ;-)
$wgHiddenPrefs[] = 'skin';	//Here too
$wgHiddenPrefs[] = 'realname'; //Whether or not to allow real name fields. Used only in article credits, and we use real names in username anyway


######################
## :Recent Changes: ##
$wgAllowCategorizedRecentChanges = true; 	#Allow to filter the recentchanges by a category or one of its sub(subsubsub...)categories
$wgDefaultUserOptions['usenewrc'] = true;	# Enhanced recent changes - javascript collapsable tree
$wgHiddenPrefs[] = 'usenewrc'; 			# Hide the above setting - less (mess) is more (fun?)

#############
## :CACHE: ##
$wgShowIPinHeader = false;
$wgDisableCounters = true; // Disable page counters (not useful anyway, since many pages are processed by Varnish

require_once("$IP/extensions.php");