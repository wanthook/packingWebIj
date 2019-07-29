<?php

namespace App\Transformers;

use App\Mesin;
use League\Fractal;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;


class MesinTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [];

    /**
     * Transform object into a generic array
     *
     * @var $resource
     * @return array
     */
    public function transform(Mesin $resource)
    {
        return [

            'id' => $resource->id,
            'nama' => $resource->nama,
            'kode' => $resource->kode,
            'register_start' => $resource->register_start,
            'register_end' => $resource->register_end
			
        ];
    }
}
