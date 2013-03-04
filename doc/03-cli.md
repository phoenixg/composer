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

你可以使用 Composer 从一个已存在的包来创建新的项目. 这跟随后使用 git clone或svn checkout来安装 vendors 是一样的.

有这么几个应用程序:

1. 你可以部署应用程序包.
2. 你可以check out 任何包，并开始开发补丁.
3. 有多个开发者的项目可以使用该特性来引导要开发的应用程序.

要使用 composer 来创建一个新项目，你可以使用 "create-project" 命令。
传递给它一个包名称， 以及要创建项目的路径. 你还可以把版本号作为第三个参数
, 要不然就会使用最新的版本号.

不允许已经存在的路径, 路径在安装时会被创建.

    php composer.phar create-project doctrine/orm path 2.2.0

默认该命令会检查 packagist.org 网站上面的包.

### 选项

* **--repository-url:** 提供一个自定义的仓库来搜索包,
  这将会替代 packagist. 可以要么是指向
  一个 `composer` 仓库的 HTTP URL 路径, 要么是一个本地 `packages.json` 文件的路径.
* **--stability (-s):** 包的最小稳定版本. 默认是 `stable`.
* **--prefer-source:** 如果可以，则安装来自 `source` 的包.
* **--prefer-dist:** 如果可以，则安装来自 `dist` 的包.
* **--dev:** 安装在 `require-dev` 里列出的包.
* **--no-custom-installers:** 禁用自定义安装程序.
* **--no-scripts:** 禁用在 root 包里定义的脚本的执行.
* **--no-progress:** 移除可能会引起无法很好支持回退字符的一些终端或脚本的进度显示.
* **--keep-vcs:** 跳出已创建项目的VCS元标签
  . 如果你在非交互模式下执行该命令，那么这个选项非常有用.

## dump-autoload

如果你需要更新自动加载器，比如类图包有一个新的类库
, 你可以使用 "dump-autoload" 来达成这个任务，而无需通过安装或更新命令.

此外，它还会dump出一个优化过的自动加载器，它会将 PSR-0 包
转成类图，以便提升性能. 在拥有许多类库的大型项目中
, 该自动加载器可以节省每个请求的响应时间
. 使用类图在开发过程中有些不便, 但
使用该选项，你仍旧可以因着方便而使用 PSR-0 的同时，还能出于性能的缘故使用
类图.

### 选项

* **--optimize (-o):** 将 PSR-0 autoloading 转换成类图（classmap）以便获得一个更快的
  自动加载器. 对于生产环境，我们推荐使用此项, 但运行此项需要花些时间，
  因此默认没有开启它。

## 帮助

要获取更多关于某条命令的帮助信息，只需要输入 `help`.

    $ php composer.phar help install

## 环境变量

你可以设置一系列的环境变量来重写某些设置.
只要有可能，我们推荐最好在 `composer.json` 文件中的 `config` 项目来指定这些设置
. 在 `composer.json` 里指定的优先级相对于环境变量来说更高.

### COMPOSER

通过设置 `COMPOSER` 环境变量，就可以把
`composer.json` 的文件名设置成别的.

比如:

    $ COMPOSER=composer-other.json php composer.phar install

### COMPOSER_ROOT_VERSION

通过设置这个变量，你可以指定 root 包的版本, 如果从
VCS 信息猜不出版本并且在 `composer.json` 里没有指定的话可以用这个.

### COMPOSER_VENDOR_DIR

通过设置这个变量，你可以让 composer 把依赖包安装进另一个名称的目录，而非
`vendor`.

### COMPOSER_BIN_DIR

通过设置这个选项，你可以改变 `bin` ([Vendor Binaries](articles/vendor-binaries.md))
目录为其他的，而不是 `vendor/bin`.

### http_proxy 或 HTTP_PROXY

如果你正通过HTTP代理使用 composer, 你可以使用这个标准的
`http_proxy` 或 `HTTP_PROXY` 环境变量. 简单地将其设置为你的代理的URL即可.
许多操作系统已经为你设置了该变量了.

使用 `http_proxy` (小写) 或者甚至两个都定义一遍比较好，因为
有些工具，像 git 或 curl 只会使用小写 `http_proxy` 的版本。
此外，你还可以定义 git 代理的设置，如
`git config --global http.proxy <proxy url>`.

### COMPOSER_HOME

`COMPOSER_HOME` 变量允许你改变 composer 的 home 目录. 这
是一个隐藏的, 全局的 (机器的每个用户都能访问) 路径，该目录被每个项目都能共享.

默认地，在 *nix 系统上，它指向 `/home/<user>/.composer`,
在 OSX 上是 `/Users/<user>/.composer`  ，
在 Windows 上是 `C:\Users\<user>\AppData\Roaming\Composer`.

#### COMPOSER_HOME/config.json

你可以把一个 `config.json` 文件放在 `COMPOSER_HOME` 指向的路径中
. Composer 会把它跟你的项目的 `composer.json` 文件进行合并，
当你运行 `install` 和 `update` 命令时.

该文件允许你为用户的项目设置 [配置](04-schema.md#config) 和
[仓库](05-repositories.md).

如果说全局的配置存在 _local_ 配置, 那么
项目中的 `composer.json` 文件中的 _local_ 配置永远优先级更高.

### COMPOSER_PROCESS_TIMEOUT

该环境变量控制 composer 等待命令完成执行所花的时间 (比如 git 
命令) . 默认值是 300 秒 (5 分钟).

&larr; [类库](02-libraries.md)  |  [Schema](04-schema.md) &rarr;
