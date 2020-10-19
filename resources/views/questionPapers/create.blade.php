@extends('app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    @include('partials.flash')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5><i class="fa fa-book"></i> Question Paper{{ trans('common.create')}}</h5>
                        <div class="ibox-tools">
                            <a style="margin-top: -8px;" href="{{ route( 'question-papers.index') }}" class="btn btn-primary"><i
                                    class="fa fa-list"></i> {{ trans('common.list')}}</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <!---FORM--->
                        <form role="form" method="post" action="{{route( 'question-papers.store')}}">
                            @csrf

                            <!---Exam--->
                            <div class="form-group">
                                <label for="parent">{{ trans('questionPaper.exam')}}</label>
                                <select id="exam_id" class="form-control custom-select mt-15" name="exam_id" required>
                                    <option value="">{{ trans('questionPaper.exam')}}</option>
                                    @foreach($exams as $key => $exam)
                                        @if (old('exam_id') == $exam->id)
                                            <option value="{{ $exam->id }}" selected data-subject_id="{{$exam->subject_id}}" data-noq="{{$exam->noq}}"> {{ $exam->exam_title }} </option>
                                        @else
                                            <option value="{{ $exam->id }}" data-subject_id="{{$exam->subject_id}}" data-noq="{{$exam->noq}}"> {{ $exam->exam_title }} </option>
                                        @endif
                                    @endforeach
                                </select>
                                <input id="totalquestions" type="hidden" name="totalquestions" value="">
                                <input id="subject" type="hidden" name="subject_id" value="">
                                <span class="form-text m-b-none text-danger"> @error('exam_id') {{ $message }} @enderror </span>
                            </div>

                            <!---Question Set--->
                            <div class="form-group">
                                <label for="noqs" class="font-bold">{{ trans('questionPaper.noqs')}}</label>
                                <input type="text" name="noqs" readonly value="{{ old('noqs', 4) }}" placeholder="{{ trans('questionPaper.noqs')}}" maxlength="1" class="form-control" required>
                                <span class="form-text m-b-none text-danger"> @error('noqs') {{ $message }} @enderror </span>
                            </div>

                            <!---Generate By--->
                            <div class="form-group">
                                <label for="exam_status">{{ trans('questionPaper.generate_by')}}</label>
                                <select id="generate_by" class="form-control generate_by custom-select mt-15" name="generate_by" required>
                                    <option value="">{{ trans('questionPaper.generate_by')}}</option>
                                    <option value="machine">Machine Generate</option>
                                    <option value="custom">Custom Generate</option>
                                </select>
                                <span class="form-text m-b-none text-danger"> @error('generate_by') {{ $message }} @enderror </span>
                            </div>

                            <div id="customGenerate" class="d-none">
                                <!---Question Set INPUT--->
                                <div class="form-group">
                                    <input type="text" name="question_set[]" value="{{ old('question_set[]', 'Set A') }}" placeholder="{{ trans('questionPaper.question_set')}}" maxlength="100" class="form-control col-md-5" required>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="question_set[]" value="{{ old('question_set[]', 'Set B') }}" placeholder="{{ trans('questionPaper.question_set')}}" maxlength="100" class="form-control col-md-5" required>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="question_set[]" value="{{ old('question_set[]', 'Set C') }}" placeholder="{{ trans('questionPaper.question_set')}}" maxlength="100" class="form-control col-md-5" required>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="question_set[]" value="{{ old('question_set[]', 'Set D') }}" placeholder="{{ trans('questionPaper.question_set')}}" maxlength="100" class="form-control col-md-5" required>
                                </div>

                                <!---CUSTOM QUESTION SET GENERATE---->
                                <div class="form-group">
                                    <table  class="table table-striped table-bordered table-hover questionTables">
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
            $('#totalquestions').val('')
            var columns = eval('{!! json_encode($columns) !!}');

            $('.questionTables').DataTable({
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
                    $("td:first", nRow).html('<input type="checkbox" name="question_ids[]" value="'+aData.id+'">');
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

        $('.generate_by').on('change', function () {
            if($(this).val() == 'custom'){
                $('#customGenerate').removeClass('d-none');
                $('#customGenerate').addClass('block');
            }else{
                $('#customGenerate').removeClass('block');
                $('#customGenerate').addClass('d-none');
            }
        });

        $('#exam_id').on('change', function () {
            var obj = $(this);

            var totalquestions = obj.find(':selected').attr('data-noq')
            var subject_id = obj.find(':selected').attr('data-subject_id')

            $('#totalquestions').val(totalquestions);
            $('#subject').val(subject_id);
        })
    </script>
@endpush
