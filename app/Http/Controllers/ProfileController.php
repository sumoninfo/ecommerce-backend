<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\Admin\ProfileResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * return user profile data
     *
     * @param $id
     * @return ProfileResource
     */
    public function show(User $user)
    {
        return new ProfileResource($user);
    }

    /**
     * user profile updating
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        if ($request->filled('image')) {
            if (Storage::disk('public')->exists('profile/' . $user->image)) {
                Storage::disk('public')->delete('profile/' . $user->image);
            }
            $user->image = Helper::fileUpload($request->image, 'profile/');
        }
        $request->offsetUnset('image');
        $user->fill($request->all());
        $user->update();
        return Helper::returnResponse("success", "Updated successfully", new ProfileResource($user));
    }
}
