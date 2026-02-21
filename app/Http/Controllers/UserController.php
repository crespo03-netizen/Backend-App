<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profilePhoto(Request $request, UploadApi $uploadApi)
    {
        $user = $request->user();

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $file = $request->file('image');

            $response = $uploadApi->upload($file->getRealPath(), [
                'folder' => 'WebApp',
            ]);

            $oldPhotoId = $user->profile_photo_id;

            $user->fill([
                'profile_photo_url' => $response['secure_url'],
                'profile_photo_id' => $response['public_id'],
            ])->save();

            if ($oldPhotoId) {
                $uploadApi->destroy($oldPhotoId, ['resource_type' => 'image']);
            }

            return new UserResource($user);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Failed to upload image'], 500);
        }

    }

    public function destroyPhoto(Request $request, UploadApi $uploadApi)
    {
        $user = $request->user();

        try {
            $uploadApi->destroy($user->profile_photo_id, ['resource_type' => 'image']);

            $user->update([
                'profile_photo_url' => null,
                'profile_photo_id' => null,
            ]);

            return new UserResource($user);

        } catch (\Exception $e) {

            return response()->json(['message' => 'No se pudo eliminar la imagen del servidor.'], 500);
        }
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'string|max:255',
            'bio' => 'string|max:1000',
        ]);

        $user->name = $request->name;
        $user->bio = $request->bio;
        $user->save();

        return new UserResource($user);
    }
}
