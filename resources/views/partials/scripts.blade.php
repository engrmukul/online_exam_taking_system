<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('js/plugins/clockpicker/clockpicker.js') }}"></script>
<script src="{{ asset('js/inspinia.js') }}"></script>

@push('scripts')
    <script>
        var mem = $('#dateItem .input-group.date').datepicker({
            todayBtn: "linked",
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
        });

        $('#datarange .input-daterange').datepicker({
            format: 'yyyy-mm-dd',
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });

        $('.select-2').select2({
            placeholder: 'Select an option'
        });

        $('.clockpicker').clockpicker();

    </script>
