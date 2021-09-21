<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- BootStrap V.5.0.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Error</title>
    <style>
        *{
            padding: 0
        }
        article{
            width: 100vw;
            height: 100vh
        }
        .head{
            height: 40vh
        }
        section{
            height: 60%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .card{
            width: 40%;
            height: 90%;
            position: relative;
            margin-top: -18%;
            box-shadow: 0.3rem 0.3rem 1rem black;
            display: flex;
            align-items: center
        }
        .container-cancel{
            width: 95%;
            height: 30%;
            border-bottom: 1rem black;
            display: flex;
            justify-content: space-between;
            align-items: center
        }
        h1{
            width: 100%;
            height: 40%;
            font-size: 150%;
            text-align: center
        }
        .container-message{
            width: 95%;
            height: 70%;
            border-bottom: 1rem black;
            display: flex;
            justify-content: center;
            align-items: center
        }
        .container-icon{
            width: 40%;
            height: 100%
        }
        .cancel-icon{
            width: 90%;
            height: 90%
        }
        .error-message{
            width: 50%;
            height: 70%;
            font-size: 90%
        }
    </style>
</head>
<body>
    <article>
       <div class="head btn-danger"></div>
       <section>
        <div class="card">
            <div class="container-cancel"> 
                <h1><strong>Acceso denegado</strong></h1>
            </div>
            <div class="container-message">
                <div class="container-icon">
                    <img class="cancel-icon" src="undraw_cancel_u1it.svg" alt="Icono de error">
                </div>
                <p class="error-message"><strong>{{$error}}</strong></p>
            </div>
        </div>
        <br>
        <a href="https://www.{{$urlFail}}.com">Volver a la página de inicio</a>
       </section>
    </article>
</body>
</html>