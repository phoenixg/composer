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

版本约束可以用集中不同方式来指定。

* **精确版本:** 你可以指定包的精确版本，比如 `1.0.2`.

* **范围:** 通过使用比较操作符，你可以指定有效版本的范围。 有效的操作符是 `>`, `>=`, `<`, `<=`, `!=`. 一个范围的例子是
  `>=1.0`. 你可以定义不同的范围，用逗号来分隔：
  `>=1.0,<2.0`.

* **通配符:** 你可以用一个 `*` 通配符来指定一个匹配模式. `1.0.*` 对应于
   `>=1.0,<1.1`.

* **下一个重要发布版 (Tilde Operator):** The `~` operator is best
  explained by example: `~1.2` is equivalent to `>=1.2,<2.0`, while `~1.2.3` is
  equivalent to `>=1.2.3,<1.3`. As you can see it is mostly useful for projects
  respecting semantic versioning. A common usage would be to mark the minimum
  minor version you depend on, like `~1.2` (which allows anything up to, but not
  including, 2.0). Since in theory there should be no backwards compatibility
  breaks until 2.0, that works well. Another way of looking at it is that using
  `~` specifies a minimum version, but allows the last digit specified to go up.

By default only stable releases are taken into consideration. If you would like
to also get RC, beta, alpha or dev versions of your dependencies you can do
so using [stability flags](04-schema.md#package-links). To change that for all
packages instead of doing per dependency you can also use the
[minimum-stability](04-schema.md#minimum-stability) setting.

## Installing Dependencies

To fetch the defined dependencies into your local project, just run the
`install` command of `composer.phar`.

    $ php composer.phar install

This will find the latest version of `monolog/monolog` that matches the
supplied version constraint and download it into the `vendor` directory.
It's a convention to put third party code into a directory named `vendor`.
In case of monolog it will put it into `vendor/monolog/monolog`.

> **Tip:** If you are using git for your project, you probably want to add
> `vendor` into your `.gitignore`. You really don't want to add all of that
> code to your repository.

Another thing that the `install` command does is it adds a `composer.lock`
file into your project root.

## `composer.lock` - The Lock File

After installing the dependencies, Composer writes the list of the exact
versions it installed into a `composer.lock` file. This locks the project
to those specific versions.

**Commit your application's `composer.lock` (along with `composer.json`) into version control.**

This is important because the `install` command checks if a lock file is present,
and if it is, it downloads the versions specified there (regardless of what `composer.json`
says). This means that anyone who sets up the project will download the exact
same version of the dependencies.

If no `composer.lock` file exists, Composer will read the dependencies and
versions from `composer.json` and  create the lock file.

This means that if any of the dependencies get a new version, you won't get the updates
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
