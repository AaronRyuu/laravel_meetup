---
layout: default
title: Code Beauty
---

## resource路由

再来优化一下路由部分。每一个访问地址，都要对应一条路由，而且还要自己定义`name`，实在是非常麻烦啊。那么有没有简便点的办法呢？其实`laravel`已经帮你准备好了。
方法就在https://laravel.com/docs/5.5/controllers#resource-controllers

到 `web.php` 中，所有的指向 IssuesController.rb 的语句都删除，而用一行代替

```php
Route::resource('issues', 'IssuesController');
```

这一行到底起什么作用？到终端中一看便知。

```bash
php artisan route:list
```

> Tips: 如果单独定义的路由，与下面表格中的一模一样。就可以直接使用 `resource route`来简化代码。

| Verb | URI | Action | Route Name | 作用 | 
| --- | --- | --- | --- | --- |
| GET | /issues | index | issues.index | 列表显示所有的issues |
| GET | /issues/create | create  | issues.create | 显示新增issue的表单 |
| POST | /issues | store  | issues.store | 真正执行新增操作，插入数据库 |
| GET | /issues/{issue} | show  | issues.show | 显示一条issue |
| GET | /issues/{issue}/edit | edit  | issues.edit | 显示编辑issue的表单 |
| PUT/PATCH | /issues/{issue} | update  | issues.update | 真正执行更新操作，修改数据库 |
| DELETE | /issues/{issue} | destory  | issues.destroy | 删除issue |


![](media/15099773171196.jpg)

再来访问试试，太棒了，所有功能都依然可以正常使用。

## 时间的展示

数据库中所有的表，运行`migrate`的时候，都被`laravel`加上了`created_at`与`updated_at`。
这两个字段我们无需任何处理，`laravel`会自动在`新增`和`修改`的时候，帮我们填上。

一个小点需要调整，`首页`和`活动列表页`的`Issue`都没有时间。

在`welcome/_issue_list.blade.php`与`issues/index.blade.php`中，找到`3 days ago`，用下面的代码代替：

```php
{% raw %}{{$issue->created_at->diffForHumans()}}{% endraw %}
```


