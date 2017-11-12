---
layout: default
title: 天啊，一大堆issues
---

数据库中目前只有几个活动信息。假如不断有用户发布新的活动，但是首页只能显示最新发布的两个活动。显示太多了首页也不好看啊，这就是一个大问题了。
这一集，我们添加一个`index`页面，用它来显示所有的活动。

## 添加一大堆issues

![](media/15099692106969.jpg)


先使用我们上一集做好的新增功能，往数据库中插入10条以上数据。

## 修改链接

`layouts/app.blade.php`布局模板中，修改`活动`的链接地址

```html
{% raw %}<a href="{{route('issues.index')}}">活动</a>{% endraw %}
```

## route

web.php中，添加`index`页面的路由

```php
Route::get('issues', 'IssuesController@index')->name('issues.index');
```

## controller

```php
public function index()
{
    $issues = Issue::orderBy('created_at', 'desc')->get();
    return view('issues.index')->with('issues', $issues);
}
```

> Tips: 在查询完数据库，我们习惯性首先 `return $issues;`，确认所查询的数据是完全正确的，再删除掉这条代码。

## 增加一个index页面

1. 复制`issues_index.html`到`views/issues`目录下，改名为`index.blade.php`
2. 处理布局模板。
3. 删除重复的`<li>...</li>`标签，只保留一条`<li>...</li>`。
4. `foreach`循环`li`标签，显示正确的活动信息。

```html
{% raw %}
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
                3 days ago
            </div>
        </div>
        <div class="am-u-sm-3 am-u-md-2 issue-comment-count">
            <span class="am-icon-comments"></span>
            <a href="{{route('issues.show', $issue->id)}}">2</a>
        </div>
    </li>
@endforeach
{% endraw %}
```

## 分页

现在看起来已经非常好了，不过随着用户发布的活动越来越多，一页就显示不下了。
这就需要用到分页来处理了，https://laravel.com/docs/5.5/pagination

在`laravel`中，分页相当的容易。

1.修改`controller`，将之前查询用的`get()`，改为`paginate(5)`。
这里`5`的意思是说，每页显示`5条`数据。

```php
$issues = Issue::orderBy('created_at', 'desc')->paginate(5);
```

2.`issues/index.blade.php`中，用`{% raw %}{{ $issues->links() }}{% endraw %}`，代替之前写死的分页代码。


![](media/15099716345098.jpg)
浏览一下，perfect！

