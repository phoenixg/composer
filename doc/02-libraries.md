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

你可以为你的类库提交 `composer.lock` 文件，如果你想这么做的话. 这
会帮助你的团队永远在相同的依赖版本下测试。
然而， 这个锁文件并不会对依赖于它的其他项目起到效果.
它只会对主项目起到效果。

如果你不想提交锁文件， 并且你正在使用 git ，那么请把它添加进
`.gitignore`.

## 发布到 VCS

一旦你在vcs（版本控制系统，比如 git）的仓库里面包含了
`composer.json` 文件, 那么你的类库就已经是可被 composer 安装了的啦. 在这个例子里
我们会发布 `acme/hello-world` 类库到 GitHub 的
`github.com/composer/hello-world` 上。

现在, 为了测试 `acme/hello-world` 包的安装, 我们来在本地创建一个
项目. 我们叫它为 `acme/blog`. 这个博客将会依赖于
`acme/hello-world`, 而这个东西接着又依赖于 `monolog/monolog`. 我们可以通过在某个地方
创建一个包含 `composer.json` 的新的 `blog` 目录来达成这个任务:

    {
        "name": "acme/blog",
        "require": {
            "acme/hello-world": "dev-master"
        }
    }

这里名称（name）并非必须, 因为我们并没有打算要把这个博客发布为一个类库
. 这里添加它是为了区分正在描述的是哪个 `composer.json` 。

现在我们需要告诉这个博客应用程序到哪里去找到这个 `hello-world` 依赖。
我们通过添加一个包仓库指定到博客的
`composer.json` 文件:

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

要获取更多关于包仓库如何工作，以及还有什么其他的类型，详见
 [仓库](05-repositories.md).

就是这样了. 你现在可以运行 composer 的
`install` 命令来安装依赖了！

**重申:** 任何包含有一个 `composer.json` 的 git/svn/hg 仓库都可以通过指定包仓库和在 `require` 字段中
声明依赖添加进你的项目里。

## 发布到 packagist

好了, 现在你可以发布包了. 但是每次都指定 vcs 仓库有点不方便
. 你可不想强制所有的用户那么做.

另一件你可能注意到的事是， 我们没有为
`monolog/monolog` 指定一个包仓库. 它是如何工作的呢？ 答案是 packagist.

[Packagist](https://packagist.org/) 是 composer 的主要的包仓库
, 默认被开启. 任何在
packagist 上发布的包都是可通过 composer 被自动获取的。 由于 monolog
[已经发布到 packagist](https://packagist.org/packages/monolog/monolog), 我们才得以
无需指定任何额外的仓库就能依赖它。

如果我们想要同全世界分享 `hello-world` , 我们也会把它发布到
packagist. 做这件事相当的容易。

你只需要点击大大的 "Submit Package" 按钮，并且注册用户. 然后你提交
你的 VCS 仓库的 URL, 接着 packagist 就会开始抓取它
. 一旦抓取完成, 你的包就可以让任何人下载了。

&larr; [基本用法](01-basic-usage.md) |  [命令行接口](03-cli.md) &rarr;
