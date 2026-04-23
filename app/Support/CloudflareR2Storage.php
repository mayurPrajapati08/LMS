<?php

namespace App\Support;

use Aws\S3\S3Client;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class CloudflareR2Storage
{
    public static function uploadPublicFile(UploadedFile $file, string $path, array $options = []): string
    {
        self::ensureConfigured();
        self::guardUpload($file, $path, $options);

        $disk = Storage::disk('r2');
        $stream = fopen($file->getRealPath(), 'r');

        if ($stream === false) {
            throw new RuntimeException('Unable to read the selected file for upload.');
        }

        try {
            $stored = $disk->put($path, $stream, [
                'visibility' => 'public',
                'ContentType' => $file->getMimeType() ?: 'application/octet-stream',
            ]);
        } finally {
            fclose($stream);
        }

        if (! $stored) {
            throw new RuntimeException('Upload failed. Please try again.');
        }

        return self::publicUrl($path);
    }

    public static function createPresignedUpload(string $path, string $contentType = 'application/octet-stream', int $ttlMinutes = 30): array
    {
        self::ensureConfigured();

        $client = self::client();
        $bucket = (string) config('filesystems.disks.r2.bucket');

        $command = $client->getCommand('PutObject', [
            'Bucket' => $bucket,
            'Key' => $path,
            'ContentType' => $contentType,
        ]);

        $request = $client->createPresignedRequest($command, '+'.$ttlMinutes.' minutes');

        return [
            'upload_url' => (string) $request->getUri(),
            'file_url' => self::publicUrl($path),
            'path' => $path,
        ];
    }

    public static function publicUrl(string $path): string
    {
        self::ensureConfigured();

        return Storage::disk('r2')->url($path);
    }

    private static function guardUpload(UploadedFile $file, string $path, array $options): void
    {
        if (! $file->isValid()) {
            throw new RuntimeException('The selected file upload is invalid. Please try again.');
        }

        $normalizedPath = trim(str_replace('\\', '/', $path), '/');

        if ($normalizedPath === '' || str_contains($normalizedPath, '../') || str_contains($normalizedPath, '..\\')) {
            throw new RuntimeException('The upload path is invalid.');
        }

        $extension = strtolower((string) ($file->getClientOriginalExtension() ?: $file->extension() ?: ''));
        $mimeType = strtolower((string) ($file->getMimeType() ?: 'application/octet-stream'));
        $size = (int) ($file->getSize() ?? 0);
        $blockedExtensions = ['php', 'phtml', 'phar', 'cgi', 'pl', 'py', 'js', 'jsp', 'asp', 'aspx', 'sh', 'exe', 'bat', 'cmd', 'dll', 'com', 'msi', 'svg', 'html', 'htm'];

        if ($extension !== '' && in_array($extension, $blockedExtensions, true)) {
            throw new RuntimeException('This file type is not allowed for upload.');
        }

        $allowedExtensions = array_map('strtolower', $options['allowed_extensions'] ?? []);
        if ($allowedExtensions !== [] && ! in_array($extension, $allowedExtensions, true)) {
            throw new RuntimeException('The selected file extension is not allowed.');
        }

        $allowedMimeTypes = array_map('strtolower', $options['allowed_mime_types'] ?? []);
        if ($allowedMimeTypes !== [] && ! in_array($mimeType, $allowedMimeTypes, true)) {
            throw new RuntimeException('The selected file type is not allowed.');
        }

        $maxBytes = (int) ($options['max_bytes'] ?? 0);
        if ($maxBytes > 0 && $size > $maxBytes) {
            throw new RuntimeException('The selected file is larger than the allowed upload limit.');
        }
    }

    private static function client(): S3Client
    {
        $config = config('filesystems.disks.r2');

        return new S3Client([
            'version' => 'latest',
            'region' => (string) ($config['region'] ?? 'auto'),
            'endpoint' => (string) ($config['endpoint'] ?? ''),
            'use_path_style_endpoint' => (bool) ($config['use_path_style_endpoint'] ?? false),
            'credentials' => [
                'key' => (string) ($config['key'] ?? ''),
                'secret' => (string) ($config['secret'] ?? ''),
            ],
        ]);
    }

    private static function ensureConfigured(): void
    {
        $config = config('filesystems.disks.r2');

        if (
            blank($config['key'] ?? null)
            || blank($config['secret'] ?? null)
            || blank($config['bucket'] ?? null)
            || blank($config['endpoint'] ?? null)
            || blank($config['url'] ?? null)
        ) {
            throw new RuntimeException('Cloudflare R2 is not configured. Add the R2 credentials and public URL to continue.');
        }
    }
}
