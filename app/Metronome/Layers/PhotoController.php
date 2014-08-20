<?php namespace Metronome\Layers;

use Str;
use Auth;
use File;
use Lang;
use View;
use Input;
use Image;
use Photo;
use Redirect;

class PhotoController extends BaseController {

    public function index()
    {
        return View::make('backend.photo.index')
            ->withPhotos(Photo::all())
            ->withTitle(Lang::get('locale.photo'));
    }

    public function store()
    {
        $photo = Image::make(Input::file('photo')->getRealPath());

        $hash = Str::random(64);

        $photo->save($this->photoUrl($hash))->fit(640)->save($this->photoUrl($hash, false));

        $user = Auth::user();

        $user->photos()->save(new Photo([
            'hash' => $hash
        ]));

        return Redirect::to('admin/photos');
    }

    public function show()
    {
        return View::make('backend.photo.show');
    }

    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);

        foreach ([true, false] as $origin) {
            File::exists($path = $this->photoUrl($photo->hash, $origin)) and File::delete($path);
        }

        $photo->delete();

        return Redirect::back();
    }

    private function photoUrl($hash = null, $origin = true)
    {
        $hash = $hash ?: Str::random(64);

        if ($origin) $hash .= '-origin';

        return join('/uploads/', [\public_path(), join('.', [$hash, 'jpg'])]);
    }
}
