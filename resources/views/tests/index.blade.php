@extends('app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

    @include('partials.flash')
    <!-- START QUESTION HEADER -->
    <div class="wrapper border-bottom white-bg page-heading borderBottom">
        <div class="admission-title">
            <h1 class="text-capitalize text-center">{{$testInfo->exam->exam_title}} <span class="text-success">{{date('Y')}}</span></h1>

            <hr style="width: 50px; height:1px ;background-color: gray;margin:0 auto 15px auto;">
            <h3 class="text-capitalize text-center">exam date : <span class="text-success"> {{$testInfo->exam->exam_date}}</span></h3>
            <h3 class="text-center text-capitalize">start time : <span class="mr-2 text-success"> {{ date('h:i a', strtotime($testInfo->exam->start_time))}} </span> end time <span class="text-success">{{date('h:i a', strtotime($testInfo->exam->end_time))}}</span></h3>

            <div class="student_name text-center">
                <h3 class="text-capitalize">student name : {{$testInfo->student->username}}</h3>
                <h3 class="text-capitalize">student role : {{$testInfo->student->username}}</h3>
            </div>

            <div class="row text-capitalize">
                <div class="col-sm-4 text-right">
                    <h3>total mark : <span> {{$testInfo->exam->noq}}</span></h3>
                </div>
                <div class="col-sm-4 text-center">
                    <h3 class="text-danger" id="demo"></h3>
                    <span class="d-none text-success" id="success-message">Successfully save your answer</span>
                    <span class="d-none text-danger" id="error-message">Something wrong!</span>
                </div>
                <div class="col-sm-4">
                    @php
                        $end_time = strtotime($testInfo->exam->end_time);
                        $start_time = strtotime($testInfo->exam->start_time);
                        $time = round(abs($end_time - $start_time) / 60,2). " minute";
                    @endphp
                    <h3>time : <span>{{$time}}</span></h3>
                </div>
            </div>
        </div>
    </div>
    <!-- END QUESTION HEADER -->

    <!-- QUESTION LIST -->
    <div class="wrapper wrapper-content questionWrapper">
        <div class="question-1">
            @forelse($questions->shuffle() as $key => $question)
            <h3>{{$key+1}}. {{$question->question}}.</h3>
            @if($question->image)<img src="{{asset('upload/questions/'. $question->image)}}">@endif
            <div class="row mb-3">
                @forelse($question->answers->shuffle() as $index => $answer)
                <div class="pl-4 col-sm-6 d-flex flex-row">
                    <input class="answer" data-question_id="{{$question->id}}" type="radio" @if(in_array($answer->id, $savedAnswers)) checked @endif class="d-block" name="{{$key}}check2" id="check" value="{{$answer->id}}">
                    <label class="d-block" for="check">{{$answer->answer}}.</label>
                </div>
                @empty
                @endforelse
            </div>
             @empty
            @endforelse
        </div>

        <div class="text-center">
            <input id="finished" class="btn btn-success btn-lg mb-5 px-5" type="button" name="Submit" value="Finish">
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        //MENU FIXED
        $(window).on('scroll',function(){
            if ($(window).scrollTop() > '250') {
                $('.borderBottom').addClass('sticky');
            }else{
                $('.borderBottom').removeClass('sticky');
            }
        });

        // Set the date we're counting down to
        var examEndDateTime = "{{ date("F j, Y, g:i a", strtotime($testInfo->exam->exam_date .' ' .$testInfo->exam->end_time)) }}";
        var countDownDate = new Date(examEndDateTime).getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countDownDate - now;
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("demo").innerHTML = hours + "h "
                + minutes + "m " + seconds + "s ";

            if (distance < 0) {
                clearInterval(x);
                examExpired();
                document.getElementById("demo").innerHTML = "EXPIRED";
            }
        }, 1000);


        //ANSWER PROCESS
        $('.answer').on('click', function () {
            var obj = $(this);
            var answer_id = obj.val();
            var question_id = obj.data('question_id');
            var exam_id = "{{ $testInfo->exam->id }}";

            $.ajax({
                type: "POST",
                url: "{{ route('save-answer') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    exam_id: exam_id,
                    question_id: question_id,
                    answer_id: answer_id
                },
                success: function(data) {
                    if(data.status == 'success'){
                        $('#success-message').removeClass('d-none').text(data.message);
                        $('#error-message').addClass('d-none');
                    }else{
                        $('#success-message').addClass('d-none');
                        $('#error-message').removeClass('d-none');
                    }
                },
                error: function(xhr, status, errorThrown) {
                    console.log(xhr.status);
                }
            });
        });

        $('#finished').on('click', function () {
            testFinish();
        });

        function testFinish() {
            var examId = "{{ $testInfo->exam->id }}";
            var url = "{{ URL::to('exam-finish') }}/" + examId;

            $.get(url , function(data, status){
                //location.reload();
            });
        }

        function examExpired() {
            var examId = "{{ $testInfo->exam->id }}";
            var url = "{{ URL::to('exam-expired') }}/" + examId;

            $.get(url , function(data, status){
                testFinish();
            });
        }

    </script>
@endpush
