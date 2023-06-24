<?php

namespace App\Traits;

trait AdminMethods
{
    public function view($path, $obj=[])
    {
        $dir = "admin.";
        return view($dir.$path, array_merge($obj));
    }
}
