<?php

namespace App\Transformers;

use App\User;
use League\Fractal;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;


class UserTransfomer extends TransformerAbstract
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
    public function transform(User $user)
    {
        return [

            'id' => $user->id,
            'username' => $user->username,
            'name'      => $user->name,
            'email'      => $user->email,
            'type'      => $user->type,
            'nama_mesin' => $user->mesin()->nama,
            'kode_mesin'    => $user->mesin()->kode,
            
            
			
        ];
    }
}
