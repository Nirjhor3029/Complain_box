@extends('admin-dashboard.layouts.app')

@section('site_title', 'Complain Status')

@section('content')
	<div class="row pt-4 pr-4 pb-4">
		<div class="col-12 col-sm-12 col-md-12 col-lg-12">

			{!! laraflash()->render() !!}

			<div class="mb-3">
				<a href="{{ route('admin.dashboard.status.create') }}" class="btn btn-success">Add Status</a>
			</div>
			<!-- /.mb-3 -->

		</div>
		<!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
	</div>
	<!-- /.row -->

	@unless (empty($create))
		<div class="row pt-4 pr-4 pb-4">
			<div class="col-12 col-sm-12 col-md-6 col-lg-6">

				<div class="card">
					<div class="card-header">Add New Status</div>
					<div class="card-body">
								<tr>
									<form action="{{ route('admin.dashboard.status.create.submit') }}" class="" method="POST">
										{{ csrf_field() }}
										<td>
											<input type="text" name="title" id="title" value="" placeholder="Title (pending)" required>
										</td>
										<td><input type="number" name="priority" id="priority" value="{{ (isset($max_status_priority))? $max_status_priority : '' }}" placeholder="Priority (1)" required></td>
										<td>
											 <input type="submit" value="submit" class="btn btn-success btn-md">
										</td>
									</form>
								</tr>
					</div>
				</div>

			</div>
			<!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
		</div>
		<!-- /.row -->
	@endunless

	<div class="table-responsive">
		<table class="table table-bordered">
			<thead>
			<tr>
				<th>#</th>
				<th>Title</th>
				<th>Status Priority</th>
				<th>Manage</th>
			</tr>
			</thead>

			<tbody>
			@unless (empty($statuses))
				@foreach ($statuses as $status)
					@if (!empty($status_id) && $status_id == $status->id )

						<tr>
							<form action="{{ route('admin.dashboard.status.edit.submit', [$status->id]) }}" class="" method="POST">
								{{ csrf_field() }}
								<td>{{ $status->id }}</td>
								<td><input type="text" name="title" id="title" value="{{ sr($status->title) }}"></td>
								<td><input type="number" name="priority" id="priority" value="{{ $status->priority }}"></td>
								<td>
								 	<input type="submit" value="submit" class="btn btn-success btn-md">
								</td>
							</form>
						</tr>

					@else
						<tr>
							<td>{{ $status->id }}</td>
							<td>{{ sr($status->title) }}</td>
							<td>{{ $status->priority }}</td>
							<td>
								<a href="{{ route('admin.dashboard.status.edit', $status->id) }}" class="btn btn-primary btn-md">Edit</a>
								<a href="{{ route('admin.dashboard.status.delete', $status->id) }}" class="btn btn-danger btn-md">Delete</a>
							</td>
						</tr>
					@endif

				@endforeach
			@endunless
			</tbody>
		</table>
		<!-- /.table table-bordered table-striped -->
	</div>
	<!-- /.table-responsive -->

	{{ $statuses->links() }}
@endsection
