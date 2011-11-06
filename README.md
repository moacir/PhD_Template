PhD Template Package
====================

This project is a proof of concept to make it easy to customize the PhD output.

##Install

This package does not have an official pear channel yet. To install it you'll have to create the pear package yourself.

`$ pear package package.xml`
`$ pear install PhD_Template-0.1.0.tgz`

##Dependencies

* PhD 1.1.0+
* PhD_PHP 1.1.0+

##Run

For running the default template *bootstrap* run:
`$ phd -d .manual.xml -f xhtml -P Template`

To specify the template run:
`$ phd -d .manual.xml -f xhtml -P Template --template-file ./phpdotnet/phd/Package/Template/templates/sphinx.tpl`

##Custom Options

* --template-file - Path of the template file

##Current templates

The templates are in the folder *phpdotnet/phd/Package/Template/templates/*.
The following template files are available:

* bootstrap.tpl - Twitter Bootstrap style
* gnome.tpl - Gnome docs style
* sphinx.tpl - Python docs style
