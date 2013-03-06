# composer.json

本章将会解释所有在 `composer.json` 文件里可以使用的字段.

## JSON schema

我们有一个格式文档 [JSON schema](http://json-schema.org) ，还可以用它来
校验你的 `composer.json` 文件. 事实上, 它使用的是
`validate` 命令. 你可以在这里找到它:
[`res/composer-schema.json`](https://github.com/composer/composer/blob/master/res/composer-schema.json).

## Root 包

root 包是在你的项目的根的 `composer.json` 定义的包
. 这是定义你项目的要求包的主要的 `composer.json` 文件.

有些字段只在root包的上下文里才应用. 其中一个例子就是
`config` 字段. 只有 root 包才能够定义配置.
依赖包的配置会被忽略. 确保了 `config` 字段是
`root-only`.

如果你克隆了一个包,你在这上面工作, 那么该包就是
root 包.  `composer.json` 是相同的, 上下文则是不同的.

> **注意:** 一个包可以是 root 包, 也可以不是, 这取决于上下文环境.
> 比如, 如果你的项目依赖于 `monolog` 类库, 那么你的项目
> 就是 root 包. 然而, 如果你从GitHub克隆了 `monolog` 包，为了要修复其中的一个bug
> , 那么这个 `monolog` 就是 root 包.

## 属性

### name

包的名称. 它由 vendor 名称和项目名称所组成,
使用 `/` 来分隔.

例子:

* monolog/monolog
* igorw/event-source

对于发布的包是必填的 (即类库).

### description

关于包的简短叙述. 只要写成一句话就行.

对于发布的包是必填的 (即类库).

### version

包的版本.

必须遵循 `X.Y.Z` 的格式，可选的后缀是 `-dev`,
`-alphaN`, `-betaN` 或 `-RCN`.

Examples:

    1.0.0
    1.0.2
    1.1.0
    0.2.5
    1.0.0-dev
    1.0.0-alpha3
    1.0.0-beta2
    1.0.0-RC5

如果包仓库可以从某处找到版本, 比如VCS 仓库里的
VCS tag 名称. 如果那样的话，我们推荐忽略掉它.

> **注意:** Packagist 使用 VCS 仓库, 因此上面的陈述对于
> Packagist 来说也是对的. 如果人工地指定版本，有可能跟版本仓库里的版本发生冲突，产生错误.

### type

包的类型. 默认是 `library`.

使用包的类型来自定义安装逻辑. 如果你有一个包需要一些特殊的逻辑
, 你可以定义一个自定义类型. 它可以是
`symfony-bundle`, 一个 `wordpress-plugin` 或者一个 `typo3-module`. 这些类型将会指定到某个项目
， 而他们需要提供一个可以安装那种类型的包的安装程序.

默认, composer 支持三种类型:

- **library:** 这是默认的. 它会简单地把文件拷贝进 `vendor`.
- **metapackage:** 一个包含了要求的空包, 他会出发这些要求（requirements）的安装
  , 但是没有任何文件产生，也不会写进任何东西到文件系统
  . 正是如此, 它不需要一个 dist 或 source key 来安装.
- **composer-installer:** 一个类型 `composer-installer` 的类型会为其他拥有自定义类型的包提供一个
  安装程序. 更多信息阅读
  [专门的文章](articles/custom-installers.md).

如果你需要自定义安装过程中的逻辑，那么就是用一个自定义类型. 不过我们推荐忽略掉它，
只用默认的 `library` 即可.

### keywords

跟包有关的关键词数组. 它的用途是搜索和过滤.

例子:

    logging
    events
    database
    redis
    templating

这是可选的.

### homepage

项目网站的URL.

这是可选的.

### time

版本的发布日期.

必须是 `YYYY-MM-DD` 或 `YYYY-MM-DD HH:MM:SS` 格式.

这是可选的.

### license

包的授权协议. 可以是一个字符串或字符串数组.

我们推荐的最常使用的协议是 (按字母排序):

    Apache-2.0
    BSD-2-Clause
    BSD-3-Clause
    BSD-4-Clause
    GPL-2.0
    GPL-2.0+
    GPL-3.0
    GPL-3.0+
    LGPL-2.1
    LGPL-2.1+
    LGPL-3.0
    LGPL-3.0+
    MIT

这是可选的, 但极力推荐应用此选项. 更多的标示符列在了
 [SPDX 开源协议注册](http://www.spdx.org/licenses/).

对于闭源软件, 你可以使用 `"proprietary"` 作为协议标示符.

一个例子:

    {
        "license": "MIT"
    }


对于包来说, 如果可以在协议之间进行选择 ("disjunctive license"),
如果要写多个协议，可以写成数组.

分离协议的一个例子:

    {
        "license": [
           "LGPL-2.1",
           "GPL-3.0+"
        ]
    }

可选的，你可以用 "or" 来分隔，用圆括号括起来;

    {
        "license": "(LGPL-2.1 or GPL-3.0+)"
    }

当应用分离协议时，很相似的，还能使用结合协议 ("conjunctive license"),
你可以使用 "and" 来分隔，用圆括号括起来.

### authors

包的作者. 这是一个对象数组.

每个作者对象都可以具有如下属性:

* **name:** 作者的名称. 通常是他的真名.
* **email:** 作者的email地址.
* **homepage:** 作者的网站URL.
* **role:** 作者在项目中担任的角色(e.g. developer 或 translator)

一个例子:

    {
        "authors": [
            {
                "name": "Nils Adermann",
                "email": "naderman@naderman.de",
                "homepage": "http://www.naderman.de",
                "role": "Developer"
            },
            {
                "name": "Jordi Boggiano",
                "email": "j.boggiano@seld.be",
                "homepage": "http://seld.be",
                "role": "Developer"
            }
        ]
    }

这是可选的, 但极力推荐使用此项.

### support

获取关于该项目帮助的各种信息.

Support information includes the following:

* **email:** 获取支持的email.
* **issues:** Issue跟踪器的URL.
* **forum:** 论坛的URL.
* **wiki:** Wiki的URL.
* **irc:** 获取支持的IRC频道, 形如 irc://server/channel.
* **source:** 浏览的URL 或 源码的下载链接地址.

一个例子:

    {
        "support": {
            "email": "support@example.org",
            "irc": "irc://irc.freenode.org/composer"
        }
    }

这是可选的.

### Package links

下面所有的都是获得一个把包名称映射到
[版本约束条件](01-basic-usage.md#package-versions) 的对象.

例子:

    {
        "require": {
            "monolog/monolog": "1.0.*"
        }
    }

所有链接都是可选的.

`require` 和 `require-dev` 会额外支持稳定标识符 (root-only).
这会允许你扩展限制，或扩展在 [最小稳定版本](#minimum-stability) 里所定义的包的稳定版设置. 你可以将其
应用在约束条件上, 或仅仅应用给一个空的约束条件，如果你觉得非稳定版也无所谓的话.

例子:

    {
        "require": {
            "monolog/monolog": "1.0.*@beta",
            "acme/foo": "@dev"
        }
    }

`require` 和 `require-dev` 会额外地支持明确的引用 (即
commit) 或开发版本， 以便确保它们在某种状态下锁定, 甚至
当你运行 update 的时候. 这些只有在你明确要求了一个 dev 版本并且用
 `#<ref>` 来引用的时候才会起效. 注意，尽管有时这么做很方便
, 总体来说你不应该这样来使用包. 你应该永远尝试使用 tagged 
的发布版, 尤其是你的项目很久没动过了的时候.

例子:

    {
        "require": {
            "monolog/monolog": "dev-master#2eb0c0978d290a1c45346a1955188929cb4e5db7",
            "acme/foo": "1.0.x-dev#abc123"
        }
    }

你可以内联别名一个包约束条件，以便它匹配一个约束条件. 
要获得更多信息 [参见别名文章
](articles/aliases.md).

#### require

列出该包所要求的包. 除非遇到这些要求，否则该包不会被安装.

#### require-dev <span>(root-only)</span>

为开发缘故，列出包, 或比如说运行测试
等等. root 包的 dev 要求只有在使用 `--dev` 运行
 `install` 或 `update` 时才能起效。

在这里所列出的包和它们的依赖包不能打破在 require 里的包
. 即使一个不同的包版本可被安装且能够解决冲突，也是不能打破的. 理由是
 `install --dev` 会产生跟 `install` 相同的状态, 独立于额外的 dev 包.

如果你遇到了这种冲突问题, 你可以在 require 段落指定冲突的包,
并 require 正确的版本号来解决冲突.

#### conflict

列出所有同该版本的包冲突的包. 它们
不允许同你的包一起安装.

#### replace

列出被这个包替代的包. 它允许你 fork 一个
包, 并在一个不同的名称下，使用它自己的版本号来发布, 于此同时,
包要求原有的包继续同你的 fork 工作，因为它替代了原有的包.

这对于包含子包的包来说非常有用, 比如主要的
symfony/symfony 包包含了全部的 Symfony 组件，不过它们也可以
作为独立的包而使用. 要是你要求了主包， 它会自动实现独立组件的任何要求,
因为它会替代它们.

我们推荐小心使用子包的替代，原因如上所述
. 典型地，你应该仅仅使用 `self.version` 作为一个版本约束条件
, 要确保主包只替代那个确切的子包版本
, 而不是其他什么版本，因为其他版本可能会出错.

#### provide

列出由该包提供的其他包. 对于常用接口来说，这很有用
. 一个包可以依赖于一些虚拟的
`logger` 包, 任何植入该 logger 接口的类库都会
简单地列在 `provide` 里面.

### suggest

Suggested packages that can enhance or work well with this package. These are
just informational and are displayed after the package is installed, to give
your users a hint that they could add more packages, even though they are not
strictly required.

The format is like package links above, except that the values are free text
and not version constraints.

Example:

    {
        "suggest": {
            "monolog/monolog": "Allows more advanced logging of the application flow"
        }
    }

### autoload

Autoload mapping for a PHP autoloader.

Currently [`PSR-0`](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)
autoloading, `classmap` generation and `files` are supported. PSR-0 is the recommended way though
since it offers greater flexibility (no need to regenerate the autoloader when you add
classes).

#### PSR-0

Under the `psr-0` key you define a mapping from namespaces to paths, relative to the
package root. Note that this also supports the PEAR-style non-namespaced convention.

The PSR-0 references are all combined, during install/update, into a single key => value
array which may be found in the generated file `vendor/composer/autoload_namespaces.php`.

Example:

    {
        "autoload": {
            "psr-0": {
                "Monolog": "src/",
                "Vendor\\Namespace\\": "src/",
                "Vendor_Namespace_": "src/"
            }
        }
    }

If you need to search for a same prefix in multiple directories,
you can specify them as an array as such:

    {
        "autoload": {
            "psr-0": { "Monolog": ["src/", "lib/"] }
        }
    }

The PSR-0 style is not limited to namespace declarations only but may be
specified right down to the class level. This can be useful for libraries with
only one class in the global namespace. If the php source file is also located
in the root of the package, for example, it may be declared like this:

    {
        "autoload": {
            "psr-0": { "UniqueGlobalClass": "" }
        }
    }

If you want to have a fallback directory where any namespace can be, you can
use an empty prefix like:

    {
        "autoload": {
            "psr-0": { "": "src/" }
        }
    }

#### Classmap

The `classmap` references are all combined, during install/update, into a single
key => value array which may be found in the generated file
`vendor/composer/autoload_classmap.php`. This map is built by scanning for
classes in all `.php` and `.inc` files in the given directories/files.

You can use the classmap generation support to define autoloading for all libraries
that do not follow PSR-0. To configure this you specify all directories or files
to search for classes.

Example:

    {
        "autoload": {
            "classmap": ["src/", "lib/", "Something.php"]
        }
    }

#### Files

If you want to require certain files explicitly on every request then you can use
the 'files' autoloading mechanism. This is useful if your package includes PHP functions
that cannot be autoloaded by PHP.

Example:

    {
        "autoload": {
            "files": ["src/MyLibrary/functions.php"]
        }
    }

### include-path

> **DEPRECATED**: This is only present to support legacy projects, and all new code
> should preferably use autoloading. As such it is a deprecated practice, but the
> feature itself will not likely disappear from Composer.

A list of paths which should get appended to PHP's `include_path`.

Example:

    {
        "include-path": ["lib/"]
    }

Optional.

### target-dir

Defines the installation target.

In case the package root is below the namespace declaration you cannot
autoload properly. `target-dir` solves this problem.

An example is Symfony. There are individual packages for the components. The
Yaml component is under `Symfony\Component\Yaml`. The package root is that
`Yaml` directory. To make autoloading possible, we need to make sure that it
is not installed into `vendor/symfony/yaml`, but instead into
`vendor/symfony/yaml/Symfony/Component/Yaml`, so that the autoloader can load
it from `vendor/symfony/yaml`.

To do that, `autoload` and `target-dir` are defined as follows:

    {
        "autoload": {
            "psr-0": { "Symfony\\Component\\Yaml": "" }
        },
        "target-dir": "Symfony/Component/Yaml"
    }

Optional.

### minimum-stability <span>(root-only)</span>

This defines the default behavior for filtering packages by stability. This
defaults to `stable`, so if you rely on a `dev` package, you should specify
it in your file to avoid surprises.

All versions of each package are checked for stability, and those that are less
stable than the `minimum-stability` setting will be ignored when resolving
your project dependencies. Specific changes to the stability requirements of
a given package can be done in `require` or `require-dev` (see
[package links](#package-links)).

Available options (in order of stability) are `dev`, `alpha`, `beta`, `RC`,
and `stable`.

### repositories <span>(root-only)</span>

Custom package repositories to use.

By default composer just uses the packagist repository. By specifying
repositories you can get packages from elsewhere.

Repositories are not resolved recursively. You can only add them to your main
`composer.json`. Repository declarations of dependencies' `composer.json`s are
ignored.

The following repository types are supported:

* **composer:** A composer repository is simply a `packages.json` file served
  via the network (HTTP, FTP, SSH), that contains a list of `composer.json`
  objects with additional `dist` and/or `source` information. The `packages.json`
  file is loaded using a PHP stream. You can set extra options on that stream
  using the `options` parameter.
* **vcs:** The version control system repository can fetch packages from git,
  svn and hg repositories.
* **pear:** With this you can import any pear repository into your composer
  project.
* **package:** If you depend on a project that does not have any support for
  composer whatsoever you can define the package inline using a `package`
  repository. You basically just inline the `composer.json` object.

For more information on any of these, see [Repositories](05-repositories.md).

Example:

    {
        "repositories": [
            {
                "type": "composer",
                "url": "http://packages.example.com"
            },
            {
                "type": "composer",
                "url": "https://packages.example.com",
                "options": {
                    "ssl": {
                        "verify_peer": "true"
                    }
                }
            },
            {
                "type": "vcs",
                "url": "https://github.com/Seldaek/monolog"
            },
            {
                "type": "pear",
                "url": "http://pear2.php.net"
            },
            {
                "type": "package",
                "package": {
                    "name": "smarty/smarty",
                    "version": "3.1.7",
                    "dist": {
                        "url": "http://www.smarty.net/files/Smarty-3.1.7.zip",
                        "type": "zip"
                    },
                    "source": {
                        "url": "http://smarty-php.googlecode.com/svn/",
                        "type": "svn",
                        "reference": "tags/Smarty_3_1_7/distribution/"
                    }
                }
            }
        ]
    }

> **Note:** Order is significant here. When looking for a package, Composer
will look from the first to the last repository, and pick the first match.
By default Packagist is added last which means that custom repositories can
override packages from it.

### config <span>(root-only)</span>

A set of configuration options. It is only used for projects.

The following options are supported:

* **process-timeout:** Defaults to `300`. The duration processes like git clones
  can run before Composer assumes they died out. You may need to make this
  higher if you have a slow connection or huge vendors.
* **use-include-path:** Defaults to `false`. If true, the Composer autoloader
  will also look for classes in the PHP include path.
* **github-protocols:** Defaults to `["git", "https", "http"]`. A list of
  protocols to use for github.com clones, in priority order. Use this if you are
  behind a proxy or have somehow bad performances with the git protocol.
* **github-oauth:** A list of domain names and oauth keys. For example using
  `{"github.com": "oauthtoken"}` as the value of this option will use `oauthtoken`
  to access private repositories on github and to circumvent the low IP-based
  rate limiting of their API.
* **vendor-dir:** Defaults to `vendor`. You can install dependencies into a
  different directory if you want to.
* **bin-dir:** Defaults to `vendor/bin`. If a project includes binaries, they
  will be symlinked into this directory.
* **cache-dir:** Defaults to `$home/cache` on unix systems and
  `C:\Users\<user>\AppData\Local\Composer` on Windows. Stores all the caches
  used by composer. See also [COMPOSER_HOME](03-cli.md#composer-home).
* **cache-files-dir:** Defaults to `$cache-dir/files`. Stores the zip archives
  of packages.
* **cache-repo-dir:** Defaults to `$cache-dir/repo`. Stores repository metadata
  for the `composer` type and the VCS repos of type `svn`, `github` and `*bitbucket`.
* **cache-vcs-dir:** Defaults to `$cache-dir/vcs`. Stores VCS clones for
  loading VCS repository metadata for the `git`/`hg` types and to speed up installs.
* **cache-files-ttl:** Defaults to `15552000` (6 months). Composer caches all
  dist (zip, tar, ..) packages that it downloads. Those are purged after six
  months of being unused by default. This option allows you to tweak this
  duration (in seconds) or disable it completely by setting it to 0.
* **cache-files-maxsize:** Defaults to `300MiB`. Composer caches all
  dist (zip, tar, ..) packages that it downloads. When the garbage collection
  is periodically ran, this is the maximum size the cache will be able to use.
  Older (less used) files will be removed first until the cache fits.
* **notify-on-install:** Defaults to `true`. Composer allows repositories to
  define a notification URL, so that they get notified whenever a package from
  that repository is installed. This option allows you to disable that behaviour.

Example:

    {
        "config": {
            "bin-dir": "bin"
        }
    }

### scripts <span>(root-only)</span>

Composer allows you to hook into various parts of the installation process
through the use of scripts.

See [Scripts](articles/scripts.md) for events details and examples.

### extra

Arbitrary extra data for consumption by `scripts`.

This can be virtually anything. To access it from within a script event
handler, you can do:

    $extra = $event->getComposer()->getPackage()->getExtra();

Optional.

### bin

A set of files that should be treated as binaries and symlinked into the `bin-dir`
(from config).

See [Vendor Binaries](articles/vendor-binaries.md) for more details.

Optional.

&larr; [Command-line interface](03-cli.md)  |  [Repositories](05-repositories.md) &rarr;
