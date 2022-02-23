@extends('admin.layouts.app', ['page' => 'orders'])
@section('title')
    Order: {{ $order->id }}
@stop
@section('scripts.header')

@stop
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-gray-800">Order ID: <strong>{{ $order->id }}</strong></h1>
        <div>
            <a href="{{ route('admin.order.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-box fa-sm text-white-50"></i> All Orders</a>
        </div>
    </div>
    <div class="row">
        <div class="col-9">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h1 class="h3 mb-0 text-gray-800">Meals</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($order->boxItems as $boxItem)
                            <div class="col-4 d-flex align-items-stretch">
                                <div class="card shadow mb-4">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">SKU: {{ $boxItem->itemable->sku }}</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $boxItem->itemable->title }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h1 class="h4 mb-0 text-gray-800">Shipping Details</h1>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th scope="row">Name</th>
                            <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Address 1</th>
                            <td>{{ $shipping->address_line_1 }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Address 2</th>
                            <td>{{ $shipping->address_line_2 }}</td>
                        </tr>
                        <tr>
                            <th scope="row">City</th>
                            <td>{{ $shipping->city }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Province/State</th>
                            <td>{{ $shipping->state }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Country</th>
                            <td>{{ $shipping->country }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Postal/Zip Code</th>
                            <td>{{ $shipping->postal_code }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Delivery Instructions</th>
                            <td>{{ $shipping->delivery_instructions }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5 >Order Status</h5>
                    <form method="POST" action="{{ route('admin.order.update', $order->id) }}">
                        @csrf
                        @method('patch')
                        <ul class="nav flex-column nav-pills order-status-list">
                            <li class="nav-item">
                                <button type="submit" name="order_status" value="pending" {{ $order->order_status == 'pending' ? 'disabled' : '' }}
                                    class="btn nav-link {{ $order->order_status == 'pending' ? 'active' : '' }}">
                                    <i class="fas fa-box-open"></i> Pending
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="submit" name="order_status" value="in-prep" {{ $order->order_status == 'in-prep' ? 'disabled' : '' }}
                                    class="btn nav-link {{ $order->order_status == 'in-prep' ? 'active' : '' }}">
                                    <i class="fas fa-people-carry"></i> In Prep
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="submit" name="order_status" value="ready-for-shipping" {{ $order->order_status == 'ready-for-shipping' ? 'disabled' : '' }}
                                    class="btn nav-link {{ $order->order_status == 'ready-for-shipping' ? 'active' : '' }}">
                                    <i class="fas fa-truck-loading"></i> Ready For Shipping
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="submit" name="order_status" value="shipped" {{ $order->order_status == 'shipped' ? 'disabled' : '' }}
                                    class="btn nav-link {{ $order->order_status == 'shipped' ? 'active' : '' }}">
                                    <i class="fas fa-truck"></i> Shipped
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="submit" name="order_status" value="delivered" {{ $order->order_status == 'delivered' ? 'disabled' : '' }}
                                    class="btn nav-link {{ $order->order_status == 'delivered' ? 'active' : '' }}">
                                    <i class="fas fa-home"></i> Delivered
                                </button>
                            </li>
                        </ul>

                    </form>
                    <h5 class="mt-4">Shipping Date</h5>
                    <p class="text-info"><strong>{{ date('M d, Y', strtotime($order->start_date)) }}</strong> <small>({{ $order->start_date->diffForHumans() }})</small></p>
                    <h5 class="mt-4">Box Status</h5>
                    <p>
                        @switch($order->status)
                            @case('skipped')
                            <span class="text-danger"><i class="fas fa-times"></i> Skipped</span>
                            @break

                            @case('ordered')
                            <span class="text-info">Ordered</span>
                            @break

                            @case('completed')
                            <span class="text-success"><i class="fas fa-check"></i> Completed</span>
                            @break
                        @endswitch
                    </p>

                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts.footer')

@stop
