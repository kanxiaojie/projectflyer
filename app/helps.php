<?php
use App\Flyer;

function flash($title = null, $message = null){
    $flash = app('App\Http\Flash');

    if(func_num_args() == 0){
        return $flash;
    }

    return $flash->info($title, $message);
}

function flyer_path(Flyer $flyer)
{
    return $flyer->zip.'/'.str_replace(' ','-', $flyer->street);
}

//link_to('Delete?', $post, 'DELETE')
//link_to('Delete?', '/photos/1/delete', 'DELETE')
function link_to($body, $path, $type){
    $csrf = csrf_field();

    if(is_object($path)){
        $action = '/'.$path->getTable();//photos

        if(in_array($type, ['PUT', 'PATCH', 'DELETE'])){
            $action .='/'.$path->getKey();// photos/1
        }
    }else{
        $action = $path;
    }

    return <<<EOT
    <form method="POST" action="{$action}">
        <input type="hidden" name="_method" value="{$type}">
        $csrf
        <button type="submit">{$body}</button>
    </form>
EOT;
}