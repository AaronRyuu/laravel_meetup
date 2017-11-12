---
layout: default
title: 笨办法发消息
---

首页显示的两条最新活动，是我们`html模板`中写死的数据。他们与我们`php`程序一点关系都没有。
现在我们就想办法，让这两条数据从 `controller`中发出，然后在模板中显示。

![](media/15099747987377.jpg)

## controller里传数据

```php
public function index()
{

    $issues = [
        ['title' => 'PHP lovers'],
        ['title' => 'Rails and Laravel']
    ];
    return view('welcome.index')->with('issues', $issues);
}
```

## 修改index.blade.php

删除一条重复的issue，然后给另一条做foreach循环

```html
@foreach($issues as $issue)
    <li class="...">
        ...
        {% raw %}<a href="issues_show.html">{{$issue['title']}}</a>{% endraw %}
        ...
    </li>
@endforeach
```

刷新页面，看到数据已经显示为我们控制器中的数据了

##  Sub-Views

https://laravel.com/docs/5.5/blade#including-sub-views

对于最新活动列表，我们还可以把他分离为一个 子视图文件。

### 步骤

1. 在 `resources/views/welcome` 中添加活动列表 `_issue_list.blade.php`文件。
2. 将`index.blade.php`中`活动列表部分`的代码，剪切到`_issue_list.blade.php`中。
3. 再到 `index.blade.php`中加上

```php
@include('welcome._issue_list')
```

重新访问，依然可以正常显示。

> Tips: 我个人习惯将 `子视图`文件名，加上一个`_`前缀，这个习惯也是来自于`ruby on rails`了。好处是，可以直观的把子视图和其他模板区分开。

