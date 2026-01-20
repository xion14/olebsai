@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Information Bar</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Admin</a></div>
                <div class="breadcrumb-item active"><a href="#">Information Bar</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ url('admin/information-bar/' . $information->id) }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="text">Text</label>
                                    <input type="text" id="text" name="text" class="form-control" placeholder="Information ....." value="{{ $information->text }}">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
