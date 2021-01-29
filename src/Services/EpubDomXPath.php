<?php

use DOMXPath;
use EPubDOMElement;
use DOMDocument;

class EPubDOMXPath extends DOMXPath
{
    public function __construct(DOMDocument $doc)
    {
        parent::__construct($doc);

        if (is_a($doc->documentElement, 'EPubDOMElement')) {
            foreach ($doc->documentElement->namespaces as $ns => $url) {
                $this->registerNamespace($ns, $url);
            }
        }
    }
}
