@extends('layouts.user_type.auth')

@section('styles')
    <link rel="stylesheet" href="{{asset('assets/datatables/datatables.bundle.css')}}">
@endsection

@section('title', 'All Teachers')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title d-flex justify-content-between w-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="card-icon">
                                <i class="flaticon-interface-7 text-primary"></i>
                            </span>
                            <h3 class="card-label">Teachers</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('teacher.partials._list')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/teacher/datatable.js') }}"></script>
    <script>
        initTeacherDataTable("{{ route('teacher.getTeachers')}}");
    </script>
@endsection
