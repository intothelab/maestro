
<!DOCTYPE html>
<html>
  <head>
    <title>{{config('idoc.title')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,800,800i,900,900i" rel="stylesheet">
    <style>

      body {
        margin: 0;
        padding: 0;
        font-family: Verdana, Geneva, sans-serif;
      }

      #redoc_container .menu-content img {
        padding: 0px 0px 30px 0px;
      }
    </style>
    <link rel="stylesheet" href="{{ mix('app.css', 'vendor/nova') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
  </head>
  <body>
    <div id="redoc_container"></div>
    <script src="{{ asset('js/documentation.js') }}"></script>
    <script src="{{ asset('js/console.redocpro.min.js') }}"></script>
    <script>

        RedocPro.init("{{config('idoc.output') . "/openapi.json"}}", {
        unstable_ignoreMimeParameters: true,
        pathInMiddlePanel: true,
        showConsole:true,
        disableSearch:true,
        hideDownloadButton: true,
        noAutoAuth:true,
        unstable_externalDescription: '{{route('idoc.info')}}',
        theme: {
          colors: {
            primary: {
              main: '#6e29e1',
            }
          },

          typography: {
            fontSize: '16px',
            lineHeight: '24px',
            fontWeightRegular: '600',
            fontWeightBold: '800',
            fontWeightLight: '400',
            fontFamily: 'Nunito,system-ui,BlinkMacSystemFont,-apple-system,sans-serif',
            smoothing: 'antialiased',
            optimizeSpeed: true,
            headings: {
              fontFamily: 'Nunito,system-ui,BlinkMacSystemFont,-apple-system,sans-serif',
              fontWeight: '600',
              lineHeight: '1.6em',
            },
            code: {
              color: '#6e29e1',
              backgroundColor: '#e5eefa',
            },
          },

          menu: {
            backgroundColor: "#f4f6f9",
              width: '300px'
          },
          rightPanel: {
            backgroundColor: '#2e2f3e',
            width: '40%',
          },
        }}, document.querySelector('#redoc_container'));

      var constantMock = window.fetch;
      window.fetch = function() {

        if (/\/api/.test(arguments[0]) && !arguments[1].headers.Accept) {
          arguments[1].headers.Accept = 'application/json';
        }

        return constantMock.apply(this, arguments)
      }
    </script>
  </body>
</html>
