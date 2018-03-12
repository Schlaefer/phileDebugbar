<?php

namespace Phile\Plugin\Siezi\PhileDebugbar\Tests;

use Phile\Core\Config;
use Phile\Test\TestCase;

class PluginTest extends TestCase
{
    public function testPluginInjectsInPage()
    {
        $config = new Config([
            'plugins' => [
                'siezi\\phileDebugbar' => ['active' => true]
            ]
        ]);
        $core = $this->createPhileCore(null, $config);
        $request = $this->createServerRequestFromArray();
        $response = $this->createPhileResponse($core, $request);

        $body = (string)$response->getBody();
        $this->assertContains('var phpdebugbar = new PhpDebugBar.DebugBar();', $body);
    }

    public function testDebugFct()
    {
        $config = new Config([
            'plugins' => [
                'siezi\\phileDebugbar' => ['active' => true]
            ]
        ]);
        $core = $this->createPhileCore(null, $config)->bootstrap();

        $item = uniqid();
        debug($item);

        $request = $this->createServerRequestFromArray();
        $response = $this->createPhileResponse($core, $request);

        $body = (string)$response->getBody();
        $this->assertContains($item, $body);
    }
}
