@extends('layouts.app')

@section('site_title', 'How It Works')

@section('bg_image', 'how-it-works-page')

@section('content')
    <div class="row mb-3">
        <div class="col-12 col-sm-12 col-md-10 col-lg-10">
            <div class="how-it-works-page mb-4">
                <h5 class="text-uppercase font-weight-bold mb-4" style="color: #432BC4;">What is idea bank?</h5>

                <p>Proin facilisis dolor ac ex euismod venenatis. Quisque hendrerit, quam ut vehicula congue, velit orci sodales lectus, eu ultrices sem ante non dui. Aenean odio neque, fringilla in ultricies sit amet, ullamcorper vitae tellus. Vestibulum interdum euismod mi at pharetra.</p>

                <p>Suspendisse id arcu non ligula interdum varius. Proin blandit lectus sit amet fringilla sodales. Fusce lobortis nisi volutpat congue dignissim. Nam eu arcu vel tellus bibendum semper. Duis sit amet ipsum eu velit auctor fermentum quis a nulla. Duis sollicitudin vehicula ipsum id convallis. Curabitur sed consectetur erat.</p>
            </div>
            <!-- /.how-it-works-page mb-4 -->

            <h5 class="text-uppercase font-weight-bold mb-4" style="color: #432BC4;">It’s Easy to submit an idea</h5>

            <div class="mb-3">
                <img src="{{ asset('img/idea-submission-steps.svg') }}" alt="" class="img-fluid">
                <!-- /.img-fluid -->
            </div>
            <!-- /.mb-4 -->

            <div class="row">
                <div class="col-12 col-sm-12 col-md-7 col-lg-7">
                    <div class="idea-submission-steps mb-1">
                        <h5 style="color: #607D8C">Step 1</h5>
                        <p>Ante imperdiet. Mus adipiscing ultricies fames purus commodo, maecenas aliquet varius nascetur imperdiet torquent facilisis habitant parturient praesent</p>
                    </div>
                    <!-- /.idea-submission-steps mb-1 -->

                    <div class="idea-submission-steps mb-1">
                        <h5 style="color: #9982FD">Step 2</h5>
                        <p>Ante imperdiet. Mus adipiscing ultricies fames purus commodo, maecenas aliquet varius nascetur imperdiet torquent facilisis habitant parturient praesent</p>
                    </div>
                    <!-- /.idea-submission-steps mb-1 -->

                    <div class="idea-submission-steps mb-1">
                        <h5 style="color: #00BAD6">Step 3</h5>
                        <p>Ante imperdiet. Mus adipiscing ultricies fames purus commodo, maecenas aliquet varius nascetur imperdiet torquent facilisis habitant parturient praesent</p>
                    </div>
                    <!-- /.idea-submission-steps mb-1 -->
                </div>
                <!-- /.col-12 col-sm-12 col-md-8 col-lg-8 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
    </div>
    <!-- /.row mb-3 -->
@endsection
