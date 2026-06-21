<!-- Required Jquery -->
    <script type="text/javascript" src="{{ asset('mega/assets/js/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mega/assets/js/jquery-ui/jquery-ui.min.js') }} "></script>
    <script type="text/javascript" src="{{ asset('mega/assets/js/popper.js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mega/assets/js/bootstrap/js/bootstrap.min.js') }} "></script>
    <script type="text/javascript" src="{{ asset('mega/assets/pages/widget/excanvas.js') }} "></script>
    <!-- waves js -->
    <script src="{{ asset('mega/assets/pages/waves/js/waves.min.js') }}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{ asset('mega/assets/js/jquery-slimscroll/jquery.slimscroll.js') }} "></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{ asset('mega/assets/js/modernizr/modernizr.js') }} "></script>
    <!-- slimscroll js -->
    <script type="text/javascript" src="{{ asset('mega/assets/js/SmoothScroll.js') }}"></script>
    <script src="{{ asset('mega/assets/js/jquery.mCustomScrollbar.concat.min.js') }} "></script>
    <!-- Chart js -->
    <script type="text/javascript" src="{{ asset('mega/assets/js/chart.js/Chart.js') }}"></script>
    <!-- amchart js -->
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="{{ asset('mega/assets/pages/widget/amchart/gauge.js') }}"></script>
    <script src="{{ asset('mega/assets/pages/widget/amchart/serial.js') }}"></script>
    <script src="{{ asset('mega/assets/pages/widget/amchart/light.js') }}"></script>
    <script src="{{ asset('mega/assets/pages/widget/amchart/pie.min.js') }}"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <!-- menu js -->
    <script src="{{ asset('mega/assets/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('mega/assets/js/vertical-layout.min.js') }} "></script>
    <!-- custom js -->
    <script type="text/javascript" src="{{ asset('mega/assets/pages/dashboard/custom-dashboard.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mega/assets/js/script.js') }} "></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>

@session('success')
    <script>
        Swal.fire({
            title: "Berhasil",
            text: "{{ session('success') }}",
            icon: "success"
        });
    </script>
@endsession

@session('error')
    <script>
        Swal.fire({
            title: "Gagal",
            text: "{{ session('error') }}",
            icon: "error"
        });
    </script>
@endsession