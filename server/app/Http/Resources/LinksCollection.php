<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LinksCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($link) {
            return [
                'id' => $link->id,
                'user_id' => $link->user_id,
                'name' => $link->name,
                'url' => $link->url,
                'image' => url('/') . $link->image,
            ];
        });
    }
}
