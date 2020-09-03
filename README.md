# Installation
*   `git clone https://github.com/onuruslu/Diyarbakir-OSB.git .`
*   `git submodule update --init --recursive`
    (to do that you need to access permission of https://github.com/onuruslu/ht-efatura)
*   Change the content of the `env.example` file according to your config,
    and save as `.env`
    ```
    HT_EFATURA_USERNAME="xxx"
    HT_EFATURA_PASSWORD="xxx"
    
    FATURA_CODE_PREFIX="xxx"
    FATURA_CODE_START="000"
    ```
*   `composer install`
*   `php artisan migrate --seed`
*   `php artisan key:generate`
*   `chmod -R 775 storage`

# HT-Mukellef CSV Import
*   `php artisan import:ht-mukellefler <filePath> --delimiter[=DELIMITER] --headerOffset[=HEADEROFFSET]`
*   `php artisan import:ht-mukellefler "/var/www/file.csv"`
*   `php artisan import:ht-mukellefler "/var/www/file.csv" --delimiter=";" --headerOffset=5`

# OSB Elektrik Aboneleri CSV Import
*   `php artisan import:osb-elektrik-aboneler <filePath> --delimiter[=DELIMITER] --headerOffset[=HEADEROFFSET]`
*   `php artisan import:osb-elektrik-aboneler "/var/www/file.csv"`
*   `php artisan import:osb-elektrik-aboneler "/var/www/file.csv" --delimiter=";" --headerOffset=5`
