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
                                <small id="mobileHelp" class="form-text text-muted">We'll never share your Mobile Number with anyone else.</small>
                        
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

@endsection


@section('customJS')
    @component('layouts.tinymce')
        @slot('editor')
            textarea#description
        @endslot
    @endcomponent


<script type="text/javascript">
$(document).ready(function(){
	window.unbeforeunload = null;

    let asset = '<?php echo asset("/idea/files")?>'

    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var uploaded = $('#uploaded_file'); //Input field wrapper
    var x = 1; //Initial field counter is 1
    var upload_id = [];

    //Once add button is clicked
    var current = document.querySelector(".row input[name='image[]']");
    // var upload_file_id = $(`'#uploaded_file_id_${x}'`);

    //configuration
    var max_file_size           = 70; //allowed file size 70MB
    var allowed_file_types      = ['image/png', 'image/gif', 'image/jpeg', 'image/pjpeg']; //allowed file types
    var result_output           = '#output'; //ID of an element for response output
    var my_form_id              = '#upload_form'; //ID of an element for response output
    var progress_bar_id         = '#progress-wrp'; //ID of an element for response output
    var total_files_allowed     = 3; //Number files allowed to upload
    var total_files_size        = 0;
    var limitLeft               = 0;

    $('#upload_form').on('click', function(){
        $(progress_bar_id +" .progress-bar").css("width", "0%");
        $(progress_bar_id + " .status").text("0%");
    });

    $('#uploadLimit').html(max_file_size+'MB');
//on form submit
$(document).on("change","#upload_form", function(event) {
// console.log($('input[type=file]')[x-1].files[0]);

    if($('input[type=file]')[x-1].files.length){

        let fileSize = getFileSize($('input[type=file]')[x-1].files[0].size);
        limitLeft = max_file_size - fileSize;
        let proceed = true; //set proceed flag
        let error = []; //errors

        if (limitLeft >= 0) {

        $('#progress-wrp').css({'visibility':'visible'});
        event.preventDefault();
        var formData = new FormData();
        formData.append('image', $('input[type=file]')[x-1].files[0]);
        formData.append('idea_id', $('#idea_id').val());
        formData.append('topic', $('#topic').val());
        formData.append('title', $('#title').val());
        formData.append('elevator_pitch', $('#elevator_pitch').val());
        formData.append('description', $('#description').val());
        formData.append('size', fileSize);

        //reset progressbar
        $(progress_bar_id +" .progress-bar").css("width", "0%");
        $(progress_bar_id + " .status").text("0%");

        if(!window.File && window.FileReader && window.FileList && window.Blob){ //if browser doesn't supports File API
            error.push("Your browser does not support new File API! Please upgrade."); //push error text
        }else{
        //if everything looks good, proceed with jQuery Ajax
        if(proceed){

            $.ajax({

                url : "{{route('dashboard.file-upload')}}",
                type: "POST",
                data : formData,
                headers: {
                    'X-CSRF-TOKEN':  $("[name=_token]").val()
                },
                contentType: false,
                cache: false,
                processData:false,
                xhr: function(){
                    //upload Progress
                    var xhr = $.ajaxSettings.xhr();
                    if (xhr.upload) {
                        xhr.upload.addEventListener('progress', function(event) {
                            var percent = 0;
                            var position = event.loaded || event.position;
                            var total = event.total;
                            if (event.lengthComputable) {
                                percent = Math.ceil(position / total * 100);
                                // console.log(percent);
                            }
                            //update progressbar
                            $(progress_bar_id + " .status").text(percent +"%");
                            $(progress_bar_id +" .progress-bar").css("width", + (percent * 2) +"px");
                            // $(progress_bar_id +" .status").css("background-color","#fff");
                        }, true);
                    }
                    return xhr;
                },
                mimeType:"multipart/form-data"
                }).done(function(res){ //

                    res = JSON.parse(res);
                    upload_id.push(res.id)
                    $("#uploaded_file_id").val(upload_id);

                    $("#idea_id").val(res.idea_id);

                    $(uploaded).append(uploadedFileShow(res));
                });

            }
            }

            total_files_size += fileSize;
            max_file_size -= fileSize;
            $('#uploadLimit').html('');
            $('#uploadLimit').html(max_file_size.toFixed(2)+'MB');
        }else{
            error.push( "File is larger than limit left:  "+max_file_size.toFixed(2)+" MB, Try smaller file!"); //push error text
            proceed = false; //set proceed flag to false
        }

        $(result_output).html(""); //reset output
        $(error).each(function(i){ //output any error to output element
            $(result_output).append('<div class="error" style="color: red">'+error[i]+"</div>");
        });
        }
    });


    function uploadedFileShow(upload){
        let fileData = `<div class="form-group col-6">
                <ul class="list-group mb-1">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="${asset}/${upload.file}" target="_blank">${upload.title}</a>

                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteUploadsModal-${upload.uuid}">D</button>

                        <div class="modal fade" id="deleteUploadsModal-${upload.uuid}" tabindex="-1" role="dialog" aria-labelledby="deleteUploadsModal${upload.uuid}Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteUploadsModal${upload.uuid}Label">Delete File: ${upload.title}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-danger">Careful, Once Deleted, There is no Rollback!</p>

                                        <form method="post" action="{{route('dashboard.upload-file-delete')}}" id="delete-upload-form-${upload.uuid}">
                                            <input type="text" hidden readonly class="form-control" value="${upload.uuid}" name="upload_id">
                                            @csrf
                                        <form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" onclick="deleteUploadedFile()" class="btn btn-danger delete" id="delete-${upload_id}" form="delete-upload-form-${upload.uuid}">Delete</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>`;

        return fileData;
    }

    function getFileSize(fileSize){
        let sizeInMB;
        var _size = fileSize;
        var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
        i=0;while(_size>900){_size/=1024;i++;}
        var exactSize = (Math.round(_size*100)/100);

        if (i == 0) {
            sizeInMB = (exactSize / 1e+6);
        }else if(i == 1){
            sizeInMB = (exactSize / 1000);
        }else if(i == 2){
            sizeInMB = exactSize;
        }else{
            sizeInMB = exactSize * 1000;
        }

       return sizeInMB;
    }
});
</script>
@endsection
