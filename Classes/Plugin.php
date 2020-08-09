<?php

namespace Phile\Plugin\Siezi\PhileDebugbar;

use Phile\Core\Container;
use Phile\Plugin\AbstractPlugin;

class Plugin extends AbstractPlugin
{
    protected $phileConfig;

    protected $debugBar;

    protected $lastEventKey;

    protected $lastData;

    protected $settings = [
        'assetRootUrl' => '/lib/vendor/maximebf/debugbar/src/DebugBar/Resources/'
    ];

    protected $events = [
        'phile.core.middleware.add' => 'addMiddleware',
        'config_loaded' => 'getConfig',
        'after_init_core' => 'setConfig',
        'template_engine_registered' => 'registerTimeline',
        'plugins_loaded' => 'registerTimeline',
        'request_uri' => 'registerTimeline',
        'after_resolve_page' => 'registerTimeline',
        'before_init_template' => 'registerTimeline',
        'before_render_template' => 'registerTimeline',
        'after_render_template' => 'registerTimeline',
        'before_read_file_meta' => 'registerTimeline',
        'after_read_file_meta' => 'registerTimeline',
        'before_load_content' => 'registerTimeline',
        'after_load_content' => 'registerTimeline',
        'before_parse_content' => 'registerTimeline',
        'after_parse_content' => 'registerTimeline',
    ];

    public function __construct()
    {
        $this->debugBar = new \DebugBar\StandardDebugBar();
        Container::getInstance()->set('siezi.debugbar', $this->debugBar);

        $this->lastEventKey = 'Start';
        $this->debugBar['time']->startMeasure($this->lastEventKey);
    }

    public function addMiddleware($eventData)
    {
        $baseUrl = $this->phileConfig->get('base_url');
        $assets = $baseUrl . $this->settings['assetRootUrl'];
        $this->debugBar->getJavascriptRenderer()->setBaseUrl($assets);

        $middleware = new \Middlewares\Debugbar($this->debugBar);
        $queue = $eventData['middleware'];
        $queue->add($middleware);
    }

    public function getConfig($eventData)
    {
        $this->phileConfig = $eventData['class'];
    }

    public function setConfig()
    {
        $collector = new \DebugBar\DataCollector\ConfigCollector($this->phileConfig->toArray());
        $this->debugBar->addCollector($collector);
    }

    public function registerTimeline()
    {
    }

    public function on($eventKey, $data = null): void
    {
        $this->debugBar['time']->stopMeasure($this->lastEventKey, $this->lastData);
        $this->debugBar['time']->startMeasure($eventKey, $eventKey);
        $this->lastEventKey = $eventKey;
        $this->lastData = $data;
        parent::on($eventKey, $data);
    }
}
