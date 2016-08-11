 <script src="{{ asset('es6-shim/es6-shim.min.js') }}"></script>
 <script src="{{ asset('systemjs/dist/system-polyfills.js') }}"></script>
 
  <script src="{{ asset('angular2/bundles/angular2-polyfills.js') }}"></script>
  <script src="{{ asset('systemjs/dist/system.src.js') }}"></script>
  <script src="{{ asset('rxjs/bundles/Rx.js') }}"></script>
  <script src="{{ asset('angular2/bundles/angular2.dev.js') }}"></script>
 
  <!-- 2. Configure SystemJS -->
  <script>
    System.config({
      "defaultJSExtensions": true,
      packages: {
        app: {
          format: 'register',
          defaultExtension: 'js'
        },
        angular2: {
          formart: 'regitser',
          defaultExtension: 'js'
        }
      },
      map: {
        'angular2': '/ammart/angular2',
        'rxjs': '/ammart/rxjs',
      }
    });
 
 
    System.import("{{ asset('typescript/boot') }}")
          .then(null, console.error.bind(console));
  </script>


<link href="{{ url('/bower_components/angular-loading-bar/src/loading-bar.css') }}" rel="stylesheet">
<link href="{{ url('bower_components/ngDialog/css/ngDialog.min.css') }}" rel="stylesheet">
<link href="{{ url('bower_components/ngDialog/css/ngDialog-theme-default.min.css') }}" rel="stylesheet">
<link href="{{ url('css/app.css') }}" rel="stylesheet">
<link href="{{ url('css/ammart.css') }}" rel="stylesheet">
<link href="{{ url('css/color.css') }}" rel="stylesheet">
<link href="{{ url('css/layout-deprecated.css') }}" rel="stylesheet">
<link href="{{ url('css/layout.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap.override.css') }}" rel="stylesheet">
<link href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">