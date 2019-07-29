<?php

namespace App\Transformers;

use App\Packing;
use League\Fractal;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;


class PackingTransformer extends TransformerAbstract
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
    public function transform(Packing $resource)
    {
        return [

            'id' => $resource->id,
            'material'  => $resource->material,
            'warna_cones'  => $resource->warna_cones,
            'batch'  => $resource->batch,
            'berat_material'  => $resource->berat_material,
            'tare_cones'  => $resource->tare_cones,
            'tare_lain'  => $resource->tare_lain,
            'bruto'  => $resource->bruto,
            'berat.deskripsi'  => $resource->berat->deskripsi,
            'berat.tipe'  => $resource->berat->tipe,
            'berat.berat'  => $resource->berat->berat,
			
        ];
    }
}
