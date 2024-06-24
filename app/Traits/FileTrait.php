<?php

namespace App\Traits;


use Illuminate\Support\Facades\Storage;

trait FileTrait
{

    public function fileUpload(object $file): string
    {
        if($file) {
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs("upload/files", $fileName, 'public');
        }
        return $fileName ?? "";
    }


    public function fileDelete(string $file): void
    {
        $filePath = "public/upload/files/" . $file;

        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
    }
}
