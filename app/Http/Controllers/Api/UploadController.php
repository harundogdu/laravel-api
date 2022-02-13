<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImageRequest;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(UploadImageRequest $request)
    {
        try {
            $file = $request->file('uploadFile');
            //$name = $request->file('file')->getClientOriginalName();
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/uploads/'), $fileName);

            return response()->json([
                'success' => true,
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
