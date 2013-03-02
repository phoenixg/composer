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

这意味着，要是任何依赖包有了一个新的版本, 你并不会得到自动的更新.
要更新至新的版本， 可使用 `update` 命令。 这条命令会抓取
最新匹配的版本 (根据你的 `composer.json` 文件) ，并且用最新版本的信息更新 lock 文件。

    $ php composer.phar update

> **注意:** 对于类库来说，没有必要提交 lock 文件，
> 另见: [类库 - Lock 文件](02-libraries.md#lock-file).

## Packagist

[Packagist](https://packagist.org/) 是主要的 Composer 仓库. 一个 Composer
仓库基本上就是一个包源: 这是一个你可以获取包的地方.
Packagist 致力于聚集每个人使用的仓库. 这
表示你可以自动 `require` 在那里的任何包。

如果你访问 [packagist 网站](https://packagist.org/) (packagist.org),
你可以浏览和搜索包。

任何使用 Composer 的项目都应该把他们的包发布到
packagist. 如果要使用 Composer 的类库，并非一定要将其发布到 packagist ,
但这让事情变得容易得多。

## 自动加载

对于指定自动加载信息的类库来说, Composer 会生成一个
`vendor/autoload.php` 文件. 你可以简单地引用这个文件，
然后你就可以自由地自动加载了。

    require 'vendor/autoload.php';

这使得使用第三方代码变得非常容易. 比如: 如果
你的项目依赖于 monolog， 你只需要在里面使用类库, 他们都会自动被加载。

    $log = new Monolog\Logger('name');
    $log->pushHandler(new Monolog\Handler\StreamHandler('app.log', Monolog\Logger::WARNING));

    $log->addWarning('Foo');

你甚至还可以给 autoloader 添加自己的代码， 只需添加给  `composer.json` 文件添加一个 `autoload` 字段即可。


    {
        "autoload": {
            "psr-0": {"Acme": "src/"}
        }
    }

Composer 会为 `Acme` 命名空间注册一个
[PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)
自动加载器。

你定义一个命名空间和路径的对应关系.  `src` 目录
就是你项目的根目录，跟 `vendor` 目录是同一级的目录. 举个例子，
文件名是 `src/Acme/Foo.php` ，就包含一个 `Acme\Foo` class.

在添加完 `autoload` 字段以后, 你必须重新执行 `install` 命令来重新生成
 `vendor/autoload.php` 文件.

引用该文件还会返回 autoloader 实例, 这样你就能够将引用调用存储到一个变量中去，
以便添加更多的命名空间。
这对于在一个测试案例里自动加载多个类来说很有用, 比如。

    $loader = require 'vendor/autoload.php';
    $loader->add('Acme\Test', __DIR__);

除了 PSR-0 autoloading 之外, 还支持类图. 这允许即使类不符合 PSR-0 一样能够自动加载. 参见
[autoload 参考](04-schema.md#autoload) 以获取更多信息.

> **注意:** Composer 提供了它自己的 autoloader. 如果你不想用那玩意儿，
你只需要引用 `vendor/composer/autoload_namespaces.php`,
它会返回一个映射命名空间和路径的关联数组。

&larr; [介绍](00-intro.md)  |  [类库](02-libraries.md) &rarr;
