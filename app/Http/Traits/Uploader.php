<?php


namespace App\Http\Traits;


use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

trait Uploader
{
    public function UploadPic(Request $request, $name, $path )
    {
        $request->validate([
            $name => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $Finalpath = $path .  date('Y/m/d') ;
        $imageName = bin2hex(random_bytes(32)) . '.jpg';
        if (!file_exists($Finalpath)) {
            \File::makeDirectory($Finalpath, 0777, true, true);
        }
        \request($name)->move($Finalpath, $imageName);

        return $Finalpath . $imageName;
    }

    public function UploadImage(UploadedFile $file , string $FolderName = null){
        //get filename with extension
        $filenamewithextension = $file->getClientOriginalName();

        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
        $filename = preg_replace("/\s/", "-", $filename);

        //get file extension
        $extension = $file->getClientOriginalExtension();

        //filename to store
        $filenametostore = $filename.'_' . rand(100000 , 100000000) . time() .'.'.$extension;

        //$basePath = '../vpn.ai1polaris.com/Uploads/';
        if ($FolderName){
            $path =   $FolderName . '/'  . date('Y/m/d') . '/';
        }else{
            $path =  date('Y/m/d') . '/';
        }

        //Upload File
        $file->storeAs( $path , $filenametostore , ['disk' => 'publichtml']);

        return 'https://kryptoarena.fun/Uploads/' . $path . $filenametostore;
    }
    public function SiteIcon(Request $request){
        $request->validate([
            'SiteIcon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);
        $orginalPath = '/assets/images/';
        $path = public_path($orginalPath);
        $imageName = 'favicon.ico';
        \request('SiteIcon')->move($path, $imageName);
        return $orginalPath.$imageName;
    }
}
