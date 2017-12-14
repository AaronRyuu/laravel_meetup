@extends('layouts.app')

@section('content')
    <div class="am-container">
        <div class="header">
            <div class="am-g">
                <h1>添加新活动</h1>
            </div>
            <hr>
        </div>

        <form class="am-form" action="{{route('issues.store')}}" method="post">
            {{ csrf_field() }}
            <fieldset>
                <div class="am-form-group">
                    <label>标题</label>
                    <input type="text" placeholder="输入活动标题" name="title">
                </div>

                <div class="am-form-group">
                    <label>内容</label>
                    <textarea rows="5" name="content"></textarea>
                </div>

                <button type="submit" class="am-btn am-btn-default">提交</button>
            </fieldset>
        </form>
    </div>
@endsection