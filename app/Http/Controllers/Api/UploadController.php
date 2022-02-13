<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImageRequest;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(UploadImageRequest $request)
    {
        if ($request->file('uploadFile')->isValid()) {
            try {
                $file = $request->file('uploadFile');
                //$name = $request->file('file')->getClientOriginalName();
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                //$file->move(public_path('/uploads/'), $fileName);

                $path = $file->storeAs('uploads/images', $fileName,'public');

                return response()->json([
                    'success' => true,
                    'data' =>  asset('storage/'.$path),
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'data' => $e->getMessage()
                ], 400);
            }
        } else {
            return response()->json([
                'success' => false,
                'data' => 'File is not valid'
            ], 400);
        }
    }
}
