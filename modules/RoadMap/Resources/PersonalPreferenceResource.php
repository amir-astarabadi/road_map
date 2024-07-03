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
            'status' => $this->resource->status,
            'budget' => $this->resource->budget,
            'course_length_type' => $this->resource->course_length_type,
            'course_location_type' => $this->resource->course_location_type,
            'industries' => $this->resource->industries,
            'jobs' => $this->resource->jobs,
        ];
    }
}
