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

If you want to see the details of a certain package, you can pass the package
name.

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

You can even pass the package version, which will tell you the details of that
specific version.

    $ php composer.phar show monolog/monolog 1.0.2

### Options

* **--installed (-i):** List the packages that are installed.
* **--platform (-p):** List only platform packages (php & extensions).
* **--self (-s):** List the root package info.
* **--dev:** Include dev-required packages when combined with **--installed** or **--platform**.

## depends

The `depends` command tells you which other packages depend on a certain
package. You can specify which link types (`require`, `require-dev`)
should be included in the listing. By default both are used.

    $ php composer.phar depends --link-type=require monolog/monolog

    nrk/monolog-fluent
    poc/poc
    propel/propel
    symfony/monolog-bridge
    symfony/symfony

### Options

* **--link-type:** The link types to match on, can be specified multiple
  times.

## validate

You should always run the `validate` command before you commit your
`composer.json` file, and before you tag a release. It will check if your
`composer.json` is valid.

    $ php composer.phar validate

## status

If you often need to modify the code of your dependencies and they are
installed from source, the `status` command allows you to check if you have
local changes in any of them.

    $ php composer.phar status

With the `--verbose` option you get some more information about what was
changed:

    $ php composer.phar status -v
    You have changes in the following dependencies:
    vendor/seld/jsonlint:
        M README.mdown

## self-update

To update composer itself to the latest version, just run the `self-update`
command. It will replace your `composer.phar` with the latest version.

    $ php composer.phar self-update

If you have installed composer for your entire system (see [global installation](00-intro.md#globally)),
you have to run the command with `root` privileges

    $ sudo composer self-update

## config

The `config` command allows you to edit some basic composer settings in either
the local composer.json file or the global config.json file.

    $ php composer.phar config --list

### Usage

`config [options] [setting-key] [setting-value1] ... [setting-valueN]`

`setting-key` is a configuration option name and `setting-value1` is a
configuration value.  For settings that can take an array of values (like
`github-protocols`), more than one setting-value arguments are allowed.

See the [config schema section](04-schema.md#config-root-only) for valid configuration
options.

### Options

* **--global (-g):** Operate on the global config file located at
`$COMPOSER_HOME/config.json` by default.  Without this option, this command
affects the local composer.json file or a file specified by `--file`.
* **--editor (-e):** Open the local composer.json file using in a text editor as
defined by the `EDITOR` env variable.  With the `--global` option, this opens
the global config file.
* **--unset:** Remove the configuration element named by `setting-key`.
* **--list (-l):** Show the list of current config variables.  With the `--global`
 option this lists the global configuration only.
* **--file="..." (-f):** Operate on a specific file instead of composer.json. Note
 that this cannot be used in conjunction with the `--global` option.

### Modifying Repositories

In addition to modifying the config section, the `config` command also supports making
changes to the repositories section by using it the following way:

    $ php composer.phar config repositories.foo vcs http://github.com/foo/bar

## create-project

You can use Composer to create new projects from an existing package. This is
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
