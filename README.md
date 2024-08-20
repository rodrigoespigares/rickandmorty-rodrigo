
# Rick y Morty uso API

API para gestionar tus personajes favoritos de Rick y Morty, buscar información sobre ellos y aprender un poco más sobre el apasionado mundo de estos personajes.


## Instalación

Clona este repositorio y comencemos a instalar esta API en un repositorio local

```bash
  git clone https://github.com/rodrigoespigares/rickandmorty-rodrigo.git
  cd rickandmorty-rodrigo
```
Tras esto deberemos actualizar las librerías de composer
```bash
  composer update
```
Y copiar el env.example pero reemplazando por nuestras credenciales en el .env

### Para uso de SQLite
Deberemos crear el fichero de la base de datos en la carpeta database

_ _ _
<div style="height='20px'"/>

Una vez completado esto deberemos crear nuestras propias credenciales para que los usuarios puedan registrarse y además de esto ejecutaremos las migraciones con el comando:

```bash
    php artisan passport:install
```
Pulsaremos ``` Y ``` y despues de nuevo ``` Y ``` 

Para finalizar creamos las credenciales de laravel con el comando
```bash
    php artisan key:generate
```

    
## Contenido aprendido

Con este proyecto he afianzado mis conocimientos sobre la creación de API en Laravel con su nueva versión 11 y además de esto he podido aprender a gestionar mi tiempo bajo presión.


## Documentación

https://rodrigoespigares.github.io/rickandmorty-rodrigo/public/docs/


## Authors

- [@rodrigoespigares](https://www.github.com/rodrigoespigares)

