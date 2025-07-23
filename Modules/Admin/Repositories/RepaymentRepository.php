<?php

namespace Modules\Admin\Repositories;

class RepaymentRepository
{

    public function index($user)
    {

        $data =$user->providerable()->where('type','repayment')->Order()->paginate(20)->appends(request()->except('page'));
        return $data;
    }

}
