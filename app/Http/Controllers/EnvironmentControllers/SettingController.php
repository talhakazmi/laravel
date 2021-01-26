<?php

namespace App\Http\Controllers\EnvironmentControllers;

use App\Http\Requests\Portal\SettingsRequest;
use App\Setting;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::find(1);
        return response()->json($settings);
    }
    public function update(SettingsRequest $request)
    {

        $settings = Setting::find(1);
        if ($settings != NULL) {
	        $settings->fill($request->all());
	        $settings->save();
        }else{
        	$settings = new Setting;
	        $settings->create($request->all());
	        $settings->save();
        }
        return response()->json(['success'=> 'Settings was edited successfully']);
    }
}
