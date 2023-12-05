@extends('AdminPanel.layouts.main')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                    </ol>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('AdminPanel.layouts.messages')

    <div class="card">

        <div class="card-body">
            <form method="post" action="{{route('orderHeaders.HandelExportShippingSheetSheet')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-12">
                    <label class="col-form-label" for="start_date">Start Date</label>
                    <input type="date" name="start_date" required>
                </div>

                <div class="form-group col-12">
                    <label class="col-form-label" for="end_date">End Date</label>
                    <input type="date" name="end_date" required>
                </div>

                <div class="form-group col-12">
                    <button type="submit" class="btn btn-success">Exports Orders Sheet</button>
                </div>
            </form>
        </div>
    </div>

@endsection
