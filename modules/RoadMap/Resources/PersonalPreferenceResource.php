<?php

namespace Modules\RoadMap\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonalPreferenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'career' => $this->resource->career_id,
            'status' => $this->resource->status,
            'budget' => $this->resource->budget,
            'work_experience' => $this->resource->work_experience,
            'course_format' => $this->resource->course_format,
            'need_degree' => $this->resource->need_degree,
            'duration' => $this->resource->duration,
            'study_abroad' => $this->resource->study_abroad,
        ];
    }
}
