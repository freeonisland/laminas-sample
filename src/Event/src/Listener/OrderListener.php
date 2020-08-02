<?php

namespace Event\Listener;


class OrderListener
{
    // ... assume events definition from above
    public function __invoke(\Event\Event\OrderEvent $orderEvent)
    {
        $name = $orderEvent->getName();
        $params = $orderEvent->getParams();

        $o_n = $orderEvent->getOrder()->getOrderName();

        echo "ORDER LISTENER: Order event $name catched! with value: \"$o_n\"<br/>";
    }

}
