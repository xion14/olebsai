<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Seller &mdash; Olebsai</title>

  <link rel="shortcut icon" href="{{ asset('assets/image/brand/logo-brand.png') }}" type="image/x-icon">
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/panel/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/panel/modules/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('assets/panel/modules/jqvmap/dist/jqvmap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/panel/modules/weather-icon/css/weather-icons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/panel/modules/weather-icon/css/weather-icons-wind.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/panel/modules/summernote/summernote-bs4.css') }}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/panel/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/panel/css/components.css') }}">

  <link href="{{ asset('assets/datatables/datatables.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">


  <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
  <script>
Dropzone.options.myDropzone = { // The camelized version of the ID of the form element

  // The configuration we've talked about above
  autoProcessQueue: false,
  uploadMultiple: true,
  parallelUploads: 100,
  maxFiles: 100,
  acceptedFiles: ".jpeg,.jpg,.png,.gif",
  dictFileTooBig: 'Image is bigger than 5MB',
  addRemoveLinks: true,

  // The setting up of the dropzone
  init: function() {
    var myDropzone = this;

    // First change the button to actually tell Dropzone to process the queue.
    this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
      // Make sure that the form isn't actually being sent.
      e.preventDefault();
      e.stopPropagation();
      myDropzone.processQueue();
    });

    // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
    // of the sending event because uploadMultiple is set to true.
    this.on("sendingmultiple", function() {
      // Gets triggered when the form is actually being sent.
      // Hide the success button or the complete form.
    });
    this.on("successmultiple", function(files, response) {
      // Gets triggered when the files have successfully been sent.
      // Redirect user or notify of success.
    });
    this.on("errormultiple", function(files, response) {
      // Gets triggered when there was an error sending the files.
      // Maybe show form again, and notify user of error
    });
  }
 
}

</script>

  <style>
    .dropdown-list .dropdown-list-content:not(.is-end):after {
      height: 10px !important;
    }
  </style>
  @yield('head')
</head>
<body>
    <div id="app">
    
    @include('__layouts.__seller.sidebar')

    @include('__layouts.__seller.header')

    @yield('body')
    @yield('modal')
    </div>
  @include('__layouts.__seller.script')
  @yield('script')
</body>

</html>