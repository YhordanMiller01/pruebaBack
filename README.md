# docker-info

Docker con Apache, MySQL 8.0, PHPMyAdmin y PHP.

Uso docker-compose como orquestador. Para ejecutar estos contenedores:

```
docker-compose up -d
```

Abra phpmyadmin en [http://127.0.0.1:8000](http://127.0.0.1:8000)

Abra el navegador web para ver el proyecto php en   [http://127.0.0.1:8080/public/usuarios](http://127.0.0.1:8080/public/usuarios)

Ejecute el cliente MySQL:

- `docker-compose exec db mysql -u root -p` 

Se agrega en la carpeta Coleccion los endpoints para consumir

