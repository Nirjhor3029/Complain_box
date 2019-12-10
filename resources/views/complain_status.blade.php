@extends('layouts.app')

@section('site_title', 'Submit Complain')

@section('bg_image','')

@section('content')


    <script src="https://kit.fontawesome.com/dfea93c091.js" crossorigin="anonymous"></script>

    <div class="row">
        <div class="card" style="width: 100%;">
            <div class="card-header">
                Search Your Complain
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('status_search')}}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="mobile">Mobile Number</label>
                                <input name="mobile" type="number" class="form-control" id="mobile" aria-describedby="mobileHelp" placeholder="Enter Mobile number">
                                <small id="mobileHelp" class="form-text text-muted">
                                    We'll never share your Mobile Number with anyone else.
                                    <br>
                                    <a href="google.com" onclick="return checkNumber()">Get Your Colpmaint List by mobile number</a>
                                </small>

                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="complain_id">Complain Id</label>
                                <input name="complain_id" type="text" class="form-control" id="complain_id" placeholder="Enter Complain Id">
                            </div>
                        </div>
                    </div>


                    {{-- <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div> --}}
                    <button type="submit" class="btn btn-primary">Submit</button>

                </form>
            </div>
        </div>
    </div>
    <!-- /.row -->

    <div class="row mt-3">
        <div class="col-12 col-sm-12 col-md-12 col-lg-6 mt-3">
            <div class="card" style="width: 100%;">
                <div class="card-header">
                    List Of Your Complaints
                </div>
                @if(isset($complains)  )
                    <div class="card-body">
                        @foreach ($complains as $single_complain )
                            <div class="row mb-1">
                                <div class="col-6">
                                    {{ $single_complain->title }}
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('status_searchById', [$single_complain->complain_id]) }}" class="">{{ $single_complain->complain_id }}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="card-body">
                        Nothing Found
                    </div>
                @endif
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-12 col-lg-6 mt-3">
            <div class="card" style="width: 100%;">
                <div class="card-header">
                    Complaint ( {{ (isset($complain->complain_id)? $complain->complain_id : "Nothing Match") }} ) Status
                </div>
                @if(isset($complain) && $check)
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <b>Title :</b>
                            </div>
                            <div class="col-9">
                                {{ $complain->title }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <b>Short Desc : </b>
                            </div>
                            <div class="col-9">
                                {{ $complain->short_description }}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="progress">

                            @foreach ($status as $single_status )
                                <div class="circle">
                                    <span class="label">{{ $single_status->priority }}</span>
                                    <span class="title">{{ $single_status->title }}</span>
                                </div>
                                <span class="bar"></span>
                            @endforeach


                            <div class="circle">
                                <span class="label">5</span>
                                <span class="title">Finish</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card-body">
                        Nothing Found
                    </div>
                @endif
            </div>
        </div>
    </div>



@endsection


@section('customJS')
    @component('layouts.tinymce')
    @slot('editor')
    textarea#description
    @endslot
    @endcomponent


    <script type="text/javascript">

        function checkNumber() {

            if (!$('#mobile').val()) {
                alert("Enter Mobile Number First !");
                $('#mobile').focus();
                return false;
            }
            else {
                return true;
            }
        }


        var break_point =
                <?php echo (isset($complain->status)? $complain->status : 0) ?>

                   var i = 1;
        $('.progress .circle').removeClass().addClass('circle');
        $('.progress .bar').removeClass().addClass('bar');
        var timer = setInterval(function () {
            $('.progress .circle:nth-of-type(' + i + ')').addClass('active');

            $('.progress .circle:nth-of-type(' + (i - 1) + ')').removeClass('active').addClass('done');

            $('.progress .circle:nth-of-type(' + (i - 1) + ') .label').html('&#10003;');

            $('.progress .bar:nth-of-type(' + (i - 1) + ')').addClass('active');

            $('.progress .bar:nth-of-type(' + (i - 2) + ')').removeClass('active').addClass('done');

            i++;


            if (i > break_point) {
                clearInterval(timer);
            }

            if (i == 0) {
                $('.progress .bar').removeClass().addClass('bar');
                $('.progress div.circle').removeClass().addClass('circle');
                i = 1;
            }
        }, 500);


        // $(document).ready(function(){

        // });
    </script>
@endsection
