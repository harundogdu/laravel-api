<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['upload', 'download']
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function upload(Request $request)
    {
        return view('upload');
    }

    public function download($fileName)
    {
        if (!Storage::disk('public')->exists('uploads/images/' . $fileName)) {
            return response()->json([
                'message' => 'File does not exist.'
            ], 404);
        }
        return Storage::disk('public')->download('uploads/images/' . $fileName);
    }
}
