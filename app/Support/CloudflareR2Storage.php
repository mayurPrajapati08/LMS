<?php

namespace App\Support;

use Aws\S3\S3Client;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class CloudflareR2Storage
{
    public static function uploadPublicFile(UploadedFile $file, string $path): string
    {
        self::ensureConfigured();

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
