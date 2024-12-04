<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class FileUploadService
{
    protected $allowedMimes = [
        'jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'
    ];

    protected $maxSize = 5120; // 5MB in kilobytes

    public function uploadFile(UploadedFile $file, string $directory): string
    {
        if (!in_array($file->getClientOriginalExtension(), $this->allowedMimes)) {
            throw new \Exception('File type not allowed');
        }

        if ($file->getSize() > $this->maxSize * 1024) {
            throw new \Exception('File size exceeds maximum limit');
        }

        $fileName = Str::random(32) . '.' . $file->getClientOriginalExtension();
        // Store in private disk instead of public
        $path = $file->storeAs($directory, $fileName, 'private');

        return $path;
    }

    public function deleteFile(string $path): bool
    {
        return Storage::disk('private')->delete($path);
    }

    public function getTemporaryUrl(string $path, $expireMinutes = 5): ?string
    {
        if (empty($path)) {
            return null;
        }

        try {
            return URL::temporarySignedRoute(
                Auth::guard('web')->check() ? 'chats.attachment.download' : 'chat.attachment.download',
                now()->addMinutes($expireMinutes),
                ['path' => $path]
            );
        } catch (\Exception $e) {
            report($e);
            return null;
        }
    }
}
