<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateBlogController extends Controller
{
    public function authorize(): bool
    {
        return true;
    }


public function rules()
{
    return [
        'title' => ['required', 'max:255'],
        'image' => [
            'nullable',
            'file', // ファイルがアップロードされている
            'image', // 画像ファイルである
            'max:2000', // ファイル容量が2000kb以下である
            'mimes:jpeg,jpg,png', // 形式はjpegかpng
            'dimensions:min_width=300,min_height=300,max_width=1200,max_height=1200', // 画像の解像度が300px * 300px ~ 1200px * 1200px
        ],
        'body' => ['required', 'max:20000'],
    ];
}
}