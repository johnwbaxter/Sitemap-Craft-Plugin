<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 16/01/2015
 * Time: 10:03
 */

namespace Craft;

class Sitemap_RenderController extends BaseController
{
    protected $allowAnonymous = true;

    /**
     * @var \DOMDocument
     */
    private $dom;

    /**
     * @var \DOMElement
     */
    private $urlset;

    public function actionRenderSitemap()
    {
        header('Content-type: text/xml');

        if(craft()->cache->get('sitemap')){
            return print(craft()->cache->get('sitemap'));
        }

        $this->createUrlSet();
        $this->addSections();

        $data = $this->dom->saveXML();

        print($data);

        craft()->cache->add('sitemap',$data,60*60*24);
    }

    private function addElement(EntryModel $entry, $changeFrequency, $priority)
    {
        //Check if manually hidden
        if($entry->SiteMapPluginHideFromSiteMap) {
            return;
        }

        //Check if entry has URL, some sections don't
        if(!$entry->getUrl()) {
            return;
        }

        $url = $this->dom->createElement('url');

        $urlLoc = $this->dom->createElement('loc');
        $urlLoc->nodeValue = $entry->getUrl();
        $url->appendChild($urlLoc);

        $urlModified = $this->dom->createElement('lastmod');
        $urlModified->nodeValue = $entry->postDate->w3c();
        $url->appendChild($urlModified);

        $urlChangeFreq = $this->dom->createElement('changefreq');
        $urlChangeFreq->nodeValue = $changeFrequency;
        $url->appendChild($urlChangeFreq);

        $urlPriority = $this->dom->createElement('priority');
        $urlPriority->nodeValue = $priority;
        $url->appendChild($urlPriority);

        $this->urlset->appendChild($url);
    }

    private function addSection(SectionModel $section)
    {
        $currentSettings = craft()->sitemap->getSettingsForSection($section);

        if (is_null($currentSettings) || $currentSettings['isEnabled'] === false || $currentSettings['isEnabled'] == 0)
        {
            return;
        }

        $criteria = craft()->elements->getCriteria(ElementType::Entry);
        $elements = $criteria->find(array('section' => $section->handle));

        foreach ($elements as $element)
        {
            $this->addElement($element, $currentSettings['frequency'], $currentSettings['priority']);
        }
    }

    private function addSections()
    {
        $sections = craft()->sections->getAllSections();

        foreach ($sections as $section)
        {
            $this->addSection($section);
        }
    }

    private function createUrlSet()
    {
        $this->dom = new \DOMDocument('1.0', 'UTF-8');
        $this->urlset = $this->dom->createElement("urlset");
        $this->urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $this->dom->appendChild($this->urlset);
    }
}