# 超简单的laravel新手入门教程


![](https://images.itfun.tv/photo/2017/laravel_meetup_index.png)
![](https://images.itfun.tv/photo/2017/laravel_meetup_show.png)

所有章节完成后的源码

课程地址：https://itfun.tv/class/26

## Laragon用户注意事项

如果你使用`laragon`来运行服务，请将`git clone`或者直接下好的`laravel_meetup-master`，改名为`meetup`，因为`laragon`创建的带有`-`或`_`的虚拟机无法访问。

就这样，改个名字，重启服务就好。

## chrome 63版本用户注意事项

近期chrome更新到了`63`版本，如果你也使用了这个版本，你会发现你无法访问 `meetup.dev`。
这是因为chrome会强制使用`https`来访问导致的。

1. 解决方案请照下图设置，将扩展名设置为`.test`或者`.localhost`
2. 然后重启`laragon`的服务，通过`meetup.test`或者`meetup.localhost`来访问。
3. 如果访问变成了搜索引擎搜索，那么你应该使用`http://`meetup.test或者`http://`meetup.test来访问。

![](https://images.itfun.tv/photo/2017/a42cedf8d931f24aedd981a8432603f7.png-large)

![](https://images.itfun.tv/photo/2017/44deb2b8aff37fc11d5f549f1c5ffcb5.png-large)


## 使用方法

1. 复制`.env.example`为`.env`，配置数据库信息，并自行在mysql中建一个对应的数据库。
2. `composer install` 安装相关包。
3. `php artisan key:generate` 生成应用Key。
4. `php artisan migrate` 运行迁移生成数据表。
5. 配置虚拟机或者使用`php artisan serve`启动服务。