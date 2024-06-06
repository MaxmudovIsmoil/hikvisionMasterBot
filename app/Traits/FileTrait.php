<?php

namespace App\Traits;


use Illuminate\Support\Facades\Storage;

trait FileTrait
{

    public function fileUpload(object $file, string $path = 'photos'): string
    {
        if($file) {
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs("upload/" . $path, $fileName, 'public');
        }
        return $fileName ?? "";
    }


    public function fileDelete(string $filePath): void
    {
        $filePath = "public/upload/" . $filePath;

        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
    }
}
