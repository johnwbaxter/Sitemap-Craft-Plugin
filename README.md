# Sitemap-Craft-Plugin
Sitemap is a plugin for the Craft content management system that provides an XML-formatted sitemap for search engines such as Google and Bing to find your content, and provide hints on how often it changes.

I wrote this plugin to provide the XML sitemap on my own website - [The Andy Sanc'tree](http://www.andys.website) - and released it as open-source to benefit the wider community.

## Installation
Installing the plugin is straight-forward and follows the same process as most other Craft plugins.

 1. Download the latest version from the Github releases page.
 2. Upload the "sitemap" folder into your website's craft/plugins folder.
 3. Activate the plugin in the Craft Settings > Plugins page.

Sitemap doesn't create any additional tables in your database - the settings are stored in the main plugins table.

## Setting options for each section
Sitemap applies settings to each entry based on the section it belongs to. You need to tell the Sitemap plugin which sections you want included, the frequency that the content within that section changes, and the priority relative to the rest of your site's content.

To open the Settings screen, click on the Sitemap plugin from your Settings > Plugin screen.

The Sitemap plugin settings page will open. For each section you have configured in Craft, you'll have 3 fields:

 1. Include in Sitemap?
 2. Change frequency
 3. Priority
 
Set the values accordingly for each section, and hit the "Save" button at the bottom of the screen. The changes take effect immediately, although you may want to submit your updated sitemap immediately to the search engines.

## Viewing the sitemap
The XML sitemap is not for the eyes of your average visitor, however it is crucial to inform the search engines of all the possible links on your site.

Your sitemap is generated on-demand (future versions of the Sitemap plugin will cache it) and you can view it at the below URL, or submit this URL to the search engines.

http://<your site URL>/sitemap.xml

As a live example, try visiting [http://www.andys.website/sitemap.xml](http://www.andys.website/sitemap.xml).