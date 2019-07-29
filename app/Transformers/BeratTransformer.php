<?php

namespace App\Transformers;

use App\Berat;
use League\Fractal;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;


class BeratTransformer extends TransformerAbstract
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
    public function transform(Berat $resource)
    {
        return [

            'id' => $resource->id,
            'deskripsi' => $resource->deskripsi,
            'tipe' => $resource->tipe,
            'berat' => $resource->berat,
            
			
        ];
    }
}
