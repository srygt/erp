<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MukellefResource extends JsonResource
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
            'id'                    => $this->id,
            'vergi_no'              => $this->vergi_no,
            'tc_kimlik_no'          => $this->tc_kimlik_no,
            'unvan'                 => $this->unvan,
            'ad_soyad'              => $this->ad_soyad,
            'vergi_dairesi_sehir'   => $this->vergi_dairesi_sehir,
            'vergi_dairesi'         => $this->vergi_dairesi,
            'email'                 => $this->email,
            'website'               => $this->website,
            'ulke'                  => $this->ulke,
            'il'                    => $this->il,
            'ilce'                  => $this->ilce,
            'adres'                 => $this->adres,
            'telefon'               => $this->telefon,
            'urn'                   => $this->urn,
        ];
    }
}
