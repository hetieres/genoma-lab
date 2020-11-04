<!DOCTYPE html>
<html>
    <head>
        <title>Service Unavailable</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato', sans-serif;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 92px;
                font-weight: bold;
                margin: 0;
            }

            .text {
                font-size: 68px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">503</div>
                <div class="text">o serviço está indisponível no momento</div>
            </div>
        </div>

        @if(app()->bound('sentry') && !empty(Sentry::getLastEventID()))
            <div class="subtitle">Error ID: {{ Sentry::getLastEventID() }}</div>

            <!-- Sentry JS SDK 2.1.+ required -->
            <script src="https://cdn.ravenjs.com/3.3.0/raven.min.js"></script>

            <script>
                Raven.showReportDialog({
                    eventId: '{{ Sentry::getLastEventID() }}',
                    // use the public DSN (dont include your secret!)
                    dsn: 'https://e9ebbd88548a441288393c457ec90441@sentry.io/3235',
                    user: {
                        'name': 'Fabio Kozlowski',
                        'email': 'fabio@studiowoz.com.br',
                    }
                });
            </script>
        @endif
    </body>
</html>
