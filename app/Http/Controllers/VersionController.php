<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Version;
use Illuminate\Support\Facades\DB;

class VersionController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = DB::table('versions')->orderBy('updated_at', 'desc')->get();
        return view('admin.versions', compact('articles'));
    }
}
