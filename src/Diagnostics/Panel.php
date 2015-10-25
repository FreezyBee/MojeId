<?php

namespace FreezyBee\MojeId\Diagnostics;

use FreezyBee\MojeId\MojeId;
use Nette\Object;
use Nette\Utils\ArrayHash;
use Tracy\Debugger;
use Tracy\IBarPanel;

/**
 * Class Panel
 * @package FreezyBee\MojeId\Diagnostics
 */
class Panel extends Object implements IBarPanel
{
    /**
     * @var ArrayHash
     */
    private $request;

    /**
     * @var ArrayHash
     */
    private $response;

    /**
     * @var ArrayHash
     */
    private $person;

    /**
     * Renders HTML code for custom tab.
     * @return string
     */
    public function getTab()
    {
        return '<span><img width="16px" height="16px" style="float: none" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAABWVBMVEUpKSlmZmYpKSktLS07OztCQT9DQ0NGRUJHR0dIPSNKSEFLS0tORSpPTkxSQyRSUU9UVFRXSypZWVlaWVNbVkdbW1teUzBhX1hiYmJlXDdmZmZoaGZqZFBrZElra2tsZEhsbGxubm5vZT1vcXVyb2FycnJ0dHR5c1mAgICDd0qDg4OEhISGci+Hh4eIh4GJiYmKioqNeziNfT+NjY2PgUaWlZCXfB+XlY2YlYuahjiai0+cgyqkpKSrq6utqJSzliW0tLS3t7fBoR7Clg3DozXGxsbHpSXLnQnMpRbPz8/Q093RmwvR0dHTqRTUpQjU1NTWsRvWszXW0sLY2NjZ2dnapwza2trb29vcxnbc29Xd3d3f4OHgsxHh39XjogPktQvk5OTl5eXmpAPm5ubs7Ozu7u7vtAPxxCXx8fHzuQP1tQD1wgP3xAX4yQL6/P/+xAD+zAD+/v7///+yqjaVAAAAAnRSTlOAgKCo1lMAAAC2SURBVHgBY2BkQgGMDEz6KICJgUkKBQAF1APcpLVCgoNDfGzVwAImBTkqBkVgkKwtARQQtzQS1S1KMdUzjyxKVAAKyDrZC2jkeQnLG1rFFjkABZRy43mVoyN8PaxFLIrCgAKS2aHsmukxOlxsbMZFIUABsTRvs8xAO1YWFg7PIkeggGBcVr5LUIKcqKJrUaoQUIAvKd9ZphBsbYYqM1CA092Phz8kJDzK34abiQkogAYwBRjQ+AD8tyfz1YB3ZwAAAABJRU5ErkJggg==">
        MojeId</span>';
    }

    /**
     * Renders HTML code for custom panel.
     * @return string
     */
    public function getPanel()
    {
        $esc = \Nette\Utils\Callback::closure('Latte\Runtime\Filters::escapeHtml');
        $click = function ($o, $c = FALSE) {
            return \Tracy\Dumper::toHtml($o, ['collapse' => $c]);
        };

        ob_start();
        include __DIR__ . '/panel.phtml';
        return ob_get_clean();
    }

    public function begin($request)
    {
        $this->request = ArrayHash::from($request);
    }

    public function complete(ArrayHash $person, \Auth_OpenID_SuccessResponse $response)
    {
        $this->person = $person;
        $this->response = ArrayHash::from($response);
    }

    public function register(MojeId $mojeId)
    {
        $mojeId->onRequest[] = $this->begin;
        $mojeId->onResponse[] = $this->complete;
        Debugger::getBar()->addPanel($this);
    }
}