<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;

class CommonController extends Controller
{

    public function postUpload()
    {
        $form_data = Input::all();
        $photo = $form_data['img'];

        $allowed_filename = md5(date('YmdHis')).rand(1,1000);

        $filename_ext = $allowed_filename . '.jpg';

        $manager = new ImageManager();
        //解决图片全都堆放在一起的问题
        $path = public_path() . '/' . env('CROPPIC_PATH') . '/' . date('Ymd');
        if (!file_exists($path)) {
            mkdir($path , 0700);
        }
        $image = $manager->make($photo)->encode('jpg')->save(public_path() . '/' . env('CROPPIC_PATH') . '/' . date('Ymd') . '/' . $filename_ext);


        if (!$image) {

            return Response::json([
                'status'  => 'error' ,
                'message' => 'Server error while uploading' ,
            ] , 200);

        }

        return Response::json([
            'status' => 'success' ,
            'url'    => asset(env('CROPPIC_PATH')). '/' . date('Ymd') . '/' . $filename_ext,
            'width'  => $image->width() ,
            'height' => $image->height()
        ] , 200);
    }

    public function postCrop()
    {
        $form_data = Input::all();
        $image_url = $form_data['imgUrl'];

        //mb_strpos
        //因为发过来的是url下面无法执行,这里给他处理下
        $num = mb_strpos($image_url,env('CROPPIC_PATH'));
        $image_url = mb_substr($image_url,$num);


        // resized sizes
        $imgW = $form_data['imgW'];
        $imgH = $form_data['imgH'];
        // offsets
        $imgY1 = $form_data['imgY1'];
        $imgX1 = $form_data['imgX1'];
        // crop box
        $cropW = $form_data['width'];
        $cropH = $form_data['height'];
        // rotation angle
        $angle = $form_data['rotation'];

        $filename_array = explode('/' , $image_url);
        $filename = $filename_array[ sizeof($filename_array) - 1 ];

        $manager = new ImageManager();

        $image = $manager->make($image_url);

        $image->resize((int)$imgW , (int)$imgH)
            ->rotate(-((int)$angle))
            ->crop((int)$cropW , (int)$cropH , (int)$imgX1 , (int)$imgY1)
            ->save(public_path() . '/' . env('CROPPIC_PATH') . '/' . date('Ymd') . '/' . 'c' . $filename);



        //删除临时的文件
        @unlink(public_path() . '/' . env('CROPPIC_PATH') . '/' . date('Ymd') . '/' . $filename);
        if (!$image) {

            return Response::json([
                'status'  => 'error' ,
                'message' => 'Server error while uploading' ,
            ] , 200);

        }

        return Response::json([
            'status' => 'success' ,
            'url'    => asset(env('CROPPIC_PATH')). '/' . date('Ymd') . '/c' . $filename
        ] , 200);

    }



}
