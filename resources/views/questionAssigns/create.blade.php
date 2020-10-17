@extends('app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    @include('partials.flash')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5><i class="fa fa-book"></i> {{ trans('common.create')}}</h5>
                        <div class="ibox-tools">
                            <a style="margin-top: -8px;" href="{{ route( 'question-assigns.index') }}" class="btn btn-primary"><i
                                    class="fa fa-list"></i> {{ trans('common.list')}}</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <!---FORM--->
                        <form role="form" method="post" action="{{route( 'question-assigns.store')}}">
                            @csrf

                            <!---Exam--->
                            <div class="form-group">
                                <label for="parent">{{ trans('questionAssign.exam')}}</label>
                                <select id="exam_id" class="form-control custom-select mt-15" name="exam_id" required>
                                    <option value="">{{ trans('questionAssign.exam')}}</option>
                                    @foreach($exams as $key => $exam)
                                        @if (old('exam_id') == $exam->exam->id)
                                            <option value="{{ $exam->exam->id }}" selected > {{ $exam->exam->exam_title }} </option>
                                        @else
                                            <option value="{{ $exam->exam->id }}" > {{ $exam->exam->exam_title }} </option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="form-text m-b-none text-danger"> @error('exam_id') {{ $message }} @enderror </span>
                            </div>

                            <!---CUSTOM QUESTION SET GENERATE---->
                            <div class="form-group">
                                <table  class="table table-striped table-bordered table-hover studentTable">
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
                            </div>

                            <!---CONTROL BUTTON--->
                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>{{ trans('common.submit')}}</button>
                                    <a class="btn btn-danger" href="{{route( 'question-papers.index')}}"><i class="fa fa-fw fa-lg fa-arrow-left"></i>{{ trans('common.go_back')}}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
@endpush

@push('scripts')
    <script src="{{asset('js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(function () {
            var columns = eval('{!! json_encode($columns) !!}');

            $('.studentTable').DataTable({
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [

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
                    $("td:first", nRow).html('<input type="checkbox" name="student_id[]" value="'+aData.id+'">');
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
        });

    </script>
@endpush
