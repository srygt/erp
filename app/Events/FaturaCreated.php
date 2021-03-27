<?php

namespace App\Events;

use App\Models\Fatura;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FaturaCreated
{
    use Dispatchable, SerializesModels;

    protected $fatura;

    /**
     * Create a new event instance.
     *
     * @param Fatura $fatura
     */
    public function __construct(Fatura $fatura)
    {
        $this->fatura = $fatura;
    }

    /**
     * @return Fatura
     */
    public function getFatura(): Fatura
    {
        return $this->fatura;
    }
}
