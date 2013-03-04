# 命令行接口

你已经学习了如何使用命令行接口来做一些事情了
. 本章列出了全部的命令。

要获取命令行的帮助信息, 只需调用 `composer` 或 `composer list`
来查看完整的命令列表, 接着用 `--help` 结合其中的任何一个命令
来获取更多信息。

## 全局选项

以下选项是每条命令都具有的:

* **--verbose (-v):** 显示更加详细的信息.
* **--help (-h):** 显示帮助信息.
* **--quiet (-q):** 不要输出任何消息.
* **--no-interaction (-n):** 不要询问任何交互的问题.
* **--working-dir (-d):** 如果指定了，就是用指定的路径为工作路径.
* **--profile:** 显示时间和内存使用情况
* **--ansi:** 强制 ANSI 输出.
* **--no-ansi:** 禁用 ANSI 输出.
* **--version (-V):** 显示该应用程序版本.

## 初始化

在 [类库](02-libraries.md) 章节我们查看了如何手工创建一个
`composer.json` . 其实还有一个 `init` 命令， 让做这件事变得更为简单.

当你运行这条命令时， 它会交互性地询问你填写字段,
同时可以使用一些聪明的默认值.

    $ php composer.phar init

### 选项

* **--name:** 包的名称
* **--description:** 包的描述
* **--author:** 包的作者名称
* **--homepage:** 包的主页
* **--require:** 要求一个版本约束条件的包. 应该是
  以 `foo/bar:1.0.0` 格式.
* **--require-dev:** 开发要求, 见 **--require**.
* **--stability (-s):**  `minimum-stability` 字段的值

## 安装

`install` 命令会读取当前目录下的 `composer.json` 文件
, 解析其依赖包, 然后将其安装进 `vendor`.

    $ php composer.phar install

如果在当前目录下存在一个 `composer.lock` 文件, 那么它会使用这个文件中的
准确版本而非解析它们. 这确保了每个使用该类库的人
都会获取到相同的依赖包.

如果不存在 `composer.lock` 文件, composer 就会在解析完依赖包后创建这个文件.

### 选项

* **--prefer-source:** 有两种方式可以下载一个包: `source`
  和 `dist`. 对于稳定版本， composer 将会默认使用 `dist`.
  `source` 是一个版本控制仓库. 如果开启了 `--prefer-source` 
  , composer 会从 `source` 安装. 如果你想修复一个项目的bug
  ，并且直接获取一个依赖包的本地git克隆的话，这非常有用.
* **--prefer-dist:** 同 `--prefer-source` 相反, composer 会从
  `dist` 安装. 这会大幅加速服务器上的安装，以及其他你无需更新 vendors 的用例. 
  这还是一个当你没有正确设置时可以绕开git问题的方法.
* **--dry-run:** 如果你想要运行一个实际上没有安装一个包的安装
  , 你可以使用 `--dry-run`. 这条命令会模拟
  安装进程， 向你显示会发生什么事情的信息.
* **--dev:** 默认地, composer 只会安装要求的包. 通过
  传递该参数， 你还可以让它安装由
  `require-dev`引用的包.
* **--no-scripts:** 跳过在 `composer.json` 里的执行脚本.
* **--no-custom-installers:** 禁用自定义的安装程序.
* **--no-progress:** 移除过程显示， 因为它们在一些终端或脚本里不能很好地处理回退字符.
* **--optimize-autoloader (-o):** 将 PSR-0 的自动加载转换为类图，以便获得更快的自动加载器
  . 推荐在生产环境下使用此项, 但是可能需要花些时间来运行的缘故
  ,所以默认没有使用此选项。

## 更新

为了获取最新版本的依赖包，更新
`composer.lock` 文件, 你应该使用 `update` 命令.

    $ php composer.phar update

这条命令会解析你的项目的全部依赖包，然后将精确的版本写入
 `composer.lock`.

如果你只想要更新一些包而不是全部, 你可以像这样列出它们来:

    $ php composer.phar update vendor/package vendor/package2

你还可以使用通配符来一次性更新一打的包:

    $ php composer.phar update vendor/*

### 选项

* **--prefer-source:** 如果可以，就安装来自 `source` 的包
* **--prefer-dist:** 如果可以，就安装来自 `dist` 的包
* **--dry-run:** 模拟而非实际执行命令
* **--dev:** 安装在 `require-dev` 里列出的包
* **--no-scripts:** 跳过在 `composer.json` 里定义的执行脚本
* **--no-custom-installers:** 禁止自定义的安装程序
* **--no-progress:** 移除可能在一些终端或脚本中因为无法很好地处理回退字符而导致的过程显示信息.
* **--optimize-autoloader (-o):** 将 PSR-0 自动加载转换为类图，以便得到一个更快的自动加载器
  . 推荐在生产环境中使用此选项，因为它需要一些时间来执行，
  所以没有被默认开启.

## 要求

`require` 命令会把当前目录下的新包添加进 `composer.json` 文件.

    $ php composer.phar require

在添加/改变要求之后, 所修改过的要求会被安装或更新.

如果你不想交互地选择requirements, 你还可以把它们传递给命令.

    $ php composer.phar require vendor/package:2.* vendor/package2:dev-master

### 选项

* **--prefer-source:** Install packages from `source` when available.
* **--prefer-dist:** Install packages from `dist` when available.
* **--dev:** 添加包到 `require-dev` 里.
* **--no-update:** 禁用依赖包的自动更新.
* **--no-progress:** Removes the progress display that can mess with some
  terminals or scripts which don't handle backspace characters.

## 搜索

搜索命令允许你在当前项目的包仓库中进行搜索
. 通常来说，这就是指 packagist. 你只要给它传递你想要搜索的词即可.

    $ php composer.phar search monolog

你还可以通过传递多个参数来搜索多个词.

### 选项

* **--only-name (-N):** 只用名称来搜索.

## 显示

要列出全部可被获取的包, 你可以使用 `show` 命令.

    $ php composer.phar show

如果你想要看看某个包的详细信息，你可以把包名称传递给它.

    $ php composer.phar show monolog/monolog

    name     : monolog/monolog
    versions : master-dev, 1.0.2, 1.0.1, 1.0.0, 1.0.0-RC1
    type     : library
    names    : monolog/monolog
    source   : [git] http://github.com/Seldaek/monolog.git 3d4e60d0cbc4b888fe5ad223d77964428b1978da
    dist     : [zip] http://github.com/Seldaek/monolog/zipball/3d4e60d0cbc4b888fe5ad223d77964428b1978da 3d4e60d0cbc4b888fe5ad223d77964428b1978da
    license  : MIT

    autoload
    psr-0
    Monolog : src/

    requires
    php >=5.3.0

你还甚至可以传递包的版本，这样它会告诉你那个特定版本的详细信息.

    $ php composer.phar show monolog/monolog 1.0.2

### 选项

* **--installed (-i):** 列出已经安装了的包.
* **--platform (-p):** 只列出平台包 (php & extensions).
* **--self (-s):** 列出root包的信息.
* **--dev:** 当使用 **--installed** 或 **--platform** 时，包括 dev-required 包的信息.

## 依赖

`depends` 命令会告诉你还有其他什么包依赖于某个包
. 你可以指定哪种链接类型 (`require`, `require-dev`) 包含在列表里. 默认两者都使用.

    $ php composer.phar depends --link-type=require monolog/monolog

    nrk/monolog-fluent
    poc/poc
    propel/propel
    symfony/monolog-bridge
    symfony/symfony

### 选项

* **--link-type:** 匹配的链接类型, 可被多次指定.

## 验证

在你提交 `composer.json` 文件和发布一个标签前，你应该总是执行一下 `validate` 命令. 
它会检查你的 
`composer.json` 是否有效。

    $ php composer.phar validate

## 状态

如果你经常需要修改依赖包的代码，而他们是从源安装的，那么
`status` 命令允许你检查它们在本地是否存在
修改.

    $ php composer.phar status

使用 `--verbose` 选项，你可以获得更多关于修改了什么的信息:

    $ php composer.phar status -v
    You have changes in the following dependencies:
    vendor/seld/jsonlint:
        M README.mdown

## 自我更新

要把 composer 本身更新到最新版本, 只需要执行 `self-update`
命令. 它会用最新版本的 `composer.phar` 替代你现有的该文件.

    $ php composer.phar self-update

如果你为整个系统(见 [全局安装](00-intro.md#globally))安装过 composer,
你就不得不用 `root` 权限来执行这条命令

    $ sudo composer self-update

## 配置

`config` 命令允许你编辑一些基本的 composer 设置，它们或在
本地的 composer.json 文件里，或是在全局的 config.json 文件里.

    $ php composer.phar config --list

### 使用

`config [options] [setting-key] [setting-value1] ... [setting-valueN]`

`setting-key` 是配置选项的名称，而 `setting-value1` 是
配置的值.  对于那些数组的设置 (比如像
`github-protocols`), 它允许不止一个设置值作为参数.

见 [配置 schema 段](04-schema.md#config-root-only) 获得有效的配置选项
.

### 选项

* **--global (-g):** 默认操作全局配置文件，它存放在
`$COMPOSER_HOME/config.json` .  没有这个选项的话, 这条命令就会
影响本地的 composer.json 文件或由 `--file` 所指定的文件.
* **--editor (-e):** 使用通过 `EDITOR` 环境变量定义的文本编辑器打开本地的 composer.json 文件.  
使用 `--global` 选项时, 它会打开全局配置文件.
* **--unset:** 移除由 `setting-key` 设置的配置元素.
* **--list (-l):** 显示当前配置变量的列表.  当使用 `--global`
 选项的时候，这会只列出全局配置.
* **--file="..." (-f):** 操作一个指定的文件，而非 composer.json. 注意
 这不能跟 `--global` 选项一起使用.

### 修改仓库

除了修改配置段落之外， `config` 命令还支持仓库的修改，这样来使用:

    $ php composer.phar config repositories.foo vcs http://github.com/foo/bar

## 创建项目

你可以使用 Composer 从一个已存在的包来创建新的项目. This is
the equivalent of doing a git clone/svn checkout followed by a composer install
of the vendors.

There are several applications for this:

1. You can deploy application packages.
2. You can check out any package and start developing on patches for example.
3. Projects with multiple developers can use this feature to bootstrap the
   initial application for development.

To create a new project using composer you can use the "create-project" command.
Pass it a package name, and the directory to create the project in. You can also
provide a version as third argument, otherwise the latest version is used.

The directory is not allowed to exist, it will be created during installation.

    php composer.phar create-project doctrine/orm path 2.2.0

By default the command checks for the packages on packagist.org.

### Options

* **--repository-url:** Provide a custom repository to search for the package,
  which will be used instead of packagist. Can be either an HTTP URL pointing
  to a `composer` repository, or a path to a local `packages.json` file.
* **--stability (-s):** Minimum stability of package. Defaults to `stable`.
* **--prefer-source:** Install packages from `source` when available.
* **--prefer-dist:** Install packages from `dist` when available.
* **--dev:** Install packages listed in `require-dev`.
* **--no-custom-installers:** Disables custom installers.
* **--no-scripts:** Disables the execution of the scripts defined in the root
  package.
* **--no-progress:** Removes the progress display that can mess with some
  terminals or scripts which don't handle backspace characters.
* **--keep-vcs:** Skip the deletion of the VCS metadata for the created
  project. This is mostly useful if you run the command in non-interactive
  mode.

## dump-autoload

If you need to update the autoloader because of new classes in a classmap
package for example, you can use "dump-autoload" to do that without having to
go through an install or update.

Additionally, it can dump an optimized autoloader that converts PSR-0 packages
into classmap ones for performance reasons. In large applications with many
classes, the autoloader can take up a substantial portion of every request's
time. Using classmaps for everything is less convenient in development, but
using this option you can still use PSR-0 for convenience and classmaps for
performance.

### Options

* **--optimize (-o):** Convert PSR-0 autoloading to classmap to get a faster
  autoloader. This is recommended especially for production, but can take
  a bit of time to run so it is currently not done by default.

## help

To get more information about a certain command, just use `help`.

    $ php composer.phar help install

## Environment variables

You can set a number of environment variables that override certain settings.
Whenever possible it is recommended to specify these settings in the `config`
section of `composer.json` instead. It is worth noting that that the env vars
will always take precedence over the values specified in `composer.json`.

### COMPOSER

By setting the `COMPOSER` env variable it is possible to set the filename of
`composer.json` to something else.

For example:

    $ COMPOSER=composer-other.json php composer.phar install

### COMPOSER_ROOT_VERSION

By setting this var you can specify the version of the root package, if it can
not be guessed from VCS info and is not present in `composer.json`.

### COMPOSER_VENDOR_DIR

By setting this var you can make composer install the dependencies into a
directory other than `vendor`.

### COMPOSER_BIN_DIR

By setting this option you can change the `bin` ([Vendor Binaries](articles/vendor-binaries.md))
directory to something other than `vendor/bin`.

### http_proxy or HTTP_PROXY

If you are using composer from behind an HTTP proxy, you can use the standard
`http_proxy` or `HTTP_PROXY` env vars. Simply set it to the URL of your proxy.
Many operating systems already set this variable for you.

Using `http_proxy` (lowercased) or even defining both might be preferable since
some tools like git or curl will only use the lower-cased `http_proxy` version.
Alternatively you can also define the git proxy using
`git config --global http.proxy <proxy url>`.

### COMPOSER_HOME

The `COMPOSER_HOME` var allows you to change the composer home directory. This
is a hidden, global (per-user on the machine) directory that is shared between
all projects.

By default it points to `/home/<user>/.composer` on *nix,
`/Users/<user>/.composer` on OSX and
`C:\Users\<user>\AppData\Roaming\Composer` on Windows.

#### COMPOSER_HOME/config.json

You may put a `config.json` file into the location which `COMPOSER_HOME` points
to. Composer will merge this configuration with your project's `composer.json`
when you run the `install` and `update` commands.

This file allows you to set [configuration](04-schema.md#config) and
[repositories](05-repositories.md) for the user's projects.

In case global configuration matches _local_ configuration, the _local_
configuration in the project's `composer.json` always wins.

### COMPOSER_PROCESS_TIMEOUT

This env var controls the time composer waits for commands (such as git
commands) to finish executing. The default value is 300 seconds (5 minutes).

&larr; [Libraries](02-libraries.md)  |  [Schema](04-schema.md) &rarr;
