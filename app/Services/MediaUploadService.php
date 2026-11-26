<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Request as RequestAlias;

class MediaUploadService
{
    private Client $httpClient;

    private ?string $remoteUrl;

    public function __construct(?Client $httpClient = null)
    {
        $this->httpClient = $httpClient ?? new Client(['timeout' => 5.0]);
        $this->remoteUrl = config('services.media.remote_upload_endpoint');
    }

    /**
     * Store an uploaded file locally and optionally mirror to a remote endpoint.
     *
     * @param  string  $directory e.g. 'school_logos', 'categories', 'projects', 'homework_files'
     * @param  string|null  $customFilename Optional custom filename (e.g. '1.png' or random string)
     * @return string Publicly accessible relative path (e.g. 'storage/school_logos/1.png')
     */
    public function upload(UploadedFile $file, string $directory, ?string $customFilename = null): string
    {
        $extension = $file->getClientOriginalExtension() ?: 'png';
        $filename = $customFilename ?? (uniqid('', true).'.'.$extension);
        $relativePath = trim($directory, '/').'/'.$filename;

        // Ensure storage directory exists
        Storage::disk('public')->putFileAs($directory, $file, $filename);

        // Optional remote mirror (non-blocking, tolerant to network outages)
        if ($this->remoteUrl) {
            $this->mirrorToRemote($relativePath, $directory, $filename);
        }

        return 'storage/'.$relativePath;
    }

    /**
     * Gracefully mirror file to remote endpoint without crashing the local transaction.
     */
    private function mirrorToRemote(string $relativePath, string $directory, string $filename): void
    {
        try {
            $absolutePath = Storage::disk('public')->path($relativePath);
            if (! file_exists($absolutePath)) {
                return;
            }

            $this->httpClient->request(RequestAlias::METHOD_POST, $this->remoteUrl, [
                'multipart' => [
                    [
                        'name' => 'image',
                        'contents' => fopen($absolutePath, 'r'),
                        'filename' => $filename,
                    ],
                    [
                        'name' => 'path',
                        'contents' => $directory,
                    ],
                ],
            ]);
        } catch (GuzzleException $e) {
            Log::warning("MediaUploadService: Remote upload mirror failed for {$relativePath}: ".$e->getMessage());
        } catch (\Throwable $e) {
            Log::warning("MediaUploadService: Unexpected error mirroring {$relativePath}: ".$e->getMessage());
        }
    }
}
