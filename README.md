# Proyecto de recomendación de InstaCart

Para poder iniciar este proyecto de manera local se necesitan los siguientes requerimientos:

- Tener instalado PHP
- Tener instalado composer
- Tener instalado node.js y por consiguiente su gestorr de paquetes (npm)
- Un entorno de ejecución para proyectos de laravel (Preferiblemente laravel Herd)

Una vez se han satisfecho los siguientes requerimientos y el entorno se haya configurado correctamente, se deberán settear las variables de entorno (archivo env, en caso de no poseerlo, se tendrá que renombrar el archivo 'env.example' a 'env'), las mas importantes para este caso son las siguientes y deberán configurarse con los parámetros de la base de datos local del desarrollador

- DB_CONNECTION=mysql
- DB_HOST=
- DB_PORT=
- DB_DATABASE=
- DB_USERNAME=
- DB_PASSWORD=


Para continuar con la instalación del proyecto se deberán ejecutar los siguientes comandos en el orden indicado:

1. Composer install / update
2. En un terminal de bash ejecutar 'npm install'
3. php artisan key:generate
4. php artisan migrate
5. php artisan db:seed UserSeeder
6. php artisan db:seed ProductsSeeder

Para poder ejecutar los seeder es necesario que se guarde de manera manual el archivo 'definitivo.csv' en el siguiente directorio:

storage\app\public\csv\definitivo.csv

en caso deno existir, se pueden crear de manera manual los directorios con los definidos en el path. 

Una vez seguidos estos pasos, la aplicación debeía funcionar correctamente
