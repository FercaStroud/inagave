<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use App\User;
use App\Util\Errors;
use App\Util\Utils;

class SettingController extends Controller
{
    public function index(){
        return Setting::first();
    }

    public function update(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'id' => 'required',
            'maintenance' => 'required',
        ]);

        $setting = Setting::find($request->get('id'));
        tap($setting)->update($request->all());

        $setting->save();
        return response()->json($setting, 201);
    }

    public function saveSettings(Request $request)
    {
        $request->validate([
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($request->user()->isAdmin()) {
            $settingsFile = Utils::getSettingsFile();

            $settings = json_encode([ // TODO change
                'example' => $request->input('example', ''),
            ]);

            file_put_contents($settingsFile, $settings);
        }

        $password = $request['password'];

        if (!empty($password)) {
            $request->user()->update([
                'password' => bcrypt($password),
            ]);
        }

        return [];
    }
}
