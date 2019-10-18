# Student School Manager (SSManager - Español)

Student School Manager es un proyecto de grado realizado por un compañero y yo entre el 2016 - 2017.

Para poder usarse, debe de importarse la base de datos, la cual está en la carpeta `db`. Este proyecto fue desarrollado con el paquete de XAMPP (phpMyAdmin, Apache y MariaDB).

## ¿Cómo arrancar SSManager?

La versión original no contenía el archivo de `Dockerfile` ni tampoco el `docker-compose.yml`. Esta versión publica en GitHub se ha configurado con el fin de que pueda ser usada mediante Docker, esto implica, adicionalmente, cambios en la dirección de host de la base de datos. Sigue los siguientes pasos:

1. Ejecuta `docker compose up` en una shell.
2. Ingresa a phpMyAdmin. Debe de arrancar en el puerto 8080 del equipo. [Clic aquí para ir a phpMyAdmin.](http://localhost:8080)
3. Ingresa con el usuario root, cuando se realizó el proyecto, este usuario fue usado, y sin clave.
4. Crea una base de datos con el juego de caracteres utf8_mb4_general_ci o utf8_general_ci.
5. Selecciona la base de datos, y luego, importa el archivo SQL (`db/ssmanager.sql`).
6. Ya podrás ingresar a SSManager. El puerto por defecto para usar el aplicativo es el 80. [Clic aquí para ir a SSManager.](http://localhost)

No hace falta decir que este proyecto no tiene garantia, y fue desarrollado cuando estaba aprendiendo acerca del desarrollo de software. Usar bajo su propio riesgo.

# Student School Manager (SSManager - English)

Student School Manager was the final project made by a classmate and me between 2016 - 2017.

To use this, you must import the database, located in the `db` folder. This project was developed with the XAMPP package (phpMyAdmin, Apache and MariaDB).

## How to launch SSManager?

The original release didn't contain a `Dockerfile` nor the `docker-compose.yml` file. This public release on GitHub has been configured in order to be use with Docker, which implies, additionally, changes in the host address of the database in the project. Follow the next steps: 

1. Execute `docker compose up` within a shell.
2. Go to phpMyAdmin. It should have launched in the port 8080 within your computer. [Click here to go to phpMyAdmin.](http://localhost:8080)
3. Log in with the root user. When the project was developed, this was the user that was used, without password.
4. Create a database with the character set utf8_mb4_general_ci o utf8_general_ci.
5. Select the database, and then, import the SQL file (`db/ssmanager.sql`).
6. You can now use SSManager. The default port to use the app is 80. 
6. Ya podrás ingresar a SSManager. El puerto por defecto para usar el aplicativo es el 80. [Click here to go to SSManager.](http://localhost)

Needless to say, this project has no warranty and it was developed when I was starting in software development. Use at your own risk.