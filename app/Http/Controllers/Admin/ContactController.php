<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\AdminMethods;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    use AdminMethods;
    private $page = "contact.";
    public function index()
    {
        return $this->view($this->page."index");
    }
}
