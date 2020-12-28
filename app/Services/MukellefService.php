<?php


namespace App\Services;


use App\Models\ImportedFatura;
use App\Models\Mukellef;
use Illuminate\Http\RedirectResponse;

class MukellefService
{
    /**
     * @param Mukellef $mukellef
     *
     * @return bool
     */
    public static function isLocked(Mukellef $mukellef) : bool
    {
        $ids = $mukellef->abonelikler->pluck('id');

        return ImportedFatura::whereIn(ImportedFatura::COLUMN_ABONE_ID, $ids)
            ->exists();
    }

    /**
     * @return RedirectResponse
     */
    public static function showLockedMessage()
    {
        return redirect()
            ->back()
            ->withErrors([
                'İçeri aktarılanlar listesinde mükellefe ait kayıt'
                    . ' bulunduğundan işlem yapamazsınız. İlgili kaydı'
                    . ' faturalaştırdıktan ya da sildikten sonra işleminize devam'
                    . ' edebilirsiniz.'
            ]);
    }
}
