@extends('admin-dashboard.layouts.app')

@section('site_title', 'Admin Dashboard')

@section('header_tag')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@2/dist/Chart.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
@endsection

@section('bg_image', 'admin-page')

@section('content')
    <div class="row pt-3 pb-3 pl-4 pr-4 admin-dashboard-right-section">

		<div class="col-12 col-sm-12 col-md-12 col-lg-12">
				<table id="example" class=" stripe hover row-border">
						<thead>
							<tr>
								<th>#</th>
								<th>User Info</th>
								<th>Complain Title</th>
								<th>Complain ID</th>
								<th>Status</th>
							</tr>
						</thead>

						<tbody>
							<?php $i = 0 ?>
							@foreach ($publishedIdeas as $item)
								<tr>
									<td>{{ $i }}</td>
									<td>
										{{ $item->user->first_name }} 	<br>
										{{ $item->user->email }} 	<br>
										( {{ ($item->user->email_verified_at == null)? "Not Varified": "Varified" }} )<br>
										{{ $item->user->cell_number }}<br>
										{{ $item->user->designation }}<br>
										<br>
									</td>
									<td>
										{{ $item->title }}
									</td>
									<td>
										{{ $item->complain_id }}
									</td>
									<td>
										@foreach ($statuses as $item)

										@if (1)
											<div class="row">
												<div class="col-sm-10">{{ $item->title }}</div>
												<div class="col-sm-2 "><a href="#" class="button_status active"></a></div>
											</div>
										@else
											<div class="row">
												<div class="col-sm-10">{{ $item->title }}</div>
												<div class="col-sm-2"><a href="#" class="button_status"></a></div>
											</div>
										@endif

										<hr>

										@endforeach

									</td>
								</tr>
								<?php $i++;  ?>
							@endforeach

						</tbody>

						<tfoot>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
						</tfoot>

					</table>
		</div>
		<!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
    </div>
    <!-- /.row -->











@endsection

@section('customJS')


	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>

    <script>
		$(document).ready( function () {

			$('#example').DataTable({
				paging: true,
				// scrollY:100,
				searching: true,
				ordering:  true,
				select: true,

			});


			// Setup - add a text input to each footer cell
			$('#example tfoot th').each( function () {
				var title = $('#example thead th').eq( $(this).index() ).text();
				$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
			} );

			// DataTable
			var table = $('#example').DataTable();

			// Apply the filter
			table.columns().every( function () {
				var column = this;

				$( 'input', this.footer() ).on( 'keyup change', function () {
					column
						.search( this.value )
						.draw();
				} );
			} );


			var table = $('#example').DataTable();

			table.columns( '.select-filter' ).every( function () {
				var that = this;

				// Create the select list and search operation
				var select = $('<select />')
					.appendTo(
						this.footer()
					)
					.on( 'change', function () {
						that
							.search( $(this).val() )
							.draw();
					} );

				// Get the search data for the first column and add to the select list
				this
					.cache( 'search' )
					.sort()
					.unique()
					.each( function ( d ) {
						select.append( $('<option value="'+d+'">'+d+'</option>') );
					} );
			} );



		} );
    </script>
@endsection
