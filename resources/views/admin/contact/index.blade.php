@extends('layouts.admin.app')
@section('title', 'Contact')
@section('contact', 'active')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row col-12 mb-2">
                <div class="col-sm-6">
                    <h1>All Contacts</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title float-right">
                                <a href="javascript:void(0);" class="btn btn-primary" onclick="window.test.showModal()">
                                    <i class="fas fa-plus"></i> Add Contact
                                </a>
                            </div>
                        </div>
                        <contact-list/>
                    </div>
                </div>
            </div>
            <div class="row">
{{--                @include('admin.modals.contactFormModal')--}}
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>

    </script>
@endsection
