<?php

namespace App\Http\Controllers\newsletter;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function index()
    {
        $newsletter = Newsletter::get();
        return view('pages.Newsletter.newsletter',compact('newsletter'));
    }
}
