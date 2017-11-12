使用`mac`做开发，有一些`app`几乎做任何程序开发都是必备品。

## xcode
mac中有太多开发相关的程序，都依赖于`xcode`。所以无论你做不做`iso`开发，基本都是必须安装的。安装也非常简单，直接在`app store`中下载就好了。需要注意的是，当安装完成之后，一定记得要启动一次，并点击同意按钮。


## oh my zsh

http://ohmyz.sh/

![](media/15104946745739.jpg)


这是一个命令行增强工具，它提供各种美观的主题，还有各种各样对开发有帮助的插件，包括对`php`和`laravel`都有相关的插件支持。总之非常推荐安装一下了，我们后面的教程也都会使用它。

一条命令来搞定它~

```bash
sh -c "$(curl -fsSL https://raw.github.com/robbyrussell/oh-my-zsh/master/tools/install.sh)"
```

## homebrew

![](media/15104947331623.jpg)


https://brew.sh/

如果你用过`linux`系统。那么在`ubuntu`上安装程序，经常会使用一个叫做`apt`的命令。在`centos`上，也有一个类似的`yum`命令。
如果你喜欢这个功能，那么就一定要来试试`homebrew`了。

同样一条命令搞定它。

```bash
/usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"
```

使用的方法也非常简单，想安什么就直接`brew install`吧。

```bash
brew install wget
```

## php

有了上面这些工具后，再来安装一下`php`。现在我们使用的`laravel 5.5`版本，最低要求的php版本都是`7`以上，所有我们直接来安装最新的`php 7.1`好了。

```bash
brew install php71
```

php装好后，要添加到`oh my zsh`的环境变量中，这样我们才能在命令行中打`php`这个命令。

```bash
export PATH=$(brew --prefix homebrew/php/php71)/bin::$PATH
```

完成后重启终端

```php
php -v
which php
```

## 安装composer

`composer`是`php`的包管理器，也是类似`homebrew`的功能，不同的是`composer`是专门用来安装`php`包的。在开发`php`程序时，想安装什么，都是一条`composer require`，就可以自动下载好你想要的包了。

```php
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
```

`composer`默认的仓库在国外，用起来非常的慢。那么就修改为使用中国镜像，这样下载包的时候速度就会很快了。

```php
composer config -g repo.packagist composer https://packagist.phpcomposer.com
```

## mysql

最后来安装一个`mysql`数据库，到后面我们再学习数据库到底是怎么玩的。

```bash
brew install mysql
```

装完后，通过下面这条命令来启动`mysql`

```bash
brew services start mysql
```

>Tips: `mysql`默认的账号是`root`，密码是空。


## 跑起一个`laravel`项目来

先使用composer安装 laravel安装器

```php
composer global require "laravel/installer"
```

装完后，要来修改一下`oh my zsh`的环境变量

```bash
export PATH=$(brew --prefix homebrew/php/php71)/bin:$HOME/.composer/vendor/bin:$PATH
```

改完后，记得要重启一下终端。

建一个专门放`php`项目的目录

```bash
mkdir -p  ~/Developer/PHP
cd ~/Developer/PHP
```

再来建一个`laravel`项目，并启动服务。

```php
laravel new meetup
cd meetup
php artisan serve
```

现在就可以用浏览器来访问了

```php
http://localhost:8000
```

great，一个`laravel`项目已经成功跑起来了。


