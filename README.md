## API REST FULL (HYATT REGENCY)

Es una API desarrollada como parte de entrenamiento, es única y exclusivamente para uso educativo. Es un servicio web para una aplicación de Hoteles.

## CONFIGURACION

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
