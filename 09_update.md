---
layout: default
title: 更新一个资源
---

现在活动的`读取`、`删除`、`添加`都已经完成了。
这一集我们来实现`CURD`里面，最后的`update`。

![](media/15099747133489.jpg)

## 修改链接
来添加一个 `edit` 的链接，到 `views/issues/show.blade.php`中

```html
<a href="{{route('issues.edit', $issue->id)}}"...>Edit</a>
```

## route

```php
Route::get('issues/{issue}/edit', 'IssuesController@edit')->name('issues.edit');
```

> 注意：这一行路由要写在 get 'issues/{issue}' 的上面。


## controller

`IssuesController.php`中添加

```php
public function edit($id)
{
    $issue = Issue::find($id);
    return view('issues.edit')->with('issue', $issue);
}
```

## edit页面

最重要的是要有 `views/issues/edit.blade.php`。

1. 把 `create.blade.php`中的内容原封不动搬过来，命名为`edit.blade.php`。
2. 标题改为`<h1>修改活动</h1>`
3. `form`的`action`改为`{{route('issues.update', $issue->id)}}`
4. 填写标题的`input`标签中加上 `value="{{$issue->title}}"`
5. 在`textarea`的开始与结束标签中间，加上`{{$issue->content}}`

> Tips: `input`标签有`value`属性，而`textarea`标签直接写在两个`textarea`的中间就好。

浏览报错，相信你已经非常清楚的知道，我们又要去`web.php`中添加对应的`route`了

```php
Route::put('issues/{issue}', 'IssuesController@update')->name('issues.update');
```

因为这里使用了`put`动词，而`form`表单并不能发起`put`、`patch`和`delete`请求。
`larave`的解决方式是，添加 {% raw %}`{{ method_field('PUT') }}`{% endraw %}，来伪造一个`put`请求。

最终得到的页面

```html
@extends('layouts.app')

@section('content')
    <div class="am-container">
        <div class="header">
            <div class="am-g">
                <h1>修改活动</h1>
            </div>
            <hr>
        </div>

        <form class="am-form" action="{{route('issues.update', $issue->id)}}" method="post">
            {% raw %}
			{{ csrf_field() }}
            {{ method_field('PUT') }}
			{% endraw %}
            
            <fieldset>
                <div class="am-form-group">
                    <label>标题</label>
                    <input type="text" placeholder="输入活动标题" name="title" value="{{$issue->title}}">
                </div>

                <div class="am-form-group">
                    <label>内容</label>
                    <textarea rows="5" name="content">{{$issue->content}}</textarea>
                </div>

                <button type="submit" class="am-btn am-btn-default">提交</button>
            </fieldset>
        </form>
    </div>
@endsection
```

## 更新数据库

`controller`中，添加`update`方法

```php
public function update(Request $request, $id)
{
    $issue = Issue::find($id);
    $issue->update($request->all());
    return redirect(route('issues.show', $id));
}
```

提交一下试试，活动已经可以修改了。不错不错，`CURD`的所有功能都已经完美实现。
