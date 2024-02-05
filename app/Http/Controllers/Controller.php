<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /*    Use productImageUpload() in following Controller
     *
     * //$directory = 'attached_images/members/' . $memberDetails->id . '/';
     * //$directory = 'attached_images/members/' . $memberDetails->id . '/';
     */

    protected function productImageUpload($productImage, $directory)
    {
//        $imageName = $productImage->getClientOriginalName();
        $imageName = $this->generateRandomString() . '.' . $this->getExt($productImage);
        $imageUrl = $directory . $imageName;
        $rootUrl = public_path() . '/' . $directory . '/';
//        $productImage->move($rootUrl, $imageName);
        $path = $productImage->storeAs($directory, $imageName, 'public');
        return $path;
//        chmod($rootUrl,0444);
//        return $imageUrl;
    }
    protected function getExt($productImage)
    {
        $type = $productImage->getMimeType();
        switch ($type) {
            case 'image/jpeg':
                return 'JPEG';
                break;
            case 'image/png':
                return 'PNG';
                break;
            case 'image/gif':
                return 'GIF';
                break;
            case 'image/svg+xml':
                return 'SVG';
                break;
            case 'application/pdf':
                return 'PDF';
                break;
            default:
                return 'JPG';
        }
    }

    protected function generateRandomString($length = 15)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}
