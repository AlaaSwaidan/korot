<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class ToPupLikeCardController extends Controller
{

    public function toPupLikecard(Request  $request)
    {
        $get_return_data = toPup($request->phone,$request->amount);
        dd($get_return_data);

    }
}
