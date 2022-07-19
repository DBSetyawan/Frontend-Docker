<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <head>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <link rel="stylesheet"
                            href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
                        <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
                        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"
                            rel="stylesheet">
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js">
                        </script>
                        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
                        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
                        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
                    </head>

                    <div class="container">
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-bordered user_datatable">
                                    <thead>
                                        <tr>
                                            {{-- <th>DATE</th> --}}
                                            <th>Label</th>
                                            <th>Visit</th>
                                            {{-- <th>Status</th> --}}
                                            <th width="100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </body>
                    <script type="text/javascript">
                        $(function () {
                            var table = $('.user_datatable').DataTable({
                                processing: true,
                                serverSide: true,
                                ajax: "{{ route('list.data') }}",
                                columns: [
                                    // {
                                    //     data: 'date',
                                    //     name: 'date'
                                    // },
                                    {
                                        data: 'label',
                                        name: 'label'
                                    },
                                    {
                                        data: 'nb_visits',
                                        name: 'nb_visits'
                                    },
                                    // {
                                    //     data: 'status',
                                    //     name: 'status'
                                    // },
                                    {
                                        data: 'action',
                                        name: 'action',
                                        orderable: false,
                                        searchable: false
                                    },
                                ]
                            });
                        });

                    </script>
                    <div class="container">
                        <div class="card-header border-left">
                            <h3><strong> daniel</strong></h3>
                        </div>
                        <br>

                        {{-- Modal --}}
                        <div id="customermodal" class="modal fade" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="modelHeading"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times</span></button>
                                    </div>
                                    <div class="modal-body">

                                        <form id="customerForm" name="customerForm" class="form-horizontal">
                                            <input type="hidden" name="customerid" id="customerid">

                                            <div class="form-group">
                                                <label for="name" class="col-sm-6 control-label">Customer Name</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        placeholder="Name" value="" maxlength="50" required="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-6 control-label">Customer Name</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="chiname" name="chiname"
                                                        placeholder="Customer Name" value="" maxlength="50" required="">
                                                </div>
                                            </div>

                                            <br>
                                            <div class="col-sm text-right">
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
