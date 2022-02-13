<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        try {
            $request->validate([
                'uploadFile' => 'required|mimes:png,jpg,jpeg|max:2048',
            ]);
            $file = $request->file('uploadFile');

            //$name = $request->file('file')->getClientOriginalName();
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('/uploads/'), $fileName);
            return response()->json([
                'success' => $fileName,
                'data' => 'File uploaded successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => $e->getMessage()
            ], 400);
        }
    }
}
