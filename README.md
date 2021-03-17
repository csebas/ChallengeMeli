# Challenge para CloudSec Mercado Libre

Desafio que me envio Mercado Libre como prueba de conocimiento en la entrevista laboral. El mismo consiste de obtener IPs de salida de TOR desde una web [activa al 17/03/2021] y otras funcionalidades.

### Pre-requisitos

● Docker

● Git 

## Endpoints

● leerIps: Devuelve las Ips de la página web obteniendo las mismas de la base de datos
local.
```
$ curl http(s)://<ip>/leerIps
```
● leerIpsFiltrados: Devuelve las Ips de la web menos las que están en la BD de filtrados
```
$ curl http(s)://<ip>/leerIpsFiltrados
```
● agregarIpAFiltro: Carga un Ip enviado por parámetro a la BD de Ips filtrados.
```
$ curl -d “ip=127.0.0.1” http(s)://<ip>/cargarIpAFiltro
```
● borrarIpDeFiltro: Borra la ip en caso de encontrarse en la BD.
```
$ curl -d “ip=127.0.0.1” http(s)://<ip>/borrarIpDeFiltro
```

● cargarIpsDeLaWeb: Carga inicial de los Ips a la base de datos.

## Despliegue

Agrega notas adicionales sobre como hacer deploy_


Pasos para ejecutar correctamente la solución
1. Clonar el repositorio.
```
$ git clone <direccion del repositorio>
```
2. Crear una red en modo bridge:
```
$ docker network create <nombre de la red>
```
3. Crear las imágenes dockerizadas del WebServer y la BD:
Situarse en cada carpeta y realizar
```
$ docker build - t <nombre>:tag .
```
4. Desplegar la Base de datos:
```
$ docker run -d --network <nombre de la red> --network-alias mysql --name basededatos <id imagen de la base de datos creada en punto 3>
```
5. Desplegar el Web Server:
```
$ docker run -dp “9080:80” -p “9443:443” --network mired --network-alias webserver --name webserver <id imagen del webserver creada en punto 3
```

Con estos pasos quedaría desplegada la solución.
