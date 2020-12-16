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
        self::FIELD_STATUS_MALFORMED,
        self::FIELD_STATUS_APPROVED,
    ];

    const FIELD_STATUS_UPLOADING    = 'uploading';
    const FIELD_STATUS_UPLOADED     = 'uploaded';
    const FIELD_STATUS_MALFORMED    = 'malformed';
    const FIELD_STATUS_APPROVED     = 'approved';

}
