## HOW TO INSTALL STEP BY STEP
### Setting environtment and database sql
- after clone this project open the folder
- make database and change the env
- type on terminal "composer install" click enter
- type on terminal "npm install && npm run dev"
- type on "npm install again"
- type on terminal "php artisan migrate
- type on terminal "php artisan migrate:fresh --seed

### Setting no sql 
- download elastic search on https://www.elastic.co/downloads/elasticsearch
- open the elastic search folder with terminal then write “./bin/elasticsearch” if you use on mac/linux or “bin\elasticsearch. bat”. if you use on windows
- after open elasticsearch close it then go to file  “elasticsearch.yml” on “rootFolder/config/elasticsearch.yml” and change the line 92,94,98,dan 103 to all false setting then save
- open again elasticsearch with terminal like two step before
- login to admin in this app then type “http://127.0.0.1:8000/aktivasielasticsearch” on browser
- then elastic search already can save the data and read the data 

### last step
php artisan serve
