jsfiddle-plugin
===============

Adds functionality for an [iajsfiddle] shortcode to Wordpress.

The plug-in will add a custom user contact method to the User Profile page for a JSFiddle username, but will also allow admins to define the custom field name to use for this contact method, in case a developer has already altered contact methods and added a field for JSFiddle.

This shortcode pulls in a user's JSFiddle and allows configurable height, width, and will support custom skins, too.

The plug-in creates a custom metabox on the Edit Post and Edit Page admin pages that contains a list of all the user's JSFiddles and allows them to generate a shortcode to be copied and pasted into the editor.

This plug-in is in its super-beta phase, functions, but requires some manual set up and has only been lightly tested

It is a work in progress.


thanks
======

[@dzejkej](https://github.com/dzejkej/) for the [jsfiddle-utils](https://github.com/dzejkej/jsfiddle-utils) JavaScript that makes it dead-simple to retrieve info from the JSFiddle API
[@padolsey](https://github.com/padolsey) for the [cross-domain-ajax](https://github.com/padolsey/jQuery-Plugins/tree/master/cross-domain-ajax/) JavaScript that [jsfiddle-utils](https://github.com/dzejkej/jsfiddle-utils) uses to retrieve the Fiddles from the API