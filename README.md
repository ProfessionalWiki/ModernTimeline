# Modern Timeline for MediaWiki

MediaWiki extension that adds a modern timeline visualization available as Semantic MediaWiki result format.

Requirements:

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
