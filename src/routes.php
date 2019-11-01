<?php

Route::get('prove','faridfr\itsMyCode\ProveController@proveProgrammer');
Route::get('prove/'.config('itsMyCode.GITHUB_USERNAME'),'faridfr\itsMyCode\ProveController@proveProgrammer');