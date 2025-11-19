<?php

namespace App\Support\Concerns;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

trait HandlesMediaUrls
{
    protected function mediaUrl(?string $path, string $fallback): string
    {
        if (blank($path)) {
            return $this->formatAssetUrl($fallback);
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            return $this->formatAssetUrl($fallback);
        }

        $storageUrl = $disk->url($path);

        if ($this->isLocalPlaceholderUrl($storageUrl)) {
            return $this->absoluteStorageUrl($path);
        }

        return $storageUrl;
    }

    protected function formatAssetUrl(string $path): string
    {
        return filter_var($path, FILTER_VALIDATE_URL) ? $path : asset($path);
    }

    protected function isLocalPlaceholderUrl(string $url): bool
    {
        return str_contains($url, '://localhost')
            || str_contains($url, '://127.0.0.1')
            || str_contains($url, '://[::1]');
    }

    protected function absoluteStorageUrl(string $path): string
    {
        $relativePath = 'storage/' . ltrim($path, '/');

        if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            $appUrl = rtrim((string) config('app.url'), '/');

            return $appUrl ? $appUrl . '/' . $relativePath : '/' . $relativePath;
        }

        $host = request()->getSchemeAndHttpHost();

        if ($host) {
            return rtrim($host, '/') . '/' . $relativePath;
        }

        $appUrl = rtrim((string) config('app.url'), '/');

        return $appUrl ? $appUrl . '/' . $relativePath : '/' . $relativePath;
    }
}

