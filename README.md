# Modern Timeline for MediaWiki

[![Build Status](https://travis-ci.org/ProfessionalWiki/ModernTimeline.svg?branch=master)](https://travis-ci.org/ProfessionalWiki/ModernTimeline)
[![Code Coverage](https://scrutinizer-ci.com/g/ProfessionalWiki/ModernTimeline/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ProfessionalWiki/ModernTimeline/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ProfessionalWiki/ModernTimeline/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ProfessionalWiki/ModernTimeline/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/professional-wiki/modern-timeline/version.png)](https://packagist.org/packages/professional-wiki/modern-timeline)
[![Download count](https://poser.pugx.org/professional-wiki/modern-timeline/d/total.png)](https://packagist.org/packages/professional-wiki/modern-timeline)

MediaWiki extension that adds a modern timeline visualization available as Semantic MediaWiki result format.

Demo: [https://sandbox.semantic-mediawiki.org/wiki/Modern_Timeline](https://sandbox.semantic-mediawiki.org/wiki/Modern_Timeline)

## Platform requirements

* PHP 7.1 or later
* MediaWiki 1.31 up to 1.34
* Semantic MediaWiki 3.0 or later

## Usage

The first date printout is used as date for the timeline events:

```
{{ #ask: [[Modification date::+]]
| format=moderntimeline
| ?Modification date
}}
```

If a second date printout is present it is used as end date and the event is displayed as a range:

 ```
 {{ #ask: [[Start date::+]]
 | format=moderntimeline
 | ?Start date
 | ?End date
 }}
 ```

Display and behaviour of the timeline can be changed via parameters:

```
{{ #ask: [[Modification date::+]]
| format=moderntimeline
| ?Modification date
| width=75%
| height=500px
| start at end=on
}}
```

A full list of supported parameters can be obtained in wiki via the `smwdoc` parser function:

```
{{ #smwdoc: moderntimeline}}
```

## Limitations

* Template parameter is not supported on Special:Ask
* The timeline style does not automatically match that of the wiki
* The timeline language does not automatically match that of the wiki
