<?php

namespace Vanguard\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Vanguard\Country;
use Vanguard\Http\Controllers\Controller;

class MembersDataController extends Controller
{
    public function countries(){
        if (!Cache::has('countries')) {
            Cache::rememberForever('countries', function () {
                return Country::select('id','name')->get();
            });
        }
        $countries = Cache::get('countries');
        return response()->json($countries);
    }
}
