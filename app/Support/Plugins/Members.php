<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class Members extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Members'))
            ->route('members.index')
            ->icon('fas fa-users')
            ->active("members*")
            ->permissions('members.manage');
    }
}
