<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ProfileResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * return admin profile data
     *
     * @param $id
     * @return ProfileResource
     */
    public function show(Admin $admin)
    {
        return new ProfileResource($admin);
    }

    /**
     * admin profile updating
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Admin $admin)
    {
        if ($request->filled('image')) {
            if (Storage::disk('public')->exists('profile/' . $admin->image)) {
                Storage::disk('public')->delete('profile/' . $admin->image);
            }
            $admin->image = Helper::fileUpload($request->image, 'profile/');
        }
        $request->offsetUnset('image');
        $admin->fill($request->all());
        $admin->update();
        return Helper::returnResponse("success", "Updated successfully", new ProfileResource($admin));
    }
}
