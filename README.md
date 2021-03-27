# Installation
*   `git clone https://github.com/onuruslu/Diyarbakir-OSB.git .`
*   `git submodule update --init --recursive`
    (to do that you need to access permission of https://github.com/onuruslu/ht-efatura)
*   Change the content of the `env.example` file according to your config,
    and save as `.env`
    ```
    HT_EFATURA_URL="https://econnecttest.hizliteknoloji.com.tr"
    HT_EFATURA_USERNAME="xxx"
    HT_EFATURA_PASSWORD="xxx"
    
    HT_EFATURA_URL="https://econnecttest.hizliteknoloji.com.tr"
    
    EFATURA_CODE_PREFIX="XXX"
    EARSIV_CODE_PREFIX="YYY"
    EX_DATE_PREFIX="2020" // eFatura and eArsiv date prefix
    
    FATURA_VERGI_NO="4620553774" // Hizliteknoloji for test operations
    FATURA_EMAIL_ACTIVE=false

    VIZYONMESAJ_USERNAME=""
    VIZYONMESAJ_PASSWORD=""
    VIZYONMESAJ_ORIGIN=""
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

# Usefull Links
*   [How to deploy Laravel in cPanel the right way](https://web.archive.org/web/20200903195906/https://medium.com/@hafizmohammedg/how-to-deploy-laravel-in-cpanel-the-right-way-78d0a767d5a2) - [Original](https://medium.com/@hafizmohammedg/how-to-deploy-laravel-in-cpanel-the-right-way-78d0a767d5a2)
*   [How to create and configure the deployment SSH Keys for a Gitlab private repository in your Ubuntu Server](https://web.archive.org/web/20200903200059/https://ourcodeworld.com/articles/read/654/how-to-create-and-configure-the-deployment-ssh-keys-for-a-gitlab-private-repository-in-your-ubuntu-server) - [Original](https://ourcodeworld.com/articles/read/654/how-to-create-and-configure-the-deployment-ssh-keys-for-a-gitlab-private-repository-in-your-ubuntu-server)
*   [How to configure multiple deploy keys for different private github repositories on the same computer](https://web.archive.org/web/20200903200408/https://gist.github.com/FlorianBouron/208c77aff253fc178a4a0ad6639f1412) - [Original](https://gist.github.com/FlorianBouron/208c77aff253fc178a4a0ad6639f1412)
