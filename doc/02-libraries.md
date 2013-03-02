# 类库

本章节会告诉你如何制作可以通过 composer 来安装的自己的类库。

## 每个项目都是一个包（package）

一旦你的目录中有了一个 `composer.json` , 那么这个目录就是一个
包. 当你添加一个 `require` 到项目中去时, 你就在制作一个依赖于其他包的包. 
你的项目和类库之间的唯一区别是，你的项目是一个没有名称的包。

为了让这个包可被安装，你需要给他命名一个名称。添加一个 `name` 到 `composer.json` 中:

    {
        "name": "acme/hello-world",
        "require": {
            "monolog/monolog": "1.0.*"
        }
    }

这里例子里， 项目名称是 `acme/hello-world`, 而 `acme` 是 vendor 名称。
vendor 命名是强制需要提供的。

> **注意:** 如果你不知道该把什么当作 vendor 名称, 就用你的 GitHub
用户名， 这通常是一个好主意. 包名称是大小写不敏感的, 约定俗成的做法是
全部都小写，用短中杠（dashes）来分割单词。

## 平台包

Composer 有平台包， 他们是安装在你系统上的虚拟包，
而非实际可被 composer 安装的包。 它们包括了
PHP 自身, PHP 的扩展（extensions） 和一些系统类库。

* `php` 代表用户的 PHP 版本, 允许你应用约束条件
   , 比如 `>=5.4.0`. 如果要求一个 64位版本的PHP, 你可以
   要求 `php-64bit` 包.

* `ext-<name>` 允许你要求 PHP 扩展 (包括核心
  扩展). 这里的扩展版本可能经常反复不一, 所以通常
  一个好的主意是只设置约束条件到 `*`.  一个扩展包名称的例子是
  `ext-gd`.

* `lib-<name>` 允许你约束使用 PHP 制作的类库版本
  . 这几个都是可以的: `curl`, `iconv`, `libxml`, `openssl`,
  `pcre`, `uuid`, `xsl`.

你还可以使用 `composer show --platform` 来获取本地可以获得的平台包的一个列表。

## 指定版本

你需要用某些方法指定包的版本. 当你在 Packagist 发布包的时候, 
可以通过 VCS (git, svn,
hg) 来推测出版本信息, 假如是这样的情况， 你就无需指定它, 并且我们也推荐不要去指定. 
见 [tags](#tags) 和 [branches](#branches) 以查看版本号是如何从中被抽取出来的。

如果你正在手工创建包，并且必须要明确指定它的时候，
你也只需添加一个 `version` 字段：

    {
        "version": "1.0.0"
    }

### Tags

对于每一个看起来像一个版本的 tag , 对应于该 tag 的包版本也会被创建出来。
它应该匹配 'X.Y.Z' 或 'vX.Y.Z' 这样的形式, 可选的还有 RC, beta, alpha 或 patch作为后缀。


下面是一些有效的 tag 名称的例子:

    1.0.0
    v1.0.0
    1.10.5-RC1
    v4.4.4beta2
    v2.0.0-alpha
    v2.0.4-p1

> **注意:** 如果你在 `composer.json` 里面明确指定了版本号, tag 名称则必须匹配那个指定的版本。

### Branches

对于每一个分支来讲, 都会创建一个包的开发版本. 如果分支名称看起来像一个版本，
, 那么包版本就会是 `{branchname}-dev`. 比如说
一个分支 `2.0` 将会得到一个版本 `2.0.x-dev` ( `.x` 出于技术原因会被加上
, 以便保证它能被分支所认出,  `2.0.x` 分支也是有效的，它会被转成
 `2.0.x-dev` . 如果分支看起来不像是一个版本
, 它就会变成为 `dev-{branchname}`. 而 `master` 分支则会变成
`dev-master` 版本.

下面是一些分支版本的名称:

    1.x
    1.0 (equals 1.0.x)
    1.1.x

> **注意:** 当你安装一个 dev 版本时， 会通过源代码来安装它。

### 别名

还有可能，你会把分支名称的别名指向版本. 比如， 你会把别名
`dev-master` 指向 `1.0.x-dev`, 这会允许你在所有的包里要求 `1.0.x-dev` 。

见 [别名](articles/aliases.md) 查看更多信息.

## 锁文件（ Lock file ）

For your library you may commit the `composer.lock` file if you want to. This
can help your team to always test against the same dependency versions.
However, this lock file will not have any effect on other projects that depend
on it. It only has an effect on the main project.

If you do not want to commit the lock file and you are using git, add it to
the `.gitignore`.

## Publishing to a VCS

Once you have a vcs repository (version control system, e.g. git) containing a
`composer.json` file, your library is already composer-installable. In this
example we will publish the `acme/hello-world` library on GitHub under
`github.com/composer/hello-world`.

Now, To test installing the `acme/hello-world` package, we create a new
project locally. We will call it `acme/blog`. This blog will depend on
`acme/hello-world`, which in turn depends on `monolog/monolog`. We can
accomplish this by creating a new `blog` directory somewhere, containing a
`composer.json`:

    {
        "name": "acme/blog",
        "require": {
            "acme/hello-world": "dev-master"
        }
    }

The name is not needed in this case, since we don't want to publish the blog
as a library. It is added here to clarify which `composer.json` is being
described.

Now we need to tell the blog app where to find the `hello-world` dependency.
We do this by adding a package repository specification to the blog's
`composer.json`:

    {
        "name": "acme/blog",
        "repositories": [
            {
                "type": "vcs",
                "url": "https://github.com/composer/hello-world"
            }
        ],
        "require": {
            "acme/hello-world": "dev-master"
        }
    }

For more details on how package repositories work and what other types are
available, see [Repositories](05-repositories.md).

That's all. You can now install the dependencies by running composer's
`install` command!

**Recap:** Any git/svn/hg repository containing a `composer.json` can be added
to your project by specifying the package repository and declaring the
dependency in the `require` field.

## Publishing to packagist

Alright, so now you can publish packages. But specifying the vcs repository
every time is cumbersome. You don't want to force all your users to do that.

The other thing that you may have noticed is that we did not specify a package
repository for `monolog/monolog`. How did that work? The answer is packagist.

[Packagist](https://packagist.org/) is the main package repository for
composer, and it is enabled by default. Anything that is published on
packagist is available automatically through composer. Since monolog
[is on packagist](https://packagist.org/packages/monolog/monolog), we can depend
on it without having to specify any additional repositories.

If we wanted to share `hello-world` with the world, we would publish it on
packagist as well. Doing so is really easy.

You simply hit the big "Submit Package" button and sign up. Then you submit
the URL to your VCS repository, at which point packagist will start crawling
it. Once it is done, your package will be available to anyone.

&larr; [Basic usage](01-basic-usage.md) |  [Command-line interface](03-cli.md) &rarr;
