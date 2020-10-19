<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>


<h1>{{ $details['title'] }}</h1>
<p>{{ $details['testResult'] }}</p>

<div class="question-1">
    @forelse($details['testResult'] as $key => $question)
        <h3>{{$key+1}}. {{$question->questions}}.</h3>
        @if($question->image)<img src="{{asset('upload/questions/'. $question->image)}}">@endif
        <div class="row mb-3">
            @forelse($question->questions->answers as $index => $answer)
                <div class="pl-4 col-sm-6 d-flex flex-row">
                    <label class="d-block" for="check">{{$answer->answer}}.</label>
                </div>
            @empty
            @endforelse
        </div>
    @empty
    @endforelse
</div>

<p>Thank you</p>
</body>
</html>
