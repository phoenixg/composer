# 基本用法

## 安装

要安装 Composer， 你只需下载 `composer.phar` 可执行文件即可。

    $ curl -sS https://getcomposer.org/installer | php

更多详细信息请见 [介绍](00-intro.md) 章节。

要检查 Composer 是否正常工作, 只需用 `php` 运行 PHAR :

    $ php composer.phar

这条命令会显示一系列可以执行的命令来。

> **注意:** 你还可以在无需下载 Composer 的情况下执行这个检查：
> 使用 `--check` 选项。 更多信息，使用 `--help`.
>
>     $ curl -sS https://getcomposer.org/installer | php -- --help

## `composer.json`: 项目设置

要开始在你的项目里使用 Composer ，你所需的只是一个 `composer.json` 文件而已。
该文件描述了你的项目的依赖，还可能包含其他的元信息。

[JSON 格式](http://json.org/) 相当容易编写。它允许你来定义嵌套的结构。

### `require` 键

你在 `composer.json` 文件中首先（并且通常也是唯一）要指定的是
`require` 键。 你只需简单告诉 Composer 你的项目依赖于的包是什么即可。

    {
        "require": {
            "monolog/monolog": "1.0.*"
        }
    }

如你所见， `require` 包含了一个对象，它映射了 **包名称** (比如 `monolog/monolog`)
至 **包版本** (比如 `1.0.*`).

### 包名称

包名称由vendor名称和项目名称所组成。 通常这些名称是唯一的 - vender 名称的存在
是为了避免命名冲突。 它允许两个不同的人创建一个都叫做 `json` 的类库，
这样它们就会命名成 `igorw/json` 和 `seldaek/json`。

现在，我们要求加载 `monolog/monolog`, 所以 vendor 名称和项目名称是相同的。
我们推荐将项目名称命名成独一无二的。 它还允许在相同的命名空间下添加更多关联的项目。
如果你在维护着一个类库， 这样做会使得你的项目被分割成更小的解耦单元。


### 包版本

我们要求 monolog 的版本是 `1.0.*` 。 这意味着任何在 `1.0`
开发分支的版本都是可以的。它会匹配 `1.0.0`, `1.0.2` 或 `1.0.20`。

版本约束可以用几种不同方式来指定：

* **精确版本:** 你可以指定包的精确版本，比如 `1.0.2`.

* **范围:** 通过使用比较操作符，你可以指定有效版本的范围。 有效的操作符是 `>`, `>=`, `<`, `<=`, `!=`. 一个范围的例子是
  `>=1.0`. 你可以定义不同的范围，用逗号来分隔：
  `>=1.0,<2.0`.

* **通配符:** 你可以用一个 `*` 通配符来指定一个匹配模式. `1.0.*` 对应于
   `>=1.0,<1.1`.

* **下一个重要发布版 (波浪操作符):**  `~` 操作符用这个例子来解释再好不过：
  `~1.2` 对应于 `>=1.2,<2.0`,  `~1.2.3` 对应于
  `>=1.2.3,<1.3`. 如你所见，它最常被用于那些含语义的版本。 
  普遍用法是，标志出你需要依赖的最小版本号，比如像 `~1.2` (它允许了任何高于该版本, 
  但是不包括 2.0 的版本). 因为理论上，直到 2.0 版本以前，都不会发生兼容性问题, 那样的话应该工作正常. 
  另一种使用 `~` 的场景是用来指定一个最小版本，但是允许最新数字来指定以便升级。

默认地， 只有稳定版本才需要考虑。 要是你还想获取到依赖包的
RC, beta, alpha 或 dev 版本， 你可以使用[稳定性标识](04-schema.md#package-links)来达成. 
要针对全部的包修改这一项，而不是只针对单个包，你可以使用
[最小稳定性](04-schema.md#minimum-stability) 设置。

## 安装依赖包

要将定义好的依赖包抓取到你的本地项目中来，只需运行 `composer.phar` 的
`install` 命令。

    $ php composer.phar install

这条命令会寻找匹配当前版本约束条件的最新版本的 `monolog/monolog`,
并将其下载到 `vendor` 目录中去。
把第三方代码放置到命名为 `vendor` 的目录是一个约定俗成。
拿 monolog 的例子来说，它会被放置到 `vendor/monolog/monolog` 目录中。

> **贴士:** 如果你使用 git 管理项目，你很可能想要将
> `vendor` 添加到 `.gitignore` 文件中. 你可不想把所有那些代码
> 添加到你的代码仓库里去吧.

`install` 命令所做的另一件事是， 它会创建一个 `composer.lock` 
文件到你项目的根目录中。

## `composer.lock` - 锁文件

在安装完依赖包后， Composer 会编写出它所安装的精确版本的列表到
一个 `composer.lock` 文件中。 它会把项目锁定到那些
所指定的版本号上。

**Commit 你应用程序的 `composer.lock` (跟 `composer.json` 一起) 到你的版本控制仓库里**

这很重要，因为 `install` 命令会检查是否存在一个 lock 文件,
如果存在, 它就会下载在它里面指定的版本 (而毫不理睬 `composer.json`
写了什么). 这意味着任何配置这个项目的人都会下载跟你相同版本的依赖包。

如果没有 `composer.lock` 这个文件, Composer 就会读取 `composer.json` 文件里面的依赖包和版本
，然后创建这个 lock 文件。

这意味着，要是任何依赖包有了一个新的版本, you won't get the updates
automatically. To update to the new version, use `update` command. This will fetch
the latest matching versions (according to your `composer.json` file) and also update
the lock file with the new version.

    $ php composer.phar update

> **Note:** For libraries it is not necessarily recommended to commit the lock file,
> see also: [Libraries - Lock file](02-libraries.md#lock-file).

## Packagist

[Packagist](https://packagist.org/) is the main Composer repository. A Composer
repository is basically a package source: a place where you can get packages
from. Packagist aims to be the central repository that everybody uses. This
means that you can automatically `require` any package that is available
there.

If you go to the [packagist website](https://packagist.org/) (packagist.org),
you can browse and search for packages.

Any open source project using Composer should publish their packages on
packagist. A library doesn't need to be on packagist to be used by Composer,
but it makes life quite a bit simpler.

## Autoloading

For libraries that specify autoload information, Composer generates a
`vendor/autoload.php` file. You can simply include this file and you
will get autoloading for free.

    require 'vendor/autoload.php';

This makes it really easy to use third party code. For example: If your
project depends on monolog, you can just start using classes from it, and they
will be autoloaded.

    $log = new Monolog\Logger('name');
    $log->pushHandler(new Monolog\Handler\StreamHandler('app.log', Monolog\Logger::WARNING));

    $log->addWarning('Foo');

You can even add your own code to the autoloader by adding an `autoload` field
to `composer.json`.

    {
        "autoload": {
            "psr-0": {"Acme": "src/"}
        }
    }

Composer will register a
[PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)
autoloader for the `Acme` namespace.

You define a mapping from namespaces to directories. The `src` directory would
be in your project root, on the same level as `vendor` directory is. An example
filename would be `src/Acme/Foo.php` containing an `Acme\Foo` class.

After adding the `autoload` field, you have to re-run `install` to re-generate
the `vendor/autoload.php` file.

Including that file will also return the autoloader instance, so you can store
the return value of the include call in a variable and add more namespaces.
This can be useful for autoloading classes in a test suite, for example.

    $loader = require 'vendor/autoload.php';
    $loader->add('Acme\Test', __DIR__);

In addition to PSR-0 autoloading, classmap is also supported. This allows
classes to be autoloaded even if they do not conform to PSR-0. See the
[autoload reference](04-schema.md#autoload) for more details.

> **Note:** Composer provides its own autoloader. If you don't want to use
that one, you can just include `vendor/composer/autoload_namespaces.php`,
which returns an associative array mapping namespaces to directories.

&larr; [Intro](00-intro.md)  |  [Libraries](02-libraries.md) &rarr;
