<?php


namespace App\Services;


use App\Models\Abone;
use Illuminate\Http\RedirectResponse;

class AboneService
{
    /**
     * @param Abone $abone
     *
     * @return bool
     */
    public static function isLocked(Abone $abone) : bool
    {
        return $abone->importedFaturalar()->exists();
    }

    /**
     * @return RedirectResponse
     */
    public static function showLockedMessage()
    {
        return redirect()
            ->back()
            ->withErrors([
                'İçeri aktarılanlar listesinde aboneye ait kayıt'
                    . ' bulunduğundan işlem yapamazsınız. İlgili kaydı'
                    . ' faturalaştırdıktan ya da sildikten sonra işleminize devam'
                    . ' edebilirsiniz.'
            ]);
    }
}
