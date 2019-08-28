# Modern Timeline

[![Build Status](https://travis-ci.org/ProfessionalWiki/ModernTimeline.svg?branch=master)](https://travis-ci.org/ProfessionalWiki/ModernTimeline)
[![Code Coverage](https://scrutinizer-ci.com/g/ProfessionalWiki/ModernTimeline/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ProfessionalWiki/ModernTimeline/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ProfessionalWiki/ModernTimeline/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ProfessionalWiki/ModernTimeline/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/professional-wiki/modern-timeline/version.png)](https://packagist.org/packages/professional-wiki/modern-timeline)
[![Download count](https://poser.pugx.org/professional-wiki/modern-timeline/d/total.png)](https://packagist.org/packages/professional-wiki/modern-timeline)

The **Modern Timeline** extension provides a modern timeline visualization for
[Semantic MediaWiki](https://www.semantic-mediawiki.org/wiki/Semantic_MediaWiki) as a
[result format](https://www.semantic-mediawiki.org/wiki/Help:Result_formats).

It was created by [Professional.Wiki](https://professional.wiki/) and funded by
[KDZ - Centre for Public Administration Research](https://www.kdz.eu/).

## Platform requirements

* PHP 7.1 or later
* MediaWiki 1.31.x up to 1.34.x
* Semantic MediaWiki 3.0 or later

## Versions

See the [RELEASE-NOTES](/RELEASE-NOTES.md) for more information on the different versions of Modern Timeline.

## Installation

The recommended way to install Modern Timeline is using [Composer](https://getcomposer.org) with
[MediaWiki's built-in support for Composer](https://www.mediawiki.org/wiki/Composer).

Note that the required extension Semantic MediaWiki must be installed first according to the installation
instructions provided.

### Step 1

Change to the base directory of your MediaWiki installation. If you do not have a "composer.local.json" file yet,
create one and add the following content to it:

```
{
	"require": {
		"professional-wiki/modern-timeline": "~1.0"
	}
}
```

If you already have a "composer.local.json" file add the following line to the end of the "require"
section in your file:

    "professional-wiki/modern-timeline": "~1.0"

Remember to add a comma to the end of the preceding line in this section.

### Step 2

Run the following command in your shell:

    php composer.phar update --no-dev

Note if you have Git installed on your system add the `--prefer-source` flag to the above command.

### Step 3

Add the following line to the end of your "LocalSettings.php" file:

    wfLoadExtension( 'ModernTimeline' );

## Usage

See also live demos at the following website:
[Professional.Wiki Starter demo wiki - Category:Modern Timeline examples.](https://starter.professional.wiki/page/Category:Modern_Timeline_examples)

The first date printout is used as date for the timeline events:

```
{{#ask:
 [[Modification date::+]]
 |format=moderntimeline
 |?Modification date
}}
```

If a second date printout is present it is used as end date and the event is displayed as a range:

 ```
 {{#ask:
  [[Start date::+]]
  |format=moderntimeline
  |?Start date
  |?End date
 }}
 ```

Display and behaviour of the timeline can be changed via several output parameters:

```
{{#ask:
 [[Modification date::+]]
 |format=moderntimeline
 |?Modification date
 |width=75%
 |height=500px
 |start at end=on
}}
```

### Parameters

A full list of supported output parameters can be obtained in wiki via the `smwdoc` parser function:

```
{{#smwdoc: moderntimeline }}
```

### Configuration

The default value of all parameters can be changed by placing configuration in `LocalSettings.php`.
These configuration settings are available:

* $wgModernTimelineWidth
* $wgModernTimelineHeight
* $wgModernTimelineBookmark
* $wgModernTimelineBackground
* $wgModernTimelineScaleFactor
* $wgModernTimelinePosition
* $wgModernTimelineTickWidth
* $wgModernTimelineStartSlide
* $wgModernTimelineStartAtEnd
* $wgModernTimelineTransitionDuration
* $wgModernTimelineNavHeight
* $wgModernTimelineTemplate

Default values of these configuration settings can be found in `extension.json`. Do not change `extension.json`.

Example of changing one of the configuration settings:

```php
$wgModernTimelineHeight = '500px';
```

## Limitations

* The template parameter is not supported on "Special:Ask"
* The timeline style does not automatically match that of the wiki
* The timeline language does not automatically match that of the wiki

[Professional MediaWiki development](https://professional.wiki/en/services#development) is available via
[Professional Wiki](https://professional.wiki/).

## Contribution and support

If you want to contribute work to the project please subscribe to the developers mailing list and
have a look at the contribution guideline.

* [File an issue](https://github.com/ProfessionalWiki/ModernTimeline/issues)
* [Submit a pull request](https://github.com/ProfessionalWiki/ModernTimeline/pulls)
* Ask a question on [the mailing list](https://www.semantic-mediawiki.org/wiki/Mailing_list)

[Professional MediaWiki support](https://professional.wiki/en/support) is available via
[Professional Wiki](https://professional.wiki/).

## License

[GNU General Public License v2.0 or later (GPL-2.0-or-later)](/COPYING).
