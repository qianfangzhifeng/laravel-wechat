<?php

Route::prefix('wechat')->group(function () {
		Route::any('/','WechatController@index')-> middleware('swechat.check');
		Route::get('hello',function (){
		    dd(config());
        });
});