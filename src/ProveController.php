<?php

namespace faridfr\itsMyCode;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProveController extends Controller
{
    public function proveProgrammer()
    {
        $data = $this->getProgrammerData();

        if (isNotLumen())
            return view('itsMyCode::provePage')->with([
                'user' => $data['user'],
                'repos' => $data['repos'],
            ]);
        else
            return response()->json([
                'data' => null ,
                'status'=> 'success' ,
                'message' => "It's My Code ".config('itsMyCode.GITHUB_USERNAME'),
                'errors'=> null
            ], 200);
    }

    public function getProgrammerData()
    {

        if(config('itsMyCode.GITHUB_USERNAME') != null)
            return $this->getDataFromGithub();

        else
            return [
                'user'  => null,
                'repos' => null,
            ];

    }

    public function getDataFromGithub()
    {
        // get data from github

        $append = "client_id=".config('itsMyCode.GITHUB_CLIENT_ID')."&client_secret=".config('itsMyCode.GITHUB_CLIENT_SECRET');
        ini_set('max_execution_time', 300);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.github.com/users/".config('itsMyCode.GITHUB_USERNAME')."/repos?sort=pushed&".$append);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_USERAGENT,'Personal Website');
        $repos_exec = curl_exec($ch);
        $repos = json_decode($repos_exec);
        curl_setopt($ch, CURLOPT_URL, "https://api.github.com/users/".config('itsMyCode.GITHUB_USERNAME')."?".$append);
        $user_exec = curl_exec($ch);
        $user = json_decode($user_exec);
        curl_close($ch);

        return [
            'user'  => $user,
            'repos' => $repos,
        ];

    }

}
