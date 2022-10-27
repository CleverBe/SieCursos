<!-- SCRIPTS PLANTILLA -->
<script src="{{ asset('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="{{ asset('assets/js/custom.js') }}"></script>

{{-- SCRIPTS PERSONALIZADOS --}}
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/notification/snackbar/snackbar.min.js') }}"></script>
<script src="{{ asset('plugins/nicescroll/nicescroll.js') }}"></script>
<script src="{{ asset('plugins/currency/currency.js') }}"></script>

<script src="{{ asset('plugins/highlight/highlight.pack.js') }}"></script>
<script src="{{ asset('assets/js/scrollspyNav.js') }}"></script>

<script src="{{ asset('plugins/blockui/jquery.blockUI.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>

{{-- NOTY --}}
<script>
    function noty(msg, option = '1') {
        Snackbar.show({
            text: msg,
            actionText: 'Cerrar',
            actionTextColor: '#fff',
            backgroundColor: option == 1 ? '#5c1ac3' : (option == 2 ? '#2196f3' : '#e7515a'),
            pos: 'top-right'
        });
    }
</script>

@livewireScripts
