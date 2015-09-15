<?php

namespace Lees\View\Pages;

class Index implements \Lees\Interfaces\Viewable
{
    public function __construct()
    {
        $this->name = 'Marie';
        $this->dayoftheweek = date('l');
        $this->currentime = date('H:i:s');
    }
}
