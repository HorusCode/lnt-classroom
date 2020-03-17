<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentPivotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = $this->user;
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'lastname'=> $user->lastname,
            'patronymic' => $user->patronymic,
            'firstname' => $user->firstname,
            'group' => $this->group->group
        ];
    }
}
