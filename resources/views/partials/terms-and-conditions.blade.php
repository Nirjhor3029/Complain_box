@extends('layouts.app')

@section('site_title', 'Terms of Service Agreement')

@section('bg_image', 'submit-idea-page')

@section('content')
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card card-opacity">
                <div class="card-body">
                    <h4>Terms of Service Agreement</h4>

                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>

                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>

                    <p>Etiam quis iaculis dolor. Maecenas id purus luctus, malesuada ante in, vulputate ipsum. Proin molestie ante erat, quis semper ipsum venenatis vel. Praesent lectus risus, accumsan sed purus vel, dictum finibus lorem. Pellentesque porta vitae dui in tincidunt. Vestibulum faucibus ullamcorper iaculis. Aliquam dictum sapien nec tellus porttitor, eu eleifend tortor accumsan. Vivamus condimentum nunc scelerisque sagittis scelerisque. Integer sed urna nulla.</p>

                    <p>Nam in congue sapien, eu cursus nibh. Pellentesque eget velit ut libero vestibulum fermentum vitae eu augue. Mauris in lorem efficitur, egestas mauris vitae, ultricies sapien. Phasellus efficitur orci vitae ipsum pretium tincidunt. Curabitur sapien libero, volutpat sit amet tincidunt at, mattis ut ipsum. Integer pulvinar porta lorem, at efficitur lorem molestie at. Nulla facilisi. Cras pharetra nibh id cursus bibendum. Nam consequat ipsum at velit auctor dignissim. Cras aliquam sollicitudin fringilla. Ut porta condimentum quam rutrum laoreet. Donec vehicula massa at lectus convallis, vitae ultricies magna pellentesque. Ut porta, magna non congue vestibulum, leo ex volutpat elit, pulvinar malesuada risus justo vel urna.</p>

                    {!! Form::open(['url' => route('terms.update'), 'method' => 'post', 'data-parsley-validate']) !!}
                    <div class="row">
                        <div class="form-group col-12">
                            <div class="pretty p-smooth p-bigger p-default">
                                {!! Form::checkbox('accept_the_terms_of_service', '1', null,  ['id' => 'accept_the_terms_of_service', 'required']) !!}
                                <div class="state p-success-o">{!! Form::label('accept_the_terms_of_service') !!}</div>
                            </div>
                        </div>
                        <!-- /.form-group col-12 -->

                        <div class="form-group col-12">
                            {!! Form::submit('Agree and Continue', ['class' => 'btn btn-success']) !!}
                        </div>
                        <!-- /.form-group col-12 -->
                    </div>
                    <!-- /.row -->
                    {!! Form::close() !!}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
    </div>
    <!-- /.row -->
@endsection
