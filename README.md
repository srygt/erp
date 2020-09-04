# Installation
*   `git clone https://github.com/onuruslu/Diyarbakir-OSB.git .`
*   `git submodule update --init --recursive`
    (to do that you need to access permission of https://github.com/onuruslu/ht-efatura)
*   Change the content of the `env.example` file according to your config,
    and save as `.env`
    ```
    HT_EFATURA_USERNAME="xxx"
    HT_EFATURA_PASSWORD="xxx"
    
    HT_EFATURA_URL="https://econnecttest.hizliteknoloji.com.tr"
    
    EFATURA_CODE_PREFIX="XXX"
    EFATURA_CODE_START="000"
    
    EARSIV_CODE_PREFIX="YYY"
    EARSIV_CODE_START="000"
    ```
*   `composer install`
*   `php artisan migrate --seed`

# HT-Mukellef CSV Import
*   `php artisan import:ht-mukellefler <filePath> --delimiter[=DELIMITER] --headerOffset[=HEADEROFFSET]`
*   `php artisan import:ht-mukellefler "/var/www/file.csv"`
*   `php artisan import:ht-mukellefler "/var/www/file.csv" --delimiter=";" --headerOffset=5`

# OSB Elektrik Aboneleri CSV Import
*   `php artisan import:osb-elektrik-aboneler <filePath> --delimiter[=DELIMITER] --headerOffset[=HEADEROFFSET]`
*   `php artisan import:osb-elektrik-aboneler "/var/www/file.csv"`
*   `php artisan import:osb-elektrik-aboneler "/var/www/file.csv" --delimiter=";" --headerOffset=5`
