<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Image;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Image as VanguardImage;
use Vanguard\User;
use Vanguard\UserProfile;
use Vanguard\UserSalary;

class MultipleImageController extends Controller
{
    // store
    public function store(Request $request, $user)
    {


        if ($request->name && $request->file('url')) {



            $names = $request->name;
            $urls = $request->file('url');

            // convert the two arrays into one array
            $combined = collect(array_map(
                function ($name, $url) {
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

        return redirect()->back()->with('file_fields_required', "The file's name and url field is required");
    }

    // viewProfile
    public function viewProfile($user)
    {
        $userProfile = UserProfile::where('user_id', $user->id)->first();
        $salaryInfo = UserSalary::where('user_id', $user->id)->first();
        $images = $user->images()->get();
        return view('user.view-profile', compact('userProfile', 'user', 'images', 'salaryInfo'));
    }

    // deleteFile
    public function deleteFile($user, $imageid)
    {
        $filename = VanguardImage::where('id', $imageid)->first()->url;

        $file_path = public_path() . '/storage/uploads/user-profile/' . $filename;
        VanguardImage::destroy($imageid);

        unlink($file_path);


        return redirect()->back();
    }




}
