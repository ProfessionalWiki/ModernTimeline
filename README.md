# Modern Timeline

[![Code Coverage](https://scrutinizer-ci.com/g/ProfessionalWiki/ModernTimeline/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ProfessionalWiki/ModernTimeline/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/professional-wiki/modern-timeline/version.png)](https://packagist.org/packages/professional-wiki/modern-timeline)
[![Download count](https://poser.pugx.org/professional-wiki/modern-timeline/d/total.png)](https://packagist.org/packages/professional-wiki/modern-timeline)

The **Modern Timeline** extension provides a
[modern timeline visualization](https://timeline.knightlab.com) for
[Semantic MediaWiki](https://www.semantic-mediawiki.org/wiki/Semantic_MediaWiki) as a
[result format](https://www.semantic-mediawiki.org/wiki/Help:Result_formats).

It was created by [Professional.Wiki](https://professional.wiki/) and funded by
[KDZ - Centre for Public Administration Research](https://www.kdz.eu/).

Example timeline

[![image](https://user-images.githubusercontent.com/146040/78048722-70915b00-737a-11ea-89af-7c555b4f2ae7.png)](https://fina.oeaw.ac.at/wiki/index.php/Timeline_of_Correspondence_in_the_16th_Century#event-aahrefhttpsfinaoeawacatwikiindexphpchristopheplantin-fulvioorsini-1574-11-6christopheaplantina-afulvioaorsinia-a1574-11-6a)

## Platform requirements

* PHP 7.1 or later (tested up to PHP 8.0)
* MediaWiki 1.31.x or later (tested up to MediaWiki 1.37)
* Semantic MediaWiki 3.0 or later (tested up to SMW 4.0.2)

See the [release notes](#release-notes) for more information on the different versions of Modern Timeline.

## Installation

The recommended way to install Modern Timeline is using [Composer](https://getcomposer.org) with
[MediaWiki's built-in support for Composer](https://professional.wiki/en/articles/installing-mediawiki-extensions-with-composer).

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

The default value of all parameters can be changed by placing configuration in "LocalSettings.php".
These configuration settings are available:

* `$wgModernTimelineWidth` – Timeline width in %. Can also be specified in px, em and ex
* `$wgModernTimelineHeight` – Timeline height in pixels. Can also be specified in em and ex
* `$wgModernTimelineBookmark` – Make the timeline bookmarkable via the page URL
* `$wgModernTimelineBackground` – Background color for the timeline slides (CSS color values)
* `$wgModernTimelineScaleFactor` – Timeline width in screen widths at first presentation
* `$wgModernTimelinePosition` – Display the timeline navigation at the top or at the bottom
* `$wgModernTimelineTickWidth` – Optimal distance (in pixels) between ticks on the axis
* `$wgModernTimelineStartSlide` – The first slide to display when the timeline is loaded
* `$wgModernTimelineStartAtEnd` – Start with the last timeline slide
* `$wgModernTimelineTransitionDuration` – Slide transition in milliseconds
* `$wgModernTimelineNavHeight` – Height of the timeline navigation section in % or px
* `$wgModernTimelineTemplate` – Name of a template to show the slide area with
* `$wgModernTimelineImageProperty` – Semantic property of type Page. Needs to be queried as print request

Default values of these configuration settings can be found in "extension.json". Do not change "extension.json".

Example of changing one of the configuration settings:

```php
$wgModernTimelineHeight = '500px';
```

## Limitations

* The template parameter is not supported on "Special:Ask"
* The timeline style does not automatically match that of the wiki
* The timeline language does not automatically match that of the wiki

[Professional MediaWiki development](https://professional.wiki/en/services#development) is available via
[Professional.Wiki](https://professional.wiki/).

## Contribution and support

If you want to contribute work to the project please subscribe to the developers mailing list and
have a look at the contribution guideline.

* [File an issue](https://github.com/ProfessionalWiki/ModernTimeline/issues)
* [Submit a pull request](https://github.com/ProfessionalWiki/ModernTimeline/pulls)
* Ask a question on [the mailing list](https://www.semantic-mediawiki.org/wiki/Mailing_list)

[Professional MediaWiki support](https://professional.wiki/en/support) is available via
[Professional.Wiki](https://professional.wiki/).

## License

[GNU General Public License v2.0 or later (GPL-2.0-or-later)](/COPYING).

## Release notes

### Version 1.2.1

Released on April 11th, 2022.

* Fixed fatal error in some cases where a Title becomes available

### Version 1.2.0

Released on March 29, 2020.

* Fixed error occurring when using the `template` parameter with MediaWiki 1.34 or later
* Added `image property` parameter (with `image` alias)
* Added `wgModernTimelineImageProperty` configuration parameter
* Translation updates from https://translatewiki.net

### Version 1.1.0

Released on August 28, 2019.

* Improved handling of large data sets
* Translation updates from https://translatewiki.net

### Version 1.0.0

Released on August 16, 2019.

Initial release with a [TimelineJS3](https://github.com/NUKnightLab/TimelineJS3)
based result format featuring 12 customization parameters, template support and
date range support.

## Examples

![image](https://user-images.githubusercontent.com/146040/78049781-c31f4700-737b-11ea-839e-4ec8fe1d9d70.png)

---

[![image](https://user-images.githubusercontent.com/146040/78048722-70915b00-737a-11ea-89af-7c555b4f2ae7.png)](https://fina.oeaw.ac.at/wiki/index.php/Timeline_of_Correspondence_in_the_16th_Century#event-aahrefhttpsfinaoeawacatwikiindexphpchristopheplantin-fulvioorsini-1574-11-6christopheaplantina-afulvioaorsinia-a1574-11-6a)
