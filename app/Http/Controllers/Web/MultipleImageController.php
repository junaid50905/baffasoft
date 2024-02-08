<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Image as VanguardImage;
use Vanguard\User;
use Vanguard\UserProfile;

class MultipleImageController extends Controller
{
    // store
    public function store(Request $request, $user)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'required'
        ]);

        $names = $request->name;
        $urls = $request->file('url');

        // convert the two arrays into one array
        $combined = collect(array_map(function ($name, $url) {
                return [
                    'name' => $name,
                    'url' => $url
                ];
            },
                $names,
                $urls
            ));

        foreach ($combined as $item) {
            $user = User::find($user->id);

            $image = new VanguardImage;
            $image->name = $item['name'];

            $filename = time() . '.' . $item['url']->getClientOriginalExtension();
            $item['url']->storeAs('public/uploads/user-profile', $filename);
            $image->url = $filename;

            $user->images()->save($image);

        }

        return redirect()->to('admin/users');

    }

    // viewProfile
    public function viewProfile($user)
    {
        $userProfile = UserProfile::where('user_id', $user->id)->first();
        $images = $user->images()->get();
        return view('user.view-profile', compact('userProfile', 'user', 'images'));
    }
}
