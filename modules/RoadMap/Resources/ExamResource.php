<?php

namespace Modules\RoadMap\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'exam_id' => $this->resource->id,
            'questions' => QuestionResource::collection($this->resource->questions()),
        ];
    }
}
