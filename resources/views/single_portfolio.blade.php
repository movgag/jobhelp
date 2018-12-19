@extends('layout')

@section('content')

    <div class="breadcrumb-banner-area pt-94 pb-85 bg-3 bg-opacity-dark-blue-90">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-text">
                        <h2 class="text-center text-white uppercase mb-17">{{ $data['portfolio']->title }}</h2>
                        <div class="breadcrumb-bar">
                            <ul class="text-center m-0">
                                <li class="text-white uppercase ml-15 mr-15">Author: {{' '.$data['portfolio']->employee()->first()->name.' '.$data['portfolio']->employee()->first()->last_name}} </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End of Breadcrumb Banner Area-->
    <!--Start of Blog Area-->
    <div class="blog-area pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="single-blog hover-effect mb-50">
                        <div class="blog-image box-hover">
                            <a class="block">
                                <img class="single_portfolio_img" src="{{ asset('/images/emp-portfolios/'.$data['portfolio']->image) }}" alt="">
                            </a>
                        </div>
                        <div class="blog-text">
                            <div class="blog-date pt-12">
                                <span class="text-large block text-white">{{ \Carbon\Carbon::parse($data['portfolio']->created_at)->format('d') }}</span>
                                <span class="uppercase block text-white">{{ \Carbon\Carbon::parse($data['portfolio']->created_at)->format('F') }}</span>
                            </div>
                            <div class="blog-post-info">
                                <span class="pl-20 l-text"><i class="zmdi zmdi-account pr-8"></i>
                                    {{ $data['portfolio']->employee()->first()->name.' '.$data['portfolio']->employee()->first()->last_name }}
                                </span>
                            </div>
                            <h5 class="pt-42 mb-14 l-text">{{ $data['portfolio']->title }}</h5>
                            <p class="mb-25">{{ $data['portfolio']->description }}</p>

                        </div>
                    </div>
                    <div class=" {{--tags-and-links--}} fix pt-14 pb-12">

                        {{--<div class="related-tag pull-left">--}}
                            {{--<span class="mr-10">Tag:</span>--}}
                            {{--<ul class="tags">--}}
                                {{--<li><a href="#">job</a></li>--}}
                                {{--<li><a href="#">new</a></li>--}}
                                {{--<li><a href="#">job board</a></li>--}}
                                {{--<li><a href="#">job help</a></li>--}}
                                {{--<li><a href="#">job offer</a></li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}

                        {{--<div class="social-links pull-right">--}}
                            {{--<span>Share:</span>--}}
                            {{--<a href="#"><i class="zmdi zmdi-facebook"></i></a>--}}
                            {{--<a href="#"><i class="zmdi zmdi-twitter"></i></a>--}}
                            {{--<a href="#"><i class="zmdi zmdi-google-old"></i></a>--}}
                            {{--<a href="#"><i class="zmdi zmdi-instagram"></i></a>--}}
                        {{--</div>--}}


                    </div>

                </div>
                <div class="col-md-4">

                    <div class="single-sidebar-widget mb-48">
                        <div class="sidebar-widget-title">
                            <h4 class="mb-23">Random Portfolios</h4>
                        </div>
                        <div class="recent-posts light-gray-bg">
                            @if($data['portfolios'] && count($data['portfolios']) > 0)
                                @foreach($data['portfolios'] as $item)
                                    <div class="recent-post-item pl-30 ptb-20">
                                        <h5 class="mb-6"><a href="{{ route('single.portfolio',['id'=>$item->id]) }}">{{$item->title}}</a></h5>
                                        <span class="block"><i class="zmdi zmdi-account mr-10 mb-5"></i>
                                            {{$item->employee()->first()->name.' '.$item->employee()->first()->last_name}}
                                        </span>
                                        <span class="block"><i class="zmdi zmdi-calendar-check mr-10"></i>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection