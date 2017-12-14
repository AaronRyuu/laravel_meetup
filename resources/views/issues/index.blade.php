@extends('layouts.app')
@section('content')
    
    <div class="detail">
        <div class="am-g am-container">
            <div class="am-u-lg-12">
                <h1 class="detail-h1">所有的活动都在下面了...</h1>
            </div>
        </div>
    </div>

    <div class="am-container">
        <div data-am-widget="list_news" class="am-list-news am-list-news-default">
            <!--列表标题-->
            <div class="am-list-news-bd">
                <ul class="am-list">

                    @foreach($issues as $issue)
                        <li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-left">
                            <div class="am-u-sm-2 am-u-md-1 am-list-thumb">
                                <a href="{{route('issues.show', $issue->id)}}">
                                    <img src="assets/img/avatar1.png" alt=""/>
                                </a>
                            </div>

                            <div class="am-u-sm-7 am-u-md-9 am-list-main">
                                <h3 class="am-list-item-hd">
                                    <a href="{{route('issues.show', $issue->id)}}" class="">{{$issue->title}}</a>
                                </h3>

                                <div class="am-list-item-text">
                                    <span class="am-badge am-badge-secondary am-radius">read</span>
                                    <span class="meta-data">Aaron</span>
                                    {{$issue->created_at->diffForHumans()}}
                                </div>
                            </div>
                            <div class="am-u-sm-3 am-u-md-2 issue-comment-count">
                                <span class="am-icon-comments"></span>
                                <a href="{{route('issues.show', $issue->id)}}">2</a>
                            </div>
                        </li>
                    @endforeach
                </ul>

                {{ $issues->links() }}
            </div>
        </div>
    </div>
@endsection