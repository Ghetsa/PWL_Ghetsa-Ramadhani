<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
  public function index()
  {
    $breadcrumb = (object) [
      'title' => 'Kontak Developer',
      'list' => ['Home', 'Kontak']
    ];

    $page = (object) [
      'title' => 'Informasi Kontak Developer Sistem'
    ];

    $activeMenu = '';

    return view('contact.index', compact('breadcrumb', 'page', 'activeMenu'));
  }
}
