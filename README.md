# Proyecto API REST Giphy

Este proyecto es una API REST que interactúa con el servicio de Giphy para buscar y mostrar gifs. Está construido utilizando las siguientes tecnologías:

## Tecnologías Utilizadas

- **PHP 8.3.2**: Lenguaje principal del backend.
- **Laravel 10**: Framework PHP utilizado para el desarrollo del backend.
- **MySQL 8.0**: Base de datos relacional utilizada.
- **Docker**: Para la contenedorización de la aplicación.
- **Docker Compose**: Para la orquestación de los contenedores Docker.
- **Nginx**: Servidor web y proxy inverso.

## Requisitos

Antes de desplegar el proyecto, asegúrate de tener instalados los siguientes requisitos:

- **Docker**: [Instrucciones de instalación](https://docs.docker.com/get-docker/)
- **Docker Compose**: [Instrucciones de instalación](https://docs.docker.com/compose/install/)
- **Git**: Para clonar el repositorio (opcional, pero recomendado).

## Configuración del Proyecto

Sigue los siguientes pasos para desplegar el proyecto:

### 1. Clonar el Repositorio

Clona el repositorio en tu máquina local:

```sh
git clone https://github.com/AlannFernandez/api-rest-giphy
cd api-rest-giphy
```

### 2. Configurar Variables de Entorno

Crea un archivo `.env` en la raíz del proyecto y agrega las variables de entorno necesarias. Puedes basarte en el archivo `.env.example`:

``` sh
cp .env.example .env
```
Asegúrate de configurar correctamente las variables de entorno para la base de datos y las claves de la aplicación.

### 3. Construir y Levantar los Contenedores

Construye y levanta los contenedores Docker utilizando Docker Compose, asegurate de estar en carpeta raiz del proyecto para ejecutrar el siguiente comando:
``` sh
docker-compose up --build
```

Esto construirá los contenedores y los levantará. Los servicios que se levantarán son:

- **app:** Contenedor para la aplicación Laravel.
- **web:** Contenedor para el servidor Nginx.
- **db:** Contenedor para la base de datos MySQL.

### 4. Scripts automaticos 
El proyecto está configurado para correr unos comandos automaticamente mientras hace el despligue, estos comandos se encuentran en el archivo `entrypoint.sh` . Este archivo puede ser editado pero hay que tener en cuenta los cambios que se realizen.


### 5. Ejecutar Seeders
Ejecuta los seeders para la creación de usuarios en la base de datos:

``` sh
docker-compose exec app php artisan db:seed --force
```

### 6. Generar Claves de Passport
Genera las claves necesarias para Laravel Passport:

``` sh
docker-compose exec app php artisan passport:install --force
```
Una vez ejecutado el comando se debe ir confirmando los pasos.

## Acceso a la Aplicación
Una vez que los contenedores estén levantados y las migraciones se hayan ejecutado correctamente, puedes acceder a la aplicación en http://localhost:8000.

## Comandos Útiles
- Levantar los contenedores en segundo plano:

```sh
docker-compose up -d

```

- Ver logs de un contenedor específico:
```sh
docker-compose logs -f <nombre_del_servicio>
```

- Detener los contenedores:
```sh
docker-compose down
```

## Problemas Comunes
### Error: "Key path does not exist or is not readable"
Si ves un error indicando que el archivo de clave no existe o no es legible, asegúrate de que las claves de Passport se han generado correctamente y que los permisos son los adecuados.

``` sh
docker-compose exec app php artisan passport:install --force
docker-compose exec app chown www-data:www-data storage/oauth-public.key storage/oauth-private.key
docker-compose exec app chmod 600 storage/oauth-public.key storage/oauth-private.key

```
## Correr Tests

Para correr los tests en manera local ejecuta el siguiente comando:

```bash
  php artisan test

```


## Potenciales mejoras
Una de las grandes mejoras que se pueden realizar en el proyecto es en el middleware para registrar las interacciones de los usuarios con los servicios, es algo que puede hacerse de forma asincrona y de esta forma se reduciria notablemente el tiempo de response en los servicios.

## Contribuciones
Las contribuciones son bienvenidas. Por favor, abre un issue o un pull request en GitHub.



## Licencia

[MIT](https://choosealicense.com/licenses/mit/)

