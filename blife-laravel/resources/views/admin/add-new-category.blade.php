@extends('layouts.admin')

@section('title', 'Blife - Add New Category')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-sm-8 m-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header-2">
                                <h5>Category Information</h5>
                            </div>

                            <form class="theme-form theme-form-2 mega-form" id="category-form" method="POST" action="{{ route('admin.store-category') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4 row align-items-center">
                                    <label class="form-label-title col-sm-3 mb-0">Category Name</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="name" placeholder="Category Name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row align-items-center">
                                    <label class="col-sm-3 col-form-label form-label-title">Category Image</label>
                                    <div class="form-group col-sm-9">
                                        <input class="form-control" type="file" name="image" accept="image/*">
                                        @error('image')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row align-items-center">
                                    <div class="col-sm-3 form-label-title">Select Category Icon</div>
                                    <div class="col-sm-9">
                                        <div class="dropdown icon-dropdown">
                                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown">
                                                Select Icon
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li>
                                                    <a class="dropdown-item" href="#" data-icon="vegetable">
                                                        <img src="{{ asset('assets/svg/1/vegetable.svg') }}" class="img-fluid" alt="">
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" data-icon="cup">
                                                        <img src="{{ asset('assets/svg/1/cup.svg') }}" class="blur-up lazyload" alt="">
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" data-icon="meats">
                                                        <img src="{{ asset('assets/svg/1/meats.svg') }}" class="img-fluid" alt="">
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" data-icon="breakfast">
                                                        <img src="{{ asset('assets/svg/1/breakfast.svg') }}" class="img-fluid" alt="">
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" data-icon="frozen">
                                                        <img src="{{ asset('assets/svg/1/frozen.svg') }}" class="img-fluid" alt="">
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" data-icon="biscuit">
                                                        <img src="{{ asset('assets/svg/1/biscuit.svg') }}" class="img-fluid" alt="">
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" data-icon="grocery">
                                                        <img src="{{ asset('assets/svg/1/grocery.svg') }}" class="img-fluid" alt="">
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" data-icon="drink">
                                                        <img src="{{ asset('assets/svg/1/drink.svg') }}" class="img-fluid" alt="">
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" data-icon="milk">
                                                        <img src="{{ asset('assets/svg/1/milk.svg') }}" class="img-fluid" alt="">
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" data-icon="pet">
                                                        <img src="{{ asset('assets/svg/1/pet.svg') }}" class="img-fluid" alt="">
                                                    </a>
                                                </li>
                                            </ul>
                                            <input type="hidden" name="icon" id="selected-icon">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-submit-button">
                            <button class="btn btn-animation ms-auto" type="submit" form="category-form">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const iconItems = document.querySelectorAll('.dropdown-menu .dropdown-item');
        const selectedIconInput = document.getElementById('selected-icon');
        const dropdownButton = document.getElementById('dropdownMenuButton1');

        iconItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const icon = this.getAttribute('data-icon');
                selectedIconInput.value = icon;
                dropdownButton.textContent = 'Icon Selected';
            });
        });
    });
</script>
@endpush
