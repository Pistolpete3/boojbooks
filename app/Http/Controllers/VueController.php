<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class VueController
 * @package App\Http\Controllers
 */
class VueController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('vue');
    }
}
