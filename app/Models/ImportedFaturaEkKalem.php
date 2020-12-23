<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImportedFaturaEkKalem extends Model
{
    const COLUMN_EK_KALEM_ID        = 'ek_kalem_id';
    const COLUMN_IMPORTED_FATURA_ID = 'imported_fatura_id';
    const COLUMN_DEGER              = 'deger';

    const RELATION_EK_KALEM         = 'ekKalem';
    const RELATION_IMPORTED_FATURA  = 'importedFatura';

    /**
     * @return BelongsTo
     */
    public function ekKalem()
    {
        return $this->belongsTo(AyarEkKalem::class);
    }

    /**
     * @return BelongsTo
     */
    public function importedFatura()
    {
        return $this->belongsTo(ImportedFatura::class);
    }
}
