@extends('partials.layouts.master')

@section('title', 'การสั่งซื้อ | FabKin Admin & Dashboards Template')
@section('title-sub', 'E-commerce')
@section('pagetitle', 'ดำเนินการสั่งซื้อ')
@section('content')

    <div id="layout-wrapper">

        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                </div>

                            <div class="tab-content">
                                <div class="tab-pane fade" id="pills-bill-info" role="tabpanel"
                                    aria-labelledby="pills-bill-info-tab">
                                    <p class="mb-1 fw-semibold text-end text-muted op-5 fs-20">01</p>
                                    <p class="fs-15 fw-semibold">รายละเอียดผู้ติดต่อ:</p>
                                    <div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="billinginfo-firstName" class="form-label">ชื่อจริง</label>
                                                    <input type="text" class="form-control" id="billinginfo-firstName"
                                                        name="first_name" placeholder="ใส่ชื่อจริง" 
                                                        value="{{ old('first_name', $user->first_name ?? '') }}">
                                                </div>
                                            </div>
                                            </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">เบอร์โทรศัพท์</label>
                                                    <input type="tel" class="form-control" name="phone_number" 
                                                        value="{{ old('phone_number', $user->phone_number ?? '') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="billinginfo-address" class="form-label">ที่อยู่ (บ้านเลขที่, ถนน)</label>
                                            <textarea class="form-control" id="billinginfo-address" name="address_line" 
                                                placeholder="ใส่ที่อยู่จัดส่ง" rows="3">{{ old('address_line', $billing_address->address_line ?? '') }}</textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-3"><label class="form-label">จังหวัด</label></div>
                                            <div class="col-sm-3"><label class="form-label">อำเภอ/เขต</label></div>
                                            <div class="col-sm-3"><label class="form-label">ตำบล/แขวง</label></div>
                                            <div class="col-sm-3"><label class="form-label">รหัสไปรษณีย์</label></div>
                                        </div>

                                        <div class="d-flex align-items-start gap-3 mt-3">
                                            <button type="button" class="btn btn-primary ms-auto"
                                                data-nexttab="pills-bill-address-tab">
                                                <i class="ri-truck-line me-2"></i>
                                                ดำเนินการต่อเพื่อจัดส่ง
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade active show" id="pills-bill-address" role="tabpanel"
                                    aria-labelledby="pills-bill-address-tab">
                                    <p class="mb-1 fw-semibold text-end text-muted op-5 fs-20">02</p>
                                    <p class="fs-15 fw-semibold">ที่อยู่ที่บันทึกไว้:</p>
                                    <div class="mt-4">
                                        <div class="row gy-3">
                                            @foreach ($user->addresses as $address)
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="card address-content">
                                                    <div class="card-body">
                                                        <div>
                                                            <label class="check-box">
                                                                <input id="shippingAddress{{ $address->id }}" name="shippingAddress"
                                                                    type="radio" class="form-check-input" 
                                                                    value="{{ $address->id }}" {{ $address->is_default ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="shippingAddress{{ $address->id }}">
                                                                    <span
                                                                        class="mb-4 fw-semibold d-block text-uppercase">{{ $address->address_type ?? 'ที่อยู่หลัก' }}
                                                                        </span>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div>
                                                            <p class="text-muted">{{ $address->address_line }}, {{ $address->sub_district_name }}, {{ $address->district_name }}, {{ $address->province_name }}, {{ $address->zip_code }}</p>
                                                            <p>โทรศัพท์: {{ $address->phone_number }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            <div class="col-lg-4 col-sm-6">
                                                </div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-start gap-3 mt-4">
                                        <button type="button" class="btn btn-primary ms-auto"
                                            data-nexttab="pills-payment-tab">
                                            <i class="ri-bank-card-line me-2"></i> ดำเนินการต่อเพื่อชำระเงิน
                                        </button>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-payment" role="tabpanel"
                                    aria-labelledby="pills-payment-tab">
                                    <p class="mb-1 fw-semibold text-end text-muted op-5 fs-20">03</p>
                                    <p class="fs-15 fw-semibold">รายละเอียดการชำระเงิน:</p>
                                    <div class="d-flex align-items-center gap-6">
                                        @foreach ($payment_methods as $method)
                                        <div class="border rounded w-100 p-4">
                                            <div data-bs-toggle="collapse" data-bs-target="#paymentmethodCollapse.show"
                                                aria-expanded="false" aria-controls="paymentmethodCollapse">
                                                <div class="form-check card-radio">
                                                    <input id="paymentMethod{{ $method->id }}" name="payment_option" type="radio"
                                                        class="form-check-input" value="{{ $method->name }}" {{ $method->is_default ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="paymentMethod{{ $method->id }}">
                                                        <span class="fs-16 text-muted me-2"><i
                                                                class="{{ $method->icon_class }} align-bottom"></i></span>
                                                        <span class="fs-14 text-wrap">{{ $method->name_thai }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="d-flex align-items-start gap-3 mt-4">
                                        <button type="submit" class="btn btn-primary btn-label right ms-auto nexttab"
                                            data-nexttab="pills-finish-tab"><i
                                                class="ri-shopping-basket-line label-icon align-middle fs-16 ms-2"></i>ยืนยันคำสั่งซื้อ</button>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-finish" role="tabpanel"
                                    aria-labelledby="pills-finish-tab">
                                    <div class="text-center mx-auto w-384px p-5 rounded shadow-lg mt-6">
                                        <h4 class="fw-semibold text-success">ชำระเงินสำเร็จ!</h4>
                                        <p class="text-muted">ขอบคุณสำหรับการสั่งซื้อ ระบบได้บันทึกคำสั่งซื้อของคุณเรียบร้อยแล้ว</p>

                                        <h6 class="fw-semibold mt-3">หมายเลขคำสั่งซื้อ:
                                            <a href="{{ route('order.details', $order->id) }}"
                                                class="text-decoration-underline text-primary">{{ $order->order_id }}</a>
                                        </h6>
                                    </div>

                                </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-borderless border rounded">
                                <tbody>
                                    @foreach ($cart_items as $item)
                                    <tr>
                                        <td class="text-end">{{ number_format($item->total_price, 2) }} บาท</td>
                                    </tr>
                                    @endforeach
                                    
                                    <tr>
                                        <td colspan="2"><span class="fs-14">ราคารวมสินค้า</span></td>
                                        <td class="text-end"><span class="fs-14 fw-semibold">{{ number_format($subtotal, 2) }} บาท</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><span class="fs-14">ค่าจัดส่ง</span></td>
                                        <td class="text-end"><span class="fs-14 fw-semibold">{{ number_format($delivery_cost, 2) }} บาท</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><span class="fs-14">ส่วนลดรวม</span></td>
                                        <td class="text-end "><span class="fs-14 fw-semibold">{{ $discount_display }}</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><span class="fs-14">ภาษีมูลค่าเพิ่ม (VAT)</span></td>
                                        <td class="text-end fs-14 fw-semibold">{{ $tax_display }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td colspan="2"><span class="fw-semibold fs-14">ยอดรวมสุทธิ</span></td>
                                        <td class="text-end "><span class="fw-semibold fs-14">{{ number_format($grand_total, 2) }} บาท</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
