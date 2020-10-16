@push('style')
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
@endpush

<table id="dataTable" class="table table-striped table-bordered table-hover dataTables">
    <thead>
    <tr>
        @foreach ($tableHeads as $key => $title)
            <th>{{ ucfirst(str_replace('_',' ',$title))}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>


@push('scripts')
    <script src="{{asset('js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(function () {
            var columns = eval('{!! json_encode($columns) !!}');

            $('.dataTables').DataTable({
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {
                        extend: 'print',
                        customize: function (win) {
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search",
                    paginate: {
                        "previous": "Previous",
                        "next": "Next",
                        "first": "First",
                        "last": "Last",
                    }
                },
                lengthMenu: [
                    [10, 20, 50, 100, 150, 200, -1],
                    [10, 20, 50, 100, 150, 200, "All"]
                ],
                bInfo : false,
                pageLength: 10,
                pagingType: "full_numbers",
                order: [
                    [0, "desc"]
                ],
                processing: true,
                serverSide: true,
                fnRowCallback: function (nRow, aData, iDisplayIndex) {
                    $("td:first", nRow).html(iDisplayIndex + 1);
                    return nRow;
                },
                ajax: {
                    url: '{{ url($dataUrl) }}',
                    data: function (e) {
                        var fields = $('#searchForm').serializeArray();
                        $.each(fields, function (i, field) {
                            e[field.name] = field.value;
                        });
                    }
                },
                columns: columns
            });

            $('#searchForm').submit(function (e) {
                e.preventDefault();
                dataTable.draw();
            });

            $('.reset').click(function (e) {
                e.preventDefault();
                $('#searchForm').trigger("reset");
                dataTable.draw();
            });
        });
    </script>
@endpush
