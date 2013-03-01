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

### Downloading the Composer Executable

#### Locally

To actually get Composer, we need to do two things. The first one is installing
Composer (again, this means downloading it into your project):

    $ curl -sS https://getcomposer.org/installer | php

This will just check a few PHP settings and then download `composer.phar` to
your working directory. This file is the Composer binary. It is a PHAR (PHP
archive), which is an archive format for PHP which can be run on the command
line, amongst other things.

You can install Composer to a specific directory by using the `--install-dir`
option and providing a target directory (it can be an absolute or relative path):

    $ curl -sS https://getcomposer.org/installer | php -- --install-dir=bin

#### Globally

You can place this file anywhere you wish. If you put it in your `PATH`,
you can access it globally. On unixy systems you can even make it
executable and invoke it without `php`.

You can run these commands to easily access `composer` from anywhere on your system:

    $ curl -sS https://getcomposer.org/installer | php
    $ sudo mv composer.phar /usr/local/bin/composer

Then, just run `composer` in order to run Composer instead of `php composer.phar`.

## Installation - Windows

### Using the Installer

This is the easiest way to get Composer set up on your machine.

Download and run [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe),
it will install the latest Composer version and set up your PATH so that you can
just call `composer` from any directory in your command line.

### Manual Installation

Change to a directory on your `PATH` and run the install snippet to download
composer.phar:

    C:\Users\username>cd C:\bin
    C:\bin>php -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"

Create a new `.bat` file alongside composer:

    C:\bin>echo @php "%~dp0composer.phar" %*>composer.bat

Close your current terminal. Test usage with a new terminal:

    C:\Users\username>composer -V
    Composer version 27d8904

    C:\Users\username>

## Using Composer

We will now use Composer to install the dependencies of the project. If you
don't have a `composer.json` file in the current directory please skip to the
[Basic Usage](01-basic-usage.md) chapter.

To resolve and download dependencies, run the `install` command:

    $ php composer.phar install

If you did a global install and do not have the phar in that directory
run this instead:

    $ composer install

Following the [example above](#declaring-dependencies), this will download
monolog into the `vendor/monolog/monolog` directory.

## Autoloading

Besides downloading the library, Composer also prepares an autoload file that's
capable of autoloading all of the classes in any of the libraries that it
downloads. To use it, just add the following line to your code's bootstrap
process:

    require 'vendor/autoload.php';

Woah! Now start using monolog! To keep learning more about Composer, keep
reading the "Basic Usage" chapter.

[Basic Usage](01-basic-usage.md) &rarr;
