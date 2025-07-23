<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeadiaWallet;
use Illuminate\Http\Request;

class GeadiaWalletController extends Controller
{
    //
    public function index(){
        $data = GeadiaWallet::orderBy('id','desc')->paginate(20);
        return view('admin.geadia.index',compact('data'));
    }
}
