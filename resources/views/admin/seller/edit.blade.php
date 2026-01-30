@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Seller</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('admin.sellers') }}">Seller</a></div>
                <div class="breadcrumb-item active">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.sellers.update', $seller->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $seller->name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $seller->email }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ $seller->phone }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="0" {{ $seller->status == 0 ? 'selected' : '' }}>Disabled</option>
                                    <option value="1" {{ $seller->status == 1 ? 'selected' : '' }}>Pending</option>
                                    <option value="3" {{ $seller->status == 3 ? 'selected' : '' }}>Failed</option>
                                    <option value="4" {{ $seller->status == 4 ? 'selected' : '' }}>Active</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">OAP</label>
                                <select name="oap" class="form-control">
                                    <option value="yes" {{ $seller->oap === 'yes' ? 'selected' : '' }}>OAP</option>
                                    <option value="no" {{ $seller->oap === 'no' ? 'selected' : '' }}>Non OAP</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tax Number</label>
                                <input type="text" name="tax_number" class="form-control" value="{{ $seller->tax_number }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Business Number</label>
                                <input type="text" name="business_number" class="form-control" value="{{ $seller->business_number }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" value="{{ $seller->address }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" value="{{ $seller->city }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Province</label>
                                <input type="text" name="province" class="form-control" value="{{ $seller->province }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" value="{{ $seller->country }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Zip</label>
                                <input type="text" name="zip" class="form-control" value="{{ $seller->zip }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Note</label>
                                <textarea name="note" class="form-control" rows="3">{{ $seller->note }}</textarea>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.sellers') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
