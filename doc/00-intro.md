# 介绍

Composer 是一个PHP工具，用来管理依赖。 它允许你声明你的项目中需要的独立类库，它会为你安装它们到你的项目中。

## 依赖管理

Composer 并非一个包管理器。 是的，它处理包（"packages"）或类库（libraries）, 
但它用基于每个项目的方式来管理它们，把他们安装进一个目录（比如 `vendor`）在你的项目中。
默认地，它永远都不会再全局范围安装任何东西。
所以，这是一个依赖管理器。

Composer 的灵感并非新奇，它受到 node 的 [npm](http://npmjs.org/)
和 ruby 的 [bundler](http://gembundler.com/) 的极大启发。 在PHP领域还没有这样一个工具。

Composer 试图解决以下问题：

a) 你有一个项目，它依赖于许多类库。

b) 这些类库中的一些类库，还依赖于其他类库。

c) 由你来声明你所依赖的东西

d) Composer 会找到需要安装哪个版本、哪个包，并且把它们安装好（意思就是将他们下载到你的项目中）。

## 声明依赖

我们举个例子，比如你正在创建一个项目，你需要一个用来logging的类库。
你决定要使用 [monolog](https://github.com/Seldaek/monolog). 
为了把它添加进你的项目中，你所需要做的只是创建一个 `composer.json` 文件，
它描述了项目的依赖关系。

    {
        "require": {
            "monolog/monolog": "1.2.*"
        }
    }

我们只是简单地描述我们的项目要求 `monolog/monolog` 这个包，
只要是以 `1.2` 版本号开头即可。

## 系统要求

Composer 需要 PHP 5.3.2+ 版本才能执行. 另外还需要一些敏感的PHP设置和编译选项，不过要是发生
了兼容性问题，安装程序会警告你的。

要从源码安装包而非从简单的zip档安装，
你需要使用git, svn 或 hg ，这取决于你的包使用了哪一种版本控制系统。

Composer 是跨平台的，我们努力让它在 Windows,
Linux 和 OSX 都能运行如一。

## 安装 - *nix

### 下载 Composer 可执行文件

#### 本地

要获取 Composer, 我们需要做两件事。首先，安装
Composer (再说一次，意思就是把它下载进你的项目中):

    $ curl -sS https://getcomposer.org/installer | php

这个操作只会检查一些PHP设置，然后就会下载 `composer.phar` 到
你的工作目录中。 该文件是 Composer 的二进制文件。 它是一个 PHAR （PHP的档案），
这是一种PHP的档案格式，可以用来在命令行里执行。

你可以把 Composer 安装到一个特定的目录，只需使用 `--install-dir`
选项，为它提供一个目标路径（绝对路径或相对路径都可以）：

    $ curl -sS https://getcomposer.org/installer | php -- --install-dir=bin

#### 全局

你可以把这个文件放在任何你想要的地方。
如果你把它放在 `PATH` ，
你就可以在全局访问它。 在unixy系统里，你甚至可以将它变为可执行的，
并且可以不通过 `php` 来调用它。

你可以在系统的任何地方用这些命令来轻松访问 `composer` :

    $ curl -sS https://getcomposer.org/installer | php
    $ sudo mv composer.phar /usr/local/bin/composer

接着, 只需执行 `composer` 以便运行 Composer 而非 `php composer.phar`.

## 安装 - Windows

### 使用安装程序

这是将 Composer 设置在你的机器上的最简单的方法。

下载并执行 [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe),
它会安装最新版的 Composer ， 并设置你的 PATH 以便你在任何目录下，只需调用 `composer` 
即可。

### 手动安装

切换到你的 `PATH` 所在目录，然后执行安装脚本来下载
composer.phar:

    C:\Users\username>cd C:\bin
    C:\bin>php -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"

创建一个新的 `.bat` 文件，跟 composer 放一起:

    C:\bin>echo @php "%~dp0composer.phar" %*>composer.bat

关闭当前的终端。 用一个新的终端来测试使用:

    C:\Users\username>composer -V
    Composer version 27d8904

    C:\Users\username>

## 使用 Composer

现在我们使用 Composer 来安装项目的依赖包. 
要是你的当前目录没有一个 `composer.json` 文件，请跳到
[Basic Usage](01-basic-usage.md) 章节.

要解析和下载依赖包，请执行 `install` 命令:

    $ php composer.phar install

要是你在全局中进行了安装，就无需在目录中有该phar文件，就能直接运行:

    $ composer install

遵从 [上面的例子](#declaring-dependencies), 
这会下载 monolog 到你的 `vendor/monolog/monolog` 目录。

## 自动加载

除了下载类库外，Composer 还准备了一个自动加载文件，它有能力自动加载下载的任何类库。
要使用它，只需在你的代码的引导过程中添加下面这行：

    require 'vendor/autoload.php';

Woah! 现在就开始使用 monolog 吧！ 要继续学习 Composer，
请阅读 "基本用法" 章节。

[基本用法](01-basic-usage.md) &rarr;
