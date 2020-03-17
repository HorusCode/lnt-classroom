<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => new StudentPivotResource($this->student),
            'rate' => $this->rate,
            'type' => $this->work_type,
            'title' => $this->work->title,
            'date' => $this->updated_at
        ];
    }
}
