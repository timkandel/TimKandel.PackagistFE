TYPO3 Neos Packagist Frontend Plugin
====================================

This plugin provides a simple plugin to display typo3-flow-* composer packages from Packagist.

Quick start
-----------
* import the packages by using the following command

```
$ ./flow packagist:import
```

* include the plugin's TypoScript definitions to your own one's

```
include: resource://TimKandel.Plugin.PackagistFE/Private/TypoScripts/Library/NodeTypes.ts2
```

* add the plugin content element "Packagist Frontend" to the position of your choice.

TODO
----
* refactor the import
* save packages to the database, so pagination, filtering and sorting will be possible
*