<?php

namespace Modules\RoadMap\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\RoadMap\Enums\QuestionCategory;
use Modules\RoadMap\Models\Answer;

class QuestionResource extends JsonResource
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
            'title' => $this->resource->title,
            'category' => $this->resource->category_enum,
            'answers' => AnswerResource::collection($this->resource->answers),
        ];
    }
}
