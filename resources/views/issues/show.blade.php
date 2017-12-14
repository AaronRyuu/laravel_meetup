@extends('layouts.app')

@section('content')

    <div class="issue-heading">
        <div class="am-container">
            {{$issue->title}}
            <a href="{{route('issues.destroy', $issue->id)}}" data-method="delete" data-token="{{csrf_token()}}" data-confirm="Are you sure?" type="button" class="am-btn am-btn-danger am-radius am-btn-sm">Destroy</a>
            <a href="{{route('issues.edit', $issue->id)}}" type="button" class="am-btn am-btn-primary am-radius am-btn-sm">Edit</a>
        </div>
    </div>

    <div class="am-container">
        <ul class="am-comments-list am-comments-list-flip">

            <li class="am-comment">
                <img src="/assets/img/avatar1.png" alt="" class="am-comment-avatar" width="100" height="100">
                <div class="am-comment-main">
                    <header class="am-comment-hd">
                        <div class="am-comment-meta">
                            <span class="am-comment-author">Aaron</span>
                        </div>
                    </header>
                    <div class="am-comment-bd"><p>{{$issue->content}}</p></div>
                </div>
            </li>

            @foreach($comments as $comment)

                <li class="am-comment">
                    <img src="{{$comment->avatar()}}" alt="" class="am-comment-avatar" width="48" height="48">

                    <div class="am-comment-main">
                        <header class="am-comment-hd">
                            <div class="am-comment-meta">
                                <span class="am-comment-author">{{$comment->name}}</span>
                                {{$comment->created_at->diffForHumans()}}
                            </div>
                        </header>
                        <div class="am-comment-bd"><p>{{$comment->content}}</p></div>
                    </div>
                </li>
            @endforeach
        </ul>

        <form class="am-form" method="post" action="{{route('comments.store')}}">
            {{csrf_field()}}
            <input type="hidden" name="issue_id" value="{{$issue->id}}">

            <fieldset>
                <div class="am-form-group">
                    <label>用户名</label>
                    <input type="text" placeholder="输入用户名" name="name">
                </div>

                <div class="am-form-group">
                    <label>邮箱</label>
                    <input type="email" placeholder="输入邮箱" name="email">
                </div>

                <div class="am-form-group">
                    <textarea rows="5" name="content"></textarea>
                </div>

                <p>
                    <button type="submit" class="am-btn am-btn-default">提交</button>
                </p>
            </fieldset>
        </form>
    </div>
@endsection