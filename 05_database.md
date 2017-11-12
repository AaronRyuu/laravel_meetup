---
layout: default
title: 数据的仓库
---

前面把要展示的数据都放在了 `controller` 里。
那么设想一下，假如现在有另一个人发布了1个新活动，那我们是不是要去修改`controller`代码，加入1条新数据。
假如现在有人发布了100个活动，我们岂不是要去修改代码，加入100条数据？
这么做实在是太笨了，也完全不现实。

![](media/15099366328467.jpg)

我们聪明的人类，当然不会干这么笨的事情了。那来欢迎今天的重量级嘉宾吧，`mysql`数据库。

## 初识数据库

不用说就该猜到了，数据库里面存的当然是数据了。这里对应我们项目的，就是各个活动信息。
最简单的一个例子，数据库就是类似于一个表格。


| id | title | 
| --- | --- |
| 1 | Laravel meetup |
| 2 | I love php and ruby |

> Tips:
> 1. 表中的`id title` ，这些我们叫做`字段`。
> 2. `id`就是一个编号，一般都会设置让他自己不断增加。
> 3. 下面存放的就是对应存放的真实数据了。

将来再有人发布新的活动，只需要在数据库中插入一新条记录，显示出来就好了。
相信我，这比直接修改控制器的代码，来的方便的多了。

## 修改数据库连接

这次相关的配置文件是根目录下的 .env文件， 里面写明了要使用的数据库和用到的账号密码 。

```text
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=meetup
DB_USERNAME=root
DB_PASSWORD=root
```

> Tips: 使用`laragon`的同学注意，你的`DB_PASSWORD`留空就好。

修改完成后，记得按 `ctrl+c` 重启一下服务。

## 安装数据库操作软件

来安装一个小巧的数据库操作软件，叫 `Sequel Pro` 。
http://www.sequelpro.com/download 下载之后，拖到应用目录，双击就可以打开了。
登录需要填写 `Host` 为`127.0.0.1`（本机），`mysql` 的用户名 `root`，密码也是`root`。 `Port` 就不用填了。

![](media/15094671719077.jpg)


> Tips: 使用`windows`的同学，可以使用`navicat`（推荐）或者`phpmyadmin`来操作数据库。

## 新建数据库

连接上去以后，我们新建一个叫做`meetup`的数据库，选择`utf8mb4`编码

![](media/15094673110904.jpg)


## 建立数据表结构

更改数据库的表结构，`laravel` 给出的方法是 `migration`
https://laravel.com/docs/5.5/migrations

```bash
php artisan make:migration create_issues_table --create=issues
```

生成的文件名的前面是时间戳，`2017_10_31…` 今天就是 `2017年10月31号`。里面可以添加需要的字段。

至于`database/migrations`文件夹中已经默认存在的`create_users_table`和`create_password_resets_table`是我们后面做用户登陆注册需要用到的，咱们暂时先不需要关注它。

```php
public function up()
{
    Schema::create('issues', function (Blueprint $table) {
        $table->increments('id');
        $table->string('title');
        $table->timestamps();
    });
}
```

运行

```bash
php artisan migrate
```

来把内容真正写进 mysql 数据库。

## 建立 model

`model` 文件要放在 `app/Models` 下面，名字叫 `Issue.php`

```bash
php artisan make:model Models/Issue
```

```php
class Issue extends Model
{
}
```

这里的 `class` 命名是很关键的，如果数据库中的表名是`issues`，那这里的`class`名就必须是 `Issue`，也就是首字母大写，同时变成单数。为啥要这样？ 因为这样`laravel`就可以建立自动的 `class` 到 `table` 的映射关系了，以后要操作`issues`这张表，就无比的方便。

> Tips：如果你需要将`model`和对应的`migration`一下全部建出来，下次也可以直接使用`php artisan make:model Models/Issue -m` 这一条命令。这样他会同时生成`model`和`migration`。

## 填充数据

这样就可以打开 `laravel tinker` 来真正对这样表进行操作了，具体可以参考 
https://laravel.com/docs/5.5/artisan#introduction

```bash
php artisan tinker
```

插入需要的记录

```php
use App\Models\Issue

Issue::create(['title' => 'PHP Lover'])
Issue::create(['title' => 'Rails and Laravel'])
Issue::all()
```

屏幕提示一个错误信息
`Illuminate\Database\Eloquent\MassAssignmentException with message 'title'`

这个是 `laravel` 为了防止坏人恶意提交数据攻击网站，而采用的自我保护机制。你想啊，如果不加说明，坏蛋们就可以在表单中人为植入其他的参数。

![](media/15099375854517.jpg)


所以必须要你自己指明哪些字段是允许直接用来赋值的。使用的方式就是 https://laravel.com/docs/5.5/eloquent#mass-assignment。

要做的修改非常简单，就是到 `Issue`模型中，添加`白名单`。

```php
class Issue extends Model
{
    protected $fillable = ['title'];
}
```


按`ctrl + c`或者输入`exit`，退出`tinker`。
再重新进入`tinker`，这样再来提交，操作成功了。

## 修改controller和view

现在在 `controller` 中读取数据

```php
use App\Models\Issue;

class WelcomeController extends Controller
{
    public function index()
    {
        $issues = Issue::orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        return view('welcome.index')->with('issues', $issues);
    }
}
```

> Tips:
> 1. `orderBy`的意思是排序。`created_at`是添加数据的时候，`laravel`自动帮添加的当前时间。
> 2. `desc`是倒序（从大到小）。这样最新发布的`issue`会就在最上面了。
> 3. `take(2)`的意思，是说这里只读取两条数据。

再到 `_issue_list.blade.php` 中在稍作修改就好了。

```php
{% raw %}{{$issue->title}}{% endraw %}
```

