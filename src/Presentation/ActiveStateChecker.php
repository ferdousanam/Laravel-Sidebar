<?php

namespace Maatwebsite\Sidebar\Presentation;

use Illuminate\Support\Facades\Request;
use Maatwebsite\Sidebar\Item;

class ActiveStateChecker
{
    /**
     * @param Item $item
     *
     * @return bool
     */
    public function isActive(Item $item)
    {
        // Check if one of the children is active
        foreach ($item->getItems() as $item) {
            if ($this->isActive($item)) {
                return true;
            }
        }

        $path = ltrim(str_replace(url('/'), '', $item->getUrl()), '/');

        return Request::is(
            $path,
            $path . '/*'
        );
    }
}