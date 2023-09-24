## 1-Clone Project
 - `git clone https://github.com/dalinICT/laravel10_CRUD_Ajax.git`
## 2-Install Composer for Vendor
 - `composer install`
## 3-Configure Database
 - `cp .env.example .env` ចម្លង Database configuration ពី file .env.example ទៅបង្កើតនិងដាក់កូដទាំងអស់ចូល .env file ថ្មី
 - កំណត់កូដខាងក្រោមដើម្បី​ភ្ជាប់ Database ក្នុង file `.env`
   ```javascript
      DB_CONNECTION=mysql
      DB_HOST=127.0.0.1
      DB_PORT=3306
      DB_DATABASE=laravel10_crud_ajax
      DB_USERNAME=root
      DB_PASSWORD=
  - បង្កើត `APP_KEY= ` ដោយប្រើ command `php artisan key:generate`
  - បង្កើត Table ដោយប្រើ command : `php artisan migrate` ប្រសិនបើមានបញ្ហា Error កើតឡើងយើងត្រូវទៅពិនិត្យថាតើមានឈ្មោះ Database នៅក្នុងប្រព័ន្ធ Database ហើយនៅ? បើគ្មានត្រូវបង្កើតអោយដូចឈ្មោះក្នុង `.env` file



