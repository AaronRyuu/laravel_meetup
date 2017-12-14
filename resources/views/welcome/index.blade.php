@extends('layouts.app')

@section('content')

    <div class="get">
        <div class="am-g">
            <div class="am-u-lg-12">
                <h1 class="get-title">It's Party Time!<br>Drink Up!</h1>

                <p>到时聚聚、聊聊程序</p>

                <p>
                    <a href="{{route('issues.create')}}" class="am-btn am-btn-default am-btn-secondary">发布新活动</a>
                </p>
            </div>
        </div>
    </div>

    <div class="detail">
        <div class="am-g am-container">
            <div class="am-u-lg-12">
                <h1 class="detail-h1">最新的活动</h1>
            </div>
        </div>
    </div>

    @include('welcome._issue_list')
@endsection