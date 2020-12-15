<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportedFaturaFile extends Model
{
    const COLUMN_ID             = 'id';
    const COLUMN_STATUS         = 'status';
    const COLUMN_TYPE           = 'type';
    const COLUMN_IP_ADDRESS     = 'ip_address';

    const LIST_STATUS   = [
        self::FIELD_STATUS_UPLOADING,
        self::FIELD_STATUS_UPLOADED,
    ];

    const FIELD_STATUS_UPLOADING    = 'uploading';
    const FIELD_STATUS_UPLOADED     = 'uploaded';

}
