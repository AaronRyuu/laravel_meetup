{% raw % }
现在有了 `issue` 也就是活动信息这个东东，后面就开始对他 `Create` `Update` `Read` `Delete` 了。

这一集只是开始，瞄准 `issue`的展示和删除 。 关于 `CURD` 比较详细的解释，参考 https://laravel.com/docs/5.5/eloquent#inserting-and-updating-models

## issue的展示
![](media/15099749555633.jpg)


### 添加 content 到 issue

首先运行一下 migration

```bash
php artisan make:migration add_content_to_issues_table --table=issues
```

修改migration文件

```php
class AddContentToIssuesTable extends Migration
{
    public function up()
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->text('content');
        });
    }

    public function down()
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->dropColumn('content');
        });
    }
}
```

别忘了`php artisan migrate`，来跑一下迁移命令。

> Tips: `down`里面写的是 `up`的反操作。将来如果写错了，将来可以通过`php artisan migrate:rollback`这一条命令来回滚对数据库的操作。


### 插入一下数据
下面打开 `php artisan tinker` 

```php
use App\Models\Issue
$i = Issue::find(1)
$i->content = "The PHP Framework For Web Artisans"
$i->save()

$i = Issue::find(2)
$i->content = "Imagine what you could build if you learned Ruby on Rails ..."
$i->save()
```

### 添加路由

在`web.php中`加上

```php
Route::get('issues/{issue}', 'IssuesController@show');
```

到 `_issue_list.blade.php` 中添加指向 IssuesController@show 页面的链接

```html
<a href="/issues/{{$issue->id}}">{{$issue->title}}</a>
```

访问一下，屏幕提示`IssuesController does not exist`，相信你一看到这个提示，就应该知道下面我们应该做什么了。

### 新建控制器

```bash
php artisan make:controller IssuesController -r
```
控制器中会自动生成7个方法，分别用来处理 `issues` 的`CURD`操作了。
先得到 `IssuesController` 中

```php
public function show($id)
{
    echo $id;
}
```

这样敲链接 `http://127.0.0.1:8000/issues/1` 页面上就显示 `1`，敲 `http://127.0.0.1:8000/issues/2` 的时候页面就显示 `2`。
那这个 $id 的作用也就清楚了。当然这只是处于调试目的，所以这一行可以删掉。

> 重点注意：首先要来use这个模型

```php
use App\Models\Issue;
```

```php
public function show($id)
{
    $issue = Issue::find($id);
    return view('issues.show')->with('issue', $issue);
}
```

### 添加show页面

下面就是要填充 `views/issues/show.blade.php` 中的内容了。这样 `show` 页面中再添加合适的 `php` 语句就可以展示清楚了。

1. 在`resources/views`中新建一个`issues`文件夹
2. 将`issues_show.html`模板放入`issues`目录中，并改名为`show.blade.php`。
3. 访问一下，确认能正常显示。修改图片的路径为`<img src="/...`。使用布局模板。
4. 将以前写死的数据，换成我们从数据库中读取的内容。

```html
<!-- 标题 -->
 <div class="issue-heading">
    ...
    {{$issue->title}}
    ...
</div>

<!-- 内容 -->
<div class="am-comment-bd">{{$issue->content}}</div>
```

### 使用命名路由

但是再来稍微优化一些代码。到 `_issue_list.blade.php`，修改`/issues/{{$issue->id}}`为

```php
{{route('issues.show', $issue->id)}}
```

这样当然会报错，这是`laravel` 提供了给路由起名字的机制，叫 `named route`，需要做的就是到 web.php 中

```php
Route::get('issues/{issue}', 'IssuesController@show')->name('issues.show');
```

现在就行了。

## 删除一个资源

现在就来看如果删除一个资源。还是从 `view` 中的链接开始写。在 `issues/show.blade.php` 中添加删除的链接地址。

```html
<a href="{{route('issues.destroy', $issue->id)}}" ...>Destroy</a>
```

对应的 web.php路由 中要添加

```php
Route::delete('issues/{issue}', 'IssuesController@destroy')->name('issues.destroy');
```

点击删除后，发现依然跳转到了当前页面，这是因为我们路由中定义的是`delete`动作，而普通的链接依旧是`get`的请求方式。

我们需要使用一个js插件来解决这个问题。在提供的`html`模板中，已经给出了。你所要做的只是引用一下就好了。

到`views/layouts/app.blade.php`的`</body>`标签前加上

```html
...
<script src="/assets/js/laravel.js"></script>
</body>
...
```

将删除链接修改为

```html
<a href="{{route('issues.destroy', $issue->id)}}" data-method="delete" data-token="{{csrf_token()}}" data-confirm="Are you sure?" ...>Destroy</a>
```

再到 `IssuesController.php`中 添加删除相关的代码

```php
public function destroy($id)
{
    Issue::destroy($id);
    return redirect('/');
}
```

{% endraw % }
