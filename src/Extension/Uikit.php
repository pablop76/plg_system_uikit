<?php
namespace Pablop76\Plugin\System\Uikits\Extension;

// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Event\Event;
use Joomla\Event\SubscriberInterface;

class Uikit extends CMSPlugin implements SubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            'onBeforeCompileHead' => 'addMedia',
        ];
    }

    public function addMedia(Event $event)
    {
        if (!$this->getApplication()->isClient('site')) {
            return;
        }
        $app = Factory::getApplication();
        $document = $app->getDocument();
        $wa = $document->getWebAssetManager();
        $wa->getRegistry()->addExtensionRegistryFile('plg_system_uikit');

        $customJsUrl = $this->params->get('jsuikit');
        $customIconUrl = $this->params->get('iconuikit');
        $customCssUrl = $this->params->get('styleuikit');

        if($customJsUrl){
            $wa->registerScript('mainjs', $customJsUrl);
        }
        if($customIconUrl){
            $wa->registerScript('mainicon', $customIconUrl);
        }
        if($customCssUrl){
            $wa->registerStyle('maincss', $customCssUrl);
        }

        if ($wa->assetExists('script', 'mainjs')) {
            $wa->useScript('mainjs');
        }else{
            $wa->useScript('plg_uikit.jsuikit');
        }
        if ($wa->assetExists('script', 'mainicon')) {
            $wa->useScript('mainicon');
        }else{
            $wa->useScript('plg_uikit.iconuikit');
        }
        if ($wa->assetExists('style', 'maincss')) {
            $wa->useStyle('maincss');
        }else{
            $wa->useStyle('plg_uikit.styleuikit');
        }
    }
}
