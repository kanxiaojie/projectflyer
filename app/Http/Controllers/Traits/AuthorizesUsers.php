<?php

namespace App\Http\Controllers\Traits;

use App\Flyer;
use Illuminate\Http\Request;

trait AuthorizesUsers{
    /**
     * @param Request $request
     * @return mixed
     */
    protected function userCreatedFlyer(Request $request){
        return Flyer::where([
            'zip' => $request->zip,
            'street' => $request->street,
            'user_id' => $this->user->id
        ])->exists();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\Response
     */
    protected function unauthorized(Request $request)//如果改为public则失效
    {
        if($request->ajax()){
            return response(['message' => 'No Way.'], 403);//403错误:服务器理解客户的请求，但拒绝处理它
        }
        flash('No Way.');
        return redirect('/');
    }
}