@extends('layouts.app')

@section('site_title', $idea->title)

@section('bg_image', 'show-idea-page')

@section('content')
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            {!! laraflash()->render() !!}

            @unless (empty($idea))
                <div class="individual-idea-page mb-3">
                    <h5 class="individual-idea-page-idea-title mb-3">Idea Title: {{ $idea->title }}</h5>
                    <!-- /.individual-idea-page-idea-title -->

                    <div class="mb-4">
                        <strong class="individual-idea-page-idea-topic">Topic: {{ $idea->topic }}</strong>
                        <!-- /.individual-idea-page-idea-topic -->
                    </div>
                    <!-- /.mb-4 -->

                    <div class="mb-4">
                        <h5 class="text-deep-purple">Elevator Pitch</h5>
                        <!-- /.text-deep-purple mb-0 -->
                        <p class="lead mb-0">{{ $idea->elevator_pitch }}</p>
                    </div>
                    <!-- /.mb-4 -->

                    <div class="mb-4">
                        <h5 class="text-deep-purple">Description</h5>
                        <!-- /.text-deep-purple mb-0 -->
                        {!! $idea->description !!}
                    </div>
                    <!-- /.mb-4 -->

                    <div class="row mb-4">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            @unless (empty($idea->uploads()->exists()))
                                <div class="mb-1">
                                    <strong class="text-deep-purple border-bottom">Files Uploaded</strong>
                                    <!-- /.text-deep-purple -->
                                </div>
                                <!-- /.mb-3 -->

                                @foreach ($idea->uploads as $upload)
                                    <ul class="list-unstyled mb-1">
                                        <li>
                                            <a href="{{ asset("/idea/files/$upload->file")  }}">{{ $upload->title }} ({{ strtoupper(\File::extension($upload->file)) }})</a>
                                        </li>
                                    </ul>
                                @endforeach
                            @endunless
                        </div>
                        <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
                    </div>
                    <!-- /.row mb-4 -->

                    <div class="idea-submitted-by mb-4">
                        <div class="mb-2">
                            <strong>Idea Submitted By:</strong>
                        </div>
                        <!-- /.mb-2 -->

                        <div class="media">
                            @if($idea->user->profile_picture != null)
                                <img src="{{ asset($idea->user->profile_picture) }}" class="mr-2 rounded-circle" height="50" alt="Profile Picture">
                            @else
                                <img src="{{asset('img/profile-picture-placeholder.svg')}}" class="mr-2 rounded-circle" height="50" alt="Profile Picture">
                            @endif
                            <div class="media-body">
                                <strong class="mt-0">{{ $idea->user->first_name }} {{ $idea->user->last_name }}</strong>
                                <p class="mb-0">{{ $idea->user->designation }}</p>
                                <!-- /.mb-0 -->
                            </div>
                        </div>
                    </div>
                    <!-- /.idea-submitted-by -->
                </div>
                <!-- /.individual-idea-page mb-3 -->

                <div v-if="ratingSubmitSuccess" v-show="elementVisible" class="alert alert-success alert-dismissible fade show" role="alert">
                    @{{ ratingSubmitSuccess }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="row mb-4" style="display: flex;color: #00BAFF;">
                    <div class="col-6 col-sm-4 col-md-4 col-lg-4">
                        <div>
                            <span class="mr-2" style="color: #00BAFF;">@{{ totalComments }}</span> comments
                            <img src="{{ asset('img/chat.svg') }}" height="18" alt="" class="ml-2">
                            <span class="ml-3 mr-2" style="color: #7B7B7B;">@{{totalLikes}} likes</span>
                            {{-- <img @click="like(ideaId)" src="{{ asset('img/like.svg') }}" height="16" alt=""> --}}

                            <span v-if="isLiked({{\Illuminate\Support\Facades\Auth::user()->id}})">
                                <img id="ideaId" @click="like(ideaId)" src="{{ asset('img/like.svg') }}" class="" height="16" alt="">
                            </span>
                            <span v-else>
                                <img id="ideaId'" @click="like(ideaId)" src="{{ asset('img/like_gray.svg') }}" class="" height="16" alt="">
                            </span>

                        </div>
                    </div>
                    <!-- /.col-6 col-sm-6 col-md-6 col-lg-6 -->

                    <div class="col-6 col-sm-8 col-md-8 col-lg-8">
                        <div class="text-right">
                            <span v-for="(rating, index) in avgRating" :key="index"><span class="view-more-button mr-1">Rating (@{{ rating.avgRating }}/5)</span></span><span class="text-muted">|</span>
                            @{{ ratings.length }} admin(s) rated <span class="text-muted mr-1">|</span>
                            <span v-for="(myRating, index) in ratings" :key="index"><span v-if="myRating.user_id == {{ auth()->id() }}">You rated: @{{ myRating.rating }}</span></span><span class="text-muted ml-1">|</span>

                            <div class="pretty p-icon p-round p-plain p-smooth p-svg p-tada">
                                <input type="radio" v-model="ratingValue" value="0">
                                <div class="state">
                                    <img class="svg" src="{{ asset('img/star.svg') }}" alt=""/>
                                    <label>0</label>
                                </div>
                            </div>

                            <div class="pretty p-icon p-round p-plain p-smooth p-svg p-tada">
                                <input type="radio" v-model="ratingValue" value="1">
                                <div class="state">
                                    <img class="svg" src="{{ asset('img/star.svg') }}" alt=""/>
                                    <label>1</label>
                                </div>
                            </div>

                            <div class="pretty p-icon p-round p-plain p-smooth p-svg p-tada">
                                <input type="radio" v-model="ratingValue" value="2">
                                <div class="state">
                                    <img class="svg" src="{{ asset('img/star.svg') }}" alt=""/>
                                    <label>2</label>
                                </div>
                            </div>

                            <div class="pretty p-icon p-round p-plain p-smooth p-svg p-tada">
                                <input type="radio" v-model="ratingValue" value="3">
                                <div class="state">
                                    <img class="svg" src="{{ asset('img/star.svg') }}" alt=""/>
                                    <label>3</label>
                                </div>
                            </div>

                            <div class="pretty p-icon p-round p-plain p-smooth p-svg p-tada">
                                <input type="radio" v-model="ratingValue" value="4">
                                <div class="state">
                                    <img class="svg" src="{{ asset('img/star.svg') }}" alt=""/>
                                    <label>4</label>
                                </div>
                            </div>

                            <div class="pretty p-icon p-round p-plain p-smooth p-svg p-tada">
                                <input type="radio" v-model="ratingValue" value="5">
                                <div class="state">
                                    <img class="svg" src="{{ asset('img/star.svg') }}" alt=""/>
                                    <label>5</label>
                                </div>
                            </div>

                            <button @click="ideaRating()" class="btn btn-success btn-sm">Rate</button>
                        </div>
                        <!-- /.text-right -->
                    </div>
                    <!-- /.col-6 col-sm-6 col-md-6 col-lg-6 -->
                </div>
                <!-- /.row -->

                <div class="card p-3" style="border-radius: 10px;">
                    <ul class="list-unstyled" v-for="(comment, index) in comments" :key="index">
                        <li class="media mb-2">
                            <span v-if="comment.user.profile_picture == undefined">
                                <img src="/img/profile-picture-placeholder.svg" class="mr-2 rounded-circle" alt="Profile Picture" height="40" style="border: 1px solid #00BAFF;">
                            </span>

                            <span v-else>
                                <img :src="'{{asset('/')}}' + comment.user.profile_picture" class="mr-2 rounded-circle" alt="Profile Picture" height="40" style="border: 1px solid #00BAFF;">
                            </span>

                            <div class="media-body">
                                <h5 class="mt-0 mb-1 text-deep-purple" style="font-weight: 600; font-size: 14px;">@{{ comment.user.first_name }} @{{ comment.user.last_name }}</h5>
                                <div style="font-size: 13px;">
                                    @{{ comment.comment }}

                                    {{-- @if(comment.user_id == Auth::user()->id) --}}
                                    <div v-if="comment.user_id == {{\Illuminate\Support\Facades\Auth::user()->id}}" class="mr-3 comment_edit_delete" style="float: right">
                                        <img @click="deleteComment(comment.id)" src="{{ asset('img/cross_10px.svg') }}" class="pr-3 comment_delete" height="16" alt="" style="float: right">
                                        <img @click="editComment(comment.id)" src="{{ asset('img/edit.svg') }}" class="pr-3 comment_edit" height="16" alt="" style="float: right">
                                    </div>
                                    {{-- @endif --}}
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="input-group" style="border-bottom: none;">
                        <input type="text" v-model="newComment" @keyup.enter="commentId == '' ? submit() : updateComment()" class="form-control" @enter placeholder="Write a comment..." aria-describedby="button-addon2" required>
                        <input type="hidden" v-model="commentId" class="form-control" placeholder="Write a comment..." aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button @click="submit()" v-if="commentId===''" class="btn btn-outline-primary" id="button-addon2">Comment</button>
                            <button @click="updateComment()" v-else class="btn btn-outline-primary" id="button-addon3">Update</button>
                        </div>
                    </div>
                    <input type="hidden" v-model="uuid">

                </div>
                <!-- /.card card-shadow -->
            @endunless
        </div>
        <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
    </div>
    <!-- /.row -->
@endsection

@section('customJS')
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>

    <script>
			function deleteAlert() {
				alert('you want to delete you comment !');
			}

			Vue.config.devtools = true;

			const app = new Vue({
				el: '#app',
				data() {
					return {
						newComment: '',
						commentId: '',
						totalComments: 0,
						totalLikes: 0,
						ideaUuid: '{{ $idea->uuid }}',
						uuid: '',
						comments: [],
						ideaId: '{{ $idea->id }}',
						likes: [],
						ratingValue: '',
						ratings: [],
						ratingSubmitSuccess: '',
						avgRating: [],
						elementVisible: true,
					};
				},
				methods: {
					created() {
						axios.get(`/secure/dashboard/individual-idea-published-comments?ideaUuid=${this.ideaUuid}`).then((response) => {
							this.comments = response.data.comments;
							this.totalComments = response.data.comments.length;
							this.totalLikes = response.data.likes.length;
							this.likes = response.data.likes;
							this.uuid = response.data.uuid;
							this.ratings = response.data.ratings;
							this.avgRating = response.data.avg_rating;
							console.log(response.data);
						}).catch((err) => {
							console.log(err.response);
						});

						Echo.channel('idea').listen('NewComment', (e) => {
							this.comments.push({
								comment: e.comment,
							});
						});
					},
					submit() {
						axios.post('/secure/dashboard/new-comment', {
							comment: this.newComment,
							idea_id: this.uuid,
						}).then((response) => {
							this.newComment = '';
							this.comments.push(response.data);
							this.totalComments = parseInt(this.totalComments) + 1;
						}).catch((err) => {
							console.log(err.response.data);
						});
					},
					deleteComment(commentId) {
						//alert("comment id: "+commentId);
						if (confirm('you want to delete you comment !')) {
							axios.post('/secure/dashboard/delete-comment', {
								comment_id: commentId,

							}).then((response) => {
								console.log(response);
								//this.newComment = '';
								//this.comments.push(response.data);
								//this.totalComments = parseInt(this.totalComments) + 1;
							}).catch((err) => {
								console.log(err.response.data);
							});
						}
					},
					editComment(commentId) {
						//alert("Edit: "+commentId);
						axios.post('/secure/dashboard/edit-comment', {
							comment_id: commentId,

						}).then((response) => {
							// console.log(response);
							this.newComment = response.data.comment;
							this.commentId = response.data.id;
							//this.comments.push(response.data);
							//this.totalComments = parseInt(this.totalComments) + 1;
						}).catch((err) => {
							console.log(err.response.data);
						});
					},
					updateComment() {
						// alert(this.newComment);
						axios.post('/secure/dashboard/update-comment', {
							comment_id: this.commentId,
							comment: this.newComment,

						}).then((response) => {
							// console.log(response);
							this.newComment = '';
							this.commentId = '';
							//this.comments.push(response.data);
							//this.totalComments = parseInt(this.totalComments) + 1;
						}).catch((err) => {
							console.log(err.response.data);
						});
					},
					like(ideaId) {
						axios.post(`/secure/dashboard/submit-like`, {idea_id: ideaId}).then((response) => {
							this.created();

							//console.log(response.data);
						}).catch((err) => {
							console.log(err);
						});
					},
					ideaRating() {
						axios.post('/secure/dashboard/idea-rating', {
							rating: this.ratingValue,
							idea_id: this.uuid,
						}).then((response) => {
							this.ratingValue = '';
							this.ratings.push(response.data);
							this.ratingSubmitSuccess = 'Rating Submission was Successful for this Idea.';
							setTimeout(() => this.elementVisible = false, 1500);
							this.elementVisible = true;
						}).catch((err) => {
							console.log(err.response.data);
						});
					},
					intervalFetchData: function() {
						setInterval(() => {
							this.created();
						}, 3000);
					},
					isLiked(id) {
						let liked = false;

						if (this.likes != []) {
							this.likes.forEach(element => {
								if (element.user_id == id) {
									liked = true;
								}
							});
						}
						return liked;
					},
				},
				mounted() {
					// Run the functions once when mounted
					this.created();
					// Run the intervalFetchData function once to set the interval time for later refresh
					this.intervalFetchData();
				},

			});

			window.__VUE_DEVTOOLS_GLOBAL_HOOK__.Vue = app.constructor;
    </script>
@endsection
