<?php

namespace App\Transformers;

use App\Timbangan;
use League\Fractal;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;


class TimbanganTransformer extends TransformerAbstract
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
    public function transform(Timbangan $resource)
    {
        return [
            
            'id' => $resource->id,
	    'no'  => $resource->no,	
            'material'  => $resource->material,
            'warna_cones'  => $resource->warna_cones,
            'batch'  => $resource->batch,
            'mill'  => $resource->mill,
            'tare_cones'  => $resource->tare_cones,
            'tare_lain'  => $resource->tare_lain,
            'tipe_berat'  => $resource->tipe_berat,
            'deskripsi'  => $resource->deskripsi,
            'qty'  => $resource->qty,
            'standar'  => $resource->standar,
            'actual'  => $resource->actual,
            'berat_sc'  => $resource->berat_sc,
            'total_cones'  => $resource->total_cones,
            'berat_papan'  => $resource->berat_papan,
            'bruto'     => $resource->bruto,
            'no_reg'    => $resource->no_reg,
            'packing_id'  => $resource->packing_id,
            'palet_id'  => $resource->palet_id,
            'created_at'  => $resource->created_at,
        ];
    }
}
