<?php

namespace App\Repositories\Schools;

use App\Models\School;
use App\Repositories\Contracts\Schools\SchoolRepositoryInterface;
use App\Services\MediaUploadService;
use Illuminate\Http\UploadedFile;

class SchoolRepository implements SchoolRepositoryInterface
{
    private MediaUploadService $mediaService;

    public function __construct(?MediaUploadService $mediaService = null)
    {
        $this->mediaService = $mediaService ?? new MediaUploadService();
    }

    public function save(School $school, UploadedFile $icon): void
    {
        $school->save();
        if ($icon) {
            $school->icon_url = $this->mediaService->upload($icon, 'school_logos', $school->id.'.png');
            $school->save();
        }
    }
}
