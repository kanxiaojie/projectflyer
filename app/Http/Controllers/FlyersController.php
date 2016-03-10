<?php

namespace App\Http\Controllers;

use App\Flyer;
use Illuminate\Http\Request;
use App\Http\Requests\FlyerRequest;
use App\Http\Controllers\Controller;

class FlyersController extends Controller
{
//    use AuthorizesUsers;

    public function __construct()
    {
        $this->middleware('auth', ['except' => 'show']);

        parent::__construct();
    }

    /**
     *Display a listing of the response
     */
    public function index()
    {

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('flyers.create');
    }

    /**
     * @param FlyerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FlyerRequest $request)
    {
//        Flyer::create($request->all());
        $flyer = $this->user->publish(
            new Flyer($request->all())
        );

        flash()->success('Success!', 'Your flyer have been created!');
        return redirect(flyer_path($flyer));
    }


//    /**
//     * Setup a new photo
//     * @param UploadedFile $file
//     * @return $this
//     */
//    protected function makePhoto(UploadedFile $file)
//    {
////        return Photo::fromForm($file)->store($file);
//        return Photo::named($file->getClientOriginalName())
//                ->move($file);
//    }

    /**
     * @param $zip
     * @param $street
     * @return mixed
     */
    public function show($zip, $street)
    {
        $flyer = Flyer::locatedAt($zip, $street);
        return view('flyers.show', compact('flyer'));
    }

}
