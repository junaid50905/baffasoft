<?php

namespace Vanguard\Http\Controllers\Web\Member;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
// use App\Models\Code;
use Vanguard\Code;
class CodeController extends Controller
{
    public function index(){
        $codes = Code::all();
        return view('print.code.index',compact('codes'));
    }

    public function create(){
        return view('print.code.create');
    }

    public function store(Request $request){
        $number = mt_rand(1000000000,9999999999);

        if ($this->ProductCodeExists($number)){
            $number = mt_rand(1000000000,9999999999);
        }

        $request['qr_code'] = $number;
        Code::create($request->all());

        return redirect('/code');
    }

    public function ProductCodeExists($number){
        return Code::whereProductCode($number)->exists();
    }
}
