@extends('layouts.admin')

@section('title', 'Blife - Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-xxl-8 col-lg-10 m-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header-2">
                                <h5>Dashboard</h5>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h5 class="font-primary">Total Sales</h5>
                                                    <span class="text-muted">$12,345</span>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="ri-shopping-cart-line icon-bg-primary"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h5 class="font-success">Total Orders</h5>
                                                    <span class="text-muted">1,234</span>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="ri-file-list-line icon-bg-success"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h5 class="font-warning">Total Customers</h5>
                                                    <span class="text-muted">567</span>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="ri-user-line icon-bg-warning"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
