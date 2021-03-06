# 仓库

本章将解释包和仓库的概念, 什么类型的仓库是可被获得的，以及它们是如何工作的。

## 概念

在我们查看不同类型的仓库之前，我们需要
理解一些 composer 所基于的基本概念.

### 包

Composer 是一个依赖管理器. 它将包安装在本地. 一个包基本上就是一个
包含了一些东西的目录. 在这种情况下，它就是 PHP
代码, 但理论上讲， 它可以是任何东西. 它包含了一个包的描述，有一个名称和一个版本
. 名称和版本用来鉴别是哪个包.

事实上, composer 内部将每个版本当做一个独立的包. 这种区别对你
使用 composer 没有影响, 但是当你要去改变它时，这很重要.

除了名称和版本之外，还有有用的 metadata. 同安装最有关系的信息
就是 source 的定义, 它描述了哪里可以获得包内容的信息
. 包数据指向包的内容. 这里有两个选项: dist 和 source.

**Dist:** dist 是包数据的打包版本. 通常是一个
发行版, 且通常是稳定版.

**Source:** source 用来做开发. 这通常会引源自一个源代码的仓库, 
比如 git. 当你要修改下载的包时，你可以这样获取它.

Packages 可以提供两者之一，或者两者都提供. 这取决于某种因素
, 比如 user-supplied 选项，以及包的稳定性, 推荐使用一个.

### Repository

一个仓库就是一个包的源. 这是一系列的包/版本. Composer
将会查看全部的仓库，从而找到你的项目所要求的包.

默认地，Composer 只注册了 Packagist 仓库. 你可以将更多的
仓库添加进你的项目中去，只需在 `composer.json` 文件中声明即可. 

仓库只在 root 包里才可获得, 在你的依赖包中定义的
仓库不会被加载. 请阅读
[FAQ 条目](faqs/why-can't-composer-load-repositories-recursively.md) 要是你想知道为什么的话.

## 类型

### Composer

主仓库的类型是 `composer` 仓库. 它使用了单个
`packages.json` 文件，包含了全部包的 metadata.

它还是 packagist 所使用的仓库类型. 要引用一个
`composer` 仓库, 只需在 `packages.json` 的前面提供路径.
比如说 packagist, 该文件位于 `/packages.json`, 所以仓库的 URL 就是
 `packagist.org`. 对于 `example.org/packages.json` 那么仓库的 URL
就是 `example.org`.

#### packages

唯一的必填字段就是 `packages`. JSON 格式的结构如下:

    {
        "packages": {
            "vendor/package-name": {
                "dev-master": { @composer.json },
                "1.0.x-dev": { @composer.json },
                "0.0.1": { @composer.json },
                "1.0.0": { @composer.json }
            }
        }
    }

`@composer.json` 标识就是 `composer.json` 的内容，来自于包含一个作为最小版本的包:

* name
* version
* dist or source

这里是一个最小版本的定义:

    {
        "name": "smarty/smarty",
        "version": "3.1.7",
        "dist": {
            "url": "http://www.smarty.net/files/Smarty-3.1.7.zip",
            "type": "zip"
        }
    }

它可以包含任何在[schema](04-schema.md) 里指定的字段.

#### notify-batch

`notify-batch` 字段允许你指定一个 URL ，该 URL在用户安装一个包的时候就会被调用
. 该 URL 既可以是绝对路径
(使用和仓库一样的域名) 也可以是一个 fully qualified URL.

一个值的例子:

    {
        "notify-batch": "/downloads/"
    }

对于包含一个 `monolog/monolog` 包的 `example.org/packages.json` , 这
会发送一个 `POST` 请求给 `example.org/downloads/` ，请求的 JSON body是:

    {
        "downloads": [
            {"name": "monolog/monolog", "version": "1.2.1.0"},
        ]
    }

版本字段包含了 normalized 的版本号.

该字段是可选的.

#### includes

对于更大的仓库，可以将 `packages.json` 分隔成
多个文件.  `includes` 字段允许你引用这些额外的文件.

一个例子:

    {
        "includes": {
            "packages-2011.json": {
                "sha1": "525a85fb37edd1ad71040d429928c2c0edec9d17"
            },
            "packages-2012-01.json": {
                "sha1": "897cde726f8a3918faf27c803b336da223d400dd"
            },
            "packages-2012-02.json": {
                "sha1": "26f911ad717da26bbcac3f8f435280d13917efa5"
            }
        }
    }

文件的 SHA-1 sum 值允许它被缓存，并且只有当hash改变了，才重新要求它.

这个字段是可选的. 你自己自定义的仓库很可能不需要它.

#### provider-includes 和 providers-url

For very large repositories like packagist.org using the so-called provider
files is the preferred method. The `provider-includes` field allows you to
list a set of files that list package names provided by this repository. The
hash should be a sha256 of the files in this case.

The `providers-url` describes how provider files are found on the server. It
is an absolute path from the repository root.

An example:

    {
        "provider-includes": {
            "providers-a.json": {
                "sha256": "f5b4bc0b354108ef08614e569c1ed01a2782e67641744864a74e788982886f4c"
            },
            "providers-b.json": {
                "sha256": "b38372163fac0573053536f5b8ef11b86f804ea8b016d239e706191203f6efac"
            }
        },
        "providers-url": "/p/%package%$%hash%.json"
    }

Those files contain lists of package names and hashes to verify the file
integrity, for example:

    {
        "providers": {
            "acme/foo": {
                "sha256": "38968de1305c2e17f4de33aea164515bc787c42c7e2d6e25948539a14268bb82"
            },
            "acme/bar": {
                "sha256": "4dd24c930bd6e1103251306d6336ac813b563a220d9ca14f4743c032fb047233"
            }
        }
    }

The file above declares that acme/foo and acme/bar can be found in this
repository, by loading the file referenced by `providers-url`, replacing
`%name%` by the package name and `%hash%` by the sha256 field. Those files
themselves just contain package definitions as described [above](#packages).

This field is optional. You probably don't need it for your own custom
repository.

#### stream options

The `packages.json` file is loaded using a PHP stream. You can set extra options
on that stream using the `options` parameter. You can set any valid PHP stream
context option. See [Context options and parameters](http://php.net/manual/en/context.php)
for more information.

### VCS

VCS stands for version control system. This includes versioning systems like
git, svn or hg. Composer has a repository type for installing packages from
these systems.

#### Loading a package from a VCS repository

There are a few use cases for this. The most common one is maintaining your
own fork of a third party library. If you are using a certain library for your
project and you decide to change something in the library, you will want your
project to use the patched version. If the library is on GitHub (this is the
case most of the time), you can simply fork it there and push your changes to
your fork. After that you update the project's `composer.json`. All you have
to do is add your fork as a repository and update the version constraint to
point to your custom branch. For version constraint naming conventions see
[Libraries](02-libraries.md) for more information.

Example assuming you patched monolog to fix a bug in the `bugfix` branch:

    {
        "repositories": [
            {
                "type": "vcs",
                "url": "https://github.com/igorw/monolog"
            }
        ],
        "require": {
            "monolog/monolog": "dev-bugfix"
        }
    }

When you run `php composer.phar update`, you should get your modified version
of `monolog/monolog` instead of the one from packagist.

It is possible to inline-alias a package constraint so that it matches a
constraint that it otherwise would not. For more information [see the
aliases article](articles/aliases.md).

#### Using private repositories

Exactly the same solution allows you to work with your private repositories at
GitHub and BitBucket:

    {
        "require": {
            "vendor/my-private-repo": "dev-master"
        },
        "repositories": [
            {
                "type": "vcs",
                "url":  "git@bitbucket.org:vendor/my-private-repo.git"
            }
        ]
    }

The only requirement is the installation of SSH keys for a git client.

#### Git alternatives

Git is not the only version control system supported by the VCS repository.
The following are supported:

* **Git:** [git-scm.com](http://git-scm.com)
* **Subversion:** [subversion.apache.org](http://subversion.apache.org)
* **Mercurial:** [mercurial.selenic.com](http://mercurial.selenic.com)

To get packages from these systems you need to have their respective clients
installed. That can be inconvenient. And for this reason there is special
support for GitHub and BitBucket that use the APIs provided by these sites, to
fetch the packages without having to install the version control system. The
VCS repository provides `dist`s for them that fetch the packages as zips.

* **GitHub:** [github.com](https://github.com) (Git)
* **BitBucket:** [bitbucket.org](https://bitbucket.org) (Git and Mercurial)

The VCS driver to be used is detected automatically based on the URL. However,
should you need to specify one for whatever reason, you can use `git`, `svn` or
`hg` as the repository type instead of `vcs`.

#### Subversion Options

Since Subversion has no native concept of branches and tags, Composer assumes
by default that code is located in `$url/trunk`, `$url/branches` and
`$url/tags`. If your repository has a different layout you can change those
values. For example if you used capitalized names you could configure the
repository like this:

    {
        "repositories": [
            {
                "type": "vcs",
                "url": "http://svn.example.org/projectA/",
                "trunk-path": "Trunk",
                "branches-path": "Branches",
                "tags-path": "Tags"
            }
        ]
    }

If you have no branches or tags directory you can disable them entirely by
setting the `branches-path` or `tags-path` to `false`.

### PEAR

It is possible to install packages from any PEAR channel by using the `pear`
repository. Composer will prefix all package names with `pear-{channelName}/` to
avoid conflicts. All packages are also aliased with prefix `pear-{channelAlias}/`

Example using `pear2.php.net`:

    {
        "repositories": [
            {
                "type": "pear",
                "url": "http://pear2.php.net"
            }
        ],
        "require": {
            "pear-pear2.php.net/PEAR2_Text_Markdown": "*",
            "pear-pear2/PEAR2_HTTP_Request": "*"
        }
    }

In this case the short name of the channel is `pear2`, so the
`PEAR2_HTTP_Request` package name becomes `pear-pear2/PEAR2_HTTP_Request`.

> **Note:** The `pear` repository requires doing quite a few requests per
> package, so this may considerably slow down the installation process.

#### Custom vendor alias

It is possible to alias PEAR channel packages with a custom vendor name.

Example:

Suppose you have a private PEAR repository and wish to use Composer to
incorporate dependencies from a VCS. Your PEAR repository contains the
following packages:

 * `BasePackage`
 * `IntermediatePackage`, which depends on `BasePackage`
 * `TopLevelPackage1` and `TopLevelPackage2` which both depend on `IntermediatePackage`

Without a vendor alias, Composer will use the PEAR channel name as the
vendor portion of the package name:

 * `pear-pear.foobar.repo/BasePackage`
 * `pear-pear.foobar.repo/IntermediatePackage`
 * `pear-pear.foobar.repo/TopLevelPackage1`
 * `pear-pear.foobar.repo/TopLevelPackage2`

Suppose at a later time you wish to migrate your PEAR packages to a
Composer repository and naming scheme, and adopt the vendor name of `foobar`.
Projects using your PEAR packages would not see the updated packages, since
they have a different vendor name (`foobar/IntermediatePackage` vs
`pear-pear.foobar.repo/IntermediatePackage`).

By specifying `vendor-alias` for the PEAR repository from the start, you can
avoid this scenario and future-proof your package names.

To illustrate, the following example would get the `BasePackage`,
`TopLevelPackage1`, and `TopLevelPackage2` packages from your PEAR repository
and `IntermediatePackage` from a Github repository:

    {
        "repositories": [
            {
                "type": "git",
                "url": "https://github.com/foobar/intermediate.git"
            },
            {
                "type": "pear",
                "url": "http://pear.foobar.repo",
                "vendor-alias": "foobar"
            }
        ],
        "require": {
            "foobar/TopLevelPackage1": "*",
            "foobar/TopLevelPackage2": "*"
        }
    }

### Package

If you want to use a project that does not support composer through any of the
means above, you still can define the package yourself by using a `package`
repository.

Basically, you define the same information that is included in the `composer`
repository's `packages.json`, but only for a single package. Again, the
minimum required fields are `name`, `version`, and either of `dist` or
`source`.

Here is an example for the smarty template engine:

    {
        "repositories": [
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
                    },
                    "autoload": {
                        "classmap": ["libs/"]
                    }
                }
            }
        ],
        "require": {
            "smarty/smarty": "3.1.*"
        }
    }

Typically you would leave the source part off, as you don't really need it.

## Hosting your own

While you will probably want to put your packages on packagist most of the time,
there are some use cases for hosting your own repository.

* **Private company packages:** If you are part of a company that uses composer
  for their packages internally, you might want to keep those packages private.

* **Separate ecosystem:** If you have a project which has its own ecosystem,
  and the packages aren't really reusable by the greater PHP community, you
  might want to keep them separate to packagist. An example of this would be
  wordpress plugins.

When hosting your own package repository it is recommended to use a `composer`
one. This is type that is native to composer and yields the best performance.

There are a few tools that can help you create a `composer` repository.

### Packagist

The underlying application used by packagist is open source. This means that you
can just install your own copy of packagist, re-brand, and use it. It's really
quite straight-forward to do. However due to its size and complexity, for most
small and medium sized companies willing to track a few packages will be better
off using Satis.

Packagist is a Symfony2 application, and it is [available on
GitHub](https://github.com/composer/packagist). It uses composer internally and
acts as a proxy between VCS repositories and the composer users. It holds a list
of all VCS packages, periodically re-crawls them, and exposes them as a composer
repository.

To set your own copy, simply follow the instructions from the [packagist
github repository](https://github.com/composer/packagist).

### Satis

Satis is a static `composer` repository generator. It is a bit like an ultra-
lightweight, static file-based version of packagist.

You give it a `composer.json` containing repositories, typically VCS and
package repository definitions. It will fetch all the packages that are
`require`d and dump a `packages.json` that is your `composer` repository.

Check [the satis GitHub repository](https://github.com/composer/satis) and
the [Satis article](articles/handling-private-packages-with-satis.md) for more
information.

## Disabling Packagist

You can disable the default Packagist repository by adding this to your
`composer.json`:

    {
        "repositories": [
            {
                "packagist": false
            }
        ]
    }


&larr; [Schema](04-schema.md)  |  [Community](06-community.md) &rarr;
