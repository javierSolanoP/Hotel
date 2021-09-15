## API REST FULL (HYATT REGENCY)

Es una API desarrollada como parte de entrenamiento, es única y exclusivamente para uso educativo. Es un servicio web para una aplicación de Hoteles.

## CONFIGURACIÓN

1) Para poder utilizar éste servicio web, se deberá instalar el paquete 'Vendor' a través del gestor de dependencias 'Composer', con el siguiente comando:

```
composer install
```
2) Se deverá tener configurado los siguientes parámetros del archivo '.env':

- Asegúrese de crear la DB con el nombre establecido y el 'SGDB' con su respectivo puerto, o de lo contrario deberá cambiarlos en el archivo '.env'.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hyatt-regency
DB_USERNAME=root
DB_PASSWORD=
```
- Para poder hacer uso del protocolo de trasferencia simple de correos electrónicos (SMTP) de 'Google', deberá tener la siguiente configuración en su archivo '.env':

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.googlemail.com
MAIL_PORT=465
MAIL_USERNAME=example@gmail.com
MAIL_PASSWORD=
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=hyatt-regency@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```
- Para poder usar la autenticación de 'Gmail', deberá tener la siguiente configuración en su archivo '.env'
```
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
```
Nota: para obtener el valor de éstos parámetros, deberá crearlos directamente de su cuenta en 'Google Cloud Platform'. 

Ingresando en el siguiente enlace: (https://accounts.google.com/ServiceLogin/signinchooser?service=cloudconsole&passive=1209600&osid=1&continue=https%3A%2F%2Fconsole.cloud.google.com%2F%3Fref%3Dhttps%3A%2F%2Fwww.bing.com%2F&followup=https%3A%2F%2Fconsole.cloud.google.com%2F%3Fref%3Dhttps%3A%2F%2Fwww.bing.com%2F&flowName=GlifWebSignIn&flowEntry=ServiceLogin) 

- Para poder consumir ésta API, se debe inicializar el entorno de desarrollo local, para ésto ejecute el siguiente conmando:
```
php artisan serve
```
### ROUTES

#### Módulo cliente

##### REGISTRO
- Para registrar un cliente utilice el siguiente 'endpoint' y envíe los siguientes datos en formato JSON: 

```
POST: 'http://127.0.0.1:8000/api/clients'
{
    "form": "register",
    "cedula": string,
    "nombre": string,
    "apellido": string,
    "genero": string,
    "edad": string,
    "fecha_nacimiento": string,
    "email": string,
    "password": string,
    "confirmPassword": string,
    "telefono": string
}
```

En caso de una petición satisfactoria, la API devolverá la siguiente respuesta:

```
{
    "register": true,
    "fields": {
        "cedula": true,
        "nombre": true,
        "apellido": true,
        "genero": true,
        "edad": true,
        "fecha_nacimiento": true,
        "email": true,
        "telefono": true
    }
}
```
En caso de una petición NO satisfactoria, la API devolverá la siguiente respuesta:

```
{
    "register": false,
    "Error": ///Descripcion del error
}
```
##### INICIAR SESIÓN
- Para inicio de sesión de manera manual, utilice el siguiente 'endpoint' y envíe los siguientes datos en formato JSON: 

```
POST: 'http://127.0.0.1:8000/api/clients'
{
    "form": "login",
    "email": string,
    "password": string
}
```
En caso de una petición satisfactoria, la API devolverá la siguiente respuesta:

```
{
    "login": true
}
```
En caso de una petición NO satisfactoria, la API devolverá la siguiente respuesta:

```
{
    "login": false,
    "Error": //Descripcion del error
}
```

- Para inicio de sesión a través del provedor de 'Gmail', utilice el siguiente 'endpoint'.

```
GET: 'http://127.0.0.1:8000/auth/redirect'
```

- Para restablecer contraseña, asegúrese de que el email del usuario pertenezca al proveedor de Google. Utilice el siguiente 'endpoint', y envíe los siguientes datos en formato JSON:

1) Enviar el correo de restablecimiento: 
```
POST: 'http://127.0.0.1:8000/api/clients'
{
    "form": "restorePassword",
    "email": string,
    "url" : string //URL del formulario al que sera redireccionado el cliente.
}
```
En caso de una petición satisfactoria, la API devolverá la siguiente respuesta:
```
{
    "restorePassword": true,
}
```
En caso de una petición NO satisfactoria, la API devolverá la siguiente respuesta:
```
{
    "restorePassword": false,
    "Error": //Descripcion del error.
}
```

2) Restablecer con la nueva contraseña. Una vez el usuario ingrese la nueva contraseña, se deberá enviar esos datos al siguiente 'enpoint' y con los siguientes datos en formato JSON:
```
POST: 'http://127.0.0.1:8000/api/clients'
{
    "form": "restorePassword",
    "email": string,
    "newPassword": string,
    "confirmPassword": string
}
```
En caso de una petición satisfactoria, la API devolverá la siguiente respuesta:
```
{
    "restorePassword": true,
}
```
En caso de una petición NO satisfactoria, la API devolverá la siguiente respuesta:
```
{
    "restorePassword": false,
    "Error": //Descripcion del error.
}
```

3) Validar tiempo límite para restablecimiento. Por defecto, la API asigna un tiempo límite de 10 minutos para realizar el restablecimiento. Pasado el tiempo límite, deverá realizar nuevamente la petición con los siguientes datos en formato JSON:
```
POST: 'http://127.0.0.1:8000/api/clients'
{
    "form": "restorePassword",
    "email": string
}
```
La API cambiará el estado de la sesión,y devolverá la siguiente respuesta:
```
{
    "restorePassword": false,
    "Error": "Ha excedido el tiempo limite de espera."
}
```
##### CERRAR SESIÓN

Para cerrar sesión en el sistema, utilice el siguiente 'endpoint' y envíe los siguientes datos en formato JSON:

```
POST: 'http://127.0.0.1:8000/api/clients'
{
    "form": "closeLogin",
    "email": string
}
```
En caso de una petición satisfactoria, la API devolverá la siguiente respuesta:
```
{
    "closeLogin": true
}
```
En caso de una petición NO satisfactoria, la API devolverá la siguiente respuesta:
```
{
    "closeLogin": false,
    "Error": //Descripcion del error.
}
```

##### OBTENER INFORMACIÓN DEL CLIENTE
Para acceder a la información de un cliente en específico, utilice el siguiente 'endpoint' y envíe el argumento correspondiente: 

```
GET: 'http://127.0.0.1:8000/api/clients/{email}'
```
En caso de una petición satisfactoria, la API devolverá la siguiente respuesta:
```
{
    "id_cliente": int,
    "cedula": string,
    "nombre": string,
    "apellido": string,
    "genero": string,
    "edad": int,
    "fecha_nacimiento": string,
    "email": string,
    "sesion": string, //Estado de la sesion actual.
    "avatar": string, //URL del avatar del usuario.
    "created_at": string, //Fecha en la que se realizo el registro.
    "updated_at": string //Fecha de la ultima actualizacion del registro.
}
```
En caso de una petición NO satisfactoria, la API devolverá la siguiente respuesta:
```
{
    "Error": //Descripcion del error.
}
```

##### ACTUALIZAR INFORMACIÓN DEL CLIENTE
- Para actualizar la información de un cliente en específico, utilice el siguiente 'endpoint', y envíe los siguientes datos en formato JSON: 

```
PUT/PATCH: 'http://127.0.0.1:8000/api/clients/update'
{
    "email": string,
    "newPassword": string,
    "confirmPassword": string,
    "telefono": string
}
```

En caso de una petición satisfactoria, la API devolverá la siguiente respuesta: 

```
{
    "register": true,
    "fields": {
        "telefono": true
    }
}
```
En caso de una petición NO satisfactoria, la API devolverá la siguiente respuesta:

```
{
    "register": false,
    "Error": ///Descripcion del error
}
```

##### ELIMINAR UN CLIENTE

- Para eliminar un cliente en específico, utilice el siguiente 'endpoint', y envíe el argumento correspondiente :

```
DELETE: 'http://127.0.0.1:8000/api/clients/{email}'
```

En caso de una petición satisfactoria, la API devolverá la siguiente respuesta:

```
{
    "Delete" : true
}
```

En caso de una petición NO satisfactoria, la API devolverá la siguiente respuesta: 

```
{
    "Delete" : false,
    "Error" : //Descripcion del error.
}
```

#### Módulo administrador

##### REGISTRO
- Para registrar un administrador utilice el siguiente 'endpoint' y envíe los siguientes datos en formato JSON: 

```
POST: 'http://127.0.0.1:8000/api/admin-root'
{
    "form": "register",
    "nombre": string,
    "apellido": string,
    "email": string,
    "password": string,
    "confirmPassword": string
}
```
- Para registrar un recepcionista utilice el siguiente 'endpoint' y envíe los siguientes datos en formato JSON:

```
POST: 'http://127.0.0.1:8000/api/admin-reception'
{
    "form": "register",
    "nombre": string,
    "apellido": string,
    "email": string,
    "password": string,
    "confirmPassword": string,
    "telefono": string
}
```

En caso de una petición satisfactoria, la API devolverá la siguiente respuesta:

```
{
    "register": true,
    "fields": {
        "nombre": true,
        "apellido": true,
        "email": true,
        "telefono": true
    }
}
```
En caso de una petición NO satisfactoria, la API devolverá la siguiente respuesta:

```
{
    "register": false,
    "Error": ///Descripcion del error
}
```
##### INICIAR SESIÓN
- Para inicio de sesión de manera manual de un administrador, utilice el siguiente 'endpoint' y envíe los siguientes datos en formato JSON: 

```
POST: 'http://127.0.0.1:8000/api/admin-root'
{
    "form": "login",
    "email": string,
    "password": string
}
```

- Para inicio de sesión de manera manual de un recepcionista, utilice el siguiente 'endpoint' y envíe los siguientes datos en formato JSON: 

```
POST: 'http://127.0.0.1:8000/api/admin-reception'
{
    "form": "login",
    "email": string,
    "password": string
}
```
En caso de una petición satisfactoria, la API devolverá la siguiente respuesta:

```
{
    "login": true
}
```
En caso de una petición NO satisfactoria, la API devolverá la siguiente respuesta:

```
{
    "login": false,
    "Error": //Descripcion del error
}
```

- Para inicio de sesión a través del provedor de 'Gmail', utilice el siguiente 'endpoint'.

```
GET: 'http://127.0.0.1:8000/auth/redirect'
```

- Para restablecer contraseña, asegúrese de que el email del usuario pertenezca al proveedor de Google. Utilice el siguiente 'endpoint', y envíe los siguientes datos en formato JSON:

1) Enviar el correo de restablecimiento: 

Administrador: 
```
POST: 'http://127.0.0.1:8000/api/admin-root'
{
    "form": "restorePassword",
    "email": string,
    "url" : string //URL del formulario al que sera redireccionado el cliente.
}
```
Recepcionista:
```
POST: 'http://127.0.0.1:8000/api/admin-reception'
{
    "form": "restorePassword",
    "email": string,
    "url" : string //URL del formulario al que sera redireccionado el cliente.
}
```
En caso de una petición satisfactoria, la API devolverá la siguiente respuesta:
```
{
    "restorePassword": true,
}
```
En caso de una petición NO satisfactoria, la API devolverá la siguiente respuesta:
```
{
    "restorePassword": false,
    "Error": //Descripcion del error.
}
```

2) Restablecer con la nueva contraseña. Una vez el usuario ingrese la nueva contraseña, se deberá enviar esos datos al siguiente 'enpoint' y con los siguientes datos en formato JSON:

Administrador: 
```
POST: 'http://127.0.0.1:8000/api/admin-root'
{
    "form": "restorePassword",
    "email": string,
    "newPassword": string,
    "confirmPassword": string
}
```
Recepcionista:
```
POST: 'http://127.0.0.1:8000/api/admin-reception'
{
    "form": "restorePassword",
    "email": string,
    "newPassword": string,
    "confirmPassword": string
}
```
En caso de una petición satisfactoria, la API devolverá la siguiente respuesta:
```
{
    "restorePassword": true,
}
```
En caso de una petición NO satisfactoria, la API devolverá la siguiente respuesta:
```
{
    "restorePassword": false,
    "Error": //Descripcion del error.
}
```

3) Validar tiempo límite para restablecimiento. Por defecto, la API asigna un tiempo límite de 10 minutos para realizar el restablecimiento. Pasado el tiempo límite, deverá realizar nuevamente la petición con los siguientes datos en formato JSON:

Administrador: 
```
POST: 'http://127.0.0.1:8000/api/admin-root'
{
    "form": "restorePassword",
    "email": string
}
```
Recepcionista: 
```
POST: 'http://127.0.0.1:8000/api/admin-reception'
{
    "form": "restorePassword",
    "email": string
}
```
La API cambiará el estado de la sesión,y devolverá la siguiente respuesta:
```
{
    "restorePassword": false,
    "Error": "Ha excedido el tiempo limite de espera."
}
```
##### CERRAR SESIÓN

Para cerrar sesión en el sistema, utilice el siguiente 'endpoint' y envíe los siguientes datos en formato JSON:

Administrador: 
```
POST: 'http://127.0.0.1:8000/api/admin-root'
{
    "form": "closeLogin",
    "email": string
}
```
Recepcionista: 
```
POST: 'http://127.0.0.1:8000/api/admin-reception'
{
    "form": "closeLogin",
    "email": string
}
```
En caso de una petición satisfactoria, la API devolverá la siguiente respuesta:
```
{
    "closeLogin": true
}
```
En caso de una petición NO satisfactoria, la API devolverá la siguiente respuesta:
```
{
    "closeLogin": false,
    "Error": //Descripcion del error.
}
```

##### OBTENER INFORMACIÓN DEL CLIENTE
- Para acceder a la información de un administrador en específico, utilice el siguiente 'endpoint' y envíe el argumento correspondiente: 

```
GET: 'http://127.0.0.1:8000/api/admin-root/{email}'
```

- Para acceder a la información de un recepcionista en específico, utilice el siguiente 'endpoint' y envíe el argumento correspondiente: 

```
GET: 'http://127.0.0.1:8000/api/admin-reception/{email}'
```
En caso de una petición satisfactoria, la API devolverá la siguiente respuesta:
```
{
    "id": int,
    "nombre": string,
    "apellido": string,
    "email": string,
    "sesion": string, //Estado de la sesion actual.
    "avatar": string, //URL del avatar del usuario.
    "created_at": string, //Fecha en la que se realizo el registro.
    "updated_at": string //Fecha de la ultima actualizacion del registro.
}
```
En caso de una petición NO satisfactoria, la API devolverá la siguiente respuesta:
```
{
    "Error": //Descripcion del error.
}
```

##### ACTUALIZAR INFORMACIÓN DEL USUARIO
- Para actualizar la información de un usuario en específico, utilice el siguiente 'endpoint', y envíe los siguientes datos en formato JSON: 

Administrador: 
```
PUT/PATCH: 'http://127.0.0.1:8000/api/admin-root/update'
{
    "email": string,
    "password": string,
    "confirmPassword": string,
    "telefono": string
}
```
Recepcionista: 
```
PUT/PATCH: 'http://127.0.0.1:8000/api/admin-reception/update'
{
    "email": string,
    "password": string,
    "confirmPassword": string,
    "telefono": string
}
```

En caso de una petición satisfactoria, la API devolverá la siguiente respuesta: 

```
{
    "register": true,
    "fields": {
        "telefono": true
    }
}
```
En caso de una petición NO satisfactoria, la API devolverá la siguiente respuesta:

```
{
    "register": false,
    "Error": ///Descripcion del error
}
```

##### ELIMINAR UN USUARIO

- Para eliminar un usuario en específico, utilice el siguiente 'endpoint', y envíe el argumento correspondiente :

Administrador: 
```
DELETE: 'http://127.0.0.1:8000/api/admin-root/{email}'
```

Recepcionista: 
```
DELETE: 'http://127.0.0.1:8000/api/admin-reception/{email}'
```

En caso de una petición satisfactoria, la API devolverá la siguiente respuesta:

```
{
    "Delete" : true
}
```

En caso de una petición NO satisfactoria, la API devolverá la siguiente respuesta: 

```
{
    "Delete" : false,
    "Error" : //Descripcion del error.
}
```