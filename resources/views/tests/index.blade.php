@extends('app')
@section('title') {{ $pageTitle }} @endsection

    <style>
        /* question css */
        .questionWrapper{
            padding: 20px 80px !important;
            background: #e0e0e0;
        }

        .wrapper.border-bottom.white-bg.page-heading.borderBottom{
            border-bottom: 1px dashed #1c84c6 !important;
            padding: 0 10px 10px 10px;
            background: #c7c7c7;
        }

        /*.question form .row .col-sm-6.pl-4{
              padding-left: 34px !important;
        }
        */
        input#check {
            margin-right: 7px;
        }

        .footer.bg-dark .row p{
            margin-top: -2px !important;
            margin-bottom: -5px !important;
        }

        input#check:focus{
            outline:none;
        }
    </style>

@section('content')

    @include('partials.flash')
    <!-- START QUESTION HEADER -->
    <div class="wrapper border-bottom white-bg page-heading borderBottom">
        <div class="admission-title">
            <h1 class="text-capitalize text-center">admissin test <span class="text-success">2020</span></h1>

            <hr style="width: 50px; height:1px ;background-color: gray;margin:0 auto 15px auto;">
            <h3 class="text-capitalize text-center">exam date : <span class="text-success"> 10:10:2020</span></h3>
            <h3 class="text-center text-capitalize">start time : <span class="mr-2 text-success"> 10:20 </span> end time <span class="text-success">11:00</span></h3>

            <div class="student_name text-center">
                <h3 class="text-capitalize">student name : md hanzal</h3>
                <h3 class="text-capitalize">student role : 366894</h3>
            </div>

            <div class="row text-capitalize">
                <div class="col-sm-4 text-right">
                    <h3>total mark : <span> 10</span></h3>
                </div>
                <div class="col-sm-4 text-center">
                    <h3>clock</h3>
                </div>
                <div class="col-sm-4">
                    <h3>time : <span>20 minute</span></h3>
                </div>
            </div>
        </div>
    </div>
    <!-- END QUESTION HEADER -->

    <!-- QUESTION LIST -->
    <div class="wrapper wrapper-content questionWrapper">
        <div class="question-1">
            <h3>1. Father of ‘C’ programming language.</h3>
            <form action="" method="">
                <div class="row mb-3">
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                </div>
            </form>
        </div>

        <div class="question-1">
            <h3>2. COBOL is widely used in applications</h3>
            <form action="" method="">
                <div class="row mb-3">
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                </div>
            </form>
        </div>

        <div class="question-1">
            <h3>3. SMPS stands for</h3>
            <form action="" method="">
                <div class="row mb-3">
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                </div>
            </form>
        </div>

        <div class="question-1">
            <h3>4. The 16 bit Microprocessor means that it has The translator which perform macro expansion is called a The translator which perform macro expansion is called a The translator which perform macro expansion is called a The translator which perform macro expansion is called a</h3>
            <form action="" method="">
                <div class="row mb-3">
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                </div>
            </form>
        </div>

        <div class="question-1">
            <h3>5. Best Quality graphics is produced by</h3>
            <form action="" method="">
                <div class="row mb-3">
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                </div>
            </form>
        </div>

        <div class="question-1">
            <h3>6. The lowest form of Computer language is called</h3>
            <form action="" method="">
                <div class="row mb-3">
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                </div>
            </form>
        </div>

        <div class="question-1">
            <h3>7. The word bandwidth is also used to mean __?</h3>
            <form action="" method="">
                <div class="row mb-3">
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                </div>
            </form>
        </div>

        <div class="question-1">
            <h3>8. In order to save word document as a web page you need to?</h3>
            <form action="" method="">
                <div class="row mb-3">
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                </div>
            </form>
        </div>

        <div class="question-1">
            <h3>9 .Which of the following places the common data elements in order from smallest to largest?</h3>
            <form action="" method="">
                <div class="row mb-3">
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                </div>
            </form>
        </div>

        <div class="question-1">
            <h3>10. One Terabyte (1 TB) is equal to?</h3>
            <form action="" method="">
                <div class="row mb-3">
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                    <div class="pl-4 col-sm-6 d-flex flex-row">
                        <input type="radio" class="d-block" name="check2" id="check" value="">
                        <label class="d-block" for="check">You have selected Lorem Ipsum is simply dummy text typesetting industry.</label>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
