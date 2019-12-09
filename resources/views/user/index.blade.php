@extends('admin-dashboard.layouts.app')

@section('site_title', 'Users Manager')

@section('content')
    <div class="row pt-4 pr-4 pb-4">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            {!! laraflash()->render() !!}

            <div class="mb-3">
                <a href="{{ route('dashboard.user.index') }}" class="btn btn-primary mr-1">All Users</a><a href="{{ route('dashboard.user.create') }}" class="btn btn-success">Create User</a>
            </div>
            <!-- /.mb-3 -->

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Staff ID</th>
                        <th>Cell Number</th>
                        <th>Email Address</th>
                        <th>Designation</th>
                        <th>Assigned Role(s)</th>
                        <th>Manage</th>
                    </tr>
                    </thead>

                    <tbody>
                    @unless (empty($users))
                        @foreach ($users as $user)
                            <tr>
                                <td style="width: 4rem;"><img src="{{asset($user->profile_picture)}}" alt="" class="img-fluid"></td>
                                <td>
                                    <a href="{{ route('dashboard.user.edit', $user->uuid) }}">{{ sr($user->first_name) }} {{ sr($user->last_name) }}</a>
                                </td>
                                <td>{{ $user->staff_id }}</td>
                                <td><a href="tel:{{ $user->cell_number }}">{{ $user->cell_number }}</a></td>
                                <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                <td>{{ $user->designation }}</td>
                                <td>{{ sr(implode(', ', $user->roles()->orderBy('id')->pluck('name')->toArray())) }}</td>
                                <td><a href="{{ route('dashboard.user.edit', $user->uuid) }}" class="btn btn-primary btn-sm">Update</a></td>
                            </tr>
                        @endforeach
                    @endunless
                    </tbody>
                </table>
                <!-- /.table table-bordered table-striped -->
            </div>
            <!-- /.table-responsive -->

            {{ $users->links() }}
        </div>
        <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
    </div>
    <!-- /.row -->
@endsection
