<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\AdminMethods;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use AdminMethods;

    public function dashboard()
    {
        return $this->view('dashboard');
    }
}
