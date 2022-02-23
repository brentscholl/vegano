@extends('admin.layouts.app', ['page' => 'orders'])
@section('title')
    View Orders
@stop
@section('scripts.header')

@stop
@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-gray-800">
            @switch( app('request')->input('country') )
                @case('cad')
                Canadian Orders
                @break
                @case('usa')
                American Orders
                @break
                @default
                All Orders
            @endswitch
        </h1>
        <div>
            @switch( app('request')->input('country') )
                @case('cad')
                <a href="{{ route('admin.order.prep-station', ['country' => 'cad']) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-people-carry fa-sm text-white-50"></i> Prep Station <i class="fab fa-canadian-maple-leaf"></i></a>
                @break
                @case('usa')
                <a href="{{ route('admin.order.prep-station', ['country' => 'usa']) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-people-carry fa-sm text-white-50"></i> Prep Station <i class="fas fa-flag-usa"></i></a>
                @break
            @endswitch
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-auto">
            <form method="get">
                <input type="hidden" name="country" value="{{app('request')->input('country')}}">
                <ul class="nav nav-pills mb-4">
                    <li class="nav-item">
                        <button type="submit" name="order_status" value=""
                            class="btn nav-link {{ $query == '' ? 'active' : '' }}">
                            <i class="fas fa-box"></i> All Orders <span class="badge badge-info">{{ $allBoxes->where('status','!=', 'open')->Where('status', '!=', 'skipped')->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="submit" name="order_status" value="pending"
                            class="btn nav-link {{ $query == 'pending' ? 'active' : '' }}">
                            <i class="fas fa-box-open"></i> Pending <span class="badge badge-info">{{ $allBoxes->where('order_status', 'pending')->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="submit" name="order_status" value="in-prep"
                            class="btn nav-link {{ $query == 'in-prep' ? 'active' : '' }}">
                            <i class="fas fa-people-carry"></i> In Prep <span class="badge badge-info">{{ $allBoxes->where('order_status', 'in-prep')->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="submit" name="order_status" value="ready-for-shipping"
                            class="btn nav-link {{ $query == 'ready-for-shipping' ? 'active' : '' }}">
                            <i class="fas fa-truck-loading"></i> Ready For Shipping <span class="badge badge-info">{{ $allBoxes->where('order_status', 'ready-for-shipping')->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="submit" name="order_status" value="shipped"
                            class="btn nav-link {{ $query == 'shipped' ? 'active' : '' }}">
                            <i class="fas fa-truck"></i> Shipped <span class="badge badge-info">{{ $allBoxes->where('order_status', 'shipped')->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="submit" name="order_status" value="delivered"
                            class="btn nav-link {{ $query == 'delivered' ? 'active' : '' }}">
                            <i class="fas fa-home"></i> Delivered <span class="badge badge-info">{{ $allBoxes->where('order_status', 'delivered')->count() }}</span>
                        </button>
                    </li>
                </ul>
            </form>
        </div>
    </div>
    <div class="row justify-content-center mb-4">
        <div class="col">
            <form method="get" id="boxes-search-form"
                class="search-bar">
                <input type="hidden" name="country" value="{{app('request')->input('country')}}">
                <input type="hidden" name="order_status" value="{{app('request')->input('order_status')}}">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    {!! Form::select('search_by',array(
                        '' => 'Search By...',
                        'id' => 'Order ID',
                        'user_id' => 'User ID',
                        'meal' => 'Meal',
                    ), session('SEARCH.SEARCH_BY') , array('class'=>'form-control', 'id' => 'search_by')) !!}

                    @if(session('SEARCH.SEARCH_BY') == 'meal')
                        {!! Form::text('search_txt', session('SEARCH.SEARCH_TXT') ,array('id' => 'search_txt', 'class' => 'form-control', 'style' => 'display:none;')) !!}
                        {!! Form::select('meal_id',$mealList, session('SEARCH.MEAL_ID') , array('class'=>'form-control', 'id' => 'meal_id', 'style' => 'display:inline-block;')) !!}
                    @else
                        {!! Form::text('search_txt', session('SEARCH.SEARCH_TXT') ,array('id' => 'search_txt', 'class' => 'form-control','placeholder'=>'Search')) !!}
                        {!! Form::select('meal_id',$mealList, session('SEARCH.MEAL_ID') , array('class'=>'form-control', 'id' => 'meal_id', 'style' => 'display:none;')) !!}
                    @endif

                    <div class="input-group-append">
                        {!! Form::submit('Search', array('id' => 'search', 'name' => '', 'class' => 'btn btn-primary')) !!}
                        {!! Form::button('Reset',array('type'=>'submit','id' => 'reset', 'name' => 'reset', 'value' => '1', 'class' => 'btn btn-secondary')) !!}
                    </div>
                </div>
            </form>
        </div>
    </div>



    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                <thead>
                <tr role="row">
                    <th>ID</th>
                    <th>Box Status</th>
                    <th>Order Status</th>
                    <th>Meals</th>
                    <th>Shipping Date & Address</th>
                    <th>User (ID | Name)</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Box Status</th>
                    <th>Order Status</th>
                    <th>Meals</th>
                    <th>Shipping Date & Address</th>
                    <th>User (ID | Name)</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($orders as $order)
                    <tr role="row" class="odd">
                        <td><a href="#" title="View Box"><strong>{{ $order->id }}</strong></a></td>
                        <td>
                            <strong>
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
                            </strong>
                        </td>
                        <td>
                            <strong>
                            @switch($order->order_status)
                                @case('pending')
                                <i class="fas fa-box-open"></i> Pending
                                @break

                                @case('in-prep')
                                <span class="text-primary"><i class="fas fa-people-carry"></i> In Prep</span>
                                @break

                                @case('ready-for-shipping')
                                <span class="text-warning"><i class="fas fa-truck-loading"></i> Ready For Shipping</span>
                                @break

                                @case('shipped')
                                <span class="text-success"><i class="fas fa-truck"></i> Shipped</span>
                                @break

                                @case('delivered')
                                <span class="text-success"><i class="fas fa-home"></i> Delivered</span>
                                @break
                            @endswitch
                            </strong>
                        </td>
                        <td>
                            <ul>
                                @foreach($order->boxItems as $b)
                                    <li>{{ $b->itemable->title }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <strong>{{ date('M d, Y', strtotime($order->start_date)) }}</strong><br>
                            {{ $order->user->shipping->address_line_1 }} {{ $order->user->shipping->address_line_2 }}<br>{{ $order->user->shipping->city }}, {{ $order->user->shipping->state }}, {{ $order->user->shipping->country }}, {{ $order->user->shipping->postal_code }}
                        </td>
                        <td>
                            <strong>{{ $order->user->id }}</strong> | {{ $order->user->first_name }} {{ $order->user->last_name }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-eye"></i>
                                </span>
                                <span class="text">View Details</span>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $paginator !!}
        </div>
    </div>

@endsection
@section('scripts.footer')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#search_by').change(function () {
                if ($('#search_by').val() == 'meal') {
                    $("#meal_id").show();
                    $("#search_txt").hide();
                } else {
                    $("#meal_id").hide();
                    $("#search_txt").show();
                }
            });

            $(window).on('load', function () {
                $('#search_by').trigger('change');
            });
        });
    </script>
@stop
