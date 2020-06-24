<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Nunito', sans-serif;
            }

            body {
                width: 100%;
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            fieldset {
                font-size: 1.2em;
                font-family: 'Nunito', sans-serif;
                font-weight: bold;
                border: 1px solid #aaa;
                border-radius: 10px;
                padding: 50px;
            }

            input[type="file"] {
                border: 1px solid #aaa;
                padding: 20px 50px;
                border-radius: 10px;
            }

            input[type="submit"] {
                width: 100%;
                height: 40px;
                margin: 10px 0;
                cursor: pointer;
                font-weight: bold;
            }

        </style>
    </head>
    <body>
        <fieldset>
            <legend>Enviar Planilha de Resíduos</legend>
            <form method="POST" action="{{url('api/v1/wastes')}}" enctype="multipart/form-data">
                <input type="file" name="spreadsheet" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"/>
                <input type="submit" value="Enviar"/>
            </form>
        </fieldset>
    </body>
</html>
