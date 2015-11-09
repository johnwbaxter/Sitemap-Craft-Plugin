<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 16/01/2015
 * Time: 09:55
 */

namespace Craft;

class SitemapService extends BaseApplicationComponent
{
    public function getSections()
    {
        return craft()->sections->getAllSections();
    }

    public function getSettingsForSection(SectionModel $section)
    {
        $plugin = craft()->plugins->getPlugin('sitemap');

        if (is_null($plugin))
        {
            return array();
        }

        $settings = $plugin->getSettings();

        $isEnabled = sprintf('section_%d_isEnabled', $section->id);
        $frequency = sprintf('section_%d_frequency', $section->id);
        $priority = sprintf('section_%d_priority', $section->id);

        $result = array();

        if (isset($settings->$isEnabled))
        {
            $result['isEnabled'] = $settings->$isEnabled;
        }

        if (isset($settings->$frequency))
        {
            $result['frequency'] = $settings->$frequency;
        }

        if (isset($settings->$priority))
        {
            $result['priority'] = $settings->$priority;
        }

        return $result;
    }

    public function invalidateSitemapCache()
    {
        if(craft()->cache->get('sitemap')) {

            craft()->cache->delete('sitemap');
            SitemapPlugin::Log('cache deleted');

        }
    }

}