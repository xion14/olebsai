@extends('__layouts.__admin.main')

@section('body')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Failed Registrations</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Admin</a></div>
                    <div class="breadcrumb-item"><a href="#">Seller</a></div>
                    <div class="breadcrumb-item active"><a href="#">Failed</a></div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="sellerTable" class="table table-striped my-4" id="table-1">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">#</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Email</th>
                                                <th class="text-center">Tax Number</th>
                                                <th class="text-center">Business Number</th>
                                                <th class="text-center">Phone</th>
                                                <th class="text-center">Location</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var table = registerDatatables({
                element: $('#sellerTable'),
                url: "{{ route('admin.sellers.failed') }}",
                columns: [{
                        data: 'no',
                        name: 'no'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        searchable: true
                    },
                    {
                        data: 'email',
                        name: 'email',
                        searchable: true
                    },
                    {
                        data: 'tax_number',
                        name: 'tax_number',
                        searchable: true
                    },
                    {
                        data: 'business_number',
                        name: 'business_number',
                        searchable: true
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        searchable: true
                    },
                    {
                        data: 'location',
                        name: 'location',
                        searchable: true
                    },
                ],
                language: {
                    paginate: {
                        previous: "<i class='fas fa-chevron-left'></i>",
                        next: "<i class='fas fa-chevron-right'></i>",
                        first: "<i class='fas fa-angle-double-left'></i>",
                        last: "<i class='fas fa-angle-double-right'></i>"
                    }
                },
            });
        });
    </script>
@endsection
