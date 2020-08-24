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

# HT-Mukellef CSV Import
*   `import:ht-mukellefler <filePath> --delimiter[=DELIMITER] --headerOffset[=HEADEROFFSET]`
*   `import:ht-mukellefler "/var/www/file.csv"`
*   `import:ht-mukellefler "/var/www/file.csv --delimiter=";" --headerOffset=5"`
