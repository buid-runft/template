<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function about()
    {
        return view('landing-page.customer.about');
    }

    public function contact()
    {
        return view('landing-page.customer.contact-us');
    }
}
