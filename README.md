# API Users Big

_Aplicación web construida con Laravel 9 (Laravel Sail) y Boostrap 5_

## Comenzando 🚀

_Estas instrucciones te permitirán obtener una copia del proyecto en funcionamiento en tu máquina local para propósitos de desarrollo y pruebas._

Mira **Deployment** para conocer como desplegar el proyecto.


### Pre-requisitos 📋

_Que cosas necesitas para instalar el software y como instalarlas_

```
Docker y Docker Compose
Composer
```

### Instalación 🔧

_Clonar el repositorio desde GitHub desde la consola de comandos o desde la terminal de su IDE_
```
git clone git@github.com:mauriciomartinezc/api-users-big
```

_Dirigirse a la carpeta api-users-big e ingresar en la consola de comandos o desde la terminal de su IDE_
```
composer install
```

_Luego de haber instalado las dependencias ejecutaremos el comando para crear el grupo de contenedores, tenga en cuenta que nuestro contenedor se van a ejecutar en los siguientes puertos 80 y 3306_
```
./vendor/bin/sail up
```

_Ejecutamos las migraciones creadas de las tablas requeridas las cuales son clients, transactions, logs y synchronization_parameters_
```
./vendor/bin/sail artisan migrate
```

## Ejecutando las pruebas ⚙️

_Todo el entorno se ejecutará en [Localhost](http://localhost/) por lo cual las rutas disponibles son las siguientes_

* [http://localhost/](http://localhost/) - Listado de clientes
* [http://localhost/1](http://localhost/1) - Listado de transacciones por cliente
* [http://localhost/clients/sync](http://localhost/clients/sync) - Sincronización de clientes

## Autores ✒️

* **Mauricio Martinez Chaves** - *Trabajo Inicial* - [mauriciomartinezc](https://github.com/mauriciomartinezc)
---
⌨️ con ❤️ por [mauriciomartinezc](https://github.com/mauriciomartinezc) 😊
