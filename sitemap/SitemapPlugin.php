<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 16/01/2015
 * Time: 09:53
 */

namespace Craft;

class SitemapPlugin extends BasePlugin
{
    function getDeveloper()
    {
        return 'Andy Heathershaw';
    }

    function getDeveloperUrl()
    {
        return 'http://www.andys.website/software/sitemap';
    }

    function getName()
    {
        return Craft::t('XML Sitemap');
    }

    function getVersion()
    {
        return '1.1.0';
    }

    function init()
    {
        $this->addEventListeners();
    }

    public function addEventListeners() {
        craft()->on('entries.saveEntry', array(craft()->sitemap,'invalidateSitemapCache'));
    }

    public function onAfterInstall()
    {

        if(!craft()->fields->getFieldByHandle('SiteMapPluginHideFromSiteMap')) {

            $thirdPartyField = new FieldModel();
            $thirdPartyField->groupId = 1;
            $thirdPartyField->name = Craft::t('Hide From SiteMap');
            $thirdPartyField->handle = 'SiteMapPluginHideFromSiteMap';
            $thirdPartyField->translatable = false;
            $thirdPartyField->type = 'Lightswitch';
            craft()->fields->saveField($thirdPartyField);
        }

    }

    protected function defineSettings()
    {
        $settings = array();

        foreach (craft()->sitemap->getSections() as $section)
        {
            $settingKey = sprintf('section_%d', $section->id);
            $settingKeyEnabled = sprintf('%s_isEnabled', $settingKey);
            $settingKeyFreq = sprintf('%s_frequency', $settingKey);
            $settingKeyPriority = sprintf('%s_priority', $settingKey);

            $settings[$settingKeyEnabled] = array(AttributeType::Bool, 'default' => true);
            $settings[$settingKeyFreq] = array(AttributeType::String, 'default' => 'weekly');
            $settings[$settingKeyPriority] = array(AttributeType::String, 'default' => '0.5');
        }

        return $settings;
    }

    public function hasCpSection()
    {
        return false;
    }

    public function getSettingsHtml()
    {
        return craft()->templates->render('sitemap/_settings', array(
            'sections' => craft()->sitemap->getSections(),
            'settings' => $this->getSettings()
        ));
    }

    public function prepSettings($settings)
    {
        // Modify $settings here...

        return $settings;
    }

    public function registerSiteRoutes()
    {
        return array(
            'sitemap.xml' => array('action' => 'sitemap/render/renderSitemap')
        );
    }

}