# Modern Timeline

[![Build Status](https://travis-ci.org/ProfessionalWiki/ModernTimeline.svg?branch=master)](https://travis-ci.org/ProfessionalWiki/ModernTimeline)
[![Code Coverage](https://scrutinizer-ci.com/g/ProfessionalWiki/ModernTimeline/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ProfessionalWiki/ModernTimeline/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ProfessionalWiki/ModernTimeline/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ProfessionalWiki/ModernTimeline/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/professional-wiki/modern-timeline/version.png)](https://packagist.org/packages/professional-wiki/modern-timeline)
[![Download count](https://poser.pugx.org/professional-wiki/modern-timeline/d/total.png)](https://packagist.org/packages/professional-wiki/modern-timeline)

The **Modern Timeline** extension provides a modern timeline visualization for
[Semantic MediaWiki](https://www.semantic-mediawiki.org/wiki/Semantic_MediaWiki) as a
[result format](https://www.semantic-mediawiki.org/wiki/Help:Result_formats).

Modern Timeline was created by [Professional Wiki](https://professional.wiki/)
and funded by "KDZ - Centre for Public Administration Research".

## Platform requirements

* PHP 7.1 or later
* MediaWiki 1.31.x up to 1.34.x
* Semantic MediaWiki 3.0.x or later

## Releases

See the [RELEASE-NOTES](/RELEASE-NOTES.md) for further information on the releases made.

## Installation

The recommended way to install Modern Timeline is using [Composer](http:s//getcomposer.org) with
[MediaWiki's built-in support for Composer](https://www.mediawiki.org/wiki/Composer).

Note that the required extension Semantic MediaWiki must be installed first according to the installation
instructions provided.

### Step 1

Change to the base directory of your MediaWiki installation. This is where the "LocalSettings.php"
file is located. If you have not yet installed Composer do it now by running the following command
in your shell:

    wget https://getcomposer.org/composer.phar

### Step 2
    
If you do not have a "composer.local.json" file yet, create one and add the following content to it:

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

### Step 3

Run the following command in your shell:

    php composer.phar update --no-dev

Note if you have Git installed on your system add the `--prefer-source` flag to the above command. Also
note that it may be necessary to run this command twice. If unsure do it twice right away.

### Step 4

Add the following line to the end of your "LocalSettings.php" file:

    wfLoadExtension( 'ModernTimeline' );

### Verify installation success

As final step, you can verify Modern Timeline got installed by looking at the "Special:Version" page on your
wiki and check that it is listed in the semantic extensions section.


## Usage

See also live demos at the following location: [https://starter.professional.wiki/page/Category:Modern_Timeline_examples](https://starter.professional.wiki/page/Category:Modern_Timeline_examples)

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

A full list of supported output parameters can be obtained in wiki via the `smwdoc` parser function:

```
{{#smwdoc: moderntimeline }}
```

## Limitations

* The template parameter is not supported on "Special:Ask"
* The timeline style does not automatically match that of the wiki
* The timeline language does not automatically match that of the wiki

## Contribution and support

If you want to contribute work to the project please subscribe to the developers mailing list and
have a look at the contribution guideline.

* [File an issue](https://github.com/ProfessionalWiki/ModernTimeline/issues)
* [Submit a pull request](https://github.com/ProfessionalWiki/ModernTimeline/pulls)
* Ask a question on [the mailing list](https://www.semantic-mediawiki.org/wiki/Mailing_list)

## License

[GNU General Public License v2.0 or later (GPL-2.0-or-later)](/COPYING).
