jsfiddle-plugin
===============

Adds functionality for an [iajsfiddle] shortcode to Wordpress.

This plug-in adds a custom user contact method to the User Profile page for a JSFiddle username, but will also allow admins to define the custom field to use for this contact method, in case a developer has already altered contact methods and added a field for JSFiddle.

This shortcode pulls in a user's JSFiddle and allows configurable height, width, and supports custom skins, too. You can also include a JSFiddle from another user, by providing the username and id of the JSFiddle.

The plug-in creates a custom metabox on the Edit Post and Edit Page admin pages that contains a list of all the user's JSFiddles and allows them to generate a shortcode to be copied and pasted into the editor.

The plug-in supports custom JSFiddle skins, and allows the admin to define a folder where custom skins will be uploaded.

This plug-in is in its beta phase; it functions, but has only been lightly tested. It has not been internationalized or set up for multi-site network integration.

It is a work in progress.


thanks
======

* [@dzejkej](https://github.com/dzejkej/) for the [jsfiddle-utils](https://github.com/dzejkej/jsfiddle-utils) JavaScript that makes it dead-simple to retrieve info from the JSFiddle API
* [@padolsey](https://github.com/padolsey) for the [cross-domain-ajax](https://github.com/padolsey/jQuery-Plugins/tree/master/cross-domain-ajax/) JavaScript that [jsfiddle-utils](https://github.com/dzejkej/jsfiddle-utils) uses to retrieve the Fiddles from the API
* [@Naatan](https://github.com/Naatan/) for the basic [jsFiddle-skin-proxy](https://github.com/Naatan/jsFiddle-skin-proxy) code that allows custom skins to be attached to embedded JSFiddles. The plug-in utilizes a fork of this repository that can be found [here](https://github.com/ericrallen/jsFiddle-skin-proxy)