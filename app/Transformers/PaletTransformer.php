<?php

namespace App\Transformers;

use App\Palet;
use League\Fractal;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;


class PaletTransformer extends TransformerAbstract
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
    public function transform(Palet $resource)
    {
        return [
            
            'id' => $resource->id,
            'material'  => $resource->material,
            'warna_cones'  => $resource->warna_cones,
            'batch'  => $resource->batch,
            'mill'  => $resource->mill,
            'tTare_cones'  => $resource->tTare_cones,
            'tTare_lain'  => $resource->tTare_lain,
            'tipe_berat'  => $resource->tipe_berat,
            'deskripsi'  => $resource->deskripsi,
            'tQty'  => $resource->tQty,
            'tStandar'  => $resource->tStandar,
            'tActual'  => $resource->tActual,
            'tBerat_sc'  => $resource->tBerat_sc,
            'tTotal_cones'  => $resource->tTotal_cones,
            'tBerat_papan'  => $resource->tBerat_papan,
            'tBruto'     => $resource->tBruto,
            'start_no'    => $resource->start_no,
            'end_no'    => $resource->end_no,
            'created_at'  => $resource->created_at,
        ];
    }
}
