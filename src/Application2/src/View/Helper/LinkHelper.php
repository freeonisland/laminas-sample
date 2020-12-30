<?php

namespace Application\View\Helper;

use Laminas\View\Helper\AbstractHelper;

class LinkHelper extends AbstractHelper
{
    public function __invoke(string $content, string $href="#", string $style="")
    {
        return '<a style="'.$style.'" href="'.$href.'">'.$content.'</a>';
    }
}