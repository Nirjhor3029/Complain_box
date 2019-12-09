@extends('admin-dashboard.layouts.app')

@section('site_title', 'Admin Dashboard')

@section('header_tag')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@2/dist/Chart.min.css">
@endsection

@section('bg_image', 'admin-page')

@section('content')
    <div class="row pt-3 pb-3 pl-4 pr-4 admin-dashboard-right-section">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row mb-4">
                <div class="col-12 col-sm-8 col-md-8 col-lg-8">
                    <div class="card admin-card-shadow p-3">
                        <h6 class="text-uppercase mb-0 font-weight-bold" style="color: #00B6F5;">Idea Received Ratio</h6>
                        <!-- /.text-muted text-uppercase -->

                        <hr class="hr" style="border: 1px solid #EDEDED;">
                        <!-- /.hr -->

                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                {!! $ideasChart->container() !!}
                            </div>
                            <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.card card-shadow p-3 -->
                </div>
                <!-- /.col-12 col-sm-9 col-md-9 col-lg-9 -->

                <div class="col-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="card admin-card-shadow p-3">
                        <h6 class="text-uppercase mb-0 font-weight-bold" style="color: #00B6F5;">Total Idea</h6>
                        <!-- /.text-muted text-uppercase -->

                        <hr class="hr" style="border: 1px solid #EDEDED;">
                        <!-- /.hr -->

                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 text-center">
                                <div class="admin-dashboard-idea-badge-blue">
                                    <span  class="admin-dashboard-idea-badge-blue-content">@{{featuredIdeasCount}}  </span>
                                    <!-- /.draft-card -->
                                </div>

                                <p class="mb-0" style="color: #6F6F6F; font-size: 13px; font-weight: 600;">Featured Ideas</p>
                                <!-- /.mb-0 -->
                            </div>
                            <!-- /.col-6 col-sm-6 col-md-6 col-lg-6 -->

                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 text-center">
                                <div class="admin-dashboard-idea-badge-light-blue">
                                    <span class="admin-dashboard-idea-badge-light-blue-content"> @{{submittedIdeasCount}} </span>
                                    <!-- /.draft-card -->
                                </div>

                                <p class="mb-0" style="color: #6F6F6F; font-size: 13px; font-weight: 600;">No. of Idea submitted</p>
                                <!-- /.mb-0 -->
                            </div>
                            <!-- /.col-6 col-sm-6 col-md-6 col-lg-6 -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.card card-shadow p-3 -->
                </div>
                <!-- /.col-12 col-sm-3 col-md-3 col-lg-3 -->
            </div>
            <!-- /.row mb-4 -->
			<div class="row pt-3 pb-3 pl-4 pr-4 admin-dashboard-right-section">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
							<div class="col-12 col-12 col-md-12 col-lg-12">
								<div class="card card-shadow p-3">
										<h5 class="text-deep-purple mb-0">Recent Ideas &nbsp;&nbsp;&nbsp;<span class="badge badge-purple badge-pill">{{ $recentIdeasCount }}</span>
										</h5>
									<hr class="hr">

									<div class="enable-ideas-scrollable">
										<ul class="list-unstyled recent-ideas-module pt-0 pb-1" v-for="(idea, index) in ideas" :key="index">
											<div class="row">
													<div class="col-8 col-8 col-md-8 col-lg-8">
															<li class="media hr pb-0 mb-2 mt-2">

																	<div v-if="idea.user.profile_picture == undefined">
																		<a :href="'/secure/dashboard/idea/' + idea.uuid" target="_blank"><img src="/img/profile-picture-placeholder.svg" class="mr-2 rounded-circle" alt="Profile Picture" height="60"></a>
																	</div>

																	<div v-else>
																	<a :href="'/secure/dashboard/idea/' + idea.uuid" target="_blank"><img :src="'{{asset('/')}}' + idea.user.profile_picture" class="mr-2 rounded-circle" alt="Profile Picture" height="60"></a>
																	</div>

																	<div class="media-body recent-ideas-idea-description">
																		<h5 class="recent-ideas-idea-title" style="color: #FFAD4D;">
																			<a :href="'/secure/dashboard/idea/' + idea.uuid" target="_blank">@{{ idea.title }}<span class="text-muted">|</span> @{{ idea.topic }}</a>
																		</h5>

																		<div class="row">
																			<div class="col-12 col-sm-8 col-md-8 col-lg-8">
																				<p class="mb-1 font-weight-bold recent-ideas-idea-author" style="color: #555555;">@{{ idea.user.first_name }}, @{{ idea.user.designation }}</p>
																			</div>
																			<!-- /.col-12 col-sm-8 col-md-8 col-lg-8 -->

																			<div class="col-12 col-sm-4 col-md-4 col-lg-4 text-right">
																				<span v-if="idea.is_featured == 1"><span class="is-featured"><img src="{{ asset('img/featured.svg') }}" alt=""></span></span>
																				<small class="recent-ideas-idea-published-time" style="color: #B9B9B9;">@{{ idea.submitted_at | formatDate }}</small>
																			</div>
																			<!-- /.col-12 col-sm-4 col-md-4 col-lg-4 -->
																		</div>
																		<!-- /.row -->

																		<p style="color: #414141;">@{{ idea.elevator_pitch | truncate(300, '...') }}</p>

																		{{--<div class="text-right"><a href="#" class="view-more-button">View More</a></div>
																		<!-- /.text-right -->--}}

																		<div class="row" style="display: flex; font-size: 11px;">
																			<div class="col-6 col-sm-6 col-md-6 col-lg-6">
																				<div>
																					<span class="mr-2" style="color: #7B7B7B;">@{{ idea.comments.length }}</span> comments
																					<img src="{{ asset('img/chat.svg') }}" height="18" alt="" class="ml-2">
																					<span class="ml-3 mr-2" style="color: #7B7B7B;">@{{idea.likes.length}} likes</span>
																					{{-- <img @click="like(idea.id)" src="{{ asset('img/like.svg') }}" height="16" alt=""> --}}
																				</div>
																			</div>
																			<!-- /.col-6 col-sm-6 col-md-6 col-lg-6 -->

																			<div class="col-6 col-sm-6 col-md-6 col-lg-6">
																				<div class="text-right">


																					<a :href="'/secure/dashboard/idea/' + idea.uuid" target="_blank" class="view-more-button " style="font-size: 11px;">Full View</a>
																				</div>
																				<!-- /.text-right -->
																			</div>
																			<!-- /.col-6 col-sm-6 col-md-6 col-lg-6 -->
																		</div>
																		<!-- /.row -->
																	</div>
																</li>
													</div>
													<!-- /.col-12 col-12 col-md-12 col-lg-12 -->

													<div class="col-4 col-4 col-md-4 col-lg-4 feature_column">
														<div class="row">
															<div class="col-4 col-4 col-md-4 col-lg-4"></div>
															<div class="col-8 col-8 col-md-8 col-lg-8" style="display: flex;">
																	<a v-if="idea.is_featured == 0" @click="makeFeatured(idea.id)"   class="view-more-button make_featured_idea_badge" style="font-size: 11px;">Make Fetured</a>
																	<span v-else  @click="makeNonFeatur(idea.id)"  class="featured_idea_badge" style="font-size: 11px;">Fetured</span>
															</div>
														</div>

													</div>
													<!-- /.col-12 col-12 col-md-12 col-lg-12 -->
											</div>


										</ul>
									</div>
									<!-- /.enable-ideas-scrollable -->

								</div>
								<!-- /.card card-shadow -->
							</div>
							<!-- /.col-12 col-12 col-md-12 col-lg-12 -->
						</div>
						<!-- /.row -->
					</div>
					<!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
				</div>
				<!-- /.row -->
			</div>

        </div>
        <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
    </div>
    <!-- /.row -->
@endsection

@section('customJS')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2/dist/Chart.min.js"></script>

    {!! $ideasChart->script() !!}

    <script src="https://cdn.jsdelivr.net/npm/vue"></script>

    <script>
			Vue.config.devtools = true;

			const app = new Vue({
				el: '#app',
				data() {
					return {
						ideas: [],
						featuredIdeasCount:0,
						submittedIdeasCount:0,

					};
				},

				methods: {
					getIdea() {

						axios.get('/secure/dashboard/recent-idea-published').then((response) => {
							this.ideas = response.data.ideas;
							console.log(response.data);
						}).catch((err) => {
							console.log(err.response);
						});
					},
					like(ideaId) {
						axios.post(`/secure/dashboard/submit-like`, {idea_id: ideaId}).then((response) => {
							this.getIdea();

							console.log(response.data);
						}).catch((err) => {
							console.log(err);
						});
					},
					makeFeatured(ideaId) {
						// alert(ideaId);
						axios.post(`/secure/admin/make_featured`, {idea_id: ideaId}).then((response) => {
							this.getIdea();

							console.log(response.data);
						}).catch((err) => {
							console.log(err);
						});
					},
					makeNonFeatur(ideaId) {
						// alert(ideaId);
						axios.post(`/secure/admin/make_non_featured`, {idea_id: ideaId}).then((response) => {
							this.getIdea();

							console.log(response.data);
						}).catch((err) => {
							console.log(err);
						});
					},
				},
				created() {
					this.getIdea();

					Echo.channel('idea').listen('NewComment', (e) => {
						this.comments.push({
							comment: e.comment,
						});
					});
				},
			});

			Vue.filter('formatDate', function(value) {
				if (value) {
					return moment(String(value)).fromNow();
				}
			});

			const filter = function(text, length, clamp) {
				clamp = clamp || '...';
				var node = document.createElement('div');
				node.innerHTML = text;
				var content = node.textContent;
				return content.length > length ? content.slice(0, length) + clamp : content;
			};

			Vue.filter('truncate', filter);

			window.__VUE_DEVTOOLS_GLOBAL_HOOK__.Vue = app.constructor;
    </script>
@endsection
