<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        # return parent::toArray($request);
        $articleRoute = route('api.v1.articles.show', $this->resource);
        return [
            'type' => 'articles',
            'id' => $this->resource->getRouteKey(),
            'attributes' => [
                'title' => $this->resource->title,
                'slug' => $this->resource->slug,
                'content' => $this->resource->content,
            ],
            'links' => [
                'self' => $articleRoute
            ]
        ];
    }
}
